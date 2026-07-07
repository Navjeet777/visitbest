<?php
/**
 * Asset registration and enqueue.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue styles and scripts.
 */
class Visitbest_Assets {

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_frontend' ), 20 );
		add_action( 'enqueue_block_editor_assets', array( __CLASS__, 'enqueue_editor' ) );
	}

	/**
	 * Enqueue frontend design system and components.
	 *
	 * @return void
	 */
	public static function enqueue_frontend() {
		$version = VISITBEST_VERSION;

		wp_enqueue_style(
			'visitbest-tokens',
			VISITBEST_URI . '/assets/css/design-system/tokens.css',
			array(),
			$version
		);

		wp_enqueue_style(
			'visitbest-typography',
			VISITBEST_URI . '/assets/css/design-system/typography.css',
			array( 'visitbest-tokens' ),
			$version
		);

		wp_enqueue_style(
			'visitbest-spacing',
			VISITBEST_URI . '/assets/css/design-system/spacing.css',
			array( 'visitbest-tokens' ),
			$version
		);

		wp_enqueue_style(
			'visitbest-shadows',
			VISITBEST_URI . '/assets/css/design-system/shadows.css',
			array( 'visitbest-tokens' ),
			$version
		);

		wp_enqueue_style(
			'visitbest-buttons',
			VISITBEST_URI . '/assets/css/design-system/buttons.css',
			array( 'visitbest-tokens', 'visitbest-typography' ),
			$version
		);

		wp_enqueue_style(
			'visitbest-forms',
			VISITBEST_URI . '/assets/css/design-system/forms.css',
			array( 'visitbest-tokens', 'visitbest-typography' ),
			$version
		);

		wp_enqueue_style(
			'visitbest-components',
			VISITBEST_URI . '/assets/css/components/components.css',
			array(
				'visitbest-tokens',
				'visitbest-typography',
				'visitbest-spacing',
				'visitbest-shadows',
				'visitbest-buttons',
			),
			$version
		);

		wp_enqueue_style(
			'visitbest-child',
			VISITBEST_URI . '/style.css',
			array( 'visitbest-components' ),
			$version
		);
	}

	/**
	 * Enqueue block editor assets.
	 *
	 * @return void
	 */
	public static function enqueue_editor() {
		wp_enqueue_style(
			'visitbest-editor',
			VISITBEST_URI . '/assets/css/editor.css',
			array( 'visitbest-tokens', 'visitbest-typography' ),
			VISITBEST_VERSION
		);
	}
}
