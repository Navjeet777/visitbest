<?php
/**
 * Production performance optimizations.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Performance and production readiness helpers.
 */
class Visitbest_Performance {

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_filter( 'wp_get_attachment_image_attributes', array( __CLASS__, 'lazy_load_content_images' ), 10, 3 );
		add_filter( 'script_loader_tag', array( __CLASS__, 'defer_scripts' ), 10, 3 );
		add_action( 'wp_head', array( __CLASS__, 'dns_prefetch' ), 1 );
	}

	/**
	 * Lazy-load images in post content (not hero/LCP).
	 *
	 * @param array        $attr       Image attributes.
	 * @param WP_Post      $attachment Attachment post.
	 * @param string|int[] $size       Image size.
	 * @return array
	 */
	public static function lazy_load_content_images( $attr, $attachment, $size ) {
		if ( is_admin() ) {
			return $attr;
		}

		if ( is_singular( 'post' ) && has_post_thumbnail() && (int) get_post_thumbnail_id() === (int) $attachment->ID ) {
			return $attr;
		}

		if ( empty( $attr['loading'] ) ) {
			$attr['loading'] = 'lazy';
		}

		if ( empty( $attr['decoding'] ) ) {
			$attr['decoding'] = 'async';
		}

		return $attr;
	}

	/**
	 * Defer non-critical theme scripts.
	 *
	 * @param string $tag    Script tag.
	 * @param string $handle Script handle.
	 * @param string $src    Script source.
	 * @return string
	 */
	public static function defer_scripts( $tag, $handle, $src ) {
		if ( is_admin() ) {
			return $tag;
		}

		$defer_handles = array( 'visitbest-header', 'visitbest-earphones' );

		if ( ! in_array( $handle, $defer_handles, true ) ) {
			return $tag;
		}

		if ( false !== strpos( $tag, 'defer' ) ) {
			return $tag;
		}

		return str_replace( ' src', ' defer src', $tag );
	}

	/**
	 * DNS prefetch for share domains on single posts.
	 *
	 * @return void
	 */
	public static function dns_prefetch() {
		if ( ! is_singular( 'post' ) ) {
			return;
		}

		$domains = array(
			'//wa.me',
			'//twitter.com',
			'//www.facebook.com',
			'//www.linkedin.com',
		);

		foreach ( $domains as $domain ) {
			printf( '<link rel="dns-prefetch" href="%s" />' . "\n", esc_url( $domain ) );
		}
	}
}
