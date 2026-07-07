<?php
/**
 * Homepage latest posts grid.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$latest_query = Visitbest_Homepage::get_latest_posts( 6 );

if ( ! $latest_query->have_posts() ) {
	return;
}
?>

<section class="vb-home-latest vb-section" id="vb-latest-posts" aria-labelledby="vb-latest-heading">
	<div class="vb-container">
		<?php
		Visitbest_Components::section_heading(
			array(
				'eyebrow'      => __( 'Fresh Content', 'visitbest' ),
				'title'        => __( 'Latest Posts', 'visitbest' ),
				'description'  => __( 'Recently published guides and listicles from Visit-Best.', 'visitbest' ),
				'action_label' => __( 'View all posts', 'visitbest' ),
				'action_url'   => get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ),
			)
		);
		?>

		<div class="vb-grid-cards vb-grid-cards--3">
			<?php
			while ( $latest_query->have_posts() ) :
				$latest_query->the_post();
				Visitbest_Components::post_card();
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
