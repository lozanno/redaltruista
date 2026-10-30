<?php
/**
 * Title: Evento – Encuentro 2017
 * Slug: redaltruista/evento-encuentro-2017
 * Categories: redaltruista
 * Post Types: page
 * Block Types: core/post-content
 * Description: Contenido de /eventos/encuentro-2017/: ficha y ponentes (con su ponencia) del 1er Encuentro Regional de Organizaciones Sociales. Usar con la plantilla "Página".
 *
 * @package RedAltruista
 */

$ra_panel = 'Panel Directores y Consejeros: Jerarquías o Relaciones Horizontales';

echo redaltruista_evento( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	array(
		'titulo'      => '1er Encuentro Regional de Organizaciones Sociales: <em>Rompiendo Paradigmas</em>',
		'descripcion' => array(
			'El Encuentro Regional de Organizaciones Sociales es una iniciativa que desea sumar valor, fuerza y entusiasmo a la tarea de transformar el mundo desde la sociedad civil.',
			'Es un punto de encuentro para conocer iniciativas, técnicas e información de vanguardia que faciliten y promuevan planes innovadores para las organizaciones; planes dinámicos en los que el esfuerzo tenga enfoque sustentable, miras a un futuro estable e impacto que se traduzca en participación social para la calidad de vida de muchos, de cada vez más.',
			'Fundación Punta de Mita y la Red de Asociaciones Altruistas de Puerto Vallarta y Bahía de Banderas convocaron a profesionales de diversas materias involucrados en la transformación social desde sus trincheras. Estos especialistas lo son porque llevan años aprendiendo y ejerciendo sus conocimientos en proyectos sociales de naturalezas distintas, pero con el mismo fin: involucrar a la sociedad, enriquecer la experiencia de ser ciudadano en toda la magnitud de la palabra y mover a su comunidad, a su ciudad y a su país a un mejor lugar.',
			'Comunicadores gráficos, procuradores de fondos, gestores, empresarios, promotores culturales, administradores, entrenadores de oratoria, estudiosos de la participación social, consejeros, fundadores, voluntarios, personal ejecutivo, mercadólogos: ciudadanos como tú que desde la sociedad civil trabajan por materializar el sueño de un mundo incluyente, justo y hermoso, como el que nosotros hemos conocido, para las siguientes generaciones. Eso y todo lo demás que pueda ser, será.',
		),
		'datos'       => array(
			'Fechas'    => '28 y 29 de septiembre de 2017',
			'Sede'      => 'Centro Empresarial Nuevo Vallarta',
			'Organizan' => 'Red de Asociaciones Altruistas y Fundación Punta de Mita',
		),
		'ponentes'    => array(
			array(
				'nombre'   => 'Adriana García',
				'foto'     => 1189,
				'bio'      => 'Directora ejecutiva de Pro Biblioteca de Vallarta, A.C. y consejera directora de la Red de Asociaciones Altruistas de Puerto Vallarta y Bahía de Banderas, A.C.',
				'ponencia' => $ra_panel,
			),
			array(
				'nombre'   => 'Alejandra Parra Cárdenas',
				'foto'     => 1190,
				'bio'      => 'Coordinadora de Gestión y Proyectos Especiales en el equipo del diputado independiente Pedro Kumamoto.',
				'ponencia' => 'Las OSC: más allá de las buenas intenciones, liderazgo que transforma',
			),
			array(
				'nombre'   => 'Ana Luisa Ramírez',
				'foto'     => 1191,
				'bio'      => 'Directora de Gestión Filantrópica Consultores.',
				'ponencia' => 'Innovando en la procuración de fondos',
			),
			array(
				'nombre'   => 'Armando Sánchez',
				'foto'     => 1192,
				'bio'      => 'Miembro fundador de la Asociación de Comercios y Turismo, A.C. (ACT LGBT, A.C.) y del Festival Cultural LGBT Vallarta Pride.',
				'ponencia' => $ra_panel,
			),
			array(
				'nombre'   => 'Felipe de Jesús Alatorre Rodríguez',
				'foto'     => 1193,
				'bio'      => 'Académico e investigador en participación ciudadana y sociedad civil. Miembro del equipo de coordinación del Proyecto de Aplicación Profesional «Estrategias para la Incidencia y Comunicación Ciudadana».',
				'ponencia' => 'Participar para transformar',
			),
			array(
				'nombre'   => 'Jessica Soler',
				'foto'     => 1195,
				'bio'      => 'Directora ejecutiva de Bahía Unida, A.C. y miembro del Consejo Asesor del Parque Nacional Islas Marietas.',
				'ponencia' => $ra_panel,
			),
			array(
				'nombre'   => 'Karin Peralta',
				'foto'     => 1196,
				'bio'      => 'Directora de INSIDE, Diseñando Experiencias, agencia enfocada en transformar organizaciones a través de las historias.',
				'ponencia' => 'Comunica tu misión con pasión',
			),
			array(
				'nombre'   => 'Luis Hernán Landívar Pimentel',
				'foto'     => 1197,
				'bio'      => 'Asesor en discurso del diputado independiente Pedro Kumamoto. Trabaja de manera independiente en producciones audiovisuales y en la aplicación de estrategias de comunicación política.',
				'ponencia' => 'Las OSC: más allá de las buenas intenciones, liderazgo que transforma',
			),
			array(
				'nombre'   => 'Marcela de Niz',
				'foto'     => 1182,
				'bio'      => 'Coordinadora de la Licenciatura en Diseño para la Comunicación Gráfica del Centro Universitario de la Costa de la Universidad de Guadalajara.',
				'ponencia' => 'Imágenes que cuentan historias',
			),
			array(
				'nombre'   => 'Martha Dau',
				'foto'     => 1183,
				'bio'      => 'Fundadora de la agencia Concierge Gpoint y de Movie Picnic, socia del proyecto Tianguis Cultural «El Vecindario», directora de ExpoKids Puerto Vallarta y gerente general del Hotel Puerto de Luna y Parque Parota.',
				'ponencia' => 'Sin miedo a innovar',
			),
			array(
				'nombre'   => 'Minerva Zamora',
				'foto'     => 1184,
				'bio'      => 'Coordinadora de Programas en Fundación Punta de Mita, A.C.',
				'ponencia' => $ra_panel . ' (moderadora)',
			),
			array(
				'nombre'   => 'Mónica A. Fong',
				'foto'     => 1185,
				'bio'      => 'Egresada del Instituto Tecnológico y de Estudios Superiores de Monterrey. Gerente corporativa de calidad y estándares en Grupo Vidanta.',
				'ponencia' => '¡Planea, planea, planea!',
			),
			array(
				'nombre'   => 'Nicole Swedlow',
				'foto'     => 1186,
				'bio'      => 'Fundadora, exdirectora ejecutiva y consejera del Centro Comunitario EntreAmigos de San Pancho, Nayarit.',
				'ponencia' => $ra_panel,
			),
			array(
				'nombre'   => 'Tere Yáñez',
				'foto'     => 1188,
				'bio'      => 'Fundadora y directora general de Add Marketing Creativo y Me2be by TY, coach de negocios y de riqueza. Publicista y comunicóloga, egresada de la Ibero Ciudad de México.',
				'ponencia' => 'Consejo, staff y voluntarios: todos un mismo equipo',
			),
		),
	)
);
