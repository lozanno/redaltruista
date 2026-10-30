<?php
/**
 * Plugin Name: Red Altruista – Publicar sitio
 * Description: Cambio único de Avada al sitio nuevo (Herramientas → Publicar sitio). Borrar este archivo y la carpeta publicar/ al terminar.
 *
 * Publica el sitio nuevo de una sola vez: activa el plugin y el tema, importa el directorio,
 * crea los formularios, pone a cada página el contenido de su patrón y desactiva Avada.
 * Es idempotente: se puede volver a correr. El contenido de Avada de cada página queda como revisión.
 *
 * Producción (sin SSH), por SFTP:
 *   wp-content/themes/redaltruista, wp-content/plugins/ra-directorio  → a su lugar
 *   bin/publicar.php                                                  → wp-content/mu-plugins/publicar.php
 *   bin/formularios.php y medios/                                     → wp-content/mu-plugins/publicar/
 * y en el admin: Herramientas → Publicar sitio → Simular, luego Publicar.
 *
 * Con WP-CLI (ensayo local, bin/ensayo.sh):
 *   bin/wp-ensayo eval-file bin/publicar.php simular
 *   bin/wp-ensayo eval-file bin/publicar.php
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'ra_pub_config' ) ) {

	/**
	 * Qué se publica. Páginas: slug en producción → patrón y ajustes ('portada' = la página de inicio
	 * actual, home-2). Imágenes por ID de adjunto (los mismos en producción y en local);
	 * 'encuentro-2024-portada.jpg' es nueva y se sube desde medios/.
	 */
	function ra_pub_config() {
		return array(
			'paginas'         => array(
				'portada'        => array( 'patron' => 'pagina-inicio', 'titulo' => 'Inicio', 'plantilla' => 'page-sin-titulo' ),
				'acerca-de'      => array( 'patron' => 'pagina-sobre-nosotros', 'titulo' => 'Sobre nosotros' ),
				'contribuye'     => array( 'patron' => 'pagina-contribuye', 'titulo' => 'Contribuye' ),
				'eventos'        => array( 'patron' => 'pagina-eventos', 'titulo' => 'Eventos' ),
				'transparencia'  => array( 'patron' => 'pagina-transparencia', 'titulo' => 'Transparencia' ),
				'contactanos'    => array( 'patron' => 'pagina-contactanos', 'titulo' => 'Contáctanos' ),
				'encuentro-2024' => array( 'patron' => 'evento-encuentro-2024', 'titulo' => 'Encuentro 2024', 'superior' => 'eventos', 'imagen' => 'encuentro-2024-portada.jpg' ),
				'encuentro-2023' => array( 'patron' => 'evento-encuentro-2023', 'titulo' => 'Encuentro 2023', 'superior' => 'eventos', 'imagen' => 1506 ),
				'encuentro-2019' => array( 'patron' => 'evento-encuentro-2019', 'titulo' => 'Encuentro 2019', 'superior' => 'eventos', 'imagen' => 1249 ),
				'diplomado-2019' => array( 'patron' => 'evento-diplomado-2019', 'titulo' => 'Diplomado 2019', 'superior' => 'eventos', 'imagen' => 1244 ),
				'encuentro2018'  => array( 'patron' => 'evento-encuentro-2018', 'titulo' => 'Encuentro 2018', 'superior' => 'eventos', 'imagen' => 1246 ),
				'encuentro-2017' => array( 'patron' => 'evento-encuentro-2017', 'titulo' => 'Encuentro 2017', 'superior' => 'eventos', 'imagen' => 1245, 'fecha' => '2017-09-01 12:00:00' ),
			),
			// Páginas de Avada que no se migran: a borrador (sin Avada se verían los shortcodes) o a la papelera.
			'a_borrador'      => array( 'programas-y-servicios', 'registro' ),
			'a_papelera'      => array( 'asociaciones-afiliadas' ), // El directorio del plugin ocupa esa URL.
			'logo'            => 1417, // Logo-Comercial-small.png
			'plugins_activar' => array( 'contact-form-7/wp-contact-form-7.php', 'ra-directorio/ra-directorio.php' ),
			'plugins_fuera'   => array( 'fusion-builder/fusion-builder.php', 'fusion-core/fusion-core.php' ),
		);
	}

	/** Ruta de un archivo de apoyo (formularios.php, medios/): junto a este archivo, en publicar/ o en la raíz del repo. */
	function ra_pub_ruta( $nombre ) {
		foreach ( array( __DIR__ . '/publicar/', __DIR__ . '/', __DIR__ . '/../' ) as $dir ) {
			if ( file_exists( $dir . $nombre ) ) {
				return realpath( $dir . $nombre );
			}
		}
		return '';
	}

	/** Página por slug, esté en la raíz o ya debajo de Eventos. */
	function ra_pub_pagina( $slug ) {
		if ( 'portada' === $slug ) {
			$id = (int) get_option( 'page_on_front' );
			return $id ? get_post( $id ) : null;
		}
		$q = get_posts(
			array(
				'post_type'   => 'page',
				'name'        => $slug,
				'post_status' => array( 'publish', 'draft', 'private', 'pending' ),
				'numberposts' => 1,
				'orderby'     => 'ID',
				'order'       => 'ASC',
			)
		);
		return $q ? $q[0] : null;
	}

	/** ID de un adjunto por nombre de archivo exacto (sin distinguir carpetas año/mes). */
	function ra_pub_adjunto( $archivo ) {
		global $wpdb;
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery
		$ids = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file' AND ( meta_value = %s OR meta_value LIKE %s )",
				$archivo,
				'%/' . $wpdb->esc_like( $archivo )
			)
		);
		foreach ( $ids as $id ) { // MySQL compara sin distinguir mayúsculas: se confirma en PHP.
			if ( basename( get_post_meta( $id, '_wp_attached_file', true ) ) === $archivo ) {
				return (int) $id;
			}
		}
		return 0;
	}

	/**
	 * 1. Revisión previa: que esté todo lo necesario. No escribe nada.
	 *
	 * @param callable $log function( $tipo, $mensaje ), $tipo: 'log' | 'warning' | 'success'.
	 */
	function ra_pub_revisar( callable $log ) {
		$c       = ra_pub_config();
		$errores = array();
		if ( ! wp_get_theme( 'redaltruista' )->exists() ) {
			$errores[] = 'Falta el tema en wp-content/themes/redaltruista.';
		}
		foreach ( $c['plugins_activar'] as $plugin ) {
			if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin ) ) {
				$errores[] = "Falta el plugin wp-content/plugins/{$plugin}.";
			}
		}
		if ( ! ra_pub_ruta( 'formularios.php' ) ) {
			$errores[] = 'Falta formularios.php (en wp-content/mu-plugins/publicar/).';
		}
		foreach ( $c['paginas'] as $slug => $p ) {
			if ( ! ra_pub_pagina( $slug ) ) {
				$errores[] = "No encuentro la página «{$slug}».";
			}
			if ( ! file_exists( get_theme_root() . '/redaltruista/patterns/' . $p['patron'] . '.php' ) ) {
				$errores[] = "Falta el patrón {$p['patron']}.";
			}
			if ( isset( $p['imagen'] ) && is_int( $p['imagen'] ) && 'attachment' !== get_post_type( $p['imagen'] ) ) {
				$errores[] = "La imagen {$p['imagen']} de «{$slug}» no está en la Biblioteca.";
			}
			if ( isset( $p['imagen'] ) && is_string( $p['imagen'] ) && ! ra_pub_adjunto( $p['imagen'] ) && ! ra_pub_ruta( 'medios/' . $p['imagen'] ) ) {
				$errores[] = "No encuentro {$p['imagen']} ni en la Biblioteca ni en medios/ (en wp-content/mu-plugins/publicar/medios/).";
			}
		}
		if ( 'attachment' !== get_post_type( $c['logo'] ) ) {
			$errores[] = "El logo (adjunto {$c['logo']}) no está en la Biblioteca.";
		}
		foreach ( $errores as $e ) {
			$log( 'warning', $e );
		}
		if ( $errores ) {
			$log( 'warning', 'Corrige lo anterior antes de publicar. No se cambió nada.' );
			return false;
		}
		$log( 'log', 'Revisión previa: todo en su lugar.' );
		return true;
	}

	/** Lista lo que haría la publicación. No escribe nada. */
	function ra_pub_plan( callable $log ) {
		$c = ra_pub_config();
		$log( 'log', 'Activaría Contact Form 7 y ra-directorio, y el tema Red Altruista (hoy: ' . get_stylesheet() . ').' );
		foreach ( $c['paginas'] as $slug => $p ) {
			$post = ra_pub_pagina( $slug );
			$log( 'log', sprintf( '  %s (ID %d, «%s») → patrón %s%s', $slug, $post->ID, $post->post_title, $p['patron'], isset( $p['superior'] ) ? ', debajo de Eventos' : '' ) );
		}
		foreach ( $c['a_borrador'] as $slug ) {
			$post = ra_pub_pagina( $slug );
			$log( 'log', $post ? "  {$slug} (ID {$post->ID}) → borrador" : "  No existe {$slug}" );
		}
		foreach ( $c['a_papelera'] as $slug ) {
			$post = ra_pub_pagina( $slug );
			$log( 'log', $post ? "  {$slug} (ID {$post->ID}) → papelera" : "  No existe {$slug}" );
		}
		$log( 'log', 'Importaría el directorio, crearía los formularios, pondría el logo y desactivaría: ' . implode( ', ', $c['plugins_fuera'] ) . '.' );
		$log( 'success', 'Simulación terminada.' );
	}

	/** 2. Plugins y tema. Los patrones del tema se registran al cargar la página siguiente. */
	function ra_pub_activar( callable $log ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		foreach ( ra_pub_config()['plugins_activar'] as $plugin ) {
			$r = activate_plugin( $plugin );
			if ( is_wp_error( $r ) ) {
				$log( 'warning', "No se pudo activar {$plugin}: " . $r->get_error_message() );
				return false;
			}
		}
		switch_theme( 'redaltruista' );
		$log( 'log', 'Plugin y tema activados.' );
		return true;
	}

	/** 3–6. Contenido: directorio, formularios, páginas, logo y Avada fuera. Requiere el tema nuevo activo. */
	function ra_pub_contenido( callable $log ) {
		$c = ra_pub_config();
		if ( 'redaltruista' !== get_stylesheet() ) {
			$log( 'warning', 'El tema Red Altruista no está activo.' );
			return false;
		}

		// Como administrador y sin kses: lo que se guarda (estilos de los patrones, el iframe de Contribuye) queda tal cual.
		if ( ! current_user_can( 'manage_options' ) ) {
			$admins = get_users( array( 'role' => 'administrator', 'number' => 1, 'orderby' => 'ID' ) );
			if ( $admins ) {
				wp_set_current_user( $admins[0]->ID );
			}
		}
		kses_remove_filters();

		// 3. Directorio de asociaciones.
		$r = ra_dir_import();
		if ( is_wp_error( $r ) ) {
			$log( 'warning', 'Directorio: ' . $r->get_error_message() );
		} else {
			$log( 'log', sprintf( 'Directorio: %d creadas, %d ya existían.', $r['created'], $r['skipped'] ) );
			foreach ( $r['log'] as $linea ) {
				if ( 0 === strpos( $linea, '!' ) || false !== strpos( $linea, 'sin logo' ) ) {
					$log( 'warning', $linea );
				}
			}
		}

		// 4. Formularios, antes que las páginas: el patrón de Contáctanos inserta el formulario «Contacto».
		if ( ! defined( 'RA_PUBLICAR' ) ) {
			define( 'RA_PUBLICAR', true );
		}
		require_once ra_pub_ruta( 'formularios.php' );
		ra_formularios_guardar( $log );
		$ejemplo = wpcf7_get_contact_form_by_title( 'Contact form 1' );
		if ( $ejemplo ) {
			wp_trash_post( $ejemplo->id() );
			$log( 'log', 'Formulario de ejemplo «Contact form 1» → papelera.' );
		}

		// 5. Páginas.
		$registro = WP_Block_Patterns_Registry::get_instance();
		$eventos  = ra_pub_pagina( 'eventos' );
		foreach ( $c['paginas'] as $slug => $p ) {
			$post   = ra_pub_pagina( $slug );
			$patron = $registro->get_registered( 'redaltruista/' . $p['patron'] );
			if ( ! $patron ) {
				$log( 'warning', "El patrón {$p['patron']} no está registrado; «{$slug}» no se tocó." );
				continue;
			}
			$datos = array(
				'ID'            => $post->ID,
				'post_title'    => $p['titulo'],
				'post_content'  => $patron['content'],
				'post_status'   => 'publish',
				'post_parent'   => isset( $p['superior'] ) ? $eventos->ID : $post->post_parent,
				// La plantilla de Avada (100-width.php) no existe en el tema nuevo y WordPress no guardaría la página.
				'page_template' => isset( $p['plantilla'] ) ? $p['plantilla'] : 'default',
			);
			if ( isset( $p['fecha'] ) ) {
				$datos['post_date']     = $p['fecha'];
				$datos['post_date_gmt'] = get_gmt_from_date( $p['fecha'] );
			}
			$r = wp_update_post( wp_slash( $datos ), true );
			if ( is_wp_error( $r ) ) {
				$log( 'warning', "«{$slug}»: " . $r->get_error_message() );
				continue;
			}

			if ( isset( $p['imagen'] ) ) {
				$img = $p['imagen'];
				if ( is_string( $img ) ) {
					$archivo = $img;
					$img     = ra_pub_adjunto( $archivo );
					if ( ! $img ) {
						require_once ABSPATH . 'wp-admin/includes/media.php';
						require_once ABSPATH . 'wp-admin/includes/file.php';
						require_once ABSPATH . 'wp-admin/includes/image.php';
						$tmp = wp_tempnam( $archivo );
						copy( ra_pub_ruta( 'medios/' . $archivo ), $tmp );
						$img = media_handle_sideload( array( 'name' => $archivo, 'tmp_name' => $tmp ), $post->ID, $p['titulo'] );
						if ( is_wp_error( $img ) ) {
							$log( 'warning', "No se pudo subir {$archivo}: " . $img->get_error_message() );
							$img = 0;
						} else {
							$log( 'log', "  Subida {$archivo} (adjunto {$img})." );
						}
					}
				}
				if ( $img ) {
					set_post_thumbnail( $post->ID, $img );
				}
			}
			$log( 'log', sprintf( '  %s (ID %d) → %s', $slug, $post->ID, get_permalink( $post->ID ) ) );
		}

		foreach ( $c['a_borrador'] as $slug ) {
			$post = ra_pub_pagina( $slug );
			if ( $post && 'draft' !== $post->post_status ) {
				wp_update_post( array( 'ID' => $post->ID, 'post_status' => 'draft' ) );
				$log( 'log', "  {$slug} (ID {$post->ID}) → borrador." );
			}
		}
		foreach ( $c['a_papelera'] as $slug ) {
			$post = ra_pub_pagina( $slug );
			if ( $post ) {
				wp_trash_post( $post->ID );
				$log( 'log', "  {$slug} (ID {$post->ID}) → papelera." );
			}
		}

		// 6. Logo, Avada fuera, enlaces permanentes (se regeneran en la siguiente visita, ya sin Avada).
		update_option( 'site_logo', $c['logo'] );
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		deactivate_plugins( $c['plugins_fuera'] );
		delete_option( 'rewrite_rules' );

		$log( 'success', 'Sitio publicado. Revisa ' . home_url( '/' ) . ' y haz un envío de prueba en ' . home_url( '/contactanos/' ) . '.' );
		return true;
	}

	/** Bitácora de la última corrida (por usuario), entre la acción y la pantalla. */
	function ra_pub_bitacora( $agregar = null ) {
		$clave = 'ra_publicar_' . get_current_user_id();
		if ( null === $agregar ) {
			return get_transient( $clave ) ?: array();
		}
		set_transient( $clave, false === $agregar ? array() : array_merge( ra_pub_bitacora(), $agregar ), HOUR_IN_SECONDS ); // false = vaciar
	}

	/** La pantalla: botones y resultado de la última corrida. */
	function ra_pub_pantalla() {
		$bitacora = ra_pub_bitacora();
		$hecho    = 'redaltruista' === get_stylesheet() && ! is_plugin_active( 'fusion-builder/fusion-builder.php' );
		?>
		<div class="wrap">
			<h1>Publicar sitio</h1>
			<?php if ( $hecho ) : ?>
				<div class="notice notice-success"><p><strong>El sitio nuevo ya está publicado.</strong> Revisa las páginas, haz un envío de prueba en Contáctanos y después borra por SFTP <code>wp-content/mu-plugins/publicar.php</code> y la carpeta <code>wp-content/mu-plugins/publicar/</code>.</p></div>
			<?php else : ?>
				<p>Cambia el sitio de Avada al tema Red Altruista en un solo paso: activa el plugin y el tema, importa las asociaciones, crea el formulario de contacto, pone el contenido nuevo en cada página y desactiva Avada. El contenido de Avada de cada página queda como revisión.</p>
				<p><strong>Antes de publicar, haz un respaldo completo del sitio.</strong> Primero usa <em>Simular</em>: revisa que todo esté en su lugar y no cambia nada.</p>
			<?php endif; ?>
			<p>
				<a class="button" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=ra_publicar&paso=simular' ), 'ra_publicar_simular' ) ); ?>">Simular</a>
				<a class="button button-primary" href="<?php echo esc_url( wp_nonce_url( admin_url( 'admin-post.php?action=ra_publicar&paso=publicar' ), 'ra_publicar_publicar' ) ); ?>"><?php echo $hecho ? 'Volver a aplicar' : 'Publicar'; ?></a>
			</p>
			<?php if ( $bitacora ) : ?>
				<h2>Resultado</h2>
				<pre style="background:#fff;border:1px solid #ccd0d4;padding:1em;white-space:pre-wrap;"><?php
				foreach ( $bitacora as $linea ) {
					list( $tipo, $mensaje ) = $linea;
					$color = 'warning' === $tipo ? '#b32d2e' : ( 'success' === $tipo ? '#007017' : 'inherit' );
					printf( "<span style=\"color:%s\">%s%s</span>\n", esc_attr( $color ), 'warning' === $tipo ? 'Aviso: ' : '', esc_html( $mensaje ) );
				}
				?></pre>
			<?php endif; ?>
		</div>
		<?php
	}
}

