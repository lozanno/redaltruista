<?php
/**
 * Title: Página – Sobre nosotros
 * Slug: redaltruista/pagina-sobre-nosotros
 * Categories: redaltruista
 * Post Types: page
 * Block Types: core/post-content
 * Description: Contenido completo de /acerca-de/: quiénes somos, misión, visión, valores, historia y consejo directivo. Usar con la plantilla "Página".
 *
 * Las imágenes se toman por ID de la Biblioteca de medios (los mismos ID que en producción).
 *
 * @package RedAltruista
 */

$ra_img = static function ( $id, $size = 'medium' ) {
	return esc_url( (string) wp_get_attachment_image_url( $id, $size ) );
};

$ra_consejo = array(
	array(
		'foto'   => 838,
		'nombre' => 'Minerva Zamora',
		'cargo'  => 'Presidenta',
		'bio'    => array(
			'Egresada de Wellesley College en Massachusetts, EU, donde estudió Ciencias Biológicas. Actualmente es coordinadora de programas en Comunalia.',
			'Ha trabajado como Coordinadora de Programas dentro del sector por más de 7 años; anteriormente estuvo en la Iniciativa Bahía de Banderas A.C. y la Fundación Comunitaria Punta de Mita, contribuyendo en el fortalecimiento de las organizaciones de la sociedad civil y grupos de base.',
			'Fue becaria del programa de Líderes Emergentes del Centro de Filantropía y Sociedad Civil de la Universidad CUNY en Nueva York. Ha estado involucrada en voluntariado y organizaciones civiles hace más de 20 años.',
		),
	),
	array(
		'foto'   => 839,
		'nombre' => 'César Sánchez Santiago',
		'cargo'  => 'Vicepresidente',
		'bio'    => array(
			'Socio fundador de la Red de Asociaciones Altruistas y vicepresidente desde 2016.',
			'Director Ejecutivo de Eagle Wings Foundation y fundador de Impulso de Águila A.C. Con más de 20 años de experiencia en el sector social, su liderazgo ha sido clave para fortalecer la colaboración entre asociaciones y generar impacto en la región.',
		),
	),
	array(
		'foto'   => 836,
		'nombre' => 'Luz María Muñoz Pulido',
		'cargo'  => 'Tesorera',
		'bio'    => array(
			'Miembro del Consejo Directivo desde 2016 y actual tesorera de la Red.',
			'Contadora Pública egresada de la Universidad Arcos y directora de su firma contable con más de 35 años de experiencia.',
			'Reconocida por su autoridad en temas fiscales para OSC, ha sido voluntaria y asesora de numerosos proyectos sociales, promoviendo transparencia y sostenibilidad en el sector.',
		),
	),
	array(
		'foto'   => 832,
		'nombre' => 'Ana Patricia García Gutiérrez',
		'cargo'  => 'Secretaria',
		'bio'    => array(
			'Primera directora ejecutiva de la Red (2013–2018), donde consolidó su estructura y programas.',
			'Ha sido Enlace Regional en IJAS, Directora de Convocatorias en Impulso de Águila A.C. y presidenta de la Asociación de Discapacitados Visuales de la Bahía.',
			'Comprometida con la profesionalización del sector social y la inclusión de personas con discapacidad. Directora en Discapacitados Visuales de la Bahía. Directora de Convocatorias en Impulso de Águila A.C.',
		),
	),
	array(
		'foto'   => 1604,
		'nombre' => 'Vicente David Sierra Izquierdo',
		'cargo'  => 'Vocal',
		'bio'    => array(
			'Forma parte del Consejo Directivo de la Red desde 2023. Contador egresado del IPN con maestría en Negocios por la Universidad de Texas en Austin y el Tec de Monterrey.',
			'Es socio director de BNI Jalisco Oeste, fundador de Strategic Coaching and Consulting Group y director de Transworld Business Advisors.',
			'Ex presidente del Colegio de Contadores Públicos de Puerto Vallarta, aporta su liderazgo y experiencia empresarial construir una comunidad más justa y próspera.',
		),
	),
	array(
		'foto'   => 2002,
		'nombre' => 'Teresita Yáñez Serrano',
		'cargo'  => 'Vocal',
		'bio'    => array( 'Forma parte del Consejo Directivo de la Red desde 2025.' ),
		'lista'  => array(
			'Master Coach Internacional de Negocios (AIAC).',
			'Consultor de Negocios con soluciones en MKT.',
			'CEO ME2BE GROUP.',
			'Miembro Red Mundial de Comunicación Organizacional.',
			'Vicepresidenta de Coparmex Puerto Vallarta, miembro del consejo 2023 - 2025.',
			'Best Seller primera, segunda y Tercera Antología de Expertos ETP.',
		),
	),
	array(
		'foto'   => 2007,
		'nombre' => 'Lourdes Quintero Escalante',
		'cargo'  => 'Directora Ejecutiva',
		'bio'    => array(
			'Desde 2018 dirige la Red de Asociaciones Altruistas, coordinando el trabajo colaborativo de [ra_total_asociaciones] asociaciones civiles en Puerto Vallarta y Bahía de Banderas.',
			'Cuenta con una maestría en Administración y Economía Pública por la Universidad La Salle y egresada de Informática por la Universidad Anáhuac, ha cursado múltiples diplomados sobre administración y procuración de fondos para OSC.',
			'Ha liderado programas de emprendimiento en varias organizaciones.',
			'Su misión es unir a OSC, empresas, gobierno y sociedad para construir comunidades más justas y sostenibles.',
		),
	),
);

