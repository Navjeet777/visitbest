<?php
/**
 * Theme setup and WordPress feature registration.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Core theme setup.
 */
class Visitbest_Theme_Setup {

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'after_setup_theme', array( __CLASS__, 'setup' ) );
		add_filter( 'body_class', array( __CLASS__, 'body_classes' ) );
	}

	/**
	 * Theme supports and image sizes.
	 *
	 * @return void
	 */
	public static function setup() {
		load_child_theme_textdomain( 'visitbest', VISITBEST_DIR . '/languages' );

		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );

		add_image_size( 'visitbest-card', 640, 360, true );
		add_image_size( 'visitbest-featured', 1200, 675, true );
		add_image_size( 'visitbest-affiliate', 400, 400, true );

		add_editor_style( 'assets/css/editor.css' );
	}

	/**
	 * Add semantic body classes for layout hooks.
	 *
	 * @param array $classes Body classes.
	 * @return array
	 */
	public static function body_classes( $classes ) {
		$classes[] = 'visitbest-theme';

		return $classes;
	}
}