/* ---------- Con WP-CLI: wp eval-file publicar.php [simular] ---------- */
if ( defined( 'WP_CLI' ) && WP_CLI && did_action( 'init' ) ) {
	$ra_log     = function ( $tipo, $mensaje ) {
		WP_CLI::$tipo( $mensaje );
	};
	$ra_simular = in_array( 'simular', (array) $args, true );
	WP_CLI::log( $ra_simular ? '== Simulación: no se escribe nada ==' : '== Publicación ==' );
	if ( ! ra_pub_revisar( $ra_log ) ) {
		WP_CLI::halt( 1 );
	}
	if ( 'redaltruista' !== get_stylesheet() ) {
		if ( $ra_simular ) {
			ra_pub_plan( $ra_log );
			return;
		}
		if ( ! ra_pub_activar( $ra_log ) ) {
			WP_CLI::halt( 1 );
		}
		// Los patrones del tema nuevo se registran en otro proceso.
		WP_CLI::runcommand( 'eval-file ' . escapeshellarg( __FILE__ ), array( 'launch' => true ) );
		return;
	}
	if ( $ra_simular ) {
		WP_CLI::log( 'El tema Red Altruista ya está activo: la simulación se detiene aquí.' );
		return;
	}
	ra_pub_contenido( $ra_log ) || WP_CLI::halt( 1 );
	return;
}

