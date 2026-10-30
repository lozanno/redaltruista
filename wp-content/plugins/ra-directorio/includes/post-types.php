<?php
/**
 * Tipo de contenido "Asociación" y taxonomía "Área de servicio".
 *
 * URLs resultantes:
 *   /asociaciones-afiliadas/                 → directorio (archivo del CPT)
 *   /asociaciones-afiliadas/pasitos-de-luz/  → ficha de una asociación
 *   /area/salud/                             → directorio filtrado por área
 *
 * @package RA_Directorio
 */

defined( 'ABSPATH' ) || exit;

/** Registra el tipo de contenido. */
function ra_dir_register_post_type() {
	register_post_type(
		RA_DIR_CPT,
		array(
			'labels'        => array(
				'name'                  => __( 'Asociaciones', 'ra-directorio' ),
				'singular_name'         => __( 'Asociación', 'ra-directorio' ),
				'menu_name'             => __( 'Asociaciones', 'ra-directorio' ),
				'all_items'             => __( 'Todas las asociaciones', 'ra-directorio' ),
				'add_new'               => __( 'Añadir asociación', 'ra-directorio' ),
				'add_new_item'          => __( 'Añadir nueva asociación', 'ra-directorio' ),
				'edit_item'             => __( 'Editar asociación', 'ra-directorio' ),
				'new_item'              => __( 'Nueva asociación', 'ra-directorio' ),
				'view_item'             => __( 'Ver asociación', 'ra-directorio' ),
				'view_items'            => __( 'Ver directorio', 'ra-directorio' ),
				'search_items'          => __( 'Buscar asociaciones', 'ra-directorio' ),
				'not_found'             => __( 'No se encontraron asociaciones.', 'ra-directorio' ),
				'not_found_in_trash'    => __( 'No hay asociaciones en la papelera.', 'ra-directorio' ),
				'featured_image'        => __( 'Logo', 'ra-directorio' ),
				'set_featured_image'    => __( 'Asignar logo', 'ra-directorio' ),
				'remove_featured_image' => __( 'Quitar logo', 'ra-directorio' ),
				'use_featured_image'    => __( 'Usar como logo', 'ra-directorio' ),
				'archives'              => __( 'Asociaciones Afiliadas', 'ra-directorio' ),
				'items_list'            => __( 'Lista de asociaciones', 'ra-directorio' ),
			),
			'description'   => __( 'Asociaciones civiles afiliadas a la Red.', 'ra-directorio' ),
			'public'        => true,
			'show_in_rest'  => true,
			'menu_position' => 20,
			'menu_icon'     => 'dashicons-groups',
			'has_archive'   => 'asociaciones-afiliadas',
			'rewrite'       => array(
				'slug'       => 'asociaciones-afiliadas',
				'with_front' => false,
			),
			// page-attributes = campo "Orden" para acomodar el directorio a mano.
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'custom-fields', 'revisions' ),
			// Al crear una asociación nueva, el editor abre con un párrafo listo para la descripción.
			'template'      => array(
				array(
					'core/paragraph',
					array( 'placeholder' => __( 'Descripción breve: qué hace la asociación y a quién atiende…', 'ra-directorio' ) ),
				),
			),
		)
	);
}
add_action( 'init', 'ra_dir_register_post_type' );

/** Registra la taxonomía de áreas de servicio (con casillas, como categorías). */
function ra_dir_register_taxonomy() {
	register_taxonomy(
		RA_DIR_TAX,
		RA_DIR_CPT,
		array(
			'labels'            => array(
				'name'          => __( 'Áreas de servicio', 'ra-directorio' ),
				'singular_name' => __( 'Área de servicio', 'ra-directorio' ),
				'menu_name'     => __( 'Áreas de servicio', 'ra-directorio' ),
				'all_items'     => __( 'Todas las áreas', 'ra-directorio' ),
				'edit_item'     => __( 'Editar área', 'ra-directorio' ),
				'add_new_item'  => __( 'Añadir área', 'ra-directorio' ),
				'search_items'  => __( 'Buscar áreas', 'ra-directorio' ),
				'not_found'     => __( 'No hay áreas.', 'ra-directorio' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'rewrite'           => array(
				'slug'       => 'area',
				'with_front' => false,
			),
		)
	);
}
add_action( 'init', 'ra_dir_register_taxonomy' );

/**
 * Áreas de servicio iniciales (las mismas que aparecen en el inicio del sitio).
 *
 * @return array<string,string> slug => nombre
 */
function ra_dir_default_terms() {
	return array(
		'salud'                  => 'Salud',
		'educacion'              => 'Educación',
		'ninez'                  => 'Niñez',
		'adultos-mayores'        => 'Adultos mayores',
		'discapacidad'           => 'Discapacidad',
		'asistencia-comunitaria' => 'Asistencia comunitaria',
		'derechos-humanos'       => 'Derechos humanos',
		'medio-ambiente'         => 'Medio ambiente',
	);
}

/** Crea las áreas iniciales si no existen. */
function ra_dir_seed_terms() {
	foreach ( ra_dir_default_terms() as $slug => $name ) {
		if ( ! term_exists( $slug, RA_DIR_TAX ) ) {
			wp_insert_term( $name, RA_DIR_TAX, array( 'slug' => $slug ) );
		}
	}
}

/**
 * En el directorio se muestran todas las asociaciones en una sola página,
 * ordenadas por el campo "Orden" y luego alfabéticamente.
 *
 * @param WP_Query $query Consulta principal.
 */
function ra_dir_archive_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_post_type_archive( RA_DIR_CPT ) || $query->is_tax( RA_DIR_TAX ) ) {
		$query->set( 'posts_per_page', -1 );
		$query->set(
			'orderby',
			array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			)
		);
	}
}
add_action( 'pre_get_posts', 'ra_dir_archive_query' );

/** El listado del admin también respeta el orden manual. */
function ra_dir_admin_order( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() || RA_DIR_CPT !== $query->get( 'post_type' ) ) {
		return;
	}
	if ( ! $query->get( 'orderby' ) ) {
		$query->set(
			'orderby',
			array(
				'menu_order' => 'ASC',
				'title'      => 'ASC',
			)
		);
	}
}
add_action( 'pre_get_posts', 'ra_dir_admin_order' );
