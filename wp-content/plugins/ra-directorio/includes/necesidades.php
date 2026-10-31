<?php
/**
 * Tipo de contenido "Necesidad": lo que hoy piden las asociaciones (en especie,
 * económico o voluntariado). Reemplaza a la hoja de Google de /contribuye/.
 *
 * No tiene páginas propias: se muestra con el bloque ra/necesidades en Contribuye
 * y en la ficha de cada asociación. Cuando una necesidad se cubre, va a la papelera;
 * si tiene "Vigente hasta", deja de mostrarse sola al vencer.
 *
 * @package RA_Directorio
 */

defined( 'ABSPATH' ) || exit;

define( 'RA_NEC_CPT', 'necesidad' );

/**
 * Tipos de necesidad.
 *
 * @return array<string,string> slug => etiqueta
 */
function ra_nec_tipos() {
	return array(
		'especie'      => __( 'En especie', 'ra-directorio' ),
		'economico'    => __( 'Económico', 'ra-directorio' ),
		'voluntariado' => __( 'Voluntariado', 'ra-directorio' ),
	);
}

/**
 * Campos de la necesidad (fuente única: caja de edición, guardado e importador).
 *
 * @return array<string, array{label:string, type:string, placeholder?:string}>
 */
function ra_nec_fields() {
	return array(
		'ra_nec_tipo'        => array(
			'label' => __( 'Tipo', 'ra-directorio' ),
			'type'  => 'tipo',
		),
		'ra_nec_asociacion'  => array(
			'label' => __( 'Asociación', 'ra-directorio' ),
			'type'  => 'asociacion',
		),
		'ra_nec_descripcion' => array(
			'label'       => __( 'Descripción', 'ra-directorio' ),
			'type'        => 'textarea',
			'placeholder' => __( 'Qué se necesita, cantidades… (los saltos de línea se respetan)', 'ra-directorio' ),
		),
		'ra_nec_frecuencia'  => array(
			'label'       => __( 'Frecuencia o cantidad', 'ra-directorio' ),
			'type'        => 'text',
			'placeholder' => __( '1 vez al mes, semanal, constante…', 'ra-directorio' ),
		),
		'ra_nec_contacto'    => array(
			'label'       => __( 'Persona de contacto', 'ra-directorio' ),
			'type'        => 'text',
			'placeholder' => '',
		),
		'ra_nec_telefono'    => array(
			'label'       => __( 'Teléfono', 'ra-directorio' ),
			'type'        => 'tel',
			'placeholder' => '322 000 0000',
		),
		'ra_nec_email'       => array(
			'label'       => __( 'Correo electrónico', 'ra-directorio' ),
			'type'        => 'email',
			'placeholder' => 'contacto@…',
		),
		'ra_nec_vigencia'    => array(
			'label' => __( 'Vigente hasta', 'ra-directorio' ),
			'type'  => 'date',
		),
	);
}

/**
 * Limpia un valor según el tipo de campo.
 *
 * @param mixed  $value Valor recibido.
 * @param string $type  Tipo de campo de ra_nec_fields().
 * @return string|int
 */
function ra_nec_sanitize_field( $value, $type ) {
	switch ( $type ) {
		case 'tipo':
			return array_key_exists( $value, ra_nec_tipos() ) ? $value : '';
		case 'asociacion':
			$value = absint( $value );
			return ( $value && RA_DIR_CPT === get_post_type( $value ) ) ? $value : 0;
		case 'textarea':
			return sanitize_textarea_field( $value );
		case 'date':
			return preg_match( '/^\d{4}-\d{2}-\d{2}$/', (string) $value ) ? $value : '';
		case 'email':
			return sanitize_email( $value );
		case 'tel':
			return ra_dir_sanitize_field( $value, 'tel' );
		default:
			return sanitize_text_field( $value );
	}
}

/** Registra el tipo de contenido. */
function ra_nec_register_post_type() {
	register_post_type(
		RA_NEC_CPT,
		array(
			'labels'        => array(
				'name'               => __( 'Necesidades', 'ra-directorio' ),
				'singular_name'      => __( 'Necesidad', 'ra-directorio' ),
				'menu_name'          => __( 'Necesidades', 'ra-directorio' ),
				'all_items'          => __( 'Todas las necesidades', 'ra-directorio' ),
				'add_new'            => __( 'Añadir necesidad', 'ra-directorio' ),
				'add_new_item'       => __( 'Añadir nueva necesidad', 'ra-directorio' ),
				'edit_item'          => __( 'Editar necesidad', 'ra-directorio' ),
				'new_item'           => __( 'Nueva necesidad', 'ra-directorio' ),
				'search_items'       => __( 'Buscar necesidades', 'ra-directorio' ),
				'not_found'          => __( 'No hay necesidades.', 'ra-directorio' ),
				'not_found_in_trash' => __( 'No hay necesidades en la papelera.', 'ra-directorio' ),
				'items_list'         => __( 'Lista de necesidades', 'ra-directorio' ),
			),
			'description'   => __( 'Lo que hoy necesitan las asociaciones de la Red.', 'ra-directorio' ),
			'public'        => false,
			'show_ui'       => true,
			'show_in_rest'  => false, // Editor clásico: título + caja de campos, sin bloques.
			'menu_position' => 21,
			'menu_icon'     => 'dashicons-heart',
			'supports'      => array( 'title', 'revisions' ),
		)
	);
}
add_action( 'init', 'ra_nec_register_post_type' );

