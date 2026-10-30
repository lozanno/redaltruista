<?php
/**
 * Title: Evento – Encuentro 2019
 * Slug: redaltruista/evento-encuentro-2019
 * Categories: redaltruista
 * Post Types: page
 * Block Types: core/post-content
 * Description: Contenido de /eventos/encuentro-2019/: ficha y programa del 3er Encuentro Regional de Organizaciones Sociales. Usar con la plantilla "Página".
 *
 * @package RedAltruista
 */

echo redaltruista_evento( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	array(
		'titulo'      => '3er Encuentro Regional de Organizaciones Sociales: <em>Bases Fuertes para Alianzas Grandes</em>',
		'descripcion' => array(
			'El Encuentro Regional de Organizaciones Sociales (ENROS) es una iniciativa de la Red de Asociaciones Altruistas de Puerto Vallarta y Bahía de Banderas y de Fundación Punta de Mita. Se trata de una jornada de dos días en la que asociaciones civiles dedicadas a la educación, la cultura, la prevención de adicciones, la rehabilitación física y emocional, el deporte, el cuidado del medio ambiente, la inclusión y el desarrollo comunitario —entre muchas otras tareas— adquieren e intercambian conocimientos, experiencias, éxitos y desafíos.',
			'El objetivo es fortalecer el trabajo de la sociedad civil organizada de la región e incrementar el impacto de las soluciones que crea y lleva a cabo para abatir problemáticas que nos afectan a todos.',
		),
		'datos'       => array(
			'Fechas'    => '26 y 27 de septiembre de 2019',
			'Sede'      => 'Salón Paraíso del Centro Empresarial Nuevo Vallarta. Paseo de los Cocoteros 55, Nuevo Vallarta, Nay.',
			'Organizan' => 'Red de Asociaciones Altruistas y Fundación Punta de Mita',
		),
		'programa'    => array(
			array(
				'titulo'   => 'Jueves 26 de septiembre',
				'columnas' => array( 'Hora', 'Actividad' ),
				'filas'    => array(
					array( '08:00', 'Registro y entrega del kit de bienvenida' ),
					array( '09:00', 'Bienvenida oficial' ),
					array( '09:30', '<strong>Alégrate, intégrate: ¡tú eres tu organización!</strong>' ),
					array( '10:00', '<strong>Las grandes alianzas que sí existen… y otras historias</strong>' ),
					array( '10:30', '<strong>Transparencia a primera vista: confianza y fuerza organizacional</strong>' ),
					array( '11:30', 'Receso' ),
					array( '11:50', 'Recapitulación' ),
					array( '12:00', '<strong>Así se ve la transparencia: análisis práctico</strong>' ),
					array( '12:15', '<strong>Tallereando: transparencia efectiva</strong>' ),
					array( '13:15', 'Presentación de conclusiones de Transparencia efectiva' ),
					array( '14:00', 'Comida' ),
					array( '15:00', '<strong>Analízate como posible aliado</strong>' ),
					array( '15:30', '<strong>De lo visible a lo invisible</strong>' ),
					array( '16:00', '<strong>Diálogo reflexivo</strong>' ),
					array( '16:30', 'Avances y preparativos para el día 2' ),
					array( '19:00', '<strong>Coctel de networking con empresas: Conecta y Conoce</strong>' ),
				),
			),
			array(
				'titulo'   => 'Viernes 27 de septiembre',
				'columnas' => array( 'Hora', 'Actividad' ),
				'filas'    => array(
					array( '08:30', 'Registro' ),
					array( '09:00', '<strong>Todos somos administradores</strong>' ),
					array( '09:45', '<strong>Buenas prácticas en la práctica</strong>' ),
					array( '11:00', 'Receso' ),
					array( '11:35', 'Dinámica energizante' ),
					array( '12:00', '<strong>Tallereando con los resultados de las encuestas a empresas y asociaciones civiles</strong>' ),
					array( '13:00', 'Comida' ),
					array( '14:00', '<strong>Alianzas: haz una oferta que no te puedan rechazar</strong>' ),
					array( '15:00', '<strong>Aprende a encontrar aliados potenciales</strong>' ),
					array( '16:00', '<strong>Panel de empresarios</strong>' ),
					array( '17:00', 'Clausura' ),
				),
			),
		),
	)
);
