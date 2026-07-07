<?php
/**
 * Section Heading component.
 *
 * @package Visitbest
 *
 * @var array $args {
 *     @type string $eyebrow      Optional eyebrow text.
 *     @type string $title        Section title.
 *     @type string $description  Optional description.
 *     @type string $action_label Optional action link label.
 *     @type string $action_url   Optional action link URL.
 *     @type string $class        Additional CSS classes.
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = wp_parse_args(
	$args ?? array(),
	array(
		'eyebrow'      => '',
		'title'        => '',
		'description'  => '',
		'action_label' => '',
		'action_url'   => '',
		'class'        => '',
	)
);

if ( empty( $args['title'] ) ) {
	return;
}

$classes = trim( 'vb-section-heading ' . $args['class'] );
?>

<header class="<?php echo esc_attr( $classes ); ?>">
	<div class="vb-section-heading__content">
		<?php if ( ! empty( $args['eyebrow'] ) ) : ?>
			<p class="vb-section-heading__eyebrow vb-meta">
				<?php echo esc_html( $args['eyebrow'] ); ?>
			</p>
		<?php endif; ?>

		<h2 class="vb-section-heading__title vb-heading-2">
			<?php echo esc_html( $args['title'] ); ?>
		</h2>

		<?php if ( ! empty( $args['description'] ) ) : ?>
			<p class="vb-section-heading__description">
				<?php echo esc_html( $args['description'] ); ?>
			</p>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $args['action_label'] ) && ! empty( $args['action_url'] ) ) : ?>
		<div class="vb-section-heading__action">
			<a class="vb-btn vb-btn--ghost" href="<?php echo esc_url( $args['action_url'] ); ?>">
				<?php echo esc_html( $args['action_label'] ); ?>
			</a>
		</div>
	<?php endif; ?>
</header>
