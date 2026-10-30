<?php
/**
 * Columnas útiles en el listado de asociaciones: logo, sitio web y orden.
 *
 * @package RA_Directorio
 */

defined( 'ABSPATH' ) || exit;

add_filter(
	'manage_' . RA_DIR_CPT . '_posts_columns',
	static function ( $columns ) {
		$new = array();
		foreach ( $columns as $key => $label ) {
			if ( 'title' === $key ) {
				$new['ra_logo'] = __( 'Logo', 'ra-directorio' );
			}
			$new[ $key ] = $label;
			if ( 'title' === $key ) {
				$new['ra_web']   = __( 'Sitio web', 'ra-directorio' );
				$new['ra_orden'] = __( 'Orden', 'ra-directorio' );
			}
		}
		return $new;
	}
);

add_action(
	'manage_' . RA_DIR_CPT . '_posts_custom_column',
	static function ( $column, $post_id ) {
		switch ( $column ) {
			case 'ra_logo':
				echo get_the_post_thumbnail( $post_id, array( 64, 64 ), array( 'style' => 'width:64px;height:auto;object-fit:contain' ) ) ?: '<span aria-hidden="true">—</span>';
				break;
			case 'ra_web':
				$url = get_post_meta( $post_id, 'ra_web', true );
				echo $url ? '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener">' . esc_html( wp_parse_url( $url, PHP_URL_HOST ) ) . '</a>' : '<span aria-hidden="true">—</span>';
				break;
			case 'ra_orden':
				echo (int) get_post_field( 'menu_order', $post_id );
				break;
		}
	},
	10,
	2
);

add_filter(
	'manage_edit-' . RA_DIR_CPT . '_sortable_columns',
	static function ( $columns ) {
		$columns['ra_orden'] = 'menu_order';
		return $columns;
	}
);

add_action(
	'admin_head',
	static function () {
		$screen = get_current_screen();
		if ( $screen && 'edit-' . RA_DIR_CPT === $screen->id ) {
			echo '<style>.column-ra_logo{width:80px}.column-ra_orden{width:60px}</style>';
		}
	}
);
