<?php
/**
 * Site footer.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$categories = get_categories(
	array(
		'hide_empty' => true,
		'number'     => 6,
	)
);

$contact_url = home_url( '/contact-us/' );
$year        = gmdate( 'Y' );
?>

<footer class="vb-footer" role="contentinfo">
	<div class="vb-footer__cta vb-section">
		<div class="vb-container">
			<?php
			Visitbest_Components::cta_block(
				array(
					'eyebrow'     => __( 'Stay Updated', 'visitbest' ),
					'title'       => __( 'Get the best guides in your inbox', 'visitbest' ),
					'text'        => __( 'Weekly curated lists on brands, products, and companies across India.', 'visitbest' ),
					'button_text' => __( 'Subscribe', 'visitbest' ),
					'button_url'  => '#vb-newsletter',
					'variant'     => 'dark',
					'class'       => 'vb-footer__cta-block',
				)
			);
			?>
		</div>
	</div>

	<div class="vb-footer__main">
		<div class="vb-container vb-footer__grid">
			<div class="vb-footer__column vb-footer__column--about">
				<p class="vb-footer__logo"><?php bloginfo( 'name' ); ?></p>
				<p class="vb-footer__about">
					<?php esc_html_e( 'Explore the best brands, products, and companies in India. Expert-curated guides you can trust.', 'visitbest' ); ?>
				</p>
			</div>

			<div class="vb-footer__column">
				<h2 class="vb-footer__heading"><?php esc_html_e( 'Categories', 'visitbest' ); ?></h2>
				<ul class="vb-footer__links">
					<?php foreach ( $categories as $category ) : ?>
						<li>
							<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
								<?php echo esc_html( $category->name ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<div class="vb-footer__column">
				<h2 class="vb-footer__heading"><?php esc_html_e( 'Quick Links', 'visitbest' ); ?></h2>
				<ul class="vb-footer__links">
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'visitbest' ); ?></a></li>
					<li><a href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Contact', 'visitbest' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'visitbest' ); ?></a></li>
				</ul>
			</div>

			<div class="vb-footer__column">
				<h2 class="vb-footer__heading"><?php esc_html_e( 'Contact', 'visitbest' ); ?></h2>
				<ul class="vb-footer__links">
					<li>
						<a href="mailto:visitbest10@gmail.com">visitbest10@gmail.com</a>
					</li>
					<li>
						<a href="<?php echo esc_url( $contact_url ); ?>"><?php esc_html_e( 'Contact form', 'visitbest' ); ?></a>
					</li>
				</ul>

				<div class="vb-footer__newsletter" id="vb-newsletter">
					<p class="vb-footer__newsletter-label"><?php esc_html_e( 'Newsletter', 'visitbest' ); ?></p>
					<form class="vb-search-form vb-footer__newsletter-form" action="#" method="post" aria-label="<?php esc_attr_e( 'Newsletter signup', 'visitbest' ); ?>">
						<label class="screen-reader-text" for="vb-newsletter-email"><?php esc_html_e( 'Email address', 'visitbest' ); ?></label>
						<input class="vb-input" type="email" id="vb-newsletter-email" name="email" placeholder="<?php esc_attr_e( 'Your email address', 'visitbest' ); ?>" disabled>
						<button class="vb-btn vb-btn--primary vb-btn--sm" type="button" disabled><?php esc_html_e( 'Coming soon', 'visitbest' ); ?></button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="vb-footer__bar">
		<div class="vb-container vb-footer__bar-inner">
			<p class="vb-footer__copyright">
				<?php
				printf(
					/* translators: %s: current year */
					esc_html__( '© %s Visit-Best. All rights reserved.', 'visitbest' ),
					esc_html( $year )
				);
				?>
			</p>
			<p class="vb-footer__disclosure">
				<?php esc_html_e( 'As an Amazon Associate, we earn from qualifying purchases.', 'visitbest' ); ?>
			</p>
		</div>
	</div>
</footer>
