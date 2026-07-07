<?php
/**
 * GenerateBlocks integration (free plugin).
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prepare theme for GenerateBlocks when the plugin is active.
 */
class Visitbest_GenerateBlocks {

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_pattern_category' ) );
		add_action( 'admin_notices', array( __CLASS__, 'admin_notice_missing_plugin' ) );
	}

	/**
	 * Register block pattern category for Visitbest layouts.
	 *
	 * @return void
	 */
	public static function register_pattern_category() {
		if ( ! function_exists( 'register_block_pattern_category' ) ) {
			return;
		}

		register_block_pattern_category(
			'visitbest',
			array(
				'label' => __( 'Visit-Best', 'visitbest' ),
			)
		);
	}

	/**
	 * Show admin notice when GenerateBlocks is not installed.
	 *
	 * Only shown to administrators on local/staging — does not affect frontend.
	 *
	 * @return void
	 */
	public static function admin_notice_missing_plugin() {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		if ( self::is_active() ) {
			return;
		}

		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

		if ( ! $screen || 'themes' !== $screen->id ) {
			return;
		}

		printf(
			'<div class="notice notice-info"><p>%s</p></div>',
			esc_html__( 'Visitbest child theme is ready for GenerateBlocks. Install the free GenerateBlocks plugin before Phase 2B layout work.', 'visitbest' )
		);
	}

	/**
	 * Whether GenerateBlocks is active.
	 *
	 * @return bool
	 */
	public static function is_active() {
		return defined( 'GENERATEBLOCKS_VERSION' ) || class_exists( 'GenerateBlocks' );
	}
}
