<?php
/**
 * Featured Post Card component.
 *
 * @package Visitbest
 *
 * @var array $args {
 *     @type int    $post_id      Post ID. Default current post.
 *     @type string $class        Additional CSS classes.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args ?? array(),
	array(
		'post_id' => get_the_ID(),
		'class'   => '',
	)
);

$post_id = (int) $args['post_id'];

if ( ! $post_id ) {
	return;
}

$permalink = get_permalink( $post_id );
$title     = get_the_title( $post_id );
$category  = Visitbest_Components::get_primary_category( $post_id );
$classes   = trim( 'vb-featured-post-card ' . $args['class'] );
?>

<article class="<?php echo esc_attr( $classes ); ?>">
	<a class="vb-featured-post-card__media" href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
		<?php
		if ( has_post_thumbnail( $post_id ) ) {
			echo get_the_post_thumbnail(
				$post_id,
				'visitbest-featured',
				array(
					'class'   => 'vb-featured-post-card__image',
					'loading' => 'lazy',
					'alt'     => the_title_attribute(
						array(
							'post' => $post_id,
							'echo' => false,
						)
					),
				)
			);
		}
		?>
	</a>

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
