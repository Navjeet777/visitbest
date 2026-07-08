<?php
/**
 * Archive page header.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$description = '';
$eyebrow     = '';
$title       = '';

if ( is_category() ) {
	$eyebrow     = __( 'Category', 'visitbest' );
	$title       = single_cat_title( '', false );
	$description = category_description();
} elseif ( is_tag() ) {
	$eyebrow     = __( 'Tag', 'visitbest' );
	$title       = single_tag_title( '', false );
	$description = tag_description();
} elseif ( is_search() ) {
	$eyebrow = __( 'Search', 'visitbest' );
	$title   = sprintf(
		/* translators: %s: search query */
		__( 'Results for "%s"', 'visitbest' ),
		get_search_query()
	);
} elseif ( is_author() ) {
	$eyebrow = __( 'Author', 'visitbest' );
	$title   = get_the_author();
} elseif ( is_404() ) {
	$eyebrow = __( 'Error', 'visitbest' );
	$title   = __( 'Page not found', 'visitbest' );
} else {
	$title = get_the_archive_title();
}
?>

<header class="vb-archive-header vb-section">
	<div class="vb-container">
		<?php if ( $eyebrow ) : ?>
			<p class="vb-archive-header__eyebrow vb-meta"><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>

		<h1 class="vb-archive-header__title vb-heading-1"><?php echo esc_html( wp_strip_all_tags( $title ) ); ?></h1>

		<?php if ( $description ) : ?>
			<div class="vb-archive-header__description">
				<?php echo wp_kses_post( $description ); ?>
			</div>
		<?php endif; ?>

		<?php if ( is_category() ) : ?>
			<?php
			$subcategories = get_categories(
				array(
					'parent'     => get_queried_object_id(),
					'hide_empty' => true,
				)
			);

			if ( ! empty( $subcategories ) ) :
				?>
				<div class="vb-archive-header__filters">
					<?php
					Visitbest_Components::category_pills(
						array(
							'categories' => $subcategories,
						)
					);
					?>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( is_search() ) : ?>
			<div class="vb-archive-header__search">
				<?php get_search_form(); ?>
			</div>
		<?php endif; ?>
	</div>
</header>
