<?php
/**
 * Related Posts component.
 *
 * @package Visitbest
 *
 * @var array $args {
 *     @type int    $post_id Post ID. Default current post.
 *     @type int    $count   Number of posts. Default 3.
 *     @type string $title   Section title.
 *     @type string $class   Additional CSS classes.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args ?? array(),
	array(
		'post_id' => get_the_ID(),
		'count'   => 3,
		'title'   => __( 'You May Also Like', 'visitbest' ),
		'class'   => '',
	)
);

$post_id    = (int) $args['post_id'];
$categories = wp_get_post_categories( $post_id );
$query_args = array(
	'post_type'           => 'post',
	'posts_per_page'      => (int) $args['count'],
	'post__not_in'        => array( $post_id ),
	'ignore_sticky_posts' => true,
	'no_found_rows'       => true,
);

if ( ! empty( $categories ) ) {
	$query_args['category__in'] = $categories;
}

$related_query = new WP_Query( $query_args );

if ( ! $related_query->have_posts() ) {
	return;
}

$classes = trim( 'vb-related-posts ' . $args['class'] );
?>

<section class="<?php echo esc_attr( $classes ); ?>" aria-label="<?php esc_attr_e( 'Related posts', 'visitbest' ); ?>">
	<header class="vb-related-posts__header">
		<?php
		Visitbest_Components::section_heading(
			array(
				'title' => $args['title'],
			)
		);
		?>
	</header>

	<div class="vb-grid-cards vb-grid-cards--3">
		<?php
		while ( $related_query->have_posts() ) :
			$related_query->the_post();
			Visitbest_Components::post_card(
				array(
					'post_id'      => get_the_ID(),
					'show_excerpt' => false,
				)
			);
		endwhile;
		wp_reset_postdata();
		?>
	</div>
</section>
