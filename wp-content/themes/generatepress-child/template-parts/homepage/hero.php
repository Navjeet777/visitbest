<?php
/**
 * Homepage hero section.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$categories = get_categories(
	array(
		'hide_empty' => true,
		'number'     => 6,
	)
);
?>

<section class="vb-home-hero vb-section" aria-labelledby="vb-hero-title">
	<div class="vb-container vb-home-hero__inner">
		<div class="vb-home-hero__content">
			<p class="vb-home-hero__eyebrow vb-meta"><?php esc_html_e( 'Explore Best In India', 'visitbest' ); ?></p>
			<h1 id="vb-hero-title" class="vb-home-hero__title vb-heading-1">
				<?php esc_html_e( 'Trusted guides on brands, products & more', 'visitbest' ); ?>
			</h1>
			<p class="vb-home-hero__text">
				<?php esc_html_e( 'Expert-curated listicles to help you discover the best watches, appliances, companies, and more across India.', 'visitbest' ); ?>
			</p>
			<div class="vb-home-hero__actions">
				<a class="vb-btn vb-btn--primary vb-btn--lg" href="#vb-latest-posts">
					<?php esc_html_e( 'Browse latest guides', 'visitbest' ); ?>
				</a>
				<a class="vb-btn vb-btn--secondary vb-btn--lg" href="#vb-category-browse">
					<?php esc_html_e( 'View categories', 'visitbest' ); ?>
				</a>
			</div>
		</div>

		<?php if ( ! empty( $categories ) ) : ?>
			<div class="vb-home-hero__categories">
				<?php
				Visitbest_Components::category_pills(
					array(
						'categories' => $categories,
						'scrollable' => true,
					)
				);
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