$ra_valores = array(
	'Colaboración'   => 'Fomentamos el trabajo conjunto entre asociaciones, empresas y sectores sociales.',
	'Confianza'      => 'Creamos relaciones basadas en confianza con donadores, voluntarios y asociaciones.',
	'Igualdad'       => 'Brindamos y fomentamos la inclusión a asociaciones con diversidad de objetos sociales.',
	'Sostenibilidad' => 'Promovemos a través de los asociados el cuidado del medio ambiente como base para el bienestar presente y futuro de nuestras comunidades.',
	'Liderazgo'      => 'Guiamos, dirigimos y motivamos a las personas que buscan un cambio en la sociedad.',
);

$ra_historia = array(
	'1999' => 'La primera convocatoria para reunir a las asociaciones de Puerto Vallarta y Bahía de Banderas se realizó en 1999, impulsada por Eagle Wings Foundation, con el objetivo de canalizar apoyos a las personas más necesitadas de la región a través de las organizaciones locales.',
	'2008' => 'Gracias a la visión de líderes comunitarios como el Lic. César Sánchez, el Lic. Ricardo Murrieta y Juan Carlos Ríos Camarena, se creó la <strong>RED de Asociaciones Altruistas de Puerto Vallarta y Bahía de Banderas</strong> para facilitar el trabajo conjunto de las asociaciones, complementar programas y fortalecer su vínculo con donantes, voluntarios y aliados estratégicos.',
	'2016' => 'El éxito de esta colaboración motivó su formalización legal como Asociación Civil. Desde entonces, la RED Altruista sigue creciendo, profesionalizando a las asociaciones y generando impacto colectivo en beneficio de la comunidad.',
);

