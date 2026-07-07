<?php
/**
 * Header helpers.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header utility methods.
 */
class Visitbest_Header {

	/**
	 * Fallback menu when no primary menu is assigned.
	 *
	 * @return void
	 */
	public static function fallback_menu() {
		$categories = get_categories(
			array(
				'hide_empty' => true,
				'number'     => 5,
			)
		);

		if ( empty( $categories ) ) {
			return;
		}

		echo '<ul class="vb-header__menu">';
		foreach ( $categories as $category ) {
			printf(
				'<li><a href="%1$s">%2$s</a></li>',
				esc_url( get_category_link( $category->term_id ) ),
				esc_html( $category->name )
			);
		}
		echo '</ul>';
	}
}
