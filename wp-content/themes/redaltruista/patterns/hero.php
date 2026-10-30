<?php
/**
 * Title: Portada – Juntos por un bien común
 * Slug: redaltruista/hero
 * Categories: redaltruista, banner
 * Description: Portada de inicio con imagen de fondo, titular y botones de voluntariado y donativos.
 *
 * @package RedAltruista
 */

?>
<!-- wp:cover {"url":"<?php echo esc_url( content_url( '/uploads/container-683x1024.jpg' ) ); ?>","dimRatio":80,"overlayColor":"primario","minHeight":560,"contentPosition":"center center","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},"layout":{"type":"constrained","contentSize":"860px"}} -->
<div class="wp-block-cover alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);min-height:560px"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( content_url( '/uploads/container-683x1024.jpg' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-primario-background-color has-background-dim-80 has-background-dim"></span><div class="wp-block-cover__inner-container">
	<!-- wp:heading {"textAlign":"center","level":1,"textColor":"blanco"} -->
	<h1 class="wp-block-heading has-text-align-center has-blanco-color has-text-color">Juntos por un bien común</h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.35rem","lineHeight":"1.5"}},"textColor":"blanco","fontFamily":"montserrat"} -->
	<p class="has-text-align-center has-blanco-color has-text-color has-montserrat-font-family" style="font-size:1.35rem;line-height:1.5">No somos solo asociaciones: somos una RED de personas y organizaciones que estamos trabajando profesionalmente para quienes más lo necesitan. Tu participación puede ser la diferencia: únete, dona o participa.</p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"},"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)">
		<!-- wp:button {"backgroundColor":"amarillo","textColor":"oscuro"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-oscuro-color has-amarillo-background-color has-text-color has-background wp-element-button" href="https://donate.stripe.com/00g8yAfDYbyl6Ry144" target="_blank" rel="noreferrer noopener">Dona</a></div>
		<!-- /wp:button -->

		<!-- wp:button {"textColor":"blanco","className":"is-style-outline"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-blanco-color has-text-color wp-element-button" href="https://docs.google.com/forms/d/e/1FAIpQLSeTDYpVYLz9z618f150nA9nlAglILU7e1nqI7gHGfTe-Y7kNg/viewform" target="_blank" rel="noreferrer noopener">Sé voluntario</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div></div>
<!-- /wp:cover -->
