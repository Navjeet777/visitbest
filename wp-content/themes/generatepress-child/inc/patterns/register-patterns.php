<?php
/**
 * GenerateBlocks block pattern registration.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Visitbest block patterns for GenerateBlocks.
 */
class Visitbest_Patterns {

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_patterns' ) );
	}

	/**
	 * Register all block patterns.
	 *
	 * @return void
	 */
	public static function register_patterns() {
		if ( ! function_exists( 'register_block_pattern' ) ) {
			return;
		}

		self::register_pattern(
			'homepage-hero',
			__( 'Visitbest — Homepage Hero', 'visitbest' ),
			self::get_hero_pattern()
		);

		self::register_pattern(
			'homepage-featured-query',
			__( 'Visitbest — Featured Posts Query', 'visitbest' ),
			self::get_featured_query_pattern()
		);

		self::register_pattern(
			'homepage-latest-query',
			__( 'Visitbest — Latest Posts Grid (Query Loop)', 'visitbest' ),
			self::get_latest_query_pattern()
		);

		self::register_pattern(
			'homepage-category-browse',
			__( 'Visitbest — Category Browse Grid', 'visitbest' ),
			self::get_category_browse_pattern()
		);

		self::register_pattern(
			'homepage-newsletter-cta',
			__( 'Visitbest — Newsletter CTA', 'visitbest' ),
			self::get_newsletter_pattern()
		);

		self::register_pattern(
			'adsense-slot',
			__( 'Visitbest — AdSense Placeholder', 'visitbest' ),
			self::get_ad_slot_pattern()
		);
	}

	/**
	 * Helper to register a single pattern.
	 *
	 * @param string $slug Pattern slug.
	 * @param string $title Pattern title.
	 * @param string $content Block markup.
	 * @return void
	 */
	private static function register_pattern( $slug, $title, $content ) {
		register_block_pattern(
			'visitbest/' . $slug,
			array(
				'title'         => $title,
				'description'   => __( 'Visit-Best editorial layout pattern.', 'visitbest' ),
				'categories'    => array( 'visitbest' ),
				'keywords'      => array( 'visitbest', 'homepage', 'blog' ),
				'content'       => $content,
				'viewportWidth' => 1280,
			)
		);
	}

	/**
	 * Hero section pattern markup.
	 *
	 * @return string
	 */
	private static function get_hero_pattern() {
		return '<!-- wp:group {"className":"vb-home-hero vb-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group vb-home-hero vb-section"><!-- wp:heading {"level":1,"className":"vb-heading-1"} -->
<h1 class="wp-block-heading vb-heading-1">Trusted guides on brands, products &amp; more</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"vb-body-muted"} -->
<p class="vb-body-muted">Expert-curated listicles to help you discover the best across India.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->';
	}

	/**
	 * Featured posts query loop — uses GenerateBlocks dynamic post data.
	 *
	 * @return string
	 */
	private static function get_featured_query_pattern() {
		if ( ! class_exists( 'GenerateBlocks' ) ) {
			return '<!-- wp:paragraph --><p>' . esc_html__( 'Install GenerateBlocks to use this query loop pattern.', 'visitbest' ) . '</p><!-- /wp:paragraph -->';
		}

		return '<!-- wp:generateblocks/query {"query":{"perPage":3,"postType":"post","order":"desc","orderBy":"date"}} -->
<div class="gb-query"><!-- wp:generateblocks/loop-item -->
<div class="gb-loop-item"><!-- wp:generateblocks/container {"isDynamic":true,"className":"vb-post-card"} -->
<div class="gb-container vb-post-card"><!-- wp:generateblocks/image {"useDynamicData":true,"dynamicContentType":"featured-image","className":"vb-post-card__image"} /-->

<!-- wp:generateblocks/headline {"element":"h3","useDynamicData":true,"dynamicContentType":"post-title","dynamicLinkType":"post","className":"vb-post-card__title"} /-->

<!-- wp:generateblocks/headline {"element":"p","useDynamicData":true,"dynamicContentType":"post-excerpt","className":"vb-post-card__excerpt"} /--></div>
<!-- /wp:generateblocks/container --></div>
<!-- /wp:generateblocks/loop-item --></div>
<!-- /wp:generateblocks/query -->';
	}

	/**
	 * Latest posts 3-column query loop pattern.
	 *
	 * @return string
	 */
	private static function get_latest_query_pattern() {
		if ( ! class_exists( 'GenerateBlocks' ) ) {
			return '<!-- wp:paragraph --><p>' . esc_html__( 'Install GenerateBlocks to use this query loop pattern.', 'visitbest' ) . '</p><!-- /wp:paragraph -->';
		}

		return '<!-- wp:generateblocks/query {"query":{"perPage":6,"postType":"post","order":"desc","orderBy":"date"}} -->
<div class="gb-query"><!-- wp:generateblocks/grid {"columns":3,"horizontalGap":24,"verticalGap":24,"className":"vb-grid-cards vb-grid-cards--3"} -->
<div class="gb-grid vb-grid-cards vb-grid-cards--3"><!-- wp:generateblocks/loop-item -->
<div class="gb-loop-item"><!-- wp:generateblocks/container {"className":"vb-post-card"} -->
<div class="gb-container vb-post-card"><!-- wp:generateblocks/image {"useDynamicData":true,"dynamicContentType":"featured-image","className":"vb-post-card__image"} /-->

<!-- wp:generateblocks/headline {"element":"h3","useDynamicData":true,"dynamicContentType":"post-title","dynamicLinkType":"post","className":"vb-post-card__title"} /-->

<!-- wp:generateblocks/headline {"element":"p","useDynamicData":true,"dynamicContentType":"post-excerpt","className":"vb-post-card__excerpt"} /--></div>
<!-- /wp:generateblocks/container --></div>
<!-- /wp:generateblocks/loop-item --></div>
<!-- /wp:generateblocks/grid --></div>
<!-- /wp:generateblocks/query -->';
	}

	/**
	 * Category browse cards pattern.
	 *
	 * @return string
	 */
	private static function get_category_browse_pattern() {
		return '<!-- wp:group {"className":"vb-home-categories vb-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group vb-home-categories vb-section"><!-- wp:heading {"level":2,"className":"vb-heading-2"} -->
<h2 class="wp-block-heading vb-heading-2">Browse by Category</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"vb-body-muted"} -->
<p class="vb-body-muted">Jump into the topics that matter most to you.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->';
	}

	/**
	 * Newsletter CTA placeholder pattern.
	 *
	 * @return string
	 */
	private static function get_newsletter_pattern() {
		return '<!-- wp:group {"className":"vb-cta-block","layout":{"type":"constrained"}} -->
<div class="wp-block-group vb-cta-block"><!-- wp:heading {"level":2,"className":"vb-cta-block__title"} -->
<h2 class="wp-block-heading vb-cta-block__title">Get the best guides in your inbox</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"vb-cta-block__text"} -->
<p class="vb-cta-block__text">Weekly curated lists from Visit-Best. Newsletter integration coming soon.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->';
	}

	/**
	 * AdSense placeholder pattern.
	 *
	 * @return string
	 */
	private static function get_ad_slot_pattern() {
		return '<!-- wp:html -->
<aside class="vb-ad-slot" data-ad-slot="pattern-slot" role="complementary" aria-label="Advertisement"><span class="vb-ad-slot__label">Ad placeholder</span></aside>
<!-- /wp:html -->';
	}
}
