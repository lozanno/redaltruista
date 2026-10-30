<?php
/**
 * Title: Evento – Encuentro 2018
 * Slug: redaltruista/evento-encuentro-2018
 * Categories: redaltruista
 * Post Types: page
 * Block Types: core/post-content
 * Description: Contenido de /eventos/encuentro2018/: ficha, programa y ponentes del 2º Encuentro Regional de Organizaciones Sociales. Usar con la plantilla "Página".
 *
 * @package RedAltruista
 */

echo redaltruista_evento( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	array(
		'titulo'      => '2º Encuentro Regional de Organizaciones Sociales: <em>Prográmate para Crecer</em>',
		'descripcion' => array(
			'El <strong>Encuentro Regional de Organizaciones Sociales</strong> es una iniciativa de <strong>Fundación Punta de Mita, A.C.</strong> y la <strong>Red de Asociaciones Altruistas de Puerto Vallarta y Bahía de Banderas, A.C.</strong> para sumar valor, fuerza y entusiasmo a la tarea de transformar el mundo desde la sociedad civil.',
			'En este <strong>2º Encuentro Regional de Organizaciones Sociales</strong>, el enfoque es el desarrollo de programas. El Encuentro toma el nombre de <em>Prográmate para Crecer</em> porque tener programas bien definidos, fuertes y organizados permite a las asociaciones crecer en todos sentidos: número de beneficiarios, el impacto que tenemos en ellos, las alianzas forjadas, los recursos recibidos, etc.',
			'Es un <strong>punto de encuentro</strong> para conocer iniciativas, técnicas e <strong>información de vanguardia</strong> que faciliten y promuevan planes innovadores para las organizaciones; planes dinámicos en los que el esfuerzo tenga enfoque sustentable, miras a un <strong>futuro estable e impacto que se traduzca en participación social</strong> para la calidad de vida de muchos, de cada vez más personas.',
			'Fundación Punta de Mita y la Red de Asociaciones Altruistas de Puerto Vallarta y Bahía de Banderas convocaron a especialistas de diversas materias involucrados en la transformación social desde sus trincheras para que, con su experiencia, enriquezcan a los ciudadanos en toda la magnitud de la palabra y muevan a su comunidad, a su ciudad y a su país hacia un mejor lugar.',
			'Convocamos a consejeros, fundadores, voluntarios, procuradores de fondos, gestores, empresarios, promotores culturales, administradores, estudiosos de la participación social, personal ejecutivo, comunicadores, gráficos, mercadólogos y ciudadanos como tú, que desde la sociedad civil trabajan por materializar el sueño de un mundo incluyente, justo y hermoso para esta generación y las siguientes.',
		),
		'datos'       => array(
			'Fechas'    => '20 y 21 de septiembre de 2018',
			'Horario'   => '9:00 a 18:00 h',
			'Sede'      => 'Sala de Capacitación de Grupo Mavy',
			'Organizan' => 'Red de Asociaciones Altruistas y Fundación Punta de Mita',
		),
		'programa'    => array(
			array(
				'titulo'   => 'Jueves 20 de septiembre',
				'columnas' => array( 'Hora', 'Actividad' ),
				'filas'    => array(
					array( '08:30', 'Registro' ),
					array( '09:00', 'Inauguración' ),
					array( '', '<strong>Los Objetivos de Desarrollo Sostenible (ODS) de la ONU y el papel de las OSC locales</strong> <em>(conferencia y dinámicas)</em><br>Laura Torres D’Giesecke – Corporativa de Fundaciones<br>Lisa K. Schalla – Fundación Punta de Mita' ),
					array( '', 'Receso' ),
					array( '', '<strong>Prográmate para Crecer: ¿por qué trabajar con programas?</strong> <em>(conferencia y dinámicas)</em><br>Laura Torres D’Giesecke – Corporativa de Fundaciones<br>Minerva Zamora – Fundación Punta de Mita' ),
					array( '', 'Comida' ),
					array( '', '<strong>Programas exitosos</strong> <em>(panel)</em><br>Gabriela Velasco González (moderadora)<br>Angélica Galván – Biblioteca Los Mangos<br>Lisa K. Schalla – Fundación Punta de Mita<br>Sarah Berne y Yazmín Gutiérrez – EntreAmigos' ),
					array( '', '<strong>Alineando objetivos y actividades</strong> <em>(taller)</em><br>Luisa Hernández Herse y Regina Gonzalo Ortúñez – INSAD' ),
					array( '18:00', 'Fin del día' ),
				),
			),
			array(
				'titulo'   => 'Viernes 21 de septiembre',
				'columnas' => array( 'Hora', 'Actividad' ),
				'filas'    => array(
					array( '08:30', 'Registro' ),
					array( '09:00', 'Inicio' ),
					array( '', '<strong>¿Qué busca un donante? De donante a inversionista social</strong> <em>(panel)</em><br>Gabriela Velasco González (moderadora)<br>Eva Contreras Sandoval – Eagle Wings Foundation<br>Gloria Carrillo – Club Rotario Puerto Vallarta Sur<br>Anselmo Delgado Arvizu – SEDESOL Nayarit' ),
					array( '', 'Receso' ),
					array( '', '<strong>¿Estoy listo para programarme?</strong> <em>(dinámica)</em><br>Lourdes Quintero Escalante – Red de Asociaciones Altruistas' ),
					array( '', 'Comida' ),
					array( '', '<strong>Evaluando resultados y procesos: ¿mi programa funciona?</strong> <em>(taller)</em><br>Luisa Hernández Herse y Regina Gonzalo Ortúñez – INSAD' ),
					array( '', '<strong>«Todo cabe en un jarro… sabiéndome organizar»: elaborando cronogramas y presupuestos</strong> <em>(taller)</em><br>Laura Stephanía Torres D’Giesecke – Corporativa de Fundaciones, A.C.' ),
					array( '18:00', 'Fin del día' ),
				),
			),
		),
		'ponentes'    => array(
			array(
				'nombre' => 'Laura Stephanía Torres D’Giesecke',
				'foto'   => 1009,
				'cargo'  => 'Consultora de Corporativa de Fundaciones, A.C.',
			),
			array(
				'nombre' => 'Luisa Hernández Herse',
				'foto'   => 1011,
				'cargo'  => 'Coordinadora del área de fortalecimiento a sociedad civil y fundaciones y evaluación en INSAD',
			),
			array(
				'nombre' => 'Regina Gonzalo Ortúñez',
				'foto'   => 1014,
				'cargo'  => 'Consultora del área de fortalecimiento a sociedad civil y fundaciones y evaluación en INSAD',
			),
			array(
				'nombre' => 'Gabriela Velasco González',
				'foto'   => 1007,
				'cargo'  => 'Activista social y emprendedora',
			),
			array(
				'nombre' => 'Angélica Galván González',
				'foto'   => 1004,
				'cargo'  => 'Auxiliar bibliotecaria encargada de Animación a la Lectura en Biblioteca Los Mangos',
			),
			array(
				'nombre' => 'Sarah Berne Kaminshine',
				'foto'   => 1015,
				'cargo'  => 'Directora educativa de EntreAmigos',
			),
			array(
				'nombre' => 'Yazmín Gutiérrez Castañeda',
				'foto'   => 1016,
				'cargo'  => 'Coordinadora de Becas y Asistencia Social en EntreAmigos',
			),
			array(
				'nombre' => 'Anselmo Delgado Arvizu',
				'foto'   => 1005,
				'cargo'  => 'Enlace en el Programa de Coinversión Social, SEDESOL Nayarit',
			),
			array(
				'nombre' => 'Eva Contreras Sandoval',
				'foto'   => 1006,
				'cargo'  => 'Presidenta de Eagle Wings Foundation',
			),
			array(
				'nombre' => 'Gloria Carrillo',
				'foto'   => 1008,
				'cargo'  => 'Presidenta del Club Rotario Puerto Vallarta Sur',
			),
			array(
				'nombre' => 'Lisa Kathleen Schalla',
				'foto'   => 1010,
				'cargo'  => 'Directora de Fundación Punta de Mita, A.C.',
			),
			array(
				'nombre' => 'Minerva Zamora Domínguez',
				'foto'   => 1013,
				'cargo'  => 'Coordinadora de Programas de Fundación Punta de Mita y presidenta de la Red de Asociaciones Altruistas',
			),
			array(
				'nombre' => 'Lourdes Quintero',
				'foto'   => 1012,
				'cargo'  => 'Directora de la Red de Asociaciones Altruistas',
			),
		),
	)
);