/* ---------- En el admin (como mu-plugin): Herramientas → Publicar sitio ---------- */
add_action(
	'admin_menu',
	function () {
		add_management_page( 'Publicar sitio', 'Publicar sitio', 'manage_options', 'ra-publicar', 'ra_pub_pantalla' );
	}
);

add_action(
	'admin_post_ra_publicar',
	function () {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'No tienes permiso.' );
		}
		$paso = isset( $_REQUEST['paso'] ) ? sanitize_key( $_REQUEST['paso'] ) : '';
		check_admin_referer( 'ra_publicar_' . $paso );

		$lineas = array();
		$log    = function ( $tipo, $mensaje ) use ( &$lineas ) {
			$lineas[] = array( $tipo, $mensaje );
		};
		$volver = admin_url( 'tools.php?page=ra-publicar' );

		if ( 'simular' === $paso ) {
			ra_pub_bitacora( false );
			$log( 'log', '== Simulación: no se escribe nada ==' );
			if ( ra_pub_revisar( $log ) ) {
				'redaltruista' === get_stylesheet() ? $log( 'log', 'El tema Red Altruista ya está activo.' ) : ra_pub_plan( $log );
			}
		} elseif ( 'publicar' === $paso ) {
			ra_pub_bitacora( false );
			$log( 'log', '== Publicación ==' );
			if ( ra_pub_revisar( $log ) && ( 'redaltruista' === get_stylesheet() || ra_pub_activar( $log ) ) ) {
				// El contenido va en la petición siguiente, ya con el tema nuevo cargado (sus patrones).
				ra_pub_bitacora( $lineas );
				wp_safe_redirect( // Sin wp_nonce_url(): escapa los & y la redirección perdería el paso.
					add_query_arg(
						array(
							'action'   => 'ra_publicar',
							'paso'     => 'contenido',
							'_wpnonce' => wp_create_nonce( 'ra_publicar_contenido' ),
						),
						admin_url( 'admin-post.php' )
					)
				);
				exit;
			}
		} elseif ( 'contenido' === $paso ) {
			ra_pub_contenido( $log );
		}
		ra_pub_bitacora( $lineas );
		wp_safe_redirect( $volver );
		exit;
	}
);
