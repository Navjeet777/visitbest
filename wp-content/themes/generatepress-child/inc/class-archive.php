<?php
/**
 * Archive, search, and 404 template logic.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Archive and search layouts.
 */
class Visitbest_Archive {

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_filter( 'body_class', array( __CLASS__, 'body_class' ) );
		add_filter( 'generate_sidebar_layout', array( __CLASS__, 'no_sidebar' ) );
		add_filter( 'generate_content_layout', array( __CLASS__, 'full_width' ) );
		add_action( 'generate_after_header', array( __CLASS__, 'render_breadcrumbs' ), 10 );
		add_filter( 'get_the_archive_title', array( __CLASS__, 'archive_title' ) );
	}

	/**
	 * Add archive body classes.
	 *
	 * @param array $classes Body classes.
	 * @return array
	 */
	public static function body_class( $classes ) {
		if ( is_archive() || is_search() || is_404() ) {
			$classes[] = 'vb-archive-page';
		}

		if ( is_category() ) {
			$classes[] = 'vb-category-archive';
		}

		if ( is_tag() ) {
			$classes[] = 'vb-tag-archive';
		}

		if ( is_search() ) {
			$classes[] = 'vb-search-page';
		}

		if ( is_404() ) {
			$classes[] = 'vb-error-page';
		}

		return $classes;
	}

	/**
	 * No sidebar on archive views.
	 *
	 * @param string $layout Layout slug.
	 * @return string
	 */
	public static function no_sidebar( $layout ) {
		if ( is_archive() || is_search() || is_404() ) {
			return 'no-sidebar';
		}

		return $layout;
	}

	/**
	 * Full-width on archive views.
	 *
	 * @param string $layout Layout slug.
	 * @return string
	 */
	public static function full_width( $layout ) {
		if ( is_archive() || is_search() || is_404() ) {
			return 'full-width-content';
		}

		return $layout;
	}

	/**
	 * Clean archive titles.
	 *
	 * @param string $title Archive title.
	 * @return string
	 */
	public static function archive_title( $title ) {
		if ( is_category() ) {
			return single_cat_title( '', false );
		}

		if ( is_tag() ) {
			return single_tag_title( '', false );
		}

		if ( is_author() ) {
			return get_the_author();
		}

		if ( is_post_type_archive() ) {
			return post_type_archive_title( '', false );
		}

		return $title;
	}

	/**
	 * Output breadcrumbs on archive pages.
	 *
	 * @return void
	 */
	public static function render_breadcrumbs() {
		if ( ! is_archive() && ! is_search() && ! is_404() ) {
			return;
		}

		if ( ! function_exists( 'rank_math_the_breadcrumbs' ) && ! shortcode_exists( 'rank_math_breadcrumb' ) ) {
			return;
		}

		echo '<div class="vb-archive-breadcrumbs vb-container">';
		echo '<nav class="vb-breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'visitbest' ) . '">';

		if ( function_exists( 'rank_math_the_breadcrumbs' ) ) {
			rank_math_the_breadcrumbs();
		} else {
			echo do_shortcode( '[rank_math_breadcrumb]' );
		}

		echo '</nav></div>';
	}

	/**
	 * Render archive header section.
	 *
	 * @return void
	 */
	public static function render_header() {
		get_template_part( 'template-parts/archive/archive', 'header' );
	}

	/**
	 * Render post grid for current query.
	 *
	 * @return void
	 */
	public static function render_post_grid() {
		if ( ! have_posts() ) {
			get_template_part( 'template-parts/archive/content', 'none' );
			return;
		}

		echo '<div class="vb-archive-grid vb-grid-cards vb-grid-cards--3">';

		while ( have_posts() ) :
			the_post();
			Visitbest_Components::post_card();
		endwhile;

		echo '</div>';
	}

	/**
	 * Render accessible pagination.
	 *
	 * @return void
	 */
	public static function render_pagination() {
		global $wp_query;

		$total = (int) $wp_query->max_num_pages;

		if ( $total <= 1 ) {
			return;
		}

		$links = paginate_links(
			array(
				'type'      => 'array',
				'prev_text' => esc_html__( 'Previous', 'visitbest' ),
				'next_text' => esc_html__( 'Next', 'visitbest' ),
				'mid_size'  => 2,
			)
		);

		if ( empty( $links ) ) {
			return;
		}

		echo '<nav class="vb-pagination" aria-label="' . esc_attr__( 'Posts pagination', 'visitbest' ) . '">';
		echo '<ul class="vb-pagination__list">';

		foreach ( $links as $link ) {
			echo '<li class="vb-pagination__item">' . $link . '</li>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- paginate_links escapes.
		}

		echo '</ul></nav>';
	}
}
