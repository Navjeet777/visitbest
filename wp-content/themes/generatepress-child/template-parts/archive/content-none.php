<?php
/**
 * No results template part.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="vb-archive-empty">
	<p class="vb-archive-empty__text">
		<?php esc_html_e( 'No posts found. Try a different search or browse our categories.', 'visitbest' ); ?>
	</p>
	<div class="vb-archive-empty__actions">
		<a class="vb-btn vb-btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php esc_html_e( 'Back to homepage', 'visitbest' ); ?>
		</a>
	</div>
</div>
