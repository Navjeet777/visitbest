<?php
/**
 * Author Box component.
 *
 * @package Visitbest
 *
 * @var array $args {
 *     @type int    $author_id Author user ID. Default post author.
 *     @type string $variant   compact|full. Default full.
 *     @type string $class     Additional CSS classes.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args ?? array(),
	array(
		'author_id' => (int) get_the_author_meta( 'ID' ),
		'variant'   => 'full',
		'class'     => '',
	)
);

$author_id = (int) $args['author_id'];

if ( ! $author_id ) {
	return;
}

$display_name = get_the_author_meta( 'display_name', $author_id );
$description  = get_the_author_meta( 'description', $author_id );
$posts_url    = get_author_posts_url( $author_id );
$avatar_size  = 'compact' === $args['variant'] ? 'sm' : 'lg';
$classes      = array( 'vb-author-box' );

if ( 'compact' === $args['variant'] ) {
	$classes[] = 'vb-author-box--compact';
}

if ( ! empty( $args['class'] ) ) {
	$classes[] = $args['class'];
}
?>

<section class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" aria-label="<?php esc_attr_e( 'About the author', 'visitbest' ); ?>">
	<div class="vb-author-box__avatar vb-author-box__avatar--<?php echo esc_attr( $avatar_size ); ?>">
		<?php echo get_avatar( $author_id, 'compact' === $args['variant'] ? 40 : 80 ); ?>
	</div>

	<div class="vb-author-box__content">
		<p class="vb-author-box__name">
			<a href="<?php echo esc_url( $posts_url ); ?>">
				<?php echo esc_html( $display_name ); ?>
			</a>
		</p>

		<?php if ( 'compact' === $args['variant'] ) : ?>
			<p class="vb-author-box__meta">
				<?php
				printf(
					/* translators: 1: published date, 2: reading time */
					esc_html__( 'Published %1$s · %2$d min read', 'visitbest' ),
					esc_html( get_the_date() ),
					(int) Visitbest_Components::get_reading_time()
				);
				?>
			</p>
		<?php else : ?>
			<?php if ( ! empty( $description ) ) : ?>
				<p class="vb-author-box__bio">
					<?php echo esc_html( $description ); ?>
				</p>
			<?php endif; ?>

			<a class="vb-btn vb-btn--ghost vb-btn--sm" href="<?php echo esc_url( $posts_url ); ?>">
				<?php esc_html_e( 'View all posts', 'visitbest' ); ?>
			</a>
		<?php endif; ?>
	</div>
</section>
