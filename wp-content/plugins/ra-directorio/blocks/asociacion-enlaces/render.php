<?php
/**
 * Render de ra/asociacion-enlaces.
 *
 * @var array    $attributes Atributos del bloque.
 * @var string   $content    Contenido interno (no se usa).
 * @var WP_Block $block      Instancia del bloque.
 *
 * @package RA_Directorio
 */

defined( 'ABSPATH' ) || exit;

$ra_post_id = isset( $block->context['postId'] ) ? (int) $block->context['postId'] : get_the_ID();
if ( ! $ra_post_id || RA_DIR_CPT !== get_post_type( $ra_post_id ) ) {
	return;
}

$ra_web     = get_post_meta( $ra_post_id, 'ra_web', true );
$ra_name    = get_the_title( $ra_post_id );
$ra_links   = '';
$ra_contact = '';

// Redes sociales: se reutiliza el bloque core/social-links para tener sus íconos y estilos.
foreach ( ra_dir_fields() as $ra_key => $ra_field ) {
	if ( empty( $ra_field['service'] ) ) {
		continue;
	}
	$ra_value = get_post_meta( $ra_post_id, $ra_key, true );
	if ( '' === $ra_value ) {
		continue;
	}
	$ra_url    = 'mail' === $ra_field['service'] ? 'mailto:' . $ra_value : $ra_value;
	$ra_links .= sprintf(
		'<!-- wp:social-link %s /-->',
		wp_json_encode(
			array(
				'url'     => $ra_url,
				'service' => $ra_field['service'],
				/* translators: 1: red social, 2: nombre de la asociación */
				'label'   => sprintf( __( '%1$s de %2$s', 'ra-directorio' ), $ra_field['label'], $ra_name ),
			)
		)
	);
}

$ra_social = '';
if ( $ra_links ) {
	$ra_social = do_blocks(
		'<!-- wp:social-links {"openInNewTab":true,"size":"has-small-icon-size","className":"is-style-logos-only ra-redes"} --><ul class="wp-block-social-links has-small-icon-size is-style-logos-only ra-redes">'
		. $ra_links
		. '</ul><!-- /wp:social-links -->'
	);
}

$ra_button = '';
if ( ! empty( $attributes['showButton'] ) && $ra_web ) {
	$ra_button = sprintf(
		'<div class="wp-block-button ra-web"><a class="wp-block-button__link wp-element-button" href="%1$s" target="_blank" rel="noopener">%2$s<span class="screen-reader-text"> — %3$s</span></a></div>',
		esc_url( $ra_web ),
		esc_html( $attributes['buttonText'] ),
		esc_html( $ra_name )
	);
	$ra_button = '<div class="wp-block-buttons">' . $ra_button . '</div>';
}

if ( ! empty( $attributes['showContact'] ) ) {
	$ra_tel   = get_post_meta( $ra_post_id, 'ra_telefono', true );
	$ra_email = get_post_meta( $ra_post_id, 'ra_email', true );
	$ra_items = array();
	if ( $ra_tel ) {
		$ra_items[] = '<a href="tel:' . esc_attr( preg_replace( '/[^0-9+]/', '', $ra_tel ) ) . '">' . esc_html( $ra_tel ) . '</a>';
	}
	if ( $ra_email ) {
		$ra_items[] = '<a href="mailto:' . esc_attr( $ra_email ) . '">' . esc_html( $ra_email ) . '</a>';
	}
	if ( $ra_items ) {
		$ra_contact = '<p class="ra-contacto">' . implode( ' · ', $ra_items ) . '</p>';
	}
}

if ( ! $ra_button && ! $ra_social && ! $ra_contact ) {
	return;
}

printf(
	'<div %1$s>%2$s%3$s%4$s</div>',
	get_block_wrapper_attributes( array( 'class' => 'ra-enlaces' ) ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	$ra_button, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado arriba.
	$ra_social, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- render de core.
	$ra_contact // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado arriba.
);
