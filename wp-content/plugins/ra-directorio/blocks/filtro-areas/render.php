<?php
/**
 * Render de ra/filtro-areas.
 *
 * @var array    $attributes Atributos del bloque.
 * @var string   $content    Contenido interno (no se usa).
 * @var WP_Block $block      Instancia del bloque.
 *
 * @package RA_Directorio
 */

defined( 'ABSPATH' ) || exit;

$ra_terms = get_terms(
	array(
		'taxonomy'   => RA_DIR_TAX,
		'hide_empty' => true,
	)
);

if ( is_wp_error( $ra_terms ) || empty( $ra_terms ) ) {
	return;
}

$ra_current = is_tax( RA_DIR_TAX ) ? get_queried_object_id() : 0;
$ra_items   = array();

$ra_items[] = sprintf(
	'<li><a href="%1$s" class="ra-filtro__item%2$s"%3$s>%4$s</a></li>',
	esc_url( get_post_type_archive_link( RA_DIR_CPT ) ),
	$ra_current ? '' : ' is-active',
	$ra_current ? '' : ' aria-current="page"',
	esc_html( $attributes['allLabel'] )
);

foreach ( $ra_terms as $ra_term ) {
	$ra_active  = ( (int) $ra_term->term_id === (int) $ra_current );
	$ra_items[] = sprintf(
		'<li><a href="%1$s" class="ra-filtro__item%2$s"%3$s>%4$s%5$s</a></li>',
		esc_url( get_term_link( $ra_term ) ),
		$ra_active ? ' is-active' : '',
		$ra_active ? ' aria-current="page"' : '',
		esc_html( $ra_term->name ),
		! empty( $attributes['showCount'] ) ? ' <span class="ra-filtro__count">' . (int) $ra_term->count . '</span>' : ''
	);
}

printf(
	'<nav %1$s aria-label="%2$s"><ul class="ra-filtro__list">%3$s</ul></nav>',
	get_block_wrapper_attributes( array( 'class' => 'ra-filtro' ) ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	esc_attr__( 'Filtrar por área de servicio', 'ra-directorio' ),
	implode( '', $ra_items ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado arriba.
);
