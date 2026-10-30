<?php
/**
 * Title: Evento – Encuentro 2023
 * Slug: redaltruista/evento-encuentro-2023
 * Categories: redaltruista
 * Post Types: page
 * Block Types: core/post-content
 * Description: Contenido de /eventos/encuentro-2023/: ficha, programa y ponentes del 4º Encuentro Regional de Organizaciones Sociales. Usar con la plantilla "Página".
 *
 * @package RedAltruista
 */

echo redaltruista_evento( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	array(
		'titulo'      => '4º Encuentro Regional de Organizaciones Sociales: <em>Hacia un Impacto Sostenible</em>',
		'descripcion' => array(
			'El Encuentro Regional de Organizaciones Sociales (ENROS) es una iniciativa de la Red de Asociaciones Altruistas de Puerto Vallarta y Bahía de Banderas y de Fundación Punta de Mita, cuyo objetivo es fortalecer las capacidades de las organizaciones civiles y grupos de base a través de un espacio formativo y de vinculación.',
		),
		'datos'       => array(
			'Fechas'    => '21 y 22 de septiembre de 2023',
			'Sede'      => 'Hotel Marival Emotions. Paseo de los Cocoteros s/n, Nuevo Vallarta, Nay.',
			'Organizan' => 'Red de Asociaciones Altruistas y Fundación Punta de Mita',
		),
		'programa'    => array(
			array(
				'titulo'   => 'Jueves 21 de septiembre',
				'columnas' => array( 'Hora', 'Actividad' ),
				'filas'    => array(
					array( '08:30 – 09:00', 'Registro' ),
					array( '09:00 – 09:15', 'Inauguración' ),
					array( '09:15 – 10:45', '<strong>¿Qué es la sostenibilidad? Dimensiones y estrategias</strong> <em>(conferencia)</em><br>Cristina Ruiz Hernández – Cemefi' ),
					array( '10:45 – 11:00', 'Receso' ),
					array( '11:00 – 11:30', '<strong>Dejando huellas</strong> <em>(rompehielos e integración)</em>' ),
					array( '11:30 – 13:15', '<strong>Programación intencional: el modelo de intervención social</strong> <em>(taller)</em><br>Claudia Villa y Ana Paula Morales – Fundación Merced Querétaro' ),
					array( '13:15 – 14:30', 'Receso y comida' ),
					array( '14:30 – 15:30', '<strong>Programación intencional: el modelo de intervención social</strong> <em>(continuación del taller)</em>' ),
					array( '15:30 – 15:45', 'Receso' ),
					array( '15:45 – 17:00', '<strong>Las redes que nos sostienen: las alianzas en el sector social y el desarrollo sostenible</strong> <em>(conferencia)</em><br>Tatiana Fraga Diez – Comunalia' ),
				),
			),
			array(
				'titulo'   => 'Viernes 22 de septiembre',
				'columnas' => array( 'Hora', 'Actividad' ),
				'filas'    => array(
					array( '08:30 – 09:00', 'Registro' ),
					array( '09:00 – 09:30', '<strong>Dejando huellas</strong> <em>(rompehielos e integración)</em>' ),
					array( '09:30 – 10:45', '<strong>Conversando experiencias: la sostenibilidad desde la participación comunitaria</strong> <em>(panel)</em>' ),
					array( '10:45 – 11:00', 'Receso' ),
					array( '11:00 – 12:45', '<strong>Todos contribuyen: construyendo nuevas narrativas sobre filantropía comunitaria</strong> <em>(taller)</em><br>Laura Martínez y Sergio Cruz – Fondo Acción Solidaria (FASOL)' ),
					array( '12:45 – 14:00', 'Receso y comida' ),
					array( '14:00 – 15:00', '<strong>Construyendo una nueva narrativa sobre la movilización de recursos</strong> <em>(continuación del taller)</em>' ),
					array( '15:00 – 16:30', '<strong>Los ODS y las comunidades sostenibles</strong><br>Rodrigo Villar – Investigador asociado al Centro de Filantropía e Inversiones Sociales de la Universidad Adolfo Ibáñez (CEFIS) de Chile y al Centro de Investigaciones y Estudios sobre Sociedad Civil, A.C. (CIESC) de México' ),
					array( '16:30 – 17:00', 'Presentación de FOROB y clausura' ),
				),
			),
		),
		'ponentes'    => array(
			array(
				'nombre' => 'Tatiana Fraga Diez',
				'foto'   => 1534,
				'cargo'  => 'Directora ejecutiva de Comunalia e instructora de la Universidad de Pensilvania',
			),
			array(
				'nombre' => 'Laura Martínez Ríos del Río',
				'foto'   => 1535,
				'cargo'  => 'Colaboradora de Fondo Acción Solidaria (FASOL), consultora en filantropía comunitaria y miembro del Consejo Directivo del Centro para el Fortalecimiento de la Acción Solidaria',
			),
			array(
				'nombre' => 'Ana Paula Morales Espinosa',
				'foto'   => 1531,
				'cargo'  => 'Líder de Profesionalización y Acompañamiento Institucional en Fundación Merced Querétaro',
			),
			array(
				'nombre' => 'Claudia Villa',
				'foto'   => 1532,
				'cargo'  => 'Coordinadora de Programas de Fortalecimiento para la Sociedad Civil en Fundación Merced Querétaro',
			),
			array(
				'nombre' => 'Rodrigo Villar',
				'foto'   => 1536,
				'cargo'  => 'Investigador asociado al Centro de Filantropía e Inversiones Sociales de la Universidad Adolfo Ibáñez (CEFIS) de Chile y al Centro de Investigaciones y Estudios sobre Sociedad Civil, A.C. (CIESC) de México',
			),
			array(
				'nombre' => 'María Cristina Ruiz',
				'foto'   => 1533,
				'cargo'  => 'Coordinadora general de Filantropía en el Centro Mexicano para la Filantropía, A.C. (Cemefi)',
			),
			array(
				'nombre' => 'Sergio Cruz Hernández',
				'foto'   => 1537,
				'cargo'  => 'Colaborador de Fondo Acción Solidaria (FASOL), miembro del Sistema Nacional de Investigadores (SNI) nivel I, consultor en filantropía comunitaria y miembro del Consejo Directivo del Centro para el Fortalecimiento de la Acción Solidaria',
			),
		),
	)
);
