<?php
/**
 * Title: Página – Contáctanos
 * Slug: redaltruista/pagina-contactanos
 * Categories: redaltruista
 * Post Types: page
 * Block Types: core/post-content
 * Description: Contenido de /contactanos/: medios de contacto y formulario «Contacto» de Contact Form 7. Usar con la plantilla "Página".
 *
 * El formulario se busca por título; se crea con bin/formularios.php.
 *
 * @package RedAltruista
 */

$ra_form = function_exists( 'wpcf7_get_contact_form_by_title' ) ? wpcf7_get_contact_form_by_title( 'Contacto' ) : null;
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"1170px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.35rem","lineHeight":"1.5"}},"fontFamily":"montserrat"} -->
	<p class="has-text-align-center has-montserrat-font-family" style="font-size:1.35rem;line-height:1.5">¿Tienes dudas, quieres afiliar tu asociación o colaborar con la Red? Estamos para ayudarte.</p>
	<!-- /wp:paragraph -->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40"},"margin":{"top":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns alignwide" style="margin-top:var(--wp--preset--spacing--50)">
		<!-- wp:column {"className":"ra-accion","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}},"border":{"top":{"color":"var:preset|color|primario","width":"4px"}}},"backgroundColor":"gris-claro"} -->
		<div class="wp-block-column ra-accion has-gris-claro-background-color has-background" style="border-top-color:var(--wp--preset--color--primario);border-top-width:4px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
			<!-- wp:heading {"level":3,"fontSize":"large"} -->
			<h3 class="wp-block-heading has-large-font-size">WhatsApp y teléfono</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><a href="tel:+523221175552">322 117 5552</a></p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"backgroundColor":"primario","textColor":"blanco"} -->
				<div class="wp-block-button"><a class="wp-block-button__link has-blanco-color has-primario-background-color has-text-color has-background wp-element-button" href="https://wa.me/5213221175552" target="_blank" rel="noreferrer noopener">Escríbenos por WhatsApp</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"className":"ra-accion","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}},"border":{"top":{"color":"var:preset|color|primario-claro","width":"4px"}}},"backgroundColor":"gris-claro"} -->
		<div class="wp-block-column ra-accion has-gris-claro-background-color has-background" style="border-top-color:var(--wp--preset--color--primario-claro);border-top-width:4px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
			<!-- wp:heading {"level":3,"fontSize":"large"} -->
			<h3 class="wp-block-heading has-large-font-size">Correo</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><a href="mailto:info@redaltruista.org">info@redaltruista.org</a></p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"className":"is-style-outline"} -->
				<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#formulario">Usar el formulario</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"className":"ra-accion","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}},"border":{"top":{"color":"var:preset|color|amarillo","width":"4px"}}},"backgroundColor":"gris-claro"} -->
		<div class="wp-block-column ra-accion has-gris-claro-background-color has-background" style="border-top-color:var(--wp--preset--color--amarillo);border-top-width:4px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
			<!-- wp:heading {"level":3,"fontSize":"large"} -->
			<h3 class="wp-block-heading has-large-font-size">Redes sociales</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Síguenos para enterarte de eventos, capacitaciones y convocatorias.</p>
			<!-- /wp:paragraph -->

			<!-- wp:social-links {"iconColor":"blanco","iconColorValue":"#ffffff","iconBackgroundColor":"primario","iconBackgroundColorValue":"#00827b","openInNewTab":true,"size":"has-large-icon-size","style":{"spacing":{"blockGap":{"left":"0.5rem"}}}} -->
			<ul class="wp-block-social-links has-large-icon-size has-icon-color has-icon-background-color">
				<!-- wp:social-link {"url":"https://www.facebook.com/redaltruistavallarta","service":"facebook"} /-->
				<!-- wp:social-link {"url":"https://www.instagram.com/redaltruistavallarta/","service":"instagram"} /-->
			</ul>
			<!-- /wp:social-links -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"anchor":"formulario","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"menta-suave","layout":{"type":"constrained","contentSize":"700px"}} -->
<div id="formulario" class="wp-block-group alignfull has-menta-suave-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:heading {"textAlign":"center"} -->
	<h2 class="wp-block-heading has-text-align-center">Escríbenos</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center"} -->
	<p class="has-text-align-center">Déjanos tu mensaje y te responderemos a la brevedad.</p>
	<!-- /wp:paragraph -->

	<?php if ( $ra_form ) : ?>
	<!-- wp:contact-form-7/contact-form-selector {"id":<?php echo (int) $ra_form->id(); ?>,"hash":"<?php echo esc_attr( $ra_form->hash() ); ?>","title":"Contacto","className":"ra-formulario"} -->
	<div class="wp-block-contact-form-7-contact-form-selector ra-formulario">[contact-form-7 id="<?php echo esc_attr( $ra_form->hash() ); ?>" title="Contacto"]</div>
	<!-- /wp:contact-form-7/contact-form-selector -->
	<?php else : ?>
	<!-- wp:paragraph {"align":"center"} -->
	<p class="has-text-align-center">Falta crear el formulario «Contacto» (bin/formularios.php). Mientras tanto, escríbenos a <a href="mailto:info@redaltruista.org">info@redaltruista.org</a>.</p>
	<!-- /wp:paragraph -->
	<?php endif; ?>
</div>
<!-- /wp:group -->
