<?php
/**
 * Title: Cifras de impacto
 * Slug: redaltruista/cifras
 * Categories: redaltruista
 * Description: Tres cifras. El número de asociaciones se calcula solo; voluntarios y proyectos (XX) los captura el cliente.
 *
 * @package RedAltruista
 */

$ra_total = post_type_exists( 'asociacion' ) ? (int) wp_count_posts( 'asociacion' )->publish : 0;
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"oscuro","textColor":"blanco","layout":{"type":"constrained","contentSize":"1170px"}} -->
<div class="wp-block-group alignfull has-blanco-color has-oscuro-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:columns {"align":"wide"} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column {"className":"ra-cifra"} -->
		<div class="wp-block-column ra-cifra">
			<!-- wp:paragraph {"align":"center","className":"ra-cifra__numero","style":{"typography":{"fontSize":"3.5rem"}},"textColor":"amarillo"} -->
			<p class="has-text-align-center ra-cifra__numero has-amarillo-color has-text-color" style="font-size:3.5rem">XX</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center">Voluntarios integrando la red</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"className":"ra-cifra"} -->
		<div class="wp-block-column ra-cifra">
			<!-- wp:paragraph {"align":"center","className":"ra-cifra__numero","style":{"typography":{"fontSize":"3.5rem"}},"textColor":"amarillo"} -->
			<p class="has-text-align-center ra-cifra__numero has-amarillo-color has-text-color" style="font-size:3.5rem">XX</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center">Proyectos activos</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"className":"ra-cifra"} -->
		<div class="wp-block-column ra-cifra">
			<!-- wp:paragraph {"align":"center","className":"ra-cifra__numero","style":{"typography":{"fontSize":"3.5rem"}},"textColor":"amarillo"} -->
			<p class="has-text-align-center ra-cifra__numero has-amarillo-color has-text-color" style="font-size:3.5rem"><?php echo esc_html( $ra_total ? $ra_total : 28 ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center">Asociaciones afiliadas</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
