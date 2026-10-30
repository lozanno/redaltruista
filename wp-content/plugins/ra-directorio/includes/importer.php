<?php
/**
 * Importador del directorio desde data/asociaciones.json.
 *
 * Logos: primero busca el archivo en la Biblioteca de medios del sitio (en
 * producción los logos ya están ahí). Si no lo encuentra y se indicó una
 * carpeta local de logos, lo sube desde esa carpeta.
 *
 * Es idempotente: si una asociación ya existe (mismo slug) se salta, salvo que
 * se pida actualizar.
 *
 * @package RA_Directorio
 */

defined( 'ABSPATH' ) || exit;

/**
 * Ejecuta la importación.
 *
 * @param array $args {
 *     @type string $file      Ruta al JSON. Por defecto data/asociaciones.json del plugin.
 *     @type string $logos_dir Carpeta con logos para subir si no están en la biblioteca.
 *     @type bool   $update    Actualiza asociaciones existentes.
 *     @type bool   $dry_run   Solo reporta, no escribe.
 * }
 * @return array{created:int, updated:int, skipped:int, log:string[]}|WP_Error
 */
function ra_dir_import( array $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'file'      => RA_DIR_PATH . 'data/asociaciones.json',
			'logos_dir' => '',
			'update'    => false,
			'dry_run'   => false,
		)
	);

	if ( ! is_readable( $args['file'] ) ) {
		return new WP_Error( 'ra_dir_no_file', sprintf( 'No se puede leer %s', $args['file'] ) );
	}
	$items = json_decode( file_get_contents( $args['file'] ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	if ( ! is_array( $items ) ) {
		return new WP_Error( 'ra_dir_bad_json', 'El JSON no es válido.' );
	}

	ra_dir_seed_terms();

	$result = array(
		'created' => 0,
		'updated' => 0,
		'skipped' => 0,
		'log'     => array(),
	);

	foreach ( array_values( $items ) as $index => $item ) {
		if ( empty( $item['nombre'] ) ) {
			continue;
		}
		$name     = $item['nombre'];
		$slug     = sanitize_title( $name );
		$existing = get_page_by_path( $slug, OBJECT, RA_DIR_CPT );

		if ( $existing && ! $args['update'] ) {
			++$result['skipped'];
			$result['log'][] = "= {$name} (ya existe)";
			continue;
		}

		if ( $args['dry_run'] ) {
			$result['log'][] = ( $existing ? '~ ' : '+ ' ) . $name;
			continue;
		}

		$postarr = array(
			'post_type'    => RA_DIR_CPT,
			'post_status'  => 'publish',
			'post_title'   => $name,
			'post_name'    => $slug,
			'post_content' => isset( $item['descripcion'] ) ? "<!-- wp:paragraph -->\n<p>" . esc_html( $item['descripcion'] ) . "</p>\n<!-- /wp:paragraph -->" : '',
			'menu_order'   => ( $index + 1 ) * 10, // De 10 en 10 para poder intercalar después.
		);
		if ( $existing ) {
			$postarr['ID'] = $existing->ID;
		}
		$post_id = wp_insert_post( wp_slash( $postarr ), true );
		if ( is_wp_error( $post_id ) ) {
			$result['log'][] = "! {$name}: " . $post_id->get_error_message();
			continue;
		}

		foreach ( ra_dir_fields() as $key => $field ) {
			$value = isset( $item[ $key ] ) ? ra_dir_sanitize_field( $item[ $key ], $field['type'] ) : '';
			if ( '' === $value ) {
				delete_post_meta( $post_id, $key );
			} else {
				update_post_meta( $post_id, $key, $value );
			}
		}

		if ( ! empty( $item['areas'] ) ) {
			wp_set_object_terms( $post_id, array_map( 'sanitize_title', (array) $item['areas'] ), RA_DIR_TAX );
		}

		$logo_note = '';
		if ( ! empty( $item['logo'] ) ) {
			$attachment_id = ra_dir_find_or_upload_logo( $item['logo'], $args['logos_dir'], $post_id );
			if ( $attachment_id ) {
				set_post_thumbnail( $post_id, $attachment_id );
			} else {
				$logo_note = " — sin logo ({$item['logo']} no encontrado)";
			}
		}

		if ( $existing ) {
			++$result['updated'];
			$result['log'][] = "~ {$name}{$logo_note}";
		} else {
			++$result['created'];
			$result['log'][] = "+ {$name}{$logo_note}";
		}
	}

	flush_rewrite_rules( false );
	return $result;
}

/**
 * Busca un logo en la Biblioteca de medios por nombre de archivo; si no está,
 * intenta subirlo desde una carpeta local.
 *
 * @param string $filename  Nombre del archivo original (sin tamaño -1024x768).
 * @param string $logos_dir Carpeta local opcional.
 * @param int    $post_id   Asociación a la que se adjunta.
 * @return int ID del adjunto o 0.
 */
function ra_dir_find_or_upload_logo( $filename, $logos_dir, $post_id ) {
	global $wpdb;

	$filename = wp_basename( $filename );

	// 1) Biblioteca de medios: el archivo puede estar en la raíz de uploads o en carpetas año/mes.
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery
	$attachment_id = (int) $wpdb->get_var(
		$wpdb->prepare(
			"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file' AND ( meta_value = %s OR meta_value LIKE %s ) ORDER BY post_id ASC LIMIT 1",
			$filename,
			'%/' . $wpdb->esc_like( $filename )
		)
	);
	if ( $attachment_id ) {
		return $attachment_id;
	}

	// 2) Carpeta local (útil en el entorno de desarrollo).
	if ( ! $logos_dir ) {
		return 0;
	}
	$path = trailingslashit( $logos_dir ) . $filename;
	if ( ! file_exists( $path ) ) {
		// Prueba también la forma normalizada (acentos en NFC/NFD según el sistema de archivos).
		$alt = class_exists( 'Normalizer' ) ? trailingslashit( $logos_dir ) . Normalizer::normalize( $filename, Normalizer::FORM_D ) : '';
		if ( $alt && file_exists( $alt ) ) {
			$path = $alt;
		} else {
			return 0;
		}
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	// media_handle_sideload mueve el archivo: se trabaja sobre una copia temporal.
	$tmp = wp_tempnam( $filename );
	copy( $path, $tmp );
	$id = media_handle_sideload(
		array(
			'name'     => $filename,
			'tmp_name' => $tmp,
		),
		$post_id,
		get_the_title( $post_id )
	);
	if ( is_wp_error( $id ) ) {
		wp_delete_file( $tmp );
		return 0;
	}
	update_post_meta( $id, '_wp_attachment_image_alt', sprintf( 'Logo de %s', get_the_title( $post_id ) ) );
	return (int) $id;
}
