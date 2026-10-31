<?php
/**
 * Panel simplificado para el perfil Editor (el staff de la Red): en el menú solo
 * aparecen Páginas, Asociaciones y Necesidades, y al entrar abre Páginas.
 *
 * Solo oculta menús; los permisos del rol no cambian (Asociaciones usa los
 * permisos de las entradas y el logo necesita poder subir medios).
 * Los administradores ven el panel completo.
 *
 * @package RA_Directorio
 */

defined( 'ABSPATH' ) || exit;

/** ¿El usuario actual es Editor (y no administrador)? */
function ra_dir_es_editor() {
	$user = wp_get_current_user();
	return in_array( 'editor', (array) $user->roles, true ) && ! current_user_can( 'manage_options' );
}

/**
 * Menús que ve el Editor.
 *
 * @return string[]
 */
function ra_dir_menus_editor() {
	return array(
		'edit.php?post_type=page',
		'edit.php?post_type=' . RA_DIR_CPT,
		'edit.php?post_type=' . RA_NEC_CPT,
	);
}

/** Quita del menú todo lo demás (prioridad alta: después de que los plugins agreguen los suyos). */
add_action(
	'admin_menu',
	static function () {
		global $menu;
		if ( ! ra_dir_es_editor() || ! is_array( $menu ) ) {
			return;
		}
		foreach ( $menu as $item ) {
			if ( ! in_array( $item[2], ra_dir_menus_editor(), true ) ) {
				remove_menu_page( $item[2] );
			}
		}
	},
	9999
);

/** El Escritorio no está en su menú: al entrar al panel abre Páginas. */
add_action(
	'load-index.php',
	static function () {
		if ( ra_dir_es_editor() ) {
			wp_safe_redirect( admin_url( 'edit.php?post_type=page' ) );
			exit;
		}
	}
);

/** Barra superior: sin comentarios ni «Añadir» de lo que no usa. */
add_action(
	'admin_bar_menu',
	static function ( $bar ) {
		if ( ! ra_dir_es_editor() ) {
			return;
		}
		foreach ( array( 'comments', 'new-post', 'new-media', 'new-user' ) as $node ) {
			$bar->remove_node( $node );
		}
	},
	999
);
