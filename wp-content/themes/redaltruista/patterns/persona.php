<?php
/**
 * Title: Tarjeta de persona
 * Slug: redaltruista/persona
 * Categories: redaltruista
 * Description: Foto redonda, nombre, cargo y semblanza plegable. Para consejos y equipos (va dentro de una cuadrícula).
 *
 * @package RedAltruista
 */

?>
<!-- wp:group {"className":"ra-persona","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"backgroundColor":"blanco","layout":{"type":"constrained"}} -->
<div class="wp-block-group ra-persona has-blanco-background-color has-background" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
	<!-- wp:image {"sizeSlug":"medium","linkDestination":"none","align":"center","className":"ra-persona__foto"} -->
	<figure class="wp-block-image aligncenter size-medium ra-persona__foto"><img alt=""/></figure>
	<!-- /wp:image -->

	<!-- wp:heading {"textAlign":"center","level":3,"fontSize":"large"} -->
	<h3 class="wp-block-heading has-text-align-center has-large-font-size">Nombre completo</h3>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","className":"ra-persona__cargo","textColor":"primario"} -->
	<p class="has-text-align-center ra-persona__cargo has-primario-color has-text-color">Cargo</p>
	<!-- /wp:paragraph -->

	<!-- wp:details -->
	<details class="wp-block-details"><summary>Leer semblanza</summary>
		<!-- wp:paragraph -->
		<p>Escribe aquí la semblanza.</p>
		<!-- /wp:paragraph -->
	</details>
	<!-- /wp:details -->
</div>
<!-- /wp:group -->
