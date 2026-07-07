<?php
/**
 * Category Pills component.
 *
 * @package Visitbest
 *
 * @var array $args {
 *     @type array  $categories Array of WP_Term objects. Default all categories.
 *     @type int    $active_id  Active category term ID.
 *     @type bool   $scrollable Enable horizontal scroll on mobile.
 *     @type string $class      Additional CSS classes.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args ?? array(),
	array(
		'categories' => get_categories(
			array(
				'hide_empty' => true,
			)
		),
		'active_id'  => 0,
		'scrollable' => true,
		'class'      => '',
	)
);

if ( empty( $args['categories'] ) || is_wp_error( $args['categories'] ) ) {
	return;
}

$classes = array( 'vb-category-pills' );

if ( $args['scrollable'] ) {
	$classes[] = 'vb-category-pills--scroll';
}

if ( ! empty( $args['class'] ) ) {
	$classes[] = $args['class'];
}
?>

<nav aria-label="<?php esc_attr_e( 'Categories', 'visitbest' ); ?>">
	<ul class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<?php foreach ( $args['categories'] as $category ) : ?>
			<?php
			$is_active = (int) $args['active_id'] === (int) $category->term_id;
			$pill_class = 'vb-category-pill' . ( $is_active ? ' is-active' : '' );
			?>
			<li>
				<a
					class="<?php echo esc_attr( $pill_class ); ?>"
					href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"
					<?php echo $is_active ? 'aria-current="page"' : ''; ?>
				>
					<?php echo esc_html( $category->name ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
