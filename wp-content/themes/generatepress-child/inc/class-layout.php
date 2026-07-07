<?php
/**
 * Site layout — custom header and footer.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Replace GeneratePress default header/footer with Visitbest layout.
 */
class Visitbest_Layout {

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'wp', array( __CLASS__, 'replace_gp_layout' ) );
		add_filter( 'generate_sidebar_layout', array( __CLASS__, 'front_page_no_sidebar' ) );
		add_filter( 'generate_content_layout', array( __CLASS__, 'front_page_full_width' ) );
	}

	/**
	 * Swap GP header/footer callbacks for child theme templates.
	 *
	 * @return void
	 */
	public static function replace_gp_layout() {
		remove_action( 'generate_header', 'generate_construct_header', 10 );
		remove_action( 'generate_footer', 'generate_construct_footer_widgets', 5 );
		remove_action( 'generate_footer', 'generate_construct_footer', 10 );

		add_action( 'generate_header', array( __CLASS__, 'render_header' ), 10 );
		add_action( 'generate_footer', array( __CLASS__, 'render_footer' ), 10 );
	}

	/**
	 * Render custom header.
	 *
	 * @return void
	 */
	public static function render_header() {
		get_template_part( 'template-parts/layout/header' );
	}

	/**
	 * Render custom footer.
	 *
	 * @return void
	 */
	public static function render_footer() {
		get_template_part( 'template-parts/layout/footer' );
	}

	/**
	 * Remove sidebar on the front page.
	 *
	 * @param string $layout Sidebar layout slug.
	 * @return string
	 */
	public static function front_page_no_sidebar( $layout ) {
		if ( is_front_page() ) {
			return 'no-sidebar';
		}

		return $layout;
	}

	/**
	 * Use full-width content container on the front page.
	 *
	 * @param string $layout Content layout slug.
	 * @return string
	 */
	public static function front_page_full_width( $layout ) {
		if ( is_front_page() ) {
			return 'full-width-content';
		}

		return $layout;
	}
}
