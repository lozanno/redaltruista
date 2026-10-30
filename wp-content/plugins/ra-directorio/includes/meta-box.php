<?php
/**
 * Caja "Enlaces y redes sociales" en la pantalla de edición de cada asociación.
 * Es una meta box clásica a propósito: funciona en el editor de bloques sin
 * necesidad de compilar JavaScript y es fácil de usar para el cliente.
 *
 * @package RA_Directorio
 */

defined( 'ABSPATH' ) || exit;

/** Agrega la caja. */
function ra_dir_add_meta_box() {
	add_meta_box(
		'ra-dir-enlaces',
		__( 'Enlaces y redes sociales', 'ra-directorio' ),
		'ra_dir_render_meta_box',
		RA_DIR_CPT,
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'ra_dir_add_meta_box' );

/**
 * Dibuja los campos.
 *
 * @param WP_Post $post Asociación.
 */
function ra_dir_render_meta_box( $post ) {
	wp_nonce_field( 'ra_dir_save', 'ra_dir_nonce' );
	echo '<p class="description">' . esc_html__( 'Deja vacío lo que no aplique: en el sitio solo aparecen los enlaces que tengan valor.', 'ra-directorio' ) . '</p>';
	echo '<table class="form-table" role="presentation"><tbody>';
	foreach ( ra_dir_fields() as $key => $field ) {
		$value = get_post_meta( $post->ID, $key, true );
		printf(
			'<tr><th scope="row"><label for="%1$s">%2$s</label></th><td><input type="%3$s" id="%1$s" name="%1$s" value="%4$s" placeholder="%5$s" class="large-text" /></td></tr>',
			esc_attr( $key ),
			esc_html( $field['label'] ),
			esc_attr( 'url' === $field['type'] ? 'text' : $field['type'] ), // "text" para aceptar dominios sin https://.
			esc_attr( $value ),
			esc_attr( $field['placeholder'] )
		);
	}
	echo '</tbody></table>';
}

/**
 * Guarda los campos.
 *
 * @param int $post_id ID de la asociación.
 */
function ra_dir_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['ra_dir_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ra_dir_nonce'] ) ), 'ra_dir_save' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( ra_dir_fields() as $key => $field ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}
		$value = ra_dir_sanitize_field( wp_unslash( $_POST[ $key ] ), $field['type'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- se limpia en ra_dir_sanitize_field().
		if ( '' === $value ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $value );
		}
	}
}
add_action( 'save_post_' . RA_DIR_CPT, 'ra_dir_save_meta_box' );
