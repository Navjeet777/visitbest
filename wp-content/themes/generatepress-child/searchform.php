<?php
/**
 * Custom search form markup.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form role="search" method="get" class="search-form vb-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="vb-search-field"><?php echo esc_html_x( 'Search for:', 'label', 'visitbest' ); ?></label>
	<input
		type="search"
		id="vb-search-field"
		class="search-field vb-input"
		placeholder="<?php echo esc_attr_x( 'Search guides…', 'placeholder', 'visitbest' ); ?>"
		value="<?php echo esc_attr( get_search_query() ); ?>"
		name="s"
	/>
	<button type="submit" class="vb-btn vb-btn--primary vb-btn--sm search-submit">
		<?php echo esc_html_x( 'Search', 'submit button', 'visitbest' ); ?>
	</button>
</form>
