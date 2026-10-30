<?php
/**
 * Title: Evento – Encuentro 2024
 * Slug: redaltruista/evento-encuentro-2024
 * Categories: redaltruista
 * Post Types: page
 * Block Types: core/post-content
 * Description: Contenido de /eventos/encuentro-2024/: ficha, programa y ponentes del 5º Encuentro Regional de Organizaciones Sociales. Usar con la plantilla "Página".
 *
 * @package RedAltruista
 */

echo redaltruista_evento( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	array(
		'titulo'      => '5º Encuentro Regional de Organizaciones Sociales: <em>Fortalece y Moviliza tu Organización</em>',
		'descripcion' => array(
			'El Encuentro Regional de Organizaciones Sociales (ENROS) es una iniciativa de la Red de Asociaciones Altruistas de Puerto Vallarta y Bahía de Banderas y de Fundación Punta de Mita, cuyo objetivo es fortalecer las capacidades de las organizaciones civiles y grupos de base a través de un espacio formativo y de vinculación.',
		),
		'datos'       => array(
			'Fechas'    => '5 y 6 de septiembre de 2024',
			'Sede'      => 'Centro de Convenciones de Puerto Vallarta, salón Mahauitas (1er piso). P.º de las Flores 505, Villa Las Flores, Puerto Vallarta, Jal.',
			'Organizan' => 'Red de Asociaciones Altruistas y Fundación Punta de Mita',
		),
		'programa'    => array(
			array(
				'titulo'   => 'Jueves 5 de septiembre',
				'columnas' => array( 'Hora', 'Actividad' ),
				'filas'    => array(
					array( '08:00', 'Registro' ),
					array( '09:00', 'Bienvenida' ),
					array( '09:10', '<strong>Organizaciones sociales de la Bahía, ¿cómo vamos?</strong><br>Presentación de resultados del proyecto de Mapeo y Diagnóstico de las Organizaciones.<br>Miguel de la Vega – Faro Civitanos' ),
					array( '10:40', 'Receso' ),
					array( '10:55', '<strong>Gestión financiera: administración de recursos al interior de las organizaciones como base de transparencia</strong><br>Maribel Trejo – Transformando 360 Grados, A.C.' ),
					array( '12:55', 'Receso' ),
					array( '13:10', '<strong>Diseño de proyectos con impacto social</strong><br>Taller sobre consistencia metodológica de proyectos.<br>Roberto Arce Rodríguez – Fundación Tercer Sector, A.C.' ),
					array( '14:25', 'Comida' ),
					array( '15:55', '<strong>Diseño de proyectos con impacto social</strong> (continuación)<br>Roberto Arce Rodríguez – Fundación Tercer Sector, A.C.' ),
					array( '17:00', 'Fin del primer día' ),
				),
			),
			array(
				'titulo'   => 'Viernes 6 de septiembre',
				'columnas' => array( 'Hora', 'Actividad' ),
				'filas'    => array(
					array( '08:30', 'Registro de asistencia' ),
					array( '09:00', '<strong>Agendas globales y agendas locales: la importancia de la localización</strong><br>Rodrigo Villar – Consejero del Centro de Investigaciones y Estudios sobre Sociedad Civil, A.C. (CIESC, México) e investigador del Centro de Filantropía e Inversiones Sociales de la Universidad Adolfo Ibáñez (CEFIS, Chile)' ),
					array( '10:30', 'Receso' ),
					array( '10:45', '<strong>De la incidencia social a la incidencia política: ¿cómo acercarnos, vincularnos y detonar el diálogo con los distintos niveles de gobierno para impulsar iniciativas de cambio?</strong><br>Víctor Espíndola – MOVII (Movimiento por la Igualdad en México)' ),
					array( '11:45', '<strong>Networking</strong>' ),
					array( '13:00', 'Comida' ),
					array( '14:30', '<strong>Experiencias en movilización de recursos de las organizaciones locales</strong><br>Vallarta Cares y Pasitos de Luz AVAC<br>Moderador: Salvador Sánchez' ),
					array( '16:00', '<strong>Movilizando tu organización: ¿cómo generamos y administramos nuestros recursos?</strong><br>Salvador Sánchez – Fundación Majocca' ),
					array( '17:00', 'Clausura' ),
				),
			),
		),
		'ponentes'    => array(
			array(
				'nombre' => 'Rodrigo Villar',
				'foto'   => 1678,
				'bio'    => 'Investigador asociado al Centro de Filantropía e Inversiones Sociales de la Universidad Adolfo Ibáñez (CEFIS) de Chile y al Centro de Investigaciones y Estudios sobre Sociedad Civil, A.C. (CIESC) de México.',
			),
			array(
				'nombre' => 'Salvador Sánchez',
				'foto'   => 1677,
				'bio'    => 'Director de desarrollo institucional de Fundación Majocca, coordinador de la plataforma educativa para OSC CEFODIM, presidente del Consejo Directivo de la RIAJ Puebla y coordinador nacional del Día de las Buenas Acciones en México.',
			),
			array(
				'nombre' => 'Miguel de la Vega',
				'foto'   => 1682,
				'bio'    => 'Socio fundador de Faro Civitanos. A nivel internacional, es miembro del Centro de Expertos del GAFI para disminuir las restricciones financieras a las OSC. Representa a Unidos en la Coalición Global de ONG sobre el GAFI y en la Coalición de OSC por los derechos humanos y contra el terrorismo.',
			),
			array(
				'nombre' => 'Víctor Espíndola',
				'foto'   => 1681,
				'bio'    => 'Promotor de derechos humanos con una amplia trayectoria en la comunicación social y política. Ha ocupado cargos destacados, como director general adjunto de Comunicación Digital en la Presidencia de la República y vocero de la SEMARNAT.',
			),
			array(
				'nombre' => 'Roberto Arce',
				'foto'   => 1679,
				'bio'    => 'Docente de la Universidad ORT y coordinador del Diplomado en Modelos de Intervención Social. Socio fundador de Grupo Tercer Sector, presidente ejecutivo de la Fundación para el Desarrollo del Tercer Sector y director de la firma Sistemas de Intervención Social, S.A.S. de C.V.',
			),
			array(
				'nombre' => 'Maribel Trejo',
				'foto'   => 1680,
				'bio'    => 'Cuenta con 28 años de experiencia en capacitación y fortalecimiento de las organizaciones de la sociedad civil.',
			),
		),
	)
);
