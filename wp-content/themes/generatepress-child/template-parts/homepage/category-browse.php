<?php
/**
 * Homepage category browse section.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$categories = get_categories(
	array(
		'hide_empty' => true,
	)
);

if ( empty( $categories ) ) {
	return;
}
?>

<section class="vb-home-categories vb-section" id="vb-category-browse" aria-labelledby="vb-categories-heading">
	<div class="vb-container">
		<?php
		Visitbest_Components::section_heading(
			array(
				'eyebrow'     => __( 'Discover', 'visitbest' ),
				'title'       => __( 'Browse by Category', 'visitbest' ),
				'description' => __( 'Jump into the topics that matter most to you.', 'visitbest' ),
			)
		);
		?>

		<div class="vb-home-categories__grid">
			<?php foreach ( $categories as $category ) : ?>
				<a class="vb-home-categories__card" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
					<span class="vb-home-categories__name"><?php echo esc_html( $category->name ); ?></span>
					<span class="vb-home-categories__count">
						<?php
						printf(
							/* translators: %d: number of posts */
							esc_html( _n( '%d article', '%d articles', (int) $category->count, 'visitbest' ) ),
							(int) $category->count
						);
						?>
					</span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
