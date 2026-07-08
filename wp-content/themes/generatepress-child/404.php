<?php
/**
 * 404 template.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<div <?php generate_do_attr( 'content' ); ?>>
	<main <?php generate_do_attr( 'main' ); ?> class="vb-archive-main">
		<?php do_action( 'generate_before_main_content' ); ?>

		<?php Visitbest_Archive::render_header(); ?>

		<div class="vb-container vb-section">
			<div class="vb-archive-empty">
				<p class="vb-archive-empty__text">
					<?php esc_html_e( 'The page you are looking for does not exist or has been moved.', 'visitbest' ); ?>
				</p>
				<div class="vb-archive-empty__actions">
					<a class="vb-btn vb-btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php esc_html_e( 'Back to homepage', 'visitbest' ); ?>
					</a>
					<a class="vb-btn vb-btn--secondary" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">
						<?php esc_html_e( 'Contact us', 'visitbest' ); ?>
					</a>
				</div>
				<div class="vb-archive-empty__search">
					<?php get_search_form(); ?>
				</div>
			</div>
		</div>

		<?php do_action( 'generate_after_main_content' ); ?>
	</main>
</div>

<?php
do_action( 'generate_after_primary_content_area' );
get_footer();
