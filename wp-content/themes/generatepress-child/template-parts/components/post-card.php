<?php
/**
 * Post Card component.
 *
 * @package Visitbest
 *
 * @var array $args {
 *     @type int    $post_id       Post ID. Default current post.
 *     @type bool   $show_excerpt  Show excerpt. Default true.
 *     @type bool   $show_meta     Show meta row. Default true.
 *     @type string $class         Additional CSS classes.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args ?? array(),
	array(
		'post_id'      => get_the_ID(),
		'show_excerpt' => true,
		'show_meta'    => true,
		'class'        => '',
	)
);

$post_id = (int) $args['post_id'];

if ( ! $post_id ) {
	return;
}

$permalink = get_permalink( $post_id );
$title     = get_the_title( $post_id );
$category  = Visitbest_Components::get_primary_category( $post_id );
$classes   = trim( 'vb-post-card ' . $args['class'] );
?>

<article class="<?php echo esc_attr( $classes ); ?>">
	<a class="vb-post-card__media" href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
		<?php
		if ( has_post_thumbnail( $post_id ) ) {
			echo get_the_post_thumbnail(
				$post_id,
				'visitbest-card',
				array(
					'class'   => 'vb-post-card__image',
					'loading' => 'lazy',
					'alt'     => the_title_attribute(
						array(
							'post'  => $post_id,
							'echo'  => false,
						)
					),
				)
			);
		}
		?>
	</a>

	<div class="vb-post-card__body">
		<?php if ( $args['show_meta'] && $category ) : ?>
			<div class="vb-post-card__meta">
				<span class="vb-meta">
					<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
						<?php echo esc_html( $category->name ); ?>
					</a>
				</span>
				<span class="vb-meta vb-body-muted">
					<?php
					printf(
						/* translators: %d: reading time in minutes */
						esc_html__( '%d min read', 'visitbest' ),
						(int) Visitbest_Components::get_reading_time( $post_id )
					);
					?>
				</span>
			</div>
		<?php endif; ?>

		<h3 class="vb-post-card__title">
			<a href="<?php echo esc_url( $permalink ); ?>">
				<?php echo esc_html( $title ); ?>
			</a>
		</h3>

		<?php if ( $args['show_excerpt'] ) : ?>
			<p class="vb-post-card__excerpt">
				<?php echo esc_html( get_the_excerpt( $post_id ) ); ?>
			</p>
		<?php endif; ?>

		<footer class="vb-post-card__footer">
			<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $post_id ) ); ?>">
				<?php echo esc_html( get_the_date( '', $post_id ) ); ?>
			</time>
		</footer>
	</div>
</article>
