<?php
/**
 * Pantalla Asociaciones → Importar, para correr la importación desde el admin
 * cuando no hay acceso SSH/WP-CLI (por ejemplo, en GoDaddy).
 *
 * @package RA_Directorio
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'admin_menu',
	static function () {
		add_submenu_page(
			'edit.php?post_type=' . RA_DIR_CPT,
			__( 'Importar asociaciones', 'ra-directorio' ),
			__( 'Importar', 'ra-directorio' ),
			'manage_options',
			'ra-dir-import',
			'ra_dir_render_import_page'
		);
	}
);

/** Pantalla de importación. */
function ra_dir_render_import_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$result = null;
	if ( isset( $_POST['ra_dir_import'] ) && check_admin_referer( 'ra_dir_import' ) ) {
		$result = ra_dir_import(
			array(
				'update'  => ! empty( $_POST['ra_dir_update'] ),
				'dry_run' => ! empty( $_POST['ra_dir_dry'] ),
			)
		);
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Importar asociaciones', 'ra-directorio' ); ?></h1>
		<p><?php esc_html_e( 'Crea las asociaciones del directorio a partir de los datos incluidos en el plugin. Los logos se toman de la Biblioteca de medios (por nombre de archivo).', 'ra-directorio' ); ?></p>
		<p><?php esc_html_e( 'Se puede correr varias veces: las asociaciones que ya existen se omiten, salvo que marques "Sobrescribir".', 'ra-directorio' ); ?></p>
		<form method="post">
			<?php wp_nonce_field( 'ra_dir_import' ); ?>
			<p><label><input type="checkbox" name="ra_dir_dry" value="1" checked> <?php esc_html_e( 'Solo simular (no guarda nada)', 'ra-directorio' ); ?></label></p>
			<p><label><input type="checkbox" name="ra_dir_update" value="1"> <?php esc_html_e( 'Sobrescribir las que ya existen (pierde cambios hechos a mano)', 'ra-directorio' ); ?></label></p>
			<?php submit_button( __( 'Importar', 'ra-directorio' ), 'primary', 'ra_dir_import' ); ?>
		</form>
		<?php if ( is_wp_error( $result ) ) : ?>
			<div class="notice notice-error"><p><?php echo esc_html( $result->get_error_message() ); ?></p></div>
		<?php elseif ( $result ) : ?>
			<div class="notice notice-success"><p>
				<?php echo esc_html( sprintf( 'Creadas: %d · Actualizadas: %d · Omitidas: %d', $result['created'], $result['updated'], $result['skipped'] ) ); ?>
			</p></div>
			<pre style="background:#fff;padding:1em;max-height:400px;overflow:auto"><?php echo esc_html( implode( "\n", $result['log'] ) ); ?></pre>
		<?php endif; ?>
	</div>
	<?php
}
