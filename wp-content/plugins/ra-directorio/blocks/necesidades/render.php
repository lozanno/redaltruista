<?php
/**
 * Render de ra/necesidades.
 *
 * Sin "deAsociacion": todas las necesidades vigentes, con filtro por tipo (Contribuye).
 * Con "deAsociacion": solo las de la asociación en contexto, con título de sección;
 * si no tiene ninguna, no se muestra nada (ficha de la asociación).
 *
 * @var array    $attributes Atributos del bloque.
 * @var string   $content    Contenido interno (no se usa).
 * @var WP_Block $block      Instancia del bloque.
 *
 * @package RA_Directorio
 */

defined( 'ABSPATH' ) || exit;

$ra_de_asociacion = ! empty( $attributes['deAsociacion'] );
$ra_asociacion_id = 0;

if ( $ra_de_asociacion ) {
	$ra_asociacion_id = isset( $block->context['postId'] ) ? (int) $block->context['postId'] : get_the_ID();
	if ( ! $ra_asociacion_id || RA_DIR_CPT !== get_post_type( $ra_asociacion_id ) ) {
		return;
	}
}

$ra_necesidades = ra_nec_get_vigentes( $ra_asociacion_id );
$ra_tipos       = ra_nec_tipos();

if ( ! $ra_necesidades ) {
	if ( $ra_de_asociacion ) {
		return;
	}
	printf(
		'<div %1$s><p class="ra-necesidades__vacio">%2$s</p></div>',
		get_block_wrapper_attributes( array( 'class' => 'ra-necesidades' ) ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		esc_html__( 'Por ahora no hay necesidades publicadas.', 'ra-directorio' )
	);
	return;
}

$ra_html = '';

if ( $ra_de_asociacion && '' !== trim( $attributes['titulo'] ) ) {
	$ra_html .= '<h2 class="wp-block-heading ra-necesidades__titulo">' . esc_html( $attributes['titulo'] ) . '</h2>';
}

// Filtro por tipo: solo los tipos que tienen necesidades. Lo activa view.js (sin JS se ven todas).
if ( ! $ra_de_asociacion && ! empty( $attributes['mostrarFiltro'] ) ) {
	$ra_usados = array_unique( array_map( static fn( $p ) => get_post_meta( $p->ID, 'ra_nec_tipo', true ), $ra_necesidades ) );
	if ( count( $ra_usados ) > 1 ) {
		$ra_botones = '<button type="button" class="ra-filtro__item" data-tipo="" aria-pressed="true">' . esc_html__( 'Todas', 'ra-directorio' ) . '</button>';
		foreach ( $ra_tipos as $ra_slug => $ra_label ) {
			if ( in_array( $ra_slug, $ra_usados, true ) ) {
				$ra_botones .= '<button type="button" class="ra-filtro__item" data-tipo="' . esc_attr( $ra_slug ) . '" aria-pressed="false">' . esc_html( $ra_label ) . '</button>';
			}
		}
		$ra_html .= '<div class="ra-nec-filtro ra-filtro__list" role="group" aria-label="' . esc_attr__( 'Filtrar por tipo', 'ra-directorio' ) . '" hidden>' . $ra_botones . '</div>';
	}
}

$ra_html .= '<div class="ra-nec-lista">';
foreach ( $ra_necesidades as $ra_nec ) {
	$ra_meta = static fn( $key ) => get_post_meta( $ra_nec->ID, $key, true );
	$ra_tipo = $ra_meta( 'ra_nec_tipo' );
	$ra_asoc = (int) $ra_meta( 'ra_nec_asociacion' );

	$ra_cabeza = '';
	if ( ! $ra_de_asociacion && $ra_asoc ) {
		$ra_link = get_permalink( $ra_asoc );
		$ra_logo = get_the_post_thumbnail( $ra_asoc, 'medium', array( 'alt' => '' ) );
		if ( $ra_logo ) {
			$ra_cabeza .= '<a class="ra-nec__logo" href="' . esc_url( $ra_link ) . '" tabindex="-1" aria-hidden="true">' . $ra_logo . '</a>';
		}
	}
	$ra_cabeza .= '<div class="ra-nec__encabezado">';
	if ( isset( $ra_tipos[ $ra_tipo ] ) ) {
		$ra_cabeza .= '<span class="ra-nec__tipo ra-nec__tipo--' . esc_attr( $ra_tipo ) . '">' . esc_html( $ra_tipos[ $ra_tipo ] ) . '</span>';
	}
	$ra_cabeza .= '<h3 class="ra-nec__titulo">' . esc_html( get_the_title( $ra_nec ) ) . '</h3>';
	if ( ! $ra_de_asociacion && $ra_asoc ) {
		$ra_cabeza .= '<a class="ra-nec__asociacion" href="' . esc_url( get_permalink( $ra_asoc ) ) . '">' . esc_html( get_the_title( $ra_asoc ) ) . '</a>';
	}
	$ra_cabeza .= '</div>';

	$ra_cuerpo = '';
	if ( $ra_meta( 'ra_nec_descripcion' ) ) {
		$ra_cuerpo .= '<p class="ra-nec__descripcion">' . nl2br( esc_html( $ra_meta( 'ra_nec_descripcion' ) ) ) . '</p>';
	}
	if ( $ra_meta( 'ra_nec_frecuencia' ) ) {
		$ra_cuerpo .= '<p class="ra-nec__frecuencia"><strong>' . esc_html__( 'Frecuencia o cantidad:', 'ra-directorio' ) . '</strong> ' . esc_html( $ra_meta( 'ra_nec_frecuencia' ) ) . '</p>';
	}

	$ra_contacto = array();
	if ( $ra_meta( 'ra_nec_contacto' ) ) {
		$ra_contacto[] = '<span class="ra-nec__persona">' . esc_html( $ra_meta( 'ra_nec_contacto' ) ) . '</span>';
	}
	if ( $ra_meta( 'ra_nec_telefono' ) ) {
		$ra_tel        = $ra_meta( 'ra_nec_telefono' );
		$ra_contacto[] = '<a href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $ra_tel ) ) . '">' . esc_html( $ra_tel ) . '</a>';
	}
	if ( $ra_meta( 'ra_nec_email' ) ) {
		$ra_contacto[] = '<a href="mailto:' . esc_attr( $ra_meta( 'ra_nec_email' ) ) . '">' . esc_html( $ra_meta( 'ra_nec_email' ) ) . '</a>';
	}
	if ( $ra_contacto ) {
		$ra_cuerpo .= '<p class="ra-nec__contacto">' . implode( '', $ra_contacto ) . '</p>';
	}

	$ra_cuerpo .= '<p class="ra-nec__fecha">' . esc_html(
		/* translators: %s: fecha */
		sprintf( __( 'Actualizada el %s', 'ra-directorio' ), get_the_modified_date( 'j \d\e F \d\e Y', $ra_nec ) )
	) . '</p>';

	$ra_html .= sprintf(
		'<article class="ra-nec" data-tipo="%1$s"><header class="ra-nec__cabeza">%2$s</header>%3$s</article>',
		esc_attr( $ra_tipo ),
		$ra_cabeza,
		$ra_cuerpo
	);
}
$ra_html .= '</div>';

printf(
	'<div %1$s>%2$s</div>',
	get_block_wrapper_attributes( array( 'class' => 'ra-necesidades' ) ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	$ra_html // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado arriba.
);
