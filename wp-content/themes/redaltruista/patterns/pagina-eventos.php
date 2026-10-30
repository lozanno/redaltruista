<?php
/**
 * Title: Página – Eventos
 * Slug: redaltruista/pagina-eventos
 * Categories: redaltruista
 * Post Types: page
 * Block Types: core/post-content
 * Description: Contenido de /eventos/: introducción y cuadrícula automática con las páginas hijas de Eventos (más reciente primero). Usar con la plantilla "Página".
 *
 * Cada evento es una página hija de Eventos con imagen destacada; el orden sale de su fecha de publicación.
 *
 * @package RedAltruista
 */

$ra_eventos = get_page_by_path( 'eventos' );
$ra_padre   = $ra_eventos ? (int) $ra_eventos->ID : 0;
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"1170px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.35rem","lineHeight":"1.5"}},"fontFamily":"montserrat"} -->
	<p class="has-text-align-center has-montserrat-font-family" style="font-size:1.35rem;line-height:1.5">Junto con Fundación Punta de Mita organizamos el Encuentro Regional de Organizaciones Sociales (ENROS), un espacio formativo y de vinculación para fortalecer las capacidades de las organizaciones civiles y grupos de base de la región. También impulsamos programas de capacitación como el Diplomado en Administración de Organizaciones Civiles.</p>
	<!-- /wp:paragraph -->

	<!-- wp:query {"queryId":2,"query":{"perPage":24,"pages":0,"offset":0,"postType":"page","order":"desc","orderBy":"date","inherit":false,"parents":[<?php echo (int) $ra_padre; ?>]},"align":"wide","layout":{"type":"default"}} -->
	<div class="wp-block-query alignwide">
		<!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","minimumColumnWidth":"300px"}} -->
			<!-- wp:group {"className":"ra-card ra-evento","style":{"spacing":{"padding":{"top":"0","bottom":"var:preset|spacing|40","left":"0","right":"0"},"blockGap":"var:preset|spacing|30"},"border":{"radius":"6px","width":"1px","color":"#e8eeee"}},"backgroundColor":"blanco","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
			<div class="wp-block-group ra-card ra-evento has-border-color has-blanco-background-color has-background" style="border-color:#e8eeee;border-width:1px;border-radius:6px;padding-top:0;padding-right:0;padding-bottom:var(--wp--preset--spacing--40);padding-left:0">
				<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"4/3","style":{"spacing":{"margin":{"bottom":"0"}}}} /-->

				<!-- wp:post-title {"level":3,"isLink":true,"style":{"spacing":{"padding":{"left":"var:preset|spacing|40","right":"var:preset|spacing|40"}},"typography":{"fontSize":"1.2rem","letterSpacing":"0.5px","fontWeight":"500"}}} /-->

				<!-- wp:read-more {"content":"Ver evento","style":{"spacing":{"padding":{"left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}}} /-->
			</div>
			<!-- /wp:group -->
		<!-- /wp:post-template -->

		<!-- wp:query-no-results -->
			<!-- wp:paragraph {"align":"center"} -->
			<p class="has-text-align-center">Pronto publicaremos nuestros próximos eventos.</p>
			<!-- /wp:paragraph -->
		<!-- /wp:query-no-results -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"redaltruista/cta-afiliate"} /-->
