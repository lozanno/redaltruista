<?php
/**
 * Publica el sitio nuevo en producción de una sola vez: activa el plugin y el tema,
 * pone a cada página el contenido de su patrón, importa el directorio, crea los
 * formularios y desactiva Avada. Es idempotente: se puede volver a correr.
 *
 * Antes: respaldo completo y subir por SFTP, junto a WordPress (p. ej. en ~/publicar/):
 *   wp-content/themes/redaltruista, wp-content/plugins/ra-directorio (a su lugar en wp-content),
 *   y bin/publicar.php, bin/formularios.php y medios/ (a la misma carpeta, ~/publicar/).
 *
 *   wp eval-file ~/publicar/publicar.php simular   # solo revisa y dice lo que haría
 *   wp eval-file ~/publicar/publicar.php           # publica
 *
 * Opciones (argumentos después del archivo):
 *   simular         No escribe nada.
 *   medios=RUTA     Carpeta con las imágenes nuevas (por defecto ../medios o ./medios junto a este archivo).
 *
 * El contenido de Avada de cada página queda como revisión. Para volver atrás: activar Avada
 * y sus plugins, o restaurar el respaldo.
 *
 * Ensayo local sobre una copia de producción: bin/ensayo.sh.
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	exit( "Se ejecuta con WP-CLI: wp eval-file publicar.php\n" );
}

$ra_simular = in_array( 'simular', $args, true );
$ra_medios  = '';
foreach ( $args as $ra_arg ) {
	if ( 0 === strpos( $ra_arg, 'medios=' ) ) {
		$ra_medios = substr( $ra_arg, 7 );
	}
}
if ( ! $ra_medios ) {
	foreach ( array( __DIR__ . '/../medios', __DIR__ . '/medios' ) as $ra_dir ) {
		if ( is_dir( $ra_dir ) ) {
			$ra_medios = $ra_dir;
			break;
		}
	}
}
$ra_medios = $ra_medios ? rtrim( realpath( $ra_medios ), '/' ) : '';

/*
 * Páginas: slug en producción → patrón y ajustes. 'portada' = la página de inicio actual (home-2).
 * Imágenes por ID de adjunto (los mismos en producción y en local); 'encuentro-2024-portada.jpg'
 * es nueva y se sube desde medios/.
 */
$ra_paginas = array(
	'portada'        => array( 'patron' => 'pagina-inicio', 'titulo' => 'Inicio', 'plantilla' => 'page-sin-titulo' ),
	'acerca-de'      => array( 'patron' => 'pagina-sobre-nosotros', 'titulo' => 'Sobre nosotros' ),
	'contribuye'     => array( 'patron' => 'pagina-contribuye', 'titulo' => 'Contribuye' ),
	'eventos'        => array( 'patron' => 'pagina-eventos', 'titulo' => 'Eventos' ),
	'transparencia'  => array( 'patron' => 'pagina-transparencia', 'titulo' => 'Transparencia' ),
	'contactanos'    => array( 'patron' => 'pagina-contactanos', 'titulo' => 'Contáctanos' ),
	'encuentro-2024' => array( 'patron' => 'evento-encuentro-2024', 'titulo' => 'Encuentro 2024', 'superior' => 'eventos', 'imagen' => 'encuentro-2024-portada.jpg' ),
	'encuentro-2023' => array( 'patron' => 'evento-encuentro-2023', 'titulo' => 'Encuentro 2023', 'superior' => 'eventos', 'imagen' => 1506 ),
	'encuentro-2019' => array( 'patron' => 'evento-encuentro-2019', 'titulo' => 'Encuentro 2019', 'superior' => 'eventos', 'imagen' => 1249 ),
	'diplomado-2019' => array( 'patron' => 'evento-diplomado-2019', 'titulo' => 'Diplomado 2019', 'superior' => 'eventos', 'imagen' => 1244 ),
	'encuentro2018'  => array( 'patron' => 'evento-encuentro-2018', 'titulo' => 'Encuentro 2018', 'superior' => 'eventos', 'imagen' => 1246 ),
	'encuentro-2017' => array( 'patron' => 'evento-encuentro-2017', 'titulo' => 'Encuentro 2017', 'superior' => 'eventos', 'imagen' => 1245, 'fecha' => '2017-09-01 12:00:00' ),
);

