<?php
/**
 * Affiliate Product Card component.
 *
 * @package Visitbest
 *
 * @var array $args {
 *     @type string $title       Product title.
 *     @type string $url         Affiliate URL.
 *     @type string $image_url   Product image URL.
 *     @type string $image_alt   Product image alt text.
 *     @type string $meta        Price or rating line.
 *     @type string $button_text CTA label. Default "Check Price on Amazon".
 *     @type string $class       Additional CSS classes.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args ?? array(),
	array(
		'title'       => '',
		'url'         => '',
		'image_url'   => '',
		'image_alt'   => '',
		'meta'        => '',
		'button_text' => __( 'Check Price on Amazon', 'visitbest' ),
		'class'       => '',
	)
);

if ( empty( $args['title'] ) || empty( $args['url'] ) ) {
	return;
}

$classes = trim( 'vb-affiliate-card ' . $args['class'] );
?>

<aside class="<?php echo esc_attr( $classes ); ?>">
	<?php if ( ! empty( $args['image_url'] ) ) : ?>
		<div class="vb-affiliate-card__media">
			<img
				class="vb-affiliate-card__image"
				src="<?php echo esc_url( $args['image_url'] ); ?>"
				alt="<?php echo esc_attr( $args['image_alt'] ?: $args['title'] ); ?>"
				loading="lazy"
				decoding="async"
				width="400"
				height="400"
			/>
		</div>
	<?php endif; ?>

	<div class="vb-affiliate-card__content">
		<h3 class="vb-affiliate-card__title">
			<?php echo esc_html( $args['title'] ); ?>
		</h3>

		<?php if ( ! empty( $args['meta'] ) ) : ?>
			<p class="vb-affiliate-card__meta">
				<?php echo esc_html( $args['meta'] ); ?>
			</p>
		<?php endif; ?>

		<a
			class="vb-btn vb-btn--cta vb-btn--block"
			href="<?php echo esc_url( $args['url'] ); ?>"
			target="_blank"
			rel="nofollow sponsored noopener"
		>
			<?php echo esc_html( $args['button_text'] ); ?>
		</a>

		<p class="vb-affiliate-card__disclosure">
			<?php esc_html_e( 'As an Amazon Associate, we earn from qualifying purchases.', 'visitbest' ); ?>
		</p>
	</div>
</aside>
