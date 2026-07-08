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

		self::register_article_pattern(
			'callout-tip',
			__( 'Visitbest — Tip Callout', 'visitbest' ),
			self::get_callout_pattern( 'tip', __( 'Pro tip', 'visitbest' ), __( 'Add your expert tip or buying advice here.', 'visitbest' ) )
		);

		self::register_article_pattern(
			'callout-warning',
			__( 'Visitbest — Warning Callout', 'visitbest' ),
			self::get_callout_pattern( 'warning', __( 'Important', 'visitbest' ), __( 'Add price disclaimers or availability notes here.', 'visitbest' ) )
		);

		self::register_article_pattern(
			'callout-info',
			__( 'Visitbest — Info Callout', 'visitbest' ),
			self::get_callout_pattern( 'info', __( 'How we evaluate', 'visitbest' ), __( 'Describe your methodology and testing process here.', 'visitbest' ) )
		);

		self::register_article_pattern(
			'quick-picks',
			__( 'Visitbest — Quick Picks Table', 'visitbest' ),
			self::get_quick_picks_pattern()
		);

		self::register_article_pattern(
			'pros-cons',
			__( 'Visitbest — Pros and Cons', 'visitbest' ),
			self::get_pros_cons_pattern()
		);

		self::register_article_pattern(
			'comparison-table',
			__( 'Visitbest — Comparison Table', 'visitbest' ),
			self::get_comparison_pattern()
		);

		self::register_article_pattern(
			'affiliate-disclosure',
			__( 'Visitbest — Affiliate Disclosure', 'visitbest' ),
			self::get_affiliate_disclosure_pattern()
		);

		self::register_article_pattern(
			'buying-guide',
			__( 'Visitbest — Buying Guide Section', 'visitbest' ),
			self::get_buying_guide_pattern()
		);

		self::register_article_pattern(
			'affiliate-product',
			__( 'Visitbest — Affiliate Product Card', 'visitbest' ),
			self::get_affiliate_product_pattern()
		);
	}

	/**
	 * Register an article-focused pattern.
	 *
	 * @param string $slug    Pattern slug.
	 * @param string $title   Pattern title.
	 * @param string $content Block markup.
	 * @return void
	 */
	private static function register_article_pattern( $slug, $title, $content ) {
		register_block_pattern(
			'visitbest/' . $slug,
			array(
				'title'         => $title,
				'description'   => __( 'Visit-Best listicle article pattern.', 'visitbest' ),
				'categories'    => array( 'visitbest' ),
				'keywords'      => array( 'visitbest', 'article', 'listicle', 'affiliate' ),
				'content'       => $content,
				'viewportWidth' => 720,
			)
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

	/**
	 * Callout box pattern.
	 *
	 * @param string $variant Callout variant.
	 * @param string $title   Callout title.
	 * @param string $text    Callout text.
	 * @return string
	 */
	private static function get_callout_pattern( $variant, $title, $text ) {
		return '<!-- wp:group {"className":"vb-callout vb-callout--' . esc_attr( $variant ) . '","layout":{"type":"constrained"}} -->
<div class="wp-block-group vb-callout vb-callout--' . esc_attr( $variant ) . '"><!-- wp:paragraph {"className":"vb-callout__title"} -->
<p class="vb-callout__title">' . esc_html( $title ) . '</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>' . esc_html( $text ) . '</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->';
	}

	/**
	 * Quick picks table pattern.
	 *
	 * @return string
	 */
	private static function get_quick_picks_pattern() {
		return '<!-- wp:group {"className":"vb-quick-picks","layout":{"type":"constrained"}} -->
<div class="wp-block-group vb-quick-picks"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Quick Picks</h3>
<!-- /wp:heading -->

<!-- wp:table -->
<figure class="wp-block-table"><table><thead><tr><th>Rank</th><th>Brand</th><th>Best For</th></tr></thead><tbody><tr><td>#1</td><td>Brand A</td><td>Overall best</td></tr><tr><td>#2</td><td>Brand B</td><td>Value pick</td></tr><tr><td>#3</td><td>Brand C</td><td>Premium choice</td></tr></tbody></table></figure>
<!-- /wp:table --></div>
<!-- /wp:group -->';
	}

	/**
	 * Pros and cons pattern.
	 *
	 * @return string
	 */
	private static function get_pros_cons_pattern() {
		return '<!-- wp:columns {"className":"vb-pros-cons"} -->
<div class="wp-block-columns vb-pros-cons"><!-- wp:column {"className":"vb-pros-cons__col vb-pros-cons__col--pros"} -->
<div class="wp-block-column vb-pros-cons__col vb-pros-cons__col--pros"><!-- wp:paragraph {"className":"vb-pros-cons__title"} -->
<p class="vb-pros-cons__title">Pros</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><li>Durable build quality</li><li>Great value for money</li><li>Wide availability</li></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"vb-pros-cons__col vb-pros-cons__col--cons"} -->
<div class="wp-block-column vb-pros-cons__col vb-pros-cons__col--cons"><!-- wp:paragraph {"className":"vb-pros-cons__title"} -->
<p class="vb-pros-cons__title">Cons</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><li>Premium pricing</li><li>Limited colour options</li></ul>
<!-- /wp:list --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->';
	}

	/**
	 * Comparison table pattern.
	 *
	 * @return string
	 */
	private static function get_comparison_pattern() {
		return '<!-- wp:group {"className":"vb-comparison-box","layout":{"type":"constrained"}} -->
<div class="wp-block-group vb-comparison-box"><!-- wp:table -->
<figure class="wp-block-table"><table><thead><tr><th>Feature</th><th>Product A</th><th>Product B</th></tr></thead><tbody><tr><td>Price</td><td>₹12,999</td><td>₹9,999</td></tr><tr><td>Rating</td><td>4.5 ★</td><td>4.2 ★</td></tr><tr><td>Best for</td><td>Premium buyers</td><td>Budget buyers</td></tr></tbody></table></figure>
<!-- /wp:table --></div>
<!-- /wp:group -->';
	}

	/**
	 * Affiliate disclosure pattern.
	 *
	 * @return string
	 */
	private static function get_affiliate_disclosure_pattern() {
		return '<!-- wp:paragraph {"className":"vb-affiliate-disclosure"} -->
<p class="vb-affiliate-disclosure">This post contains affiliate links. As an Amazon Associate, we earn from qualifying purchases. This does not affect our editorial independence.</p>
<!-- /wp:paragraph -->';
	}

	/**
	 * Buying guide section pattern.
	 *
	 * @return string
	 */
	private static function get_buying_guide_pattern() {
		return '<!-- wp:group {"className":"vb-buying-guide","layout":{"type":"constrained"}} -->
<div class="wp-block-group vb-buying-guide"><!-- wp:heading -->
<h2 class="wp-block-heading">Buying Guide</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Add key factors buyers should consider before making a purchase decision.</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><li>Factor one to consider</li><li>Factor two to consider</li><li>Factor three to consider</li></ul>
<!-- /wp:list --></div>
<!-- /wp:group -->';
	}

	/**
	 * Affiliate product card HTML pattern.
	 *
	 * @return string
	 */
	private static function get_affiliate_product_pattern() {
		return '<!-- wp:html -->
<aside class="vb-affiliate-card"><div class="vb-affiliate-card__content"><h3 class="vb-affiliate-card__title">Product Name</h3><p class="vb-affiliate-card__meta">★ 4.5 · From ₹9,999</p><a class="vb-btn vb-btn--cta vb-btn--block" href="#" target="_blank" rel="nofollow sponsored noopener">Check Price on Amazon</a><p class="vb-affiliate-card__disclosure">As an Amazon Associate, we earn from qualifying purchases.</p></div></aside>
<!-- /wp:html -->';
	}
}
