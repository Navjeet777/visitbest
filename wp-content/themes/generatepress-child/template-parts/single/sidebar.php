<?php
/**
 * Single post sticky sidebar (desktop TOC + ad).
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$headings = Visitbest_Single::get_content_headings();
?>

<aside class="vb-single-sidebar" aria-label="<?php esc_attr_e( 'Article sidebar', 'visitbest' ); ?>">
	<div class="vb-single-sidebar__inner">
		<?php if ( ! empty( $headings ) ) : ?>
			<nav class="vb-single-toc vb-single-toc--sidebar" aria-label="<?php esc_attr_e( 'Table of contents', 'visitbest' ); ?>">
				<p class="vb-single-toc__title"><?php esc_html_e( 'Table of Contents', 'visitbest' ); ?></p>
				<ol class="vb-single-toc__list">
					<?php foreach ( $headings as $heading ) : ?>
						<li class="vb-single-toc__item vb-single-toc__item--level-<?php echo esc_attr( (string) $heading['level'] ); ?>">
							<a href="#<?php echo esc_attr( $heading['id'] ); ?>">
								<?php echo esc_html( $heading['text'] ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ol>
			</nav>
		<?php endif; ?>

		<?php
		Visitbest_Components::ad_slot(
			'single-sidebar',
			__( 'Advertisement', 'visitbest' )
		);
		?>
	</div>
</aside>
