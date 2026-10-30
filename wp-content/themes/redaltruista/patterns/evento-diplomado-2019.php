<?php
/**
 * Title: Evento – Diplomado 2019
 * Slug: redaltruista/evento-diplomado-2019
 * Categories: redaltruista
 * Post Types: page
 * Block Types: core/post-content
 * Description: Contenido de /eventos/diplomado-2019/: objetivo y módulos del Diplomado en Administración de Organizaciones Civiles. Usar con la plantilla "Página".
 *
 * @package RedAltruista
 */

echo redaltruista_evento( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	array(
		'titulo'      => 'Diplomado en Administración de Organizaciones Civiles',
		'descripcion' => array(
			'<strong>Objetivo general:</strong> proporcionar las herramientas técnicas a los integrantes de las organizaciones de la sociedad civil para la construcción o fortalecimiento de sus sistemas internos de gestión organizativa y movilización de recursos.',
		),
		'datos'       => array(
			'Fechas'        => 'Del 16 de mayo al 12 de julio de 2019',
			'Duración'      => '80 horas, repartidas en 5 módulos',
			'Impartido por' => 'Corporativa de Fundaciones',
			'Dirigido a'    => 'Organizaciones que deseen actualizarse o capacitar a su equipo, y equipos de trabajo con miras a conformar una A.C.',
			'Organiza'      => 'Red de Asociaciones Altruistas',
		),
		'programa'    => array(
			array(
				'titulo'   => 'Módulos',
				'columnas' => array( 'Fechas', 'Módulo' ),
				'filas'    => array(
					array( '16 y 17 de mayo', '<strong>I.</strong> Planeación estratégica y operativa' ),
					array( '30 y 31 de mayo', '<strong>II.</strong> Gestión administrativa' ),
					array( '13 y 14 de junio', '<strong>III.</strong> Formulación de proyectos' ),
					array( '27 y 28 de junio', '<strong>IV.</strong> Voluntariado y servicio social' ),
					array( '11 y 12 de julio', '<strong>V.</strong> Captación de fondos' ),
				),
			),
		),
	)
);
