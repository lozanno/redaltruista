<?php
/**
 * Title: Página – Inicio
 * Slug: redaltruista/pagina-inicio
 * Categories: redaltruista
 * Post Types: page
 * Block Types: core/post-content
 * Description: Contenido completo del inicio: portada, objetivo, caminos, programas, cifras y asociaciones. Usar con la plantilla "Página sin título".
 *
 * Junta los patrones de cada sección para que su contenido quede en la página y el cliente pueda editarlo
 * (p. ej. las cifras); cada sección sigue disponible por separado en el insertador.
 *
 * @package RedAltruista
 */

$ra_secciones = array( 'hero', 'objetivo', 'caminos', 'programas', 'cifras', 'nuestras-asociaciones' );
$ra_registro  = WP_Block_Patterns_Registry::get_instance();

foreach ( $ra_secciones as $ra_seccion ) {
	$ra_patron = $ra_registro->get_registered( 'redaltruista/' . $ra_seccion );
	if ( $ra_patron ) {
		echo $ra_patron['content'] . "\n\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- marcado de bloques del propio tema.
	}
}
