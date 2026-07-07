<?php
/**
 * CTA Block component.
 *
 * @package Visitbest
 *
 * @var array $args {
 *     @type string $eyebrow     Optional eyebrow text.
 *     @type string $title       CTA title.
 *     @type string $text        Supporting text.
 *     @type string $button_text Primary button label.
 *     @type string $button_url  Primary button URL.
 *     @type string $variant     Style variant: default|dark. Default default.
 *     @type string $class       Additional CSS classes.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args ?? array(),
	array(
		'eyebrow'     => '',
		'title'       => '',
		'text'        => '',
		'button_text' => '',
		'button_url'  => '',
		'variant'     => 'default',
		'class'       => '',
	)
);

if ( empty( $args['title'] ) ) {
	return;
}

$classes = array( 'vb-cta-block' );

if ( 'dark' === $args['variant'] ) {
	$classes[] = 'vb-cta-block--dark';
}

if ( ! empty( $args['class'] ) ) {
	$classes[] = $args['class'];
}
?>

<section class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php if ( ! empty( $args['eyebrow'] ) ) : ?>
		<p class="vb-cta-block__eyebrow vb-meta">
			<?php echo esc_html( $args['eyebrow'] ); ?>
		</p>
	<?php endif; ?>

	<h2 class="vb-cta-block__title">
		<?php echo esc_html( $args['title'] ); ?>
	</h2>

	<?php if ( ! empty( $args['text'] ) ) : ?>
		<p class="vb-cta-block__text">
			<?php echo esc_html( $args['text'] ); ?>
		</p>
	<?php endif; ?>

	<?php if ( ! empty( $args['button_text'] ) && ! empty( $args['button_url'] ) ) : ?>
		<div class="vb-cta-block__actions">
			<a class="vb-btn vb-btn--primary vb-btn--lg" href="<?php echo esc_url( $args['button_url'] ); ?>">
				<?php echo esc_html( $args['button_text'] ); ?>
			</a>
		</div>
	<?php endif; ?>
</section>
