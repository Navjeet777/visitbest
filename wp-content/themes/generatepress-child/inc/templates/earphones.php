<?php
/**
 * Earphones landing page template assets.
 *
 * Migrated from parent theme functions.php (Phase 2A).
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Earphones page template handler.
 */
class Visitbest_Earphones_Template {

	/**
	 * Page slug for the earphones landing page.
	 */
	const PAGE_SLUG = 'earphones-under-2000';

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ), 30 );
		add_filter( 'theme_page_templates', array( __CLASS__, 'register_page_template' ) );
	}

	/**
	 * Enqueue earphones template assets on the matching page only.
	 *
	 * @return void
	 */
	public static function enqueue_assets() {
		if ( ! is_page( self::PAGE_SLUG ) ) {
			return;
		}

		wp_enqueue_style(
			'visitbest-earphones',
			VISITBEST_URI . '/assets/css/templates/earphones.css',
			array(),
			VISITBEST_VERSION
		);

		wp_enqueue_script(
			'visitbest-earphones',
			VISITBEST_URI . '/assets/js/earphones.js',
			array(),
			VISITBEST_VERSION,
			true
		);
	}

	/**
	 * Ensure the earphones template appears in the page template dropdown.
	 *
	 * @param array $templates Existing templates.
	 * @return array
	 */
	public static function register_page_template( $templates ) {
		$templates['templates/page-earphones.php'] = __( 'Earphones Page', 'visitbest' );

		return $templates;
	}
}
