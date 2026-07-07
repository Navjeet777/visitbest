<?php
/**
 * Homepage featured posts section.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$featured_query = Visitbest_Homepage::get_featured_posts();

if ( ! $featured_query->have_posts() ) {
	return;
}

$posts = $featured_query->posts;
wp_reset_postdata();
?>

<section class="vb-home-featured vb-section" aria-labelledby="vb-featured-heading">
	<div class="vb-container">
		<?php
		Visitbest_Components::section_heading(
			array(
				'eyebrow' => __( 'Editor\'s Picks', 'visitbest' ),
				'title'   => __( 'Featured Guides', 'visitbest' ),
			)
		);
		?>

		<div class="vb-home-featured__layout">
			<?php if ( ! empty( $posts[0] ) ) : ?>
				<div class="vb-home-featured__primary">
					<?php Visitbest_Components::featured_post_card( array( 'post_id' => $posts[0]->ID ) ); ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $posts[1] ) || ! empty( $posts[2] ) ) : ?>
				<div class="vb-home-featured__secondary vb-stack-5">
					<?php
					if ( ! empty( $posts[1] ) ) {
						Visitbest_Components::post_card( array( 'post_id' => $posts[1]->ID ) );
					}
					if ( ! empty( $posts[2] ) ) {
						Visitbest_Components::post_card( array( 'post_id' => $posts[2]->ID ) );
					}
					?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
