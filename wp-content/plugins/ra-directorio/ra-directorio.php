<?php
/**
 * Plugin Name:       Red Altruista – Directorio de asociaciones
 * Description:       Tipo de contenido "Asociación", áreas de servicio, campos de enlaces/redes, bloques del directorio e importador.
 * Version:           1.0.0
 * Requires at least: 6.6
 * Requires PHP:      7.4
 * Author:            Diego Lozano
 * Text Domain:       ra-directorio
 * License:           GPL-2.0-or-later
 *
 * @package RA_Directorio
 */

defined( 'ABSPATH' ) || exit;

define( 'RA_DIR_VERSION', '1.0.0' );
define( 'RA_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'RA_DIR_URL', plugin_dir_url( __FILE__ ) );

/** Slug del tipo de contenido y de la taxonomía. */
define( 'RA_DIR_CPT', 'asociacion' );
define( 'RA_DIR_TAX', 'area-servicio' );

require_once RA_DIR_PATH . 'includes/fields.php';
require_once RA_DIR_PATH . 'includes/post-types.php';
require_once RA_DIR_PATH . 'includes/meta-box.php';
require_once RA_DIR_PATH . 'includes/admin-columns.php';
require_once RA_DIR_PATH . 'includes/blocks.php';
require_once RA_DIR_PATH . 'includes/shortcodes.php';
require_once RA_DIR_PATH . 'includes/importer.php';
require_once RA_DIR_PATH . 'includes/admin-import.php';

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once RA_DIR_PATH . 'includes/cli.php';
}

register_activation_hook(
	__FILE__,
	static function () {
		ra_dir_register_post_type();
		ra_dir_register_taxonomy();
		ra_dir_seed_terms();
		flush_rewrite_rules();
	}
);

register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
