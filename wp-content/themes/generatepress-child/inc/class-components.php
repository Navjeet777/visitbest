<?php
/**
 * Reusable component render helpers.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Component rendering API.
 */
class Visitbest_Components {

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public static function init() {
		// Components are rendered on demand via public static methods.
	}

	/**
	 * Render a template part component.
	 *
	 * @param string $slug Component slug.
	 * @param array  $args Arguments passed to the template.
	 * @return void
	 */
	public static function render( $slug, $args = array() ) {
		get_template_part( 'template-parts/components/' . $slug, null, $args );
	}

	/**
	 * Render a post card.
	 *
	 * @param array $args Component arguments.
	 * @return void
	 */
	public static function post_card( $args = array() ) {
		self::render( 'post-card', $args );
	}

	/**
	 * Render a featured post card.
	 *
	 * @param array $args Component arguments.
	 * @return void
	 */
	public static function featured_post_card( $args = array() ) {
		self::render( 'featured-post-card', $args );
	}

	/**
	 * Render an affiliate product card.
	 *
	 * @param array $args Component arguments.
	 * @return void
	 */
	public static function affiliate_product_card( $args = array() ) {
		self::render( 'affiliate-product-card', $args );
	}

	/**
	 * Render a CTA block.
	 *
	 * @param array $args Component arguments.
	 * @return void
	 */
	public static function cta_block( $args = array() ) {
		self::render( 'cta-block', $args );
	}

	/**
	 * Render an author box.
	 *
	 * @param array $args Component arguments.
	 * @return void
	 */
	public static function author_box( $args = array() ) {
		self::render( 'author-box', $args );
	}

	/**
	 * Render related posts.
	 *
	 * @param array $args Component arguments.
	 * @return void
	 */
	public static function related_posts( $args = array() ) {
		self::render( 'related-posts', $args );
	}

	/**
	 * Render category pills.
	 *
	 * @param array $args Component arguments.
	 * @return void
	 */
	public static function category_pills( $args = array() ) {
		self::render( 'category-pills', $args );
	}

	/**
	 * Render a section heading.
	 *
	 * @param array $args Component arguments.
	 * @return void
	 */
	public static function section_heading( $args = array() ) {
		self::render( 'section-heading', $args );
	}

	/**
	 * Render social share buttons.
	 *
	 * @param array $args Component arguments.
	 * @return void
	 */
	public static function share_buttons( $args = array() ) {
		self::render( 'share-buttons', $args );
	}

	/**
	 * Render previous/next post navigation.
	 *
	 * @param array $args Component arguments.
	 * @return void
	 */
	public static function post_navigation( $args = array() ) {
		self::render( 'post-navigation', $args );
	}

	/**
	 * Output an ad placeholder slot.
	 *
	 * @param string $slot_id Slot identifier.
	 * @param string $label   Accessible label.
	 * @return void
	 */
	public static function ad_slot( $slot_id, $label ) {
		echo self::get_ad_slot_markup( $slot_id, $label ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper.
	}

	/**
	 * Return ad placeholder markup.
	 *
	 * @param string $slot_id Slot identifier.
	 * @param string $label   Accessible label.
	 * @return string
	 */
	public static function get_ad_slot_markup( $slot_id, $label ) {
		return sprintf(
			'<aside class="vb-ad-slot" data-ad-slot="%1$s" role="complementary" aria-label="%2$s"><span class="vb-ad-slot__label">%3$s</span></aside>',
			esc_attr( $slot_id ),
			esc_attr( $label ),
			esc_html__( 'Ad placeholder', 'visitbest' )
		);
	}

	/**
	 * Get estimated reading time in minutes.
	 *
	 * @param int $post_id Post ID.
	 * @return int
	 */
	public static function get_reading_time( $post_id = 0 ) {
		$post_id = $post_id ? $post_id : get_the_ID();
		$content = get_post_field( 'post_content', $post_id );
		$words   = str_word_count( wp_strip_all_tags( $content ) );
		$minutes = (int) ceil( $words / 200 );

		return max( 1, $minutes );
	}

	/**
	 * Get primary category for a post.
	 *
	 * @param int $post_id Post ID.
	 * @return WP_Term|null
	 */
	public static function get_primary_category( $post_id = 0 ) {
		$post_id    = $post_id ? $post_id : get_the_ID();
		$categories = get_the_category( $post_id );

		if ( empty( $categories ) ) {
			return null;
		}

		if ( class_exists( 'RankMath' ) ) {
			$primary_id = get_post_meta( $post_id, 'rank_math_primary_category', true );

			if ( $primary_id ) {
				$term = get_term( (int) $primary_id, 'category' );

				if ( $term && ! is_wp_error( $term ) ) {
					return $term;
				}
			}
		}

		return $categories[0];
	}
}
