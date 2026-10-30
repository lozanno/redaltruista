<?php
/**
 * Comando WP-CLI.
 *
 *   wp ra-directorio import [--file=<ruta>] [--logos=<carpeta>] [--update] [--dry-run]
 *
 * @package RA_Directorio
 */

defined( 'ABSPATH' ) || exit;

/**
 * Importa el directorio de asociaciones.
 *
 * ## OPTIONS
 *
 * [--file=<ruta>]
 * : JSON a importar. Por defecto, data/asociaciones.json del plugin.
 *
 * [--logos=<carpeta>]
 * : Carpeta con los logos, para subir los que no estén ya en la Biblioteca de medios.
 *
 * [--update]
 * : Sobrescribe las asociaciones que ya existen.
 *
 * [--dry-run]
 * : Muestra lo que haría sin escribir nada.
 *
 * ## EXAMPLES
 *
 *     wp ra-directorio import --dry-run
 *     wp ra-directorio import --logos=~/Development/redaltruista/logos
 *
 * @when after_wp_load
 *
 * @param array $args       Argumentos posicionales.
 * @param array $assoc_args Opciones.
 */
function ra_dir_cli_import( $args, $assoc_args ) {
	$logos = isset( $assoc_args['logos'] ) ? $assoc_args['logos'] : '';
	if ( $logos && 0 === strpos( $logos, '~' ) ) {
		$logos = getenv( 'HOME' ) . substr( $logos, 1 );
	}
	$result = ra_dir_import(
		array(
			'file'      => isset( $assoc_args['file'] ) ? $assoc_args['file'] : RA_DIR_PATH . 'data/asociaciones.json',
			'logos_dir' => $logos,
			'update'    => \WP_CLI\Utils\get_flag_value( $assoc_args, 'update', false ),
			'dry_run'   => \WP_CLI\Utils\get_flag_value( $assoc_args, 'dry-run', false ),
		)
	);
	if ( is_wp_error( $result ) ) {
		WP_CLI::error( $result->get_error_message() );
	}
	foreach ( $result['log'] as $line ) {
		WP_CLI::log( $line );
	}
	WP_CLI::success( sprintf( 'Creadas: %d · Actualizadas: %d · Omitidas: %d', $result['created'], $result['updated'], $result['skipped'] ) );
}

WP_CLI::add_command( 'ra-directorio import', 'ra_dir_cli_import' );
