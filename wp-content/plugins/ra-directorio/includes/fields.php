<?php
/**
 * Definición única de los campos de cada asociación.
 * Si agregas una red social nueva, agrégala aquí y aparece en el formulario,
 * en la REST API y en el bloque de enlaces.
 *
 * @package RA_Directorio
 */

defined( 'ABSPATH' ) || exit;

/**
 * Campos de la asociación.
 *
 * Clave = nombre del meta (con prefijo ra_). `service` = servicio del bloque
 * core/social-link que dibuja el ícono (null = no es red social).
 *
 * @return array<string, array{label:string, type:string, service:?string, placeholder:string}>
 */
function ra_dir_fields() {
	return array(
		'ra_web'       => array(
			'label'       => __( 'Sitio web', 'ra-directorio' ),
			'type'        => 'url',
			'service'     => null,
			'placeholder' => 'https://',
		),
		'ra_facebook'  => array(
			'label'       => 'Facebook',
			'type'        => 'url',
			'service'     => 'facebook',
			'placeholder' => 'https://www.facebook.com/…',
		),
		'ra_instagram' => array(
			'label'       => 'Instagram',
			'type'        => 'url',
			'service'     => 'instagram',
			'placeholder' => 'https://www.instagram.com/…',
		),
		'ra_x'         => array(
			'label'       => 'X (Twitter)',
			'type'        => 'url',
			'service'     => 'x',
			'placeholder' => 'https://x.com/…',
		),
		'ra_tiktok'    => array(
			'label'       => 'TikTok',
			'type'        => 'url',
			'service'     => 'tiktok',
			'placeholder' => 'https://www.tiktok.com/@…',
		),
		'ra_youtube'   => array(
			'label'       => 'YouTube',
			'type'        => 'url',
			'service'     => 'youtube',
			'placeholder' => 'https://www.youtube.com/@…',
		),
		'ra_email'     => array(
			'label'       => __( 'Correo electrónico', 'ra-directorio' ),
			'type'        => 'email',
			'service'     => 'mail',
			'placeholder' => 'contacto@…',
		),
		'ra_telefono'  => array(
			'label'       => __( 'Teléfono', 'ra-directorio' ),
			'type'        => 'tel',
			'service'     => null,
			'placeholder' => '322 000 0000',
		),
	);
}

/**
 * Limpia un valor según el tipo de campo.
 *
 * @param string $value Valor recibido.
 * @param string $type  url|email|tel.
 * @return string
 */
function ra_dir_sanitize_field( $value, $type ) {
	$value = trim( (string) $value );
	if ( '' === $value ) {
		return '';
	}
	switch ( $type ) {
		case 'email':
			return sanitize_email( $value );
		case 'tel':
			return preg_replace( '/[^0-9+\s()\-]/', '', $value );
		case 'url':
		default:
			// Acepta "ejemplo.com" sin protocolo (como pasaba con Clínica Santa Bárbara).
			if ( ! preg_match( '#^[a-z][a-z0-9+.\-]*://#i', $value ) ) {
				$value = 'https://' . ltrim( $value, '/' );
			}
			return esc_url_raw( $value, array( 'http', 'https' ) );
	}
}

/** Registra los campos como post meta (visibles en la REST API y para block bindings). */
function ra_dir_register_meta() {
	foreach ( ra_dir_fields() as $key => $field ) {
		register_post_meta(
			RA_DIR_CPT,
			$key,
			array(
				'type'              => 'string',
				'single'            => true,
				'default'           => '',
				'show_in_rest'      => true,
				'label'             => $field['label'],
				'sanitize_callback' => static function ( $value ) use ( $field ) {
					return ra_dir_sanitize_field( $value, $field['type'] );
				},
				'auth_callback'     => static function ( $allowed, $meta_key, $post_id ) {
					return current_user_can( 'edit_post', $post_id );
				},
			)
		);
	}
}
add_action( 'init', 'ra_dir_register_meta', 11 );
