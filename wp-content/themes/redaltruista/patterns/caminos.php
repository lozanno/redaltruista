<?php
/**
 * Title: Caminos – conoce, afíliate, constitúyete
 * Slug: redaltruista/caminos
 * Categories: redaltruista
 * Description: Tres tarjetas con foto: conocer a las asociaciones, afiliarse a la Red o constituirse como asociación.
 *
 * Las imágenes se toman por ID de la Biblioteca de medios (los mismos ID que en producción).
 *
 * @package RedAltruista
 */

$ra_caminos = array(
	array( 1280, '¿Quieres conocer qué asociaciones formamos la RED?', 'Conoce a las asociaciones', '/asociaciones-afiliadas/' ),
	array( 1288, '¿Eres una asociación y quieres afiliarte a la RED Altruista?', 'Solicitar información', '/contactanos/#formulario' ),
	array( 1272, '¿Quieres constituirte como una asociación?', 'Solicitar información', '/contactanos/#formulario' ),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"menta-suave","layout":{"type":"constrained","contentSize":"1170px"}} -->
<div class="wp-block-group alignfull has-menta-suave-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-columns alignwide">
		<?php foreach ( $ra_caminos as list( $ra_foto, $ra_texto, $ra_boton, $ra_url ) ) : ?>
		<!-- wp:column {"className":"ra-accion ra-camino","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|40"}}},"backgroundColor":"blanco"} -->
		<div class="wp-block-column ra-accion ra-camino has-blanco-background-color has-background" style="padding-bottom:var(--wp--preset--spacing--40)">
			<!-- wp:image {"id":<?php echo (int) $ra_foto; ?>,"sizeSlug":"full","linkDestination":"none"} -->
			<figure class="wp-block-image size-full"><img src="<?php echo esc_url( (string) wp_get_attachment_image_url( $ra_foto, 'full' ) ); ?>" alt="Participantes del 2º Encuentro Regional de Organizaciones Sociales" class="wp-image-<?php echo (int) $ra_foto; ?>"/></figure>
			<!-- /wp:image -->

			<!-- wp:paragraph {"style":{"spacing":{"padding":{"left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"fontSize":"large","fontFamily":"montserrat"} -->
			<p class="has-montserrat-font-family has-large-font-size" style="padding-right:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><?php echo esc_html( $ra_texto ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons {"style":{"spacing":{"padding":{"left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}}} -->
			<div class="wp-block-buttons" style="padding-right:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
				<!-- wp:button {"backgroundColor":"primario","textColor":"blanco"} -->
				<div class="wp-block-button"><a class="wp-block-button__link has-blanco-color has-primario-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( $ra_url ); ?>"><?php echo esc_html( $ra_boton ); ?></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
