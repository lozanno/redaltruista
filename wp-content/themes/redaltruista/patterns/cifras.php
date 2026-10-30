<?php
/**
 * Title: Cifras de impacto
 * Slug: redaltruista/cifras
 * Categories: redaltruista
 * Description: Tres cifras sobre fondo de textura. El número de asociaciones sale del directorio ([ra_total_asociaciones]); voluntarios y proyectos los actualiza el cliente.
 *
 * @package RedAltruista
 */

?>
<!-- wp:cover {"url":"<?php echo esc_url( content_url( '/uploads/container.jpg' ) ); ?>","dimRatio":30,"overlayColor":"oscuro","isDark":true,"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"textColor":"blanco","layout":{"type":"constrained","contentSize":"1170px"}} -->
<div class="wp-block-cover alignfull has-blanco-color has-text-color" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( content_url( '/uploads/container.jpg' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-oscuro-background-color has-background-dim-30 has-background-dim"></span><div class="wp-block-cover__inner-container">
	<!-- wp:columns {"align":"wide"} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column {"className":"ra-cifra"} -->
		<div class="wp-block-column ra-cifra">
			<!-- wp:paragraph {"align":"center","className":"ra-cifra__numero","style":{"typography":{"fontSize":"3.5rem"}},"textColor":"amarillo"} -->
			<p class="has-text-align-center ra-cifra__numero has-amarillo-color has-text-color" style="font-size:3.5rem">203</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center">Voluntarios integrando la red</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"className":"ra-cifra"} -->
		<div class="wp-block-column ra-cifra">
			<!-- wp:paragraph {"align":"center","className":"ra-cifra__numero","style":{"typography":{"fontSize":"3.5rem"}},"textColor":"amarillo"} -->
			<p class="has-text-align-center ra-cifra__numero has-amarillo-color has-text-color" style="font-size:3.5rem">32</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center">Proyectos activos</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"className":"ra-cifra"} -->
		<div class="wp-block-column ra-cifra">
			<!-- wp:paragraph {"align":"center","className":"ra-cifra__numero","style":{"typography":{"fontSize":"3.5rem"}},"textColor":"amarillo"} -->
			<p class="has-text-align-center ra-cifra__numero has-amarillo-color has-text-color" style="font-size:3.5rem">[ra_total_asociaciones]</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center">Asociaciones afiliadas</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div></div>
<!-- /wp:cover -->