/** Placeholder del título. */
add_filter(
	'enter_title_here',
	static function ( $text, $post ) {
		return RA_NEC_CPT === $post->post_type ? __( 'Resumen breve, p. ej. «Insumos para el taller de repostería»', 'ra-directorio' ) : $text;
	},
	10,
	2
);

/**
 * Necesidades vigentes (publicadas y sin vencer), las más recientes primero.
 *
 * @param int $asociacion_id Solo las de esta asociación (0 = todas).
 * @return WP_Post[]
 */
function ra_nec_get_vigentes( $asociacion_id = 0 ) {
	$meta_query = array(
		'relation' => 'AND',
		array(
			'relation' => 'OR',
			array(
				'key'     => 'ra_nec_vigencia',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => 'ra_nec_vigencia',
				'value'   => current_time( 'Y-m-d' ),
				'compare' => '>=',
				'type'    => 'DATE',
			),
		),
	);
	if ( $asociacion_id ) {
		$meta_query[] = array(
			'key'   => 'ra_nec_asociacion',
			'value' => (int) $asociacion_id,
		);
	}
	return get_posts(
		array(
			'post_type'      => RA_NEC_CPT,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'modified',
			'order'          => 'DESC',
			'meta_query'     => $meta_query, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- pocas filas.
		)
	);
}

/* ---------- Caja de edición ---------- */

add_action(
	'add_meta_boxes_' . RA_NEC_CPT,
	static function () {
		add_meta_box( 'ra-nec-datos', __( 'Datos de la necesidad', 'ra-directorio' ), 'ra_nec_render_meta_box', RA_NEC_CPT, 'normal', 'high' );
	}
);

/**
 * Dibuja los campos.
 *
 * @param WP_Post $post Necesidad.
 */
function ra_nec_render_meta_box( $post ) {
	wp_nonce_field( 'ra_nec_save', 'ra_nec_nonce' );
	$asociaciones = get_posts(
		array(
			'post_type'      => RA_DIR_CPT,
			'post_status'    => array( 'publish', 'draft' ),
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		)
	);
	echo '<table class="form-table" role="presentation"><tbody>';
	foreach ( ra_nec_fields() as $key => $field ) {
		$value = get_post_meta( $post->ID, $key, true );
		echo '<tr><th scope="row"><label for="' . esc_attr( $key ) . '">' . esc_html( $field['label'] ) . '</label></th><td>';
		switch ( $field['type'] ) {
			case 'tipo':
				echo '<select id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" required>';
				echo '<option value="">' . esc_html__( '— Elige —', 'ra-directorio' ) . '</option>';
				foreach ( ra_nec_tipos() as $slug => $label ) {
					echo '<option value="' . esc_attr( $slug ) . '"' . selected( $value, $slug, false ) . '>' . esc_html( $label ) . '</option>';
				}
				echo '</select>';
				break;
			case 'asociacion':
				echo '<select id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" required>';
				echo '<option value="">' . esc_html__( '— Elige —', 'ra-directorio' ) . '</option>';
				foreach ( $asociaciones as $asociacion ) {
					echo '<option value="' . esc_attr( $asociacion->ID ) . '"' . selected( (int) $value, $asociacion->ID, false ) . '>' . esc_html( $asociacion->post_title ) . '</option>';
				}
				echo '</select>';
				echo '<p class="description">' . esc_html__( 'Si la organización no está en la lista, primero agrégala en Asociaciones.', 'ra-directorio' ) . '</p>';
				break;
			case 'textarea':
				echo '<textarea id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" rows="8" class="large-text" placeholder="' . esc_attr( $field['placeholder'] ) . '">' . esc_textarea( $value ) . '</textarea>';
				break;
			case 'date':
				echo '<input type="date" id="' . esc_attr( $key ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '" />';
				echo '<p class="description">' . esc_html__( 'Opcional. Después de esta fecha deja de mostrarse en el sitio.', 'ra-directorio' ) . '</p>';
				break;
			default:
				printf(
					'<input type="%1$s" id="%2$s" name="%2$s" value="%3$s" placeholder="%4$s" class="regular-text" />',
					esc_attr( $field['type'] ),
					esc_attr( $key ),
					esc_attr( $value ),
					esc_attr( $field['placeholder'] )
				);
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
	echo '<p class="description">' . esc_html__( 'Cuando la necesidad se cubra, mándala a la papelera.', 'ra-directorio' ) . '</p>';
}

/**
 * Guarda los campos.
 *
 * @param int $post_id ID de la necesidad.
 */
function ra_nec_save_meta_box( $post_id ) {
	if ( ! isset( $_POST['ra_nec_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ra_nec_nonce'] ) ), 'ra_nec_save' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( ra_nec_fields() as $key => $field ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}
		$value = ra_nec_sanitize_field( wp_unslash( $_POST[ $key ] ), $field['type'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- se limpia en ra_nec_sanitize_field().
		if ( '' === $value || 0 === $value ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $value );
		}
	}
}
add_action( 'save_post_' . RA_NEC_CPT, 'ra_nec_save_meta_box' );

/* ---------- Listado del admin: columnas y filtros ---------- */

add_filter(
	'manage_' . RA_NEC_CPT . '_posts_columns',
	static function ( $columns ) {
		return array(
			'cb'                => $columns['cb'],
			'title'             => __( 'Necesidad', 'ra-directorio' ),
			'ra_nec_tipo'       => __( 'Tipo', 'ra-directorio' ),
			'ra_nec_asociacion' => __( 'Asociación', 'ra-directorio' ),
			'ra_nec_vigencia'   => __( 'Vigente hasta', 'ra-directorio' ),
			'ra_nec_modificada' => __( 'Actualizada', 'ra-directorio' ),
		);
	}
);

add_action(
	'manage_' . RA_NEC_CPT . '_posts_custom_column',
	static function ( $column, $post_id ) {
		switch ( $column ) {
			case 'ra_nec_tipo':
				$tipos = ra_nec_tipos();
				$tipo  = get_post_meta( $post_id, 'ra_nec_tipo', true );
				echo isset( $tipos[ $tipo ] ) ? esc_html( $tipos[ $tipo ] ) : '<span aria-hidden="true">—</span>';
				break;
			case 'ra_nec_asociacion':
				$asociacion = (int) get_post_meta( $post_id, 'ra_nec_asociacion', true );
				echo $asociacion ? esc_html( get_the_title( $asociacion ) ) : '<span aria-hidden="true">—</span>';
				break;
			case 'ra_nec_vigencia':
				$vigencia = get_post_meta( $post_id, 'ra_nec_vigencia', true );
				if ( ! $vigencia ) {
					echo '<span aria-hidden="true">—</span>';
					break;
				}
				echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $vigencia ) ) );
				if ( $vigencia < current_time( 'Y-m-d' ) ) {
					echo ' <strong style="color:#d63638">' . esc_html__( '(vencida)', 'ra-directorio' ) . '</strong>';
				}
				break;
			case 'ra_nec_modificada':
				echo esc_html( get_the_modified_date( '', $post_id ) );
				break;
		}
	},
	10,
	2
);

