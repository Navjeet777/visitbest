<?php
/**
 * Homepage newsletter CTA placeholder.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<section class="vb-home-newsletter vb-section" aria-labelledby="vb-newsletter-heading">
	<div class="vb-container">
		<?php
		Visitbest_Components::cta_block(
			array(
				'eyebrow'     => __( 'Newsletter', 'visitbest' ),
				'title'       => __( 'Get the best guides in your inbox', 'visitbest' ),
				'text'        => __( 'A weekly roundup of India\'s best brands, products, and companies. No spam — unsubscribe anytime.', 'visitbest' ),
				'button_text' => __( 'Coming soon', 'visitbest' ),
				'button_url'  => '#vb-newsletter',
				'title_id'    => 'vb-newsletter-heading',
				'class'       => 'vb-home-newsletter__cta',
			)
		);
		?>

		<form class="vb-home-newsletter__form vb-search-form" action="#" method="post" aria-label="<?php esc_attr_e( 'Newsletter signup', 'visitbest' ); ?>">
			<label class="screen-reader-text" for="vb-home-newsletter-email"><?php esc_html_e( 'Email address', 'visitbest' ); ?></label>
			<input class="vb-input" type="email" id="vb-home-newsletter-email" name="email" placeholder="<?php esc_attr_e( 'Enter your email', 'visitbest' ); ?>" disabled>
			<button class="vb-btn vb-btn--primary" type="button" disabled><?php esc_html_e( 'Subscribe', 'visitbest' ); ?></button>
		</form>
	</div>
</section>
