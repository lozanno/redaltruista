<?php
/**
 * Title: Página – Transparencia
 * Slug: redaltruista/pagina-transparencia
 * Categories: redaltruista
 * Post Types: page
 * Block Types: core/post-content
 * Description: Contenido de /transparencia/: línea de tiempo de la Red (1999 a hoy). Usar con la plantilla "Página". Para agregar un año, duplicar un hito en el editor.
 *
 * @package RedAltruista
 */

$ra_hitos = array(
	array( '1999', 'Eagle Wings Foundation', 'Eagle Wings Foundation convocó por primera vez a asociaciones de la región para otorgar un fondo destinado a apoyar a personas en situación de mayor vulnerabilidad.' ),
	array( '2008', 'Reuniones de vinculación', 'Se iniciaron reuniones periódicas de vinculación y capacitación con organizaciones de la sociedad civil.' ),
	array( '2010', 'La RED', 'La RED de Asociaciones Altruistas de Puerto Vallarta y Bahía de Banderas comenzó a operar formalmente, convocando a las asociaciones para elaborar estrategias que facilitaran su labor.' ),
	array( '2016', 'La RED', 'La RED se constituyó legalmente como Asociación Civil sin fines de lucro. Ese mismo año se establecieron reuniones mensuales de capacitación con los miembros.' ),
	array( '2017', 'Diplomado en Administración de OSC', 'Se impartió el Diplomado en Administración de OSC, en colaboración con Corporativa de Fundaciones. También se realizó el 1er Encuentro Regional de OSC: “Rompiendo Paradigmas”.' ),
	array( '2018', 'Renovación de estructura del Consejo Directivo', 'Ese mismo año se renovó la estructura del Consejo Directivo, quedando Raquel Minerva Zamora Domínguez como presidenta del consejo, y se organizó el 2º Encuentro Regional de OSC: “Prográmate para Crecer”.' ),
	array( '2019', '3er Encuentro Regional', 'Se llevó a cabo el 3er Encuentro Regional de OSC: “Bases Fuertes para Alianzas Grandes”.' ),
	array( '2023', 'Integración de Vicente David Sierra Izquierdo', 'Se integró Vicente David Sierra Izquierdo como nuevo miembro del consejo directivo y se actualizaron los estatutos del acta constitutiva. Se realizó el 4º Encuentro Regional de OSC: “Hacia un Impacto Sostenible”. Y se impartió el Diplomado para el Fortalecimiento de las OSC, a cargo de Gestión Filantrópica.' ),
	array( '2024', '5º Encuentro Regional de OSC', 'Se llevó a cabo el 5º Encuentro Regional de OSC: “Fortalece y Moviliza tu Organización”. Además, se realizó un proceso de planeación estratégica que definió tres programas prioritarios para la RED.' ),
	array( '2025', 'Diplomado en Fortalecimiento en Procuración de Fondos', 'Se impartió el Diplomado en Fortalecimiento en Procuración de Fondos, coordinado por Gestión Filantrópica.' ),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"860px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.35rem","lineHeight":"1.5"}},"fontFamily":"montserrat"} -->
	<p class="has-text-align-center has-montserrat-font-family" style="font-size:1.35rem;line-height:1.5">Más de 25 años uniendo a las organizaciones civiles de Puerto Vallarta y Bahía de Banderas. Este es nuestro recorrido.</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"style":{"spacing":{"margin":{"top":"var:preset|spacing|60"}}}} -->
	<h2 class="wp-block-heading" style="margin-top:var(--wp--preset--spacing--60)">Línea de tiempo</h2>
	<!-- /wp:heading -->

	<!-- wp:group {"className":"ra-linea","style":{"spacing":{"blockGap":"var:preset|spacing|50","margin":{"top":"var:preset|spacing|50"}}},"layout":{"type":"default"}} -->
	<div class="wp-block-group ra-linea" style="margin-top:var(--wp--preset--spacing--50)">
		<?php foreach ( $ra_hitos as list( $ra_anio, $ra_titulo, $ra_texto ) ) : ?>
		<!-- wp:group {"className":"ra-hito","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"default"}} -->
		<div class="wp-block-group ra-hito">
			<!-- wp:paragraph {"className":"ra-historia__anio","textColor":"primario","fontSize":"xx-large","fontFamily":"montserrat"} -->
			<p class="ra-historia__anio has-primario-color has-text-color has-montserrat-font-family has-xx-large-font-size"><?php echo esc_html( $ra_anio ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"level":3,"fontSize":"large"} -->
			<h3 class="wp-block-heading has-large-font-size"><?php echo esc_html( $ra_titulo ); ?></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><?php echo esc_html( $ra_texto ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"redaltruista/cta-afiliate"} /-->