$ra_consejo_2015 = array(
	array( 'Presidente', 'Martha Dau Villafaña' ),
	array( 'Vicepresidente', 'César Sánchez Santiago' ),
	array( 'Secretaria', 'Adriana García López' ),
	array( 'Tesorera', 'Luz María Muñoz Pulido' ),
	array( 'Vocal', 'Raquel Minerva Zamora Domínguez' ),
	array( 'Vocal', 'Yolanda Sánchez Santiago' ),
	array( 'Dirección Ejecutiva', 'Ana Patricia García Gutiérrez' ),
);?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"1170px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
	<div class="wp-block-columns alignwide are-vertically-aligned-center">
		<!-- wp:column {"verticalAlignment":"center","width":"66.66%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:66.66%">
			<!-- wp:heading -->
			<h2 class="wp-block-heading">¿Quiénes somos?</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>La RED de Asociaciones Altruistas tiene el propósito de unir, fortalecer y profesionalizar a las Asociaciones Civiles de Puerto Vallarta y Bahía de Banderas mediante la colaboración y vinculación multisectorial, promoviendo su sostenibilidad y capacidad de generar impacto positivo en la sociedad y el medio ambiente.</p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
			<h2 class="wp-block-heading" style="margin-top:var(--wp--preset--spacing--50)">¿Por qué trabajar en red?</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Nos unimos con el propósito común de trabajar unidas y facilitar la vinculación con los donadores, voluntarios y otras organizaciones. De esta manera se potencializa el trabajo que cada organización realiza en favor de la sociedad y medio ambiente y se optimizan los recursos disponibles.</p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph -->
			<p>Trabajando juntos podemos hacer una diferencia significativa atendiendo múltiples necesidades sociales y ambientales de forma más integral, para generar bienestar para la comunidad y protegiendo nuestro planeta.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"33.33%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:33.33%">
			<!-- wp:image {"id":1448,"sizeSlug":"full","linkDestination":"none"} -->
			<figure class="wp-block-image size-full"><img src="<?php echo $ra_img( 1448, 'full' ); ?>" alt="" class="wp-image-1448"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:cover {"url":"<?php echo $ra_img( 950, 'large' ); ?>","id":950,"dimRatio":80,"overlayColor":"primario","minHeight":360,"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"860px"}} -->
<div class="wp-block-cover alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60);min-height:360px"><img class="wp-block-cover__image-background wp-image-950" alt="" src="<?php echo $ra_img( 950, 'large' ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-primario-background-color has-background-dim-80 has-background-dim"></span><div class="wp-block-cover__inner-container">
	<!-- wp:heading {"textAlign":"center","textColor":"blanco"} -->
	<h2 class="wp-block-heading has-text-align-center has-blanco-color has-text-color">La Red Altruista · Fundada en 2009</h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"1.35rem","lineHeight":"1.5"}},"textColor":"blanco","fontFamily":"montserrat"} -->
	<p class="has-text-align-center has-blanco-color has-text-color has-montserrat-font-family" style="font-size:1.35rem;line-height:1.5">Impulsando el empoderamiento de las organizaciones civiles de Puerto Vallarta y Bahía de Banderas.</p>
	<!-- /wp:paragraph -->
</div></div>
<!-- /wp:cover -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"1170px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading -->
			<h2 class="wp-block-heading">Misión</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Unir y fortalecer a las organizaciones sin fines de lucro de Puerto Vallarta y Bahía de Banderas, impulsando alianzas con la sociedad y otras organizaciones que den origen a soluciones conjuntas y estrategias innovadoras y sostenibles, capaces de provocar un cambio social profundo y duradero que transforme vidas y nuestro entorno.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading -->
			<h2 class="wp-block-heading">Visión</h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p>Lograr una transformación social que eleve el bienestar de la comunidad y del medio ambiente, integrando el trabajo profesional de las asociaciones con la colaboración activa de los distintos sectores de la sociedad.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"menta-suave","layout":{"type":"constrained","contentSize":"1170px"}} -->