// Páginas de Avada que no se migran: a borrador (sin Avada se verían los shortcodes) o a la papelera.
$ra_a_borrador = array( 'programas-y-servicios', 'registro' );
$ra_a_papelera = array( 'asociaciones-afiliadas' ); // El directorio del plugin ocupa esa URL.

$ra_logo          = 1417; // Logo-Comercial-small.png
$ra_plugins_fuera = array( 'fusion-builder/fusion-builder.php', 'fusion-core/fusion-core.php' );

/** Página por slug, esté en la raíz o ya debajo de Eventos. */
function ra_pub_pagina( $slug ) {
	if ( 'portada' === $slug ) {
		$id = (int) get_option( 'page_on_front' );
		return $id ? get_post( $id ) : null;
	}
	$q = get_posts(
		array(
			'post_type'   => 'page',
			'name'        => $slug,
			'post_status' => array( 'publish', 'draft', 'private', 'pending' ),
			'numberposts' => 2,
		)
	);
	if ( count( $q ) > 1 ) {
		WP_CLI::warning( "Hay más de una página «{$slug}»; uso la de ID {$q[0]->ID}." );
	}
	return $q ? $q[0] : null;
}

/** ID de un adjunto por nombre de archivo exacto (sin distinguir carpetas año/mes). */
function ra_pub_adjunto( $archivo ) {
	global $wpdb;
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery
	$ids = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file' AND ( meta_value = %s OR meta_value LIKE %s )",
			$archivo,
			'%/' . $wpdb->esc_like( $archivo )
		)
	);
	foreach ( $ids as $id ) { // MySQL compara sin distinguir mayúsculas: se confirma en PHP.
		if ( basename( get_post_meta( $id, '_wp_attached_file', true ) ) === $archivo ) {
			return (int) $id;
		}
	}
	return 0;
}

WP_CLI::log( $ra_simular ? '== Simulación: no se escribe nada ==' : '== Publicación ==' );

/* ---------- 1. Revisiones previas ---------- */
$ra_errores = array();
if ( ! wp_get_theme( 'redaltruista' )->exists() ) {
	$ra_errores[] = 'Falta el tema en wp-content/themes/redaltruista.';
}
if ( ! file_exists( WP_PLUGIN_DIR . '/ra-directorio/ra-directorio.php' ) ) {
	$ra_errores[] = 'Falta el plugin en wp-content/plugins/ra-directorio.';
}
if ( ! file_exists( WP_PLUGIN_DIR . '/contact-form-7/wp-contact-form-7.php' ) ) {
	$ra_errores[] = 'Falta Contact Form 7.';
}
if ( ! file_exists( __DIR__ . '/formularios.php' ) ) {
	$ra_errores[] = 'Falta formularios.php junto a este archivo.';
}
foreach ( $ra_paginas as $ra_slug => $ra_p ) {
	if ( ! ra_pub_pagina( $ra_slug ) ) {
		$ra_errores[] = "No encuentro la página «{$ra_slug}».";
	}
	if ( ! file_exists( get_theme_root() . '/redaltruista/patterns/' . $ra_p['patron'] . '.php' ) ) {
		$ra_errores[] = "Falta el patrón {$ra_p['patron']}.";
	}
	if ( isset( $ra_p['imagen'] ) && is_int( $ra_p['imagen'] ) && 'attachment' !== get_post_type( $ra_p['imagen'] ) ) {
		$ra_errores[] = "La imagen {$ra_p['imagen']} de «{$ra_slug}» no está en la Biblioteca.";
	}
	if ( isset( $ra_p['imagen'] ) && is_string( $ra_p['imagen'] ) && ! ra_pub_adjunto( $ra_p['imagen'] ) && ! is_readable( $ra_medios . '/' . $ra_p['imagen'] ) ) {
		$ra_errores[] = "No encuentro {$ra_p['imagen']} ni en la Biblioteca ni en medios/ (indica medios=RUTA).";
	}
}
if ( 'attachment' !== get_post_type( $ra_logo ) ) {
	$ra_errores[] = "El logo (adjunto {$ra_logo}) no está en la Biblioteca.";
}
if ( $ra_errores ) {
	foreach ( $ra_errores as $ra_e ) {
		WP_CLI::warning( $ra_e );
	}
	WP_CLI::error( 'Corrige lo anterior antes de publicar. No se cambió nada.' );
}
WP_CLI::log( 'Revisión previa: todo en su lugar.' );

