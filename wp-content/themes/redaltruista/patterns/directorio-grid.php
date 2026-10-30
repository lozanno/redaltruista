<?php
/**
 * Title: Directorio – cuadrícula de asociaciones
 * Slug: redaltruista/directorio-grid
 * Categories: redaltruista
 * Inserter: false
 * Description: Lista de asociaciones en tarjetas. Lo usan las plantillas del directorio y de áreas de servicio.
 *
 * @package RedAltruista
 */

?>
<!-- wp:query {"queryId":1,"query":{"perPage":-1,"postType":"asociacion","inherit":true},"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-query alignwide">
	<!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","minimumColumnWidth":"300px"}} -->
		<!-- wp:group {"className":"ra-card","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|30"},"border":{"radius":"6px","width":"1px","color":"#e8eeee"}},"backgroundColor":"blanco","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
		<div class="wp-block-group ra-card has-border-color has-blanco-background-color has-background" style="border-color:#e8eeee;border-width:1px;border-radius:6px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
			<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","scale":"contain","height":"180px","style":{"spacing":{"margin":{"bottom":"0"}}}} /-->

			<!-- wp:post-title {"level":3,"isLink":true,"style":{"typography":{"fontSize":"1.2rem","letterSpacing":"0.5px","fontWeight":"500"}}} /-->

			<!-- wp:post-terms {"term":"area-servicio","separator":" · ","style":{"typography":{"fontSize":"0.8rem","textTransform":"uppercase","letterSpacing":"1px"}},"textColor":"primario-claro","fontFamily":"roboto-condensed"} /-->

			<!-- wp:post-content {"style":{"typography":{"fontSize":"0.95rem","lineHeight":"1.55"}},"layout":{"type":"default"}} /-->

			<!-- wp:ra/asociacion-enlaces {"style":{"spacing":{"margin":{"top":"auto"}}}} /-->
		</div>
		<!-- /wp:group -->
	<!-- /wp:post-template -->

	<!-- wp:query-no-results -->
		<!-- wp:paragraph -->
		<p>No hay asociaciones en esta área por ahora.</p>
		<!-- /wp:paragraph -->
	<!-- /wp:query-no-results -->
</div>
<!-- /wp:query -->