<div class="wp-block-group alignfull has-menta-suave-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:heading {"textAlign":"center"} -->
	<h2 class="wp-block-heading has-text-align-center">Nuestros valores</h2>
	<!-- /wp:heading -->

	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40","margin":{"top":"var:preset|spacing|50"}}},"layout":{"type":"grid","minimumColumnWidth":"12rem"}} -->
	<div class="wp-block-group alignwide" style="margin-top:var(--wp--preset--spacing--50)">
		<?php foreach ( $ra_valores as $ra_valor => $ra_texto ) : ?>
		<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}},"border":{"top":{"color":"var:preset|color|primario","width":"4px"}}},"backgroundColor":"blanco","layout":{"type":"constrained"}} -->
		<div class="wp-block-group has-blanco-background-color has-background" style="border-top-color:var(--wp--preset--color--primario);border-top-width:4px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
			<!-- wp:heading {"level":3,"fontSize":"large"} -->
			<h3 class="wp-block-heading has-large-font-size"><?php echo esc_html( $ra_valor ); ?></h3>
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

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"1170px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:heading {"textAlign":"center"} -->
	<h2 class="wp-block-heading has-text-align-center">Nuestra historia</h2>
	<!-- /wp:heading -->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"},"margin":{"top":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns alignwide" style="margin-top:var(--wp--preset--spacing--50)">
		<?php foreach ( $ra_historia as $ra_anio => $ra_texto ) : ?>
		<!-- wp:column {"style":{"spacing":{"padding":{"top":"var:preset|spacing|30"}},"border":{"top":{"color":"var:preset|color|menta","width":"4px"}}}} -->
		<div class="wp-block-column" style="border-top-color:var(--wp--preset--color--menta);border-top-width:4px;padding-top:var(--wp--preset--spacing--30)">
			<!-- wp:paragraph {"className":"ra-historia__anio","textColor":"primario","fontSize":"huge","fontFamily":"montserrat"} -->
			<p class="ra-historia__anio has-primario-color has-text-color has-montserrat-font-family has-huge-font-size"><?php echo esc_html( $ra_anio ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph -->
			<p><?php echo wp_kses( $ra_texto, array( 'strong' => array() ) ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"gris-claro","layout":{"type":"constrained","contentSize":"1170px"}} -->
<div class="wp-block-group alignfull has-gris-claro-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:heading {"textAlign":"center"} -->
	<h2 class="wp-block-heading has-text-align-center">Consejo Directivo 2018–2026</h2>
	<!-- /wp:heading -->

	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40","margin":{"top":"var:preset|spacing|50"}}},"layout":{"type":"grid","minimumColumnWidth":"18rem"}} -->
	<div class="wp-block-group alignwide" style="margin-top:var(--wp--preset--spacing--50)">
		<?php foreach ( $ra_consejo as $ra_p ) : ?>
		<!-- wp:group {"className":"ra-persona","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"backgroundColor":"blanco","layout":{"type":"constrained"}} -->
		<div class="wp-block-group ra-persona has-blanco-background-color has-background" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">
			<!-- wp:image {"id":<?php echo (int) $ra_p['foto']; ?>,"sizeSlug":"medium","linkDestination":"none","align":"center","className":"ra-persona__foto"} -->
			<figure class="wp-block-image aligncenter size-medium ra-persona__foto"><img src="<?php echo $ra_img( $ra_p['foto'] ); ?>" alt="<?php echo esc_attr( $ra_p['nombre'] ); ?>" class="wp-image-<?php echo (int) $ra_p['foto']; ?>"/></figure>
			<!-- /wp:image -->

			<!-- wp:heading {"textAlign":"center","level":3,"fontSize":"large"} -->
			<h3 class="wp-block-heading has-text-align-center has-large-font-size"><?php echo esc_html( $ra_p['nombre'] ); ?></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"align":"center","className":"ra-persona__cargo","textColor":"primario"} -->
			<p class="has-text-align-center ra-persona__cargo has-primario-color has-text-color"><?php echo esc_html( $ra_p['cargo'] ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:details -->
			<details class="wp-block-details"><summary>Leer semblanza</summary>
				<?php foreach ( $ra_p['bio'] as $ra_parrafo ) : ?>
				<!-- wp:paragraph -->
				<p><?php echo esc_html( $ra_parrafo ); ?></p>
				<!-- /wp:paragraph -->
				<?php endforeach; ?>
				<?php if ( ! empty( $ra_p['lista'] ) ) : ?>
				<!-- wp:list -->
				<ul class="wp-block-list">
					<?php foreach ( $ra_p['lista'] as $ra_item ) : ?>
					<!-- wp:list-item -->
					<li><?php echo esc_html( $ra_item ); ?></li>
					<!-- /wp:list-item -->
					<?php endforeach; ?>
				</ul>
				<!-- /wp:list -->
				<?php endif; ?>
			</details>
			<!-- /wp:details -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->

	<!-- wp:heading {"textAlign":"center","level":3,"style":{"spacing":{"margin":{"top":"var:preset|spacing|60"}}}} -->
	<h3 class="wp-block-heading has-text-align-center" style="margin-top:var(--wp--preset--spacing--60)">Consejo 2015–2018</h3>
	<!-- /wp:heading -->

	<!-- wp:list {"className":"ra-lista-simple","fontSize":"small"} -->
	<ul class="wp-block-list ra-lista-simple has-small-font-size">
		<?php foreach ( $ra_consejo_2015 as list( $ra_cargo, $ra_nombre ) ) : ?>
		<!-- wp:list-item -->
		<li><strong><?php echo esc_html( $ra_cargo ); ?>:</strong> <?php echo esc_html( $ra_nombre ); ?></li>
		<!-- /wp:list-item -->
		<?php endforeach; ?>
	</ul>
	<!-- /wp:list -->
</div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"redaltruista/cta-afiliate"} /-->