/* ---------- 2. Plugin y tema. Los patrones se registran con el tema activo: se relanza este archivo. ---------- */
if ( 'redaltruista' !== get_stylesheet() ) {
	if ( $ra_simular ) {
		WP_CLI::log( 'Activaría Contact Form 7 y ra-directorio, y el tema Red Altruista (hoy: ' . get_stylesheet() . ').' );
		foreach ( $ra_paginas as $ra_slug => $ra_p ) {
			$ra_post = ra_pub_pagina( $ra_slug );
			WP_CLI::log( sprintf( '  %-16s ID %-5d «%s» → patrón %s%s', $ra_slug, $ra_post->ID, $ra_post->post_title, $ra_p['patron'], isset( $ra_p['superior'] ) ? ', debajo de Eventos' : '' ) );
		}
		foreach ( $ra_a_borrador as $ra_slug ) {
			$ra_post = ra_pub_pagina( $ra_slug );
			WP_CLI::log( $ra_post ? "  Pasaría a borrador: {$ra_slug} (ID {$ra_post->ID})" : "  No existe {$ra_slug}" );
		}
		foreach ( $ra_a_papelera as $ra_slug ) {
			$ra_post = ra_pub_pagina( $ra_slug );
			WP_CLI::log( $ra_post ? "  A la papelera: {$ra_slug} (ID {$ra_post->ID})" : "  No existe {$ra_slug}" );
		}
		WP_CLI::log( 'Importaría el directorio, crearía los formularios, pondría el logo y desactivaría: ' . implode( ', ', $ra_plugins_fuera ) . '.' );
		WP_CLI::success( 'Simulación terminada.' );
		return;
	}
	foreach ( array( 'contact-form-7/wp-contact-form-7.php', 'ra-directorio/ra-directorio.php' ) as $ra_plugin ) {
		$ra_r = activate_plugin( $ra_plugin );
		if ( is_wp_error( $ra_r ) ) {
			WP_CLI::error( "No se pudo activar {$ra_plugin}: " . $ra_r->get_error_message() );
		}
	}
	switch_theme( 'redaltruista' );
	WP_CLI::log( 'Plugin y tema activados. Sigo con el contenido…' );
	WP_CLI::runcommand(
		'eval-file ' . escapeshellarg( __FILE__ ) . ( $ra_medios ? ' ' . escapeshellarg( 'medios=' . $ra_medios ) : '' ),
		array( 'launch' => true )
	);
	return;
}

if ( $ra_simular ) {
	WP_CLI::log( 'El tema Red Altruista ya está activo: la simulación se detiene aquí. Sin «simular» se actualizan las páginas.' );
	return;
}

// Como administrador y sin kses: lo que se guarda (estilos de los patrones, el iframe de Contribuye) queda tal cual.
$ra_admins = get_users( array( 'role' => 'administrator', 'number' => 1, 'orderby' => 'ID' ) );
if ( $ra_admins ) {
	wp_set_current_user( $ra_admins[0]->ID );
}
kses_remove_filters();

/* ---------- 3. Directorio de asociaciones ---------- */
$ra_r = ra_dir_import();
if ( is_wp_error( $ra_r ) ) {
	WP_CLI::warning( 'Directorio: ' . $ra_r->get_error_message() );
} else {
	WP_CLI::log( sprintf( 'Directorio: %d creadas, %d ya existían.', $ra_r['created'], $ra_r['skipped'] ) );
	foreach ( $ra_r['log'] as $ra_linea ) {
		if ( 0 === strpos( $ra_linea, '!' ) || false !== strpos( $ra_linea, 'sin logo' ) ) {
			WP_CLI::warning( $ra_linea );
		}
	}
}

/* ---------- 4. Formularios (antes que las páginas: el patrón de Contáctanos inserta el formulario «Contacto») ---------- */
require __DIR__ . '/formularios.php';
$ra_ejemplo = wpcf7_get_contact_form_by_title( 'Contact form 1' );
if ( $ra_ejemplo ) {
	wp_trash_post( $ra_ejemplo->id() );
	WP_CLI::log( 'Formulario de ejemplo «Contact form 1» → papelera.' );
}

