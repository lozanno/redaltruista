<?php
/**
 * Shortcodes del directorio.
 *
 * [ra_total_asociaciones] imprime cuántas asociaciones están publicadas en el directorio,
 * para que el número del sitio cambie solo cuando entra o sale una asociación.
 * Funciona en párrafos, encabezados, plantillas y partes del tema.
 *
 * @package RA_Directorio
 */

defined( 'ABSPATH' ) || exit;

/** Número de asociaciones publicadas en el directorio. */
function ra_dir_total_asociaciones() {
	return (int) wp_count_posts( RA_DIR_CPT )->publish;
}

add_action(
	'init',
	static function () {
		add_shortcode(
			'ra_total_asociaciones',
			static function () {
				return esc_html( number_format_i18n( ra_dir_total_asociaciones() ) );
			}
		);
	}
);
