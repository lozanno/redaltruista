<?php
/**
 * Marcado de bloques de las páginas de eventos (hijas de Eventos).
 *
 * Cada patrón patterns/evento-*.php solo define los datos del evento y llama a redaltruista_evento().
 * El resultado son bloques normales: al insertar el patrón, todo queda editable en la página.
 *
 * Datos de un evento:
 *   'titulo'      Nombre completo con lema (párrafo de entrada).
 *   'descripcion' Párrafos.
 *   'datos'       array( etiqueta => valor ) — fechas, sede, organizan…
 *   'programa'    array de días: array( 'titulo' => …, 'columnas' => array( 'Hora', 'Actividad' ), 'filas' => array( array( celda, celda ) ) ).
 *                 Las celdas admiten <strong>, <em> y <br>.
 *   'ponentes'    array de array( 'nombre', 'foto' (ID del adjunto, el mismo que en producción), 'cargo', 'bio', 'ponencia' ) — todo opcional salvo nombre.
 *
 * @package RedAltruista
 */

defined( 'ABSPATH' ) || exit;

/** Texto con el formato mínimo permitido en celdas y semblanzas. */
function redaltruista_evento_texto( $texto ) {
	return wp_kses(
		$texto,
		array(
			'strong' => array(),
			'em'     => array(),
			'br'     => array(),
		)
	);
}

