<?php
/**
 * Social share buttons (link-based, no JS).
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

$url   = rawurlencode( get_permalink() );
$title = rawurlencode( html_entity_decode( get_the_title(), ENT_QUOTES, 'UTF-8' ) );
$classes = trim( 'vb-share ' . $args['class'] );

$networks = array(
	'whatsapp' => array(
		'label' => __( 'Share on WhatsApp', 'visitbest' ),
		'url'   => 'https://wa.me/?text=' . $title . '%20' . $url,
		'icon'  => 'WA',
	),
	'x'        => array(
		'label' => __( 'Share on X', 'visitbest' ),
		'url'   => 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title,
		'icon'  => 'X',
	),
	'facebook' => array(
		'label' => __( 'Share on Facebook', 'visitbest' ),
		'url'   => 'https://www.facebook.com/sharer/sharer.php?u=' . $url,
		'icon'  => 'f',
	),
	'linkedin' => array(
		'label' => __( 'Share on LinkedIn', 'visitbest' ),
		'url'   => 'https://www.linkedin.com/sharing/share-offsite/?url=' . $url,
		'icon'  => 'in',
	),
);
?>

<div class="<?php echo esc_attr( $classes ); ?>" role="group" aria-label="<?php esc_attr_e( 'Share this article', 'visitbest' ); ?>">
	<?php foreach ( $networks as $key => $network ) : ?>
		<a
			class="vb-share__button vb-share__button--<?php echo esc_attr( $key ); ?>"
			href="<?php echo esc_url( $network['url'] ); ?>"
			target="_blank"
			rel="noopener noreferrer"
			aria-label="<?php echo esc_attr( $network['label'] ); ?>"
		>
			<span aria-hidden="true"><?php echo esc_html( $network['icon'] ); ?></span>
		</a>
	<?php endforeach; ?>
</div>
