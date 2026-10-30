<?php
/**
 * Funciones del tema Red Altruista.
 *
 * @package RedAltruista
 */

defined( 'ABSPATH' ) || exit;

/** Soportes del tema. */
add_action(
	'after_setup_theme',
	static function () {
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'style.css' );
		// Los patrones de wordpress.org no aplican a este sitio.
		remove_theme_support( 'core-block-patterns' );
	}
);

/** Hoja de estilos del tema (complementa a theme.json). */
add_action(
	'wp_enqueue_scripts',
	static function () {
		wp_enqueue_style( 'redaltruista', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
	}
);

/** Categoría propia para los patrones del tema. */
add_action(
	'init',
	static function () {
		register_block_pattern_category(
			'redaltruista',
			array( 'label' => __( 'Red Altruista', 'redaltruista' ) )
		);
	}
);

/** Quita scripts de emojis: el sitio no los necesita. */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
