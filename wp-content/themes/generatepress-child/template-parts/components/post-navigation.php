<?php
/**
 * Previous / Next post navigation within the same category.
 *
 * @package Visitbest
 *
 * @var array $args {
 *     @type string $class Additional CSS classes.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args ?? array(),
	array(
		'class' => '',
	)
);

$post_id    = get_the_ID();
$category   = Visitbest_Components::get_primary_category( $post_id );
$nav_label  = __( 'Related article', 'visitbest' );

if ( $category ) {
	$tax_query = array(
		array(
			'taxonomy' => 'category',
			'field'    => 'term_id',
			'terms'    => array( $category->term_id ),
		),
	);
	$nav_label = sprintf(
		/* translators: %s: category name */
		__( 'More in %s', 'visitbest' ),
		$category->name
	);
}

$prev = get_adjacent_post( true, '', true, 'category' );
$next = get_adjacent_post( true, '', false, 'category' );

if ( ! $prev && ! $next ) {
	$prev = get_previous_post();
	$next = get_next_post();
}

if ( ! $prev && ! $next ) {
	return;
}

$classes = trim( 'vb-post-nav ' . $args['class'] );
?>

<nav class="<?php echo esc_attr( $classes ); ?>" aria-label="<?php esc_attr_e( 'Post navigation', 'visitbest' ); ?>">
	<p class="vb-post-nav__label vb-meta"><?php echo esc_html( $nav_label ); ?></p>

	<div class="vb-post-nav__grid">
		<?php if ( $prev ) : ?>
			<a class="vb-post-nav__link vb-post-nav__link--prev" href="<?php echo esc_url( get_permalink( $prev ) ); ?>">
				<span class="vb-post-nav__direction"><?php esc_html_e( 'Previous', 'visitbest' ); ?></span>
				<span class="vb-post-nav__title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
			</a>
		<?php endif; ?>

		<?php if ( $next ) : ?>
			<a class="vb-post-nav__link vb-post-nav__link--next" href="<?php echo esc_url( get_permalink( $next ) ); ?>">
				<span class="vb-post-nav__direction"><?php esc_html_e( 'Next', 'visitbest' ); ?></span>
				<span class="vb-post-nav__title"><?php echo esc_html( get_the_title( $next ) ); ?></span>
			</a>
		<?php endif; ?>
	</div>
</nav>