add_filter(
	'manage_edit-' . RA_NEC_CPT . '_sortable_columns',
	static function ( $columns ) {
		$columns['ra_nec_modificada'] = 'modified';
		return $columns;
	}
);

/** Filtros por tipo y por asociación sobre el listado. */
add_action(
	'restrict_manage_posts',
	static function ( $post_type ) {
		if ( RA_NEC_CPT !== $post_type ) {
			return;
		}
		$tipo       = isset( $_GET['ra_nec_tipo'] ) ? sanitize_key( $_GET['ra_nec_tipo'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$asociacion = isset( $_GET['ra_nec_asociacion'] ) ? absint( $_GET['ra_nec_asociacion'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		echo '<select name="ra_nec_tipo"><option value="">' . esc_html__( 'Todos los tipos', 'ra-directorio' ) . '</option>';
		foreach ( ra_nec_tipos() as $slug => $label ) {
			echo '<option value="' . esc_attr( $slug ) . '"' . selected( $tipo, $slug, false ) . '>' . esc_html( $label ) . '</option>';
		}
		echo '</select>';
		echo '<select name="ra_nec_asociacion"><option value="">' . esc_html__( 'Todas las asociaciones', 'ra-directorio' ) . '</option>';
		foreach ( get_posts( array( 'post_type' => RA_DIR_CPT, 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC' ) ) as $item ) {
			echo '<option value="' . esc_attr( $item->ID ) . '"' . selected( $asociacion, $item->ID, false ) . '>' . esc_html( $item->post_title ) . '</option>';
		}
		echo '</select>';
	}
);

add_action(
	'pre_get_posts',
	static function ( $query ) {
		if ( ! is_admin() || ! $query->is_main_query() || RA_NEC_CPT !== $query->get( 'post_type' ) ) {
			return;
		}
		$meta_query = array();
		if ( ! empty( $_GET['ra_nec_tipo'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$meta_query[] = array(
				'key'   => 'ra_nec_tipo',
				'value' => sanitize_key( $_GET['ra_nec_tipo'] ), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			);
		}
		if ( ! empty( $_GET['ra_nec_asociacion'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$meta_query[] = array(
				'key'   => 'ra_nec_asociacion',
				'value' => absint( $_GET['ra_nec_asociacion'] ), // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			);
		}
		if ( $meta_query ) {
			$query->set( 'meta_query', $meta_query );
		}
		if ( ! $query->get( 'orderby' ) ) {
			$query->set( 'orderby', 'modified' );
			$query->set( 'order', 'DESC' );
		}
	}
);
