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
	 * Post IDs rendered in the featured section (excluded from latest).
	 *
	 * @var int[]
	 */
	private static $featured_post_ids = array();

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
	 * @param int   $count   Number of posts.
	 * @param int[] $exclude Post IDs to exclude.
	 * @return WP_Query
	 */
	public static function get_latest_posts( $count = 6, $exclude = array() ) {
		if ( empty( $exclude ) ) {
			$exclude = self::$featured_post_ids;
		}

		$query_args = array(
			'post_type'           => 'post',
			'posts_per_page'      => $count,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		);

		if ( ! empty( $exclude ) ) {
			$query_args['post__not_in'] = array_map( 'intval', $exclude );
		}

		return new WP_Query( $query_args );
	}

	/**
	 * Query featured posts (latest three).
	 *
	 * @return WP_Query
	 */
	public static function get_featured_posts() {
		$query = self::get_latest_posts( 3, array() );

		self::$featured_post_ids = ! empty( $query->posts )
			? wp_list_pluck( $query->posts, 'ID' )
			: array();

		return $query;
	}

	/**
	 * Permalink for the posts page.
	 *
	 * @return string
	 */
	public static function get_posts_page_url() {
		$posts_page_id = (int) get_option( 'page_for_posts' );

		if ( $posts_page_id ) {
			$permalink = get_permalink( $posts_page_id );

			if ( $permalink ) {
				return $permalink;
			}
		}

		return home_url( '/' );
	}
}