/** Devuelve el marcado de bloques de un evento. */
function redaltruista_evento( array $e ) {
	$e = wp_parse_args(
		$e,
		array(
			'titulo'      => '',
			'descripcion' => array(),
			'datos'       => array(),
			'programa'    => array(),
			'ponentes'    => array(),
		)
	);
	ob_start();
	?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"860px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--60)">
	<?php if ( $e['titulo'] ) : ?>
	<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.35rem","lineHeight":"1.5"}},"textColor":"primario","fontFamily":"montserrat"} -->
	<p class="has-primario-color has-text-color has-montserrat-font-family" style="font-size:1.35rem;line-height:1.5"><?php echo redaltruista_evento_texto( $e['titulo'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
	<!-- /wp:paragraph -->
	<?php endif; ?>

	<?php foreach ( $e['descripcion'] as $parrafo ) : ?>
	<!-- wp:paragraph -->
	<p><?php echo redaltruista_evento_texto( $parrafo ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
	<!-- /wp:paragraph -->
	<?php endforeach; ?>

	<?php if ( $e['datos'] ) : ?>
	<!-- wp:list {"className":"ra-evento-datos"} -->
	<ul class="wp-block-list ra-evento-datos">
		<?php foreach ( $e['datos'] as $etiqueta => $valor ) : ?>
		<!-- wp:list-item -->
		<li><strong><?php echo esc_html( $etiqueta ); ?>:</strong> <?php echo redaltruista_evento_texto( $valor ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></li>
		<!-- /wp:list-item -->
		<?php endforeach; ?>
	</ul>
	<!-- /wp:list -->
	<?php endif; ?>
</div>
<!-- /wp:group -->
	<?php if ( $e['programa'] ) : ?>

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"menta-suave","layout":{"type":"constrained","contentSize":"860px"}} -->
<div class="wp-block-group alignfull has-menta-suave-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:heading -->
	<h2 class="wp-block-heading">Programa</h2>
	<!-- /wp:heading -->
		<?php foreach ( $e['programa'] as $dia ) : ?>

	<!-- wp:heading {"level":3,"fontSize":"large","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
	<h3 class="wp-block-heading has-large-font-size" style="margin-top:var(--wp--preset--spacing--50)"><?php echo esc_html( $dia['titulo'] ); ?></h3>
	<!-- /wp:heading -->

	<!-- wp:table {"hasFixedLayout":false,"className":"ra-programa"} -->
	<figure class="wp-block-table ra-programa"><table><thead><tr><?php foreach ( $dia['columnas'] as $columna ) : ?><th><?php echo esc_html( $columna ); ?></th><?php endforeach; ?></tr></thead><tbody><?php foreach ( $dia['filas'] as $fila ) : ?><tr><?php foreach ( $fila as $celda ) : ?><td><?php echo redaltruista_evento_texto( $celda ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td><?php endforeach; ?></tr><?php endforeach; ?></tbody></table></figure>
	<!-- /wp:table -->
		<?php endforeach; ?>
</div>
<!-- /wp:group -->
	<?php endif; ?>
	<?php if ( $e['ponentes'] ) : ?>

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"gris-claro","layout":{"type":"constrained","contentSize":"1170px"}} -->
<div class="wp-block-group alignfull has-gris-claro-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:heading {"textAlign":"center"} -->
	<h2 class="wp-block-heading has-text-align-center">Ponentes</h2>
	<!-- /wp:heading -->

	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40","margin":{"top":"var:preset|spacing|50"}}},"layout":{"type":"grid","minimumColumnWidth":"16rem"}} -->
	<div class="wp-block-group alignwide" style="margin-top:var(--wp--preset--spacing--50)">
		<?php
		foreach ( $e['ponentes'] as $p ) :
			$p    = wp_parse_args( $p, array( 'foto' => 0, 'cargo' => '', 'bio' => '', 'ponencia' => '' ) );
			$foto = (int) $p['foto'];
			?>
		<!-- wp:group {"className":"ra-persona","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"backgroundColor":"blanco","layout":{"type":"constrained"}} -->
		<div class="wp-block-group ra-persona has-blanco-background-color has-background" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
			<?php if ( $foto ) : ?>
			<!-- wp:image {"id":<?php echo (int) $foto; ?>,"sizeSlug":"medium","linkDestination":"none","align":"center","className":"ra-persona__foto"} -->
			<figure class="wp-block-image aligncenter size-medium ra-persona__foto"><img src="<?php echo esc_url( (string) wp_get_attachment_image_url( $foto, 'medium' ) ); ?>" alt="<?php echo esc_attr( $p['nombre'] ); ?>" class="wp-image-<?php echo (int) $foto; ?>"/></figure>
			<!-- /wp:image -->
			<?php endif; ?>

			<!-- wp:heading {"textAlign":"center","level":3,"fontSize":"large"} -->
			<h3 class="wp-block-heading has-text-align-center has-large-font-size"><?php echo esc_html( $p['nombre'] ); ?></h3>
			<!-- /wp:heading -->
			<?php if ( $p['cargo'] ) : ?>

			<!-- wp:paragraph {"align":"center","className":"ra-persona__org","textColor":"primario","fontSize":"small"} -->
			<p class="has-text-align-center ra-persona__org has-primario-color has-text-color has-small-font-size"><?php echo redaltruista_evento_texto( $p['cargo'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<!-- /wp:paragraph -->
			<?php endif; ?>
			<?php if ( $p['bio'] ) : ?>

			<!-- wp:paragraph {"fontSize":"small"} -->
			<p class="has-small-font-size"><?php echo redaltruista_evento_texto( $p['bio'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<!-- /wp:paragraph -->
			<?php endif; ?>
			<?php if ( $p['ponencia'] ) : ?>

			<!-- wp:paragraph {"fontSize":"small"} -->
			<p class="has-small-font-size"><strong>Ponencia:</strong> <?php echo redaltruista_evento_texto( $p['ponencia'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<!-- /wp:paragraph -->
			<?php endif; ?>
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
	<?php endif; ?>

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}},"layout":{"type":"constrained","contentSize":"860px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
	<!-- wp:paragraph {"className":"ra-volver"} -->
	<p class="ra-volver"><a href="<?php echo esc_url( home_url( '/eventos/' ) ); ?>">← Todos los eventos</a></p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
	<?php
	return ob_get_clean();
}