/* ---------- 5. Páginas ---------- */
$ra_registro = WP_Block_Patterns_Registry::get_instance();
$ra_eventos  = ra_pub_pagina( 'eventos' );
foreach ( $ra_paginas as $ra_slug => $ra_p ) {
	$ra_post   = ra_pub_pagina( $ra_slug );
	$ra_patron = $ra_registro->get_registered( 'redaltruista/' . $ra_p['patron'] );
	if ( ! $ra_patron ) {
		WP_CLI::warning( "El patrón {$ra_p['patron']} no está registrado; «{$ra_slug}» no se tocó." );
		continue;
	}
	$ra_datos = array(
		'ID'           => $ra_post->ID,
		'post_title'   => $ra_p['titulo'],
		'post_content' => $ra_patron['content'],
		'post_status'  => 'publish',
		'post_parent'  => isset( $ra_p['superior'] ) ? $ra_eventos->ID : $ra_post->post_parent,
		// La plantilla de Avada (100-width.php) no existe en el tema nuevo y WordPress no guardaría la página.
		'page_template' => isset( $ra_p['plantilla'] ) ? $ra_p['plantilla'] : 'default',
	);
	if ( isset( $ra_p['fecha'] ) ) {
		$ra_datos['post_date']     = $ra_p['fecha'];
		$ra_datos['post_date_gmt'] = get_gmt_from_date( $ra_p['fecha'] );
	}
	$ra_r = wp_update_post( wp_slash( $ra_datos ), true );
	if ( is_wp_error( $ra_r ) ) {
		WP_CLI::warning( "«{$ra_slug}»: " . $ra_r->get_error_message() );
		continue;
	}

	if ( isset( $ra_p['imagen'] ) ) {
		$ra_img = $ra_p['imagen'];
		if ( is_string( $ra_img ) ) {
			$ra_archivo = $ra_img;
			$ra_img     = ra_pub_adjunto( $ra_archivo );
			if ( ! $ra_img ) {
				require_once ABSPATH . 'wp-admin/includes/media.php';
				require_once ABSPATH . 'wp-admin/includes/file.php';
				require_once ABSPATH . 'wp-admin/includes/image.php';
				$ra_tmp = wp_tempnam( $ra_archivo );
				copy( $ra_medios . '/' . $ra_archivo, $ra_tmp );
				$ra_img = media_handle_sideload( array( 'name' => $ra_archivo, 'tmp_name' => $ra_tmp ), $ra_post->ID, $ra_p['titulo'] );
				if ( is_wp_error( $ra_img ) ) {
					WP_CLI::warning( "No se pudo subir {$ra_archivo}: " . $ra_img->get_error_message() );
					$ra_img = 0;
				} else {
					WP_CLI::log( "  Subida {$ra_archivo} (adjunto {$ra_img})." );
				}
			}
		}
		if ( $ra_img ) {
			set_post_thumbnail( $ra_post->ID, $ra_img );
		}
	}
	WP_CLI::log( sprintf( '  %-16s ID %-5d → %s', $ra_slug, $ra_post->ID, get_permalink( $ra_post->ID ) ) );
}

foreach ( $ra_a_borrador as $ra_slug ) {
	$ra_post = ra_pub_pagina( $ra_slug );
	if ( $ra_post && 'draft' !== $ra_post->post_status ) {
		wp_update_post( array( 'ID' => $ra_post->ID, 'post_status' => 'draft' ) );
		WP_CLI::log( "  {$ra_slug} (ID {$ra_post->ID}) → borrador." );
	}
}
foreach ( $ra_a_papelera as $ra_slug ) {
	$ra_post = ra_pub_pagina( $ra_slug );
	if ( $ra_post ) {
		wp_trash_post( $ra_post->ID );
		WP_CLI::log( "  {$ra_slug} (ID {$ra_post->ID}) → papelera." );
	}
}

/* ---------- 6. Logo, Avada fuera, enlaces permanentes ---------- */
update_option( 'site_logo', $ra_logo );
deactivate_plugins( $ra_plugins_fuera );
flush_rewrite_rules();

WP_CLI::success( 'Sitio publicado. Revisa ' . home_url( '/' ) . ' y haz un envío de prueba en ' . home_url( '/contactanos/' ) . '.' );
