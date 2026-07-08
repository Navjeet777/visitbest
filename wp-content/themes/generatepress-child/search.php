<?php
/**
 * Search results template.
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
			<?php Visitbest_Archive::render_post_grid(); ?>
			<?php Visitbest_Archive::render_pagination(); ?>
		</div>

		<?php do_action( 'generate_after_main_content' ); ?>
	</main>
</div>

<?php
do_action( 'generate_after_primary_content_area' );
get_footer();
