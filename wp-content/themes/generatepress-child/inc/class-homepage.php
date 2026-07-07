<?php
/**
 * Homepage rendering.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front page sections.
 */
class Visitbest_Homepage {

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_filter( 'body_class', array( __CLASS__, 'body_class' ) );
		add_action( 'wp', array( __CLASS__, 'disable_gp_page_header' ) );
	}

	/**
	 * Prevent GP page hero from appearing above custom homepage.
	 *
	 * @return void
	 */
	public static function disable_gp_page_header() {
		if ( ! is_front_page() ) {
			return;
		}

		remove_action( 'generate_after_header', 'generate_featured_page_header', 10 );
	}

	/**
	 * Add homepage body class.
	 *
	 * @param array $classes Body classes.
	 * @return array
	 */
	public static function body_class( $classes ) {
		if ( is_front_page() ) {
			$classes[] = 'vb-homepage';
		}

		return $classes;
	}

	/**
	 * Render all homepage sections.
	 *
	 * @return void
	 */
	public static function render() {
		get_template_part( 'template-parts/homepage/hero' );
		get_template_part( 'template-parts/homepage/featured-posts' );
		self::render_ad_slot( 'homepage-mid-1', __( 'Advertisement', 'visitbest' ) );
		get_template_part( 'template-parts/homepage/latest-posts' );
		get_template_part( 'template-parts/homepage/category-browse' );
		get_template_part( 'template-parts/homepage/newsletter' );
		self::render_ad_slot( 'homepage-bottom', __( 'Advertisement', 'visitbest' ) );
	}

	/**
	 * Output a reserved AdSense placeholder slot.
	 *
	 * @param string $slot_id Slot identifier.
	 * @param string $label   Accessible label.
	 * @return void
	 */
	public static function render_ad_slot( $slot_id, $label ) {
		printf(
			'<aside class="vb-ad-slot" data-ad-slot="%1$s" role="complementary" aria-label="%2$s"><span class="vb-ad-slot__label">%3$s</span></aside>',
			esc_attr( $slot_id ),
			esc_attr( $label ),
			esc_html__( 'Ad placeholder', 'visitbest' )
		);
	}

	/**
	 * Query latest posts.
	 *
	 * @param int $count Number of posts.
	 * @return WP_Query
	 */
	public static function get_latest_posts( $count = 6 ) {
		return new WP_Query(
			array(
				'post_type'           => 'post',
				'posts_per_page'      => $count,
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			)
		);
	}

	/**
	 * Query featured posts (latest three).
	 *
	 * @return WP_Query
	 */
	public static function get_featured_posts() {
		return self::get_latest_posts( 3 );
	}
}
