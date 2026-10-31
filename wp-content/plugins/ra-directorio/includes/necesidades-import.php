<?php
/**
 * Importación inicial de necesidades desde data/necesidades.json (la hoja de
 * Google limpia). Pantalla Necesidades → Importar y WP-CLI
 * `wp ra-directorio import-necesidades`.
 *
 * Es idempotente: cada necesidad lleva su id de origen (meta ra_nec_origen) y,
 * si ya existe, se omite; también si ya se mandó a la papelera (estaba cubierta).
 *
 * @package RA_Directorio
 */

defined( 'ABSPATH' ) || exit;

/**
 * Ejecuta la importación.
 *
 * @param array $args {
 *     @type string $file    Ruta al JSON. Por defecto data/necesidades.json del plugin.
 *     @type bool   $dry_run Solo reporta, no escribe.
 * }
 * @return array{created:int, skipped:int, log:string[]}|WP_Error
 */
function ra_nec_import( array $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'file'    => RA_DIR_PATH . 'data/necesidades.json',
			'dry_run' => false,
		)
	);

	if ( ! is_readable( $args['file'] ) ) {
		return new WP_Error( 'ra_nec_no_file', sprintf( 'No se puede leer %s', $args['file'] ) );
	}
	$items = json_decode( file_get_contents( $args['file'] ), true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
	if ( ! is_array( $items ) ) {
		return new WP_Error( 'ra_nec_bad_json', 'El JSON no es válido.' );
	}

	$result = array(
		'created' => 0,
		'skipped' => 0,
		'log'     => array(),
	);

	foreach ( $items as $item ) {
		if ( empty( $item['id'] ) || empty( $item['titulo'] ) ) {
			continue;
		}
		$existing = get_posts(
			array(
				'post_type'   => RA_NEC_CPT,
				'post_status' => 'any,trash',
				'meta_key'    => 'ra_nec_origen', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
				'meta_value'  => $item['id'], // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
				'fields'      => 'ids',
			)
		);
		if ( $existing ) {
			++$result['skipped'];
			$result['log'][] = "= {$item['titulo']} (ya existe)";
			continue;
		}

		$asociacion = get_page_by_path( $item['asociacion'], OBJECT, RA_DIR_CPT );
		if ( ! $asociacion ) {
			++$result['skipped'];
			$result['log'][] = "! {$item['titulo']}: no existe la asociación «{$item['asociacion']}»";
			continue;
		}

		if ( $args['dry_run'] ) {
			$result['log'][] = "+ {$item['titulo']} ({$asociacion->post_title})";
			continue;
		}

		$meta = array(
			'ra_nec_origen'      => $item['id'],
			'ra_nec_tipo'        => ra_nec_sanitize_field( $item['tipo'], 'tipo' ),
			'ra_nec_asociacion'  => $asociacion->ID,
			'ra_nec_descripcion' => ra_nec_sanitize_field( $item['descripcion'], 'textarea' ),
			'ra_nec_frecuencia'  => ra_nec_sanitize_field( $item['frecuencia'], 'text' ),
			'ra_nec_contacto'    => ra_nec_sanitize_field( $item['contacto'], 'text' ),
			'ra_nec_telefono'    => ra_nec_sanitize_field( $item['telefono'], 'tel' ),
			'ra_nec_email'       => ra_nec_sanitize_field( $item['email'], 'email' ),
		);
		$post_id = wp_insert_post(
			array(
				'post_type'   => RA_NEC_CPT,
				'post_status' => 'publish',
				'post_title'  => $item['titulo'],
				'meta_input'  => array_filter( $meta ),
			),
			true
		);
		if ( is_wp_error( $post_id ) ) {
			$result['log'][] = "! {$item['titulo']}: " . $post_id->get_error_message();
			continue;
		}
		++$result['created'];
		$result['log'][] = "+ {$item['titulo']} ({$asociacion->post_title})";
	}

	return $result;
}

add_action(
	'admin_menu',
	static function () {
		add_submenu_page(
			'edit.php?post_type=' . RA_NEC_CPT,
			__( 'Importar necesidades', 'ra-directorio' ),
			__( 'Importar', 'ra-directorio' ),
			'manage_options',
			'ra-nec-import',
			'ra_nec_render_import_page'
		);
	}
);

/** Pantalla de importación. */
function ra_nec_render_import_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$result = null;
	if ( isset( $_POST['ra_nec_import'] ) && check_admin_referer( 'ra_nec_import' ) ) {
		$result = ra_nec_import( array( 'dry_run' => ! empty( $_POST['ra_nec_dry'] ) ) );
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Importar necesidades', 'ra-directorio' ); ?></h1>
		<p><?php esc_html_e( 'Crea las necesidades que estaban en la hoja de Google (ya revisadas y corregidas). Se puede correr varias veces: las que ya se importaron se omiten, aunque estén en la papelera.', 'ra-directorio' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'ra_nec_import' ); ?>
			<p><label><input type="checkbox" name="ra_nec_dry" value="1" checked> <?php esc_html_e( 'Solo simular (no guarda nada)', 'ra-directorio' ); ?></label></p>
			<?php submit_button( __( 'Importar', 'ra-directorio' ), 'primary', 'ra_nec_import' ); ?>
		</form>
		<?php if ( is_wp_error( $result ) ) : ?>
			<div class="notice notice-error"><p><?php echo esc_html( $result->get_error_message() ); ?></p></div>
		<?php elseif ( $result ) : ?>
			<div class="notice notice-success"><p>
				<?php echo esc_html( sprintf( 'Creadas: %d · Omitidas: %d', $result['created'], $result['skipped'] ) ); ?>
			</p></div>
			<pre style="background:#fff;padding:1em;max-height:400px;overflow:auto"><?php echo esc_html( implode( "\n", $result['log'] ) ); ?></pre>
		<?php endif; ?>
	</div>
	<?php
}
