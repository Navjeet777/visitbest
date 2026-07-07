<?php
/**
 * Featured Post Card component.
 *
 * @package Visitbest
 *
 * @var array $args {
 *     @type int    $post_id         Post ID. Default current post.
 *     @type bool   $priority_image  Use eager loading and high fetch priority. Default false.
 *     @type string $class           Additional CSS classes.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args ?? array(),
	array(
		'post_id'        => get_the_ID(),
		'priority_image' => false,
		'class'          => '',
	)
);

$post_id = (int) $args['post_id'];

if ( ! $post_id ) {
	return;
}

$permalink      = get_permalink( $post_id );
$title          = get_the_title( $post_id );
$category       = Visitbest_Components::get_primary_category( $post_id );
$classes        = trim( 'vb-featured-post-card ' . $args['class'] );
$has_thumbnail  = has_post_thumbnail( $post_id );
$image_attrs    = array(
	'class' => 'vb-featured-post-card__image',
	'alt'   => the_title_attribute(
		array(
			'post' => $post_id,
			'echo' => false,
		)
	),
);

if ( $args['priority_image'] ) {
	$image_attrs['loading']       = 'eager';
	$image_attrs['fetchpriority'] = 'high';
} else {
	$image_attrs['loading'] = 'lazy';
}
?>

<article class="<?php echo esc_attr( $classes ); ?>">
	<div class="vb-featured-post-card__media">
		<?php if ( $has_thumbnail ) : ?>
			<a href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
				<?php echo get_the_post_thumbnail( $post_id, 'visitbest-featured', $image_attrs ); ?>
			</a>
		<?php else : ?>
			<div class="vb-featured-post-card__placeholder" aria-hidden="true"></div>
		<?php endif; ?>
	</div>

	<div class="vb-featured-post-card__body">
		<?php if ( $category ) : ?>
			<span class="vb-meta">
				<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
					<?php echo esc_html( $category->name ); ?>
				</a>
			</span>
		<?php endif; ?>

		<h2 class="vb-featured-post-card__title">
			<a href="<?php echo esc_url( $permalink ); ?>">
				<?php echo esc_html( $title ); ?>
			</a>
		</h2>

		<p class="vb-featured-post-card__excerpt">
			<?php echo esc_html( get_the_excerpt( $post_id ) ); ?>
		</p>

		<a class="vb-btn vb-btn--primary" href="<?php echo esc_url( $permalink ); ?>">
			<?php esc_html_e( 'Read article', 'visitbest' ); ?>
		</a>
	</div>
</article>
