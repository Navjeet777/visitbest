<?php
/**
 * Single post content template.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'vb-single-article' ); ?> <?php generate_do_microdata( 'article' ); ?>>
	<div class="inside-article vb-single-article__inner">
		<?php do_action( 'generate_before_content' ); ?>

		<?php get_template_part( 'template-parts/single/article', 'header' ); ?>

		<div class="vb-single-layout vb-container">
			<div class="vb-single-content">
				<?php
				Visitbest_Components::ad_slot(
					'single-above-content',
					__( 'Advertisement', 'visitbest' )
				);
				?>

				<div class="entry-content"<?php echo 'microdata' === generate_get_schema_type() ? ' itemprop="text"' : ''; ?>>
					<?php
					the_content();

					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'visitbest' ),
							'after'  => '</div>',
						)
					);
					?>
				</div>
			</div>

			<?php get_template_part( 'template-parts/single/sidebar' ); ?>
		</div>

		<footer class="vb-single-footer">
			<?php
			Visitbest_Components::ad_slot(
				'single-after-content',
				__( 'Advertisement', 'visitbest' )
			);

			Visitbest_Components::author_box(
				array(
					'variant' => 'full',
					'class'   => 'vb-single-footer__author',
				)
			);

			Visitbest_Components::related_posts();

			Visitbest_Components::post_navigation();
			?>

			<?php if ( Visitbest_Single::should_show_comments() ) : ?>
				<div class="vb-comments" id="comments">
					<?php comments_template(); ?>
				</div>
			<?php endif; ?>
		</footer>

		<?php do_action( 'generate_after_content' ); ?>
	</div>
</article>
