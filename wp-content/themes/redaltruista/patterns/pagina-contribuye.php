<?php
/**
 * Title: Página – Contribuye
 * Slug: redaltruista/pagina-contribuye
 * Categories: redaltruista
 * Post Types: page
 * Block Types: core/post-content
 * Description: Contenido completo de /contribuye/: formas de contribuir, lista de necesidades (hoja de Google incrustada) y contacto. Usar con la plantilla "Página".
 *
 * La lista de necesidades la mantiene el cliente en Google Sheets; aquí solo se incrusta.
 *
 * @package RedAltruista
 */

$ra_hoja = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vSeP-_QG5eDDuwnP3EdMe92Imdnag5O1gwZJ7qdtnLblZaWHoqBaMFz7oVBWRkDKAKbFqfU_64VsAsQ/pubhtml';
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"1170px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.35rem","lineHeight":"1.5"}},"fontFamily":"montserrat"} -->
	<p class="has-text-align-center has-montserrat-font-family" style="font-size:1.35rem;line-height:1.5">Puedes donar en efectivo —una sola vez, cada mes o cada año— o en especie: lo que tú ya no necesites, nosotros lo podemos donar a quien realmente lo necesite.</p>
	<!-- /wp:paragraph -->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40"},"margin":{"top":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns alignwide" style="margin-top:var(--wp--preset--spacing--50)">
		<!-- wp:column {"className":"ra-accion","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}},"border":{"top":{"color":"var:preset|color|primario","width":"4px"}}},"backgroundColor":"gris-claro"} -->
		<div class="wp-block-column ra-accion has-gris-claro-background-color has-background" style="border-top-color:var(--wp--preset--color--primario);border-top-width:4px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
			<!-- wp:heading {"level":3,"fontSize":"large"} -->
			<h3 class="wp-block-heading has-large-font-size">Dona en efectivo</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Haz un donativo único o recurrente, mensual o anual. Tu aportación fortalece el trabajo de las asociaciones de la Red.</p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"backgroundColor":"amarillo","textColor":"oscuro"} -->
				<div class="wp-block-button"><a class="wp-block-button__link has-oscuro-color has-amarillo-background-color has-text-color has-background wp-element-button" href="https://donate.stripe.com/00g8yAfDYbyl6Ry144" target="_blank" rel="noreferrer noopener">Dona</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"className":"ra-accion","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}},"border":{"top":{"color":"var:preset|color|primario-claro","width":"4px"}}},"backgroundColor":"gris-claro"} -->
		<div class="wp-block-column ra-accion has-gris-claro-background-color has-background" style="border-top-color:var(--wp--preset--color--primario-claro);border-top-width:4px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
			<!-- wp:heading {"level":3,"fontSize":"large"} -->
			<h3 class="wp-block-heading has-large-font-size">Dona en especie</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Ropa, alimentos, artículos de limpieza, material didáctico… Revisa lo que necesitan hoy las asociaciones y nosotros lo hacemos llegar.</p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"className":"is-style-outline"} -->
				<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#necesidades">Ver necesidades</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"className":"ra-accion","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}},"border":{"top":{"color":"var:preset|color|amarillo","width":"4px"}}},"backgroundColor":"gris-claro"} -->
		<div class="wp-block-column ra-accion has-gris-claro-background-color has-background" style="border-top-color:var(--wp--preset--color--amarillo);border-top-width:4px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
			<!-- wp:heading {"level":3,"fontSize":"large"} -->
			<h3 class="wp-block-heading has-large-font-size">Sé voluntario</h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Comparte tu tiempo y tu talento con las asociaciones de Puerto Vallarta y Bahía de Banderas.</p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"backgroundColor":"primario","textColor":"blanco"} -->
				<div class="wp-block-button"><a class="wp-block-button__link has-blanco-color has-primario-background-color has-text-color has-background wp-element-button" href="https://docs.google.com/forms/d/e/1FAIpQLSeTDYpVYLz9z618f150nA9nlAglILU7e1nqI7gHGfTe-Y7kNg/viewform" target="_blank" rel="noreferrer noopener">Regístrate</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"anchor":"necesidades","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"menta-suave","layout":{"type":"constrained","contentSize":"1170px"}} -->
<div id="necesidades" class="wp-block-group alignfull has-menta-suave-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:heading {"textAlign":"center"} -->
	<h2 class="wp-block-heading has-text-align-center">Lista de necesidades de las asociaciones</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center"} -->
	<p class="has-text-align-center">Lo que hoy piden las asociaciones de la Red: donativos en especie, económicos y voluntariado. Comunícate directamente con el contacto de cada organización.</p>
	<!-- /wp:paragraph -->

	<!-- wp:html -->
	<div class="ra-hoja alignwide"><iframe src="<?php echo esc_url( $ra_hoja . '?widget=true&headers=false' ); ?>" title="Lista de necesidades de las asociaciones" loading="lazy"></iframe></div>
	<!-- /wp:html -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons">
		<!-- wp:button {"className":"is-style-outline"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $ra_hoja ); ?>" target="_blank" rel="noreferrer noopener">Abrir la lista completa</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}},"elements":{"link":{"color":{"text":"var:preset|color|blanco"}}}},"gradient":"turquesa","textColor":"blanco","layout":{"type":"constrained","contentSize":"780px"}} -->
<div class="wp-block-group alignfull has-blanco-color has-turquesa-gradient-background has-text-color has-background has-link-color" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:heading {"textAlign":"center","textColor":"blanco"} -->
	<h2 class="wp-block-heading has-text-align-center has-blanco-color has-text-color">¿No encuentras lo que buscas?</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.1rem"}}} -->
	<p class="has-text-align-center" style="font-size:1.1rem">Si deseas donar o hacer un voluntariado que no se encuentre en la lista, escríbenos y te ponemos en contacto con la asociación indicada.</p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"amarillo","textColor":"oscuro"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-oscuro-color has-amarillo-background-color has-text-color has-background wp-element-button" href="mailto:info@redaltruista.org">info@redaltruista.org</a></div>
		<!-- /wp:button -->

		<!-- wp:button {"textColor":"blanco","className":"is-style-outline"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-blanco-color has-text-color wp-element-button" href="https://wa.me/5213221175552" target="_blank" rel="noreferrer noopener">WhatsApp 322 117 5552</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
