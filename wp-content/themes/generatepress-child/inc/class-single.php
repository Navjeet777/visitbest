<?php
/**
 * Single post template logic.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Single article layout, hooks, and helpers.
 */
class Visitbest_Single {

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'wp', array( __CLASS__, 'setup' ) );
		add_filter( 'body_class', array( __CLASS__, 'body_class' ) );
		add_filter( 'generate_sidebar_layout', array( __CLASS__, 'no_sidebar' ) );
		add_filter( 'generate_content_layout', array( __CLASS__, 'full_width' ) );
		add_action( 'generate_after_header', array( __CLASS__, 'render_breadcrumbs' ), 10 );
		add_action( 'generate_before_footer', array( __CLASS__, 'render_newsletter_cta' ), 10 );
		add_action( 'wp_head', array( __CLASS__, 'preload_hero_image' ), 5 );
		add_filter( 'the_content', array( __CLASS__, 'add_heading_ids' ), 12 );
		add_filter( 'the_content', array( __CLASS__, 'inject_mid_content_ad' ), 25 );
		add_shortcode( 'vb_product', array( __CLASS__, 'product_shortcode' ) );
	}

	/**
	 * Remove default GP single post output we replace in content-single.php.
	 *
	 * @return void
	 */
	public static function setup() {
		if ( ! is_singular( 'post' ) ) {
			return;
		}

		remove_action( 'generate_before_content', 'generate_featured_page_header_inside_single', 10 );
		remove_action( 'generate_after_entry_title', 'generate_post_meta', 10 );
		remove_action( 'generate_after_entry_header', 'generate_post_image', 10 );
		remove_action( 'generate_after_entry_content', 'generate_footer_meta', 10 );
	}

	/**
	 * Add single post body class.
	 *
	 * @param array $classes Body classes.
	 * @return array
	 */
	public static function body_class( $classes ) {
		if ( is_singular( 'post' ) ) {
			$classes[] = 'vb-single-post';
		}

		return $classes;
	}

	/**
	 * Force no-sidebar layout on single posts.
	 *
	 * @param string $layout Layout slug.
	 * @return string
	 */
	public static function no_sidebar( $layout ) {
		if ( is_singular( 'post' ) ) {
			return 'no-sidebar';
		}

		return $layout;
	}

	/**
	 * Full-width content on single posts.
	 *
	 * @param string $layout Layout slug.
	 * @return string
	 */
	public static function full_width( $layout ) {
		if ( is_singular( 'post' ) ) {
			return 'full-width-content';
		}

		return $layout;
	}

	/**
	 * Output Rank Math breadcrumbs.
	 *
	 * @return void
	 */
	public static function render_breadcrumbs() {
		if ( ! is_singular( 'post' ) ) {
			return;
		}

		if ( ! function_exists( 'rank_math_the_breadcrumbs' ) && ! shortcode_exists( 'rank_math_breadcrumb' ) ) {
			return;
		}

		echo '<div class="vb-single-breadcrumbs vb-container">';
		echo '<nav class="vb-breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'visitbest' ) . '">';

		if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
			rank_math_the_breadcrumbs();
		} else {
			echo do_shortcode( '[rank_math_breadcrumb]' );
		}

		echo '</nav></div>';
	}

	/**
	 * Newsletter CTA before footer on single posts.
	 *
	 * @return void
	 */
	public static function render_newsletter_cta() {
		if ( ! is_singular( 'post' ) ) {
			return;
		}

		echo '<section class="vb-single-newsletter vb-section" aria-label="' . esc_attr__( 'Newsletter signup', 'visitbest' ) . '">';
		echo '<div class="vb-container">';
		Visitbest_Components::cta_block(
			array(
				'eyebrow'     => __( 'Newsletter', 'visitbest' ),
				'title'       => __( 'Get the best guides in your inbox', 'visitbest' ),
				'text'        => __( 'Weekly curated lists on brands, products, and companies across India.', 'visitbest' ),
				'button_text' => __( 'Subscribe', 'visitbest' ),
				'button_url'  => '#vb-newsletter',
				'class'       => 'vb-single-newsletter__cta',
			)
		);
		echo '</div></section>';
	}

	/**
	 * Preload LCP hero image.
	 *
	 * @return void
	 */
	public static function preload_hero_image() {
		if ( ! is_singular( 'post' ) || ! has_post_thumbnail() ) {
			return;
		}

		$url = get_the_post_thumbnail_url( get_queried_object_id(), 'visitbest-featured' );

		if ( ! $url ) {
			return;
		}

		printf(
			'<link rel="preload" as="image" href="%s" fetchpriority="high" />' . "\n",
			esc_url( $url )
		);
	}

	/**
	 * Add anchor IDs to H2/H3 headings for TOC links.
	 *
	 * @param string $content Post content.
	 * @return string
	 */
	public static function add_heading_ids( $content ) {
		if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}

		return preg_replace_callback(
			'/<h([2-3])([^>]*)>(.*?)<\/h\1>/is',
			function ( $matches ) {
				$level = $matches[1];
				$attrs = $matches[2];
				$text  = $matches[3];

				if ( false !== stripos( $attrs, 'id=' ) ) {
					return $matches[0];
				}

				$id = sanitize_title( wp_strip_all_tags( $text ) );

				if ( ! $id ) {
					return $matches[0];
				}

				return sprintf( '<h%s id="%s"%s>%s</h%s>', $level, esc_attr( $id ), $attrs, $text, $level );
			},
			$content
		);
	}

	/**
	 * Inject mid-content ad after ~40% of paragraphs on long posts.
	 *
	 * @param string $content Post content.
	 * @return string
	 */
	public static function inject_mid_content_ad( $content ) {
		if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
			return $content;
		}

		$word_count = str_word_count( wp_strip_all_tags( $content ) );

		if ( $word_count < 800 ) {
			return $content;
		}

		$paragraphs = explode( '</p>', $content );
		$total      = count( $paragraphs );

		if ( $total < 6 ) {
			return $content;
		}

		$insert_at = (int) floor( $total * 0.4 );
		$ad        = Visitbest_Components::get_ad_slot_markup( 'single-mid-content', __( 'Advertisement', 'visitbest' ) );

		$paragraphs[ $insert_at ] .= '</p>' . $ad;
		$content                   = implode( '</p>', $paragraphs );

		return $content;
	}

	/**
	 * Affiliate product shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public static function product_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'title'       => '',
				'url'         => '',
				'image'       => '',
				'meta'        => '',
				'button_text' => __( 'Check Price on Amazon', 'visitbest' ),
			),
			$atts,
			'vb_product'
		);

		ob_start();
		Visitbest_Components::affiliate_product_card(
			array(
				'title'       => $atts['title'],
				'url'         => $atts['url'],
				'image_url'   => $atts['image'],
				'meta'        => $atts['meta'],
				'button_text' => $atts['button_text'],
			)
		);

		return ob_get_clean();
	}

	/**
	 * Human-readable date label (published vs updated).
	 *
	 * @param int $post_id Post ID.
	 * @return string
	 */
	public static function get_date_label( $post_id = 0 ) {
		$post_id   = $post_id ? $post_id : get_the_ID();
		$published = get_post_time( 'U', true, $post_id );
		$modified  = get_post_modified_time( 'U', true, $post_id );
		$date      = get_the_modified_date( '', $post_id );

		if ( $modified > ( $published + ( 2 * DAY_IN_SECONDS ) ) ) {
			return sprintf(
				/* translators: %s: formatted date */
				esc_html__( 'Updated %s', 'visitbest' ),
				esc_html( $date )
			);
		}

		return sprintf(
			/* translators: %s: formatted date */
			esc_html__( 'Published %s', 'visitbest' ),
			esc_html( get_the_date( '', $post_id ) )
		);
	}

	/**
	 * Extract H2/H3 headings for sidebar TOC.
	 *
	 * @param int $post_id Post ID.
	 * @return array<int, array{level: int, text: string, id: string}>
	 */
	public static function get_content_headings( $post_id = 0 ) {
		$post_id = $post_id ? $post_id : get_the_ID();
		$content = (string) get_post_field( 'post_content', $post_id );
		$headings = array();

		if ( preg_match_all( '/<!-- wp:heading \{[^}]*"level":(\d+)[^}]*\}[^>]*-->\s*<h\1[^>]*>(.*?)<\/h\1>/is', $content, $block_matches, PREG_SET_ORDER ) ) {
			foreach ( $block_matches as $match ) {
				$level = (int) $match[1];

				if ( $level < 2 || $level > 3 ) {
					continue;
				}

				$text = wp_strip_all_tags( $match[2] );
				$id   = sanitize_title( $text );

				if ( $text && $id ) {
					$headings[] = array(
						'level' => $level,
						'text'  => $text,
						'id'    => $id,
					);
				}
			}
		}

		if ( ! empty( $headings ) ) {
			return $headings;
		}

		if ( preg_match_all( '/<h([2-3])[^>]*>(.*?)<\/h\1>/is', $content, $html_matches, PREG_SET_ORDER ) ) {
			foreach ( $html_matches as $match ) {
				$text = wp_strip_all_tags( $match[2] );
				$id   = sanitize_title( $text );

				if ( $text && $id ) {
					$headings[] = array(
						'level' => (int) $match[1],
						'text'  => $text,
						'id'    => $id,
					);
				}
			}
		}

		return $headings;
	}

	/**
	 * Whether comments should render on singles.
	 *
	 * @return bool
	 */
	public static function should_show_comments() {
		if ( ! is_singular( 'post' ) ) {
			return false;
		}

		if ( ! post_type_supports( 'post', 'comments' ) ) {
			return false;
		}

		return comments_open() || get_comments_number();
	}
}
