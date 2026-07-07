<?php
/**
 * Site header.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<header class="vb-header" id="vb-site-header" role="banner">
	<div class="vb-header__inner vb-container">
		<div class="vb-header__brand">
			<?php if ( has_custom_logo() ) : ?>
				<div class="vb-header__logo">
					<?php the_custom_logo(); ?>
				</div>
			<?php else : ?>
				<a class="vb-header__title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<span class="vb-header__title-text"><?php bloginfo( 'name' ); ?></span>
					<?php if ( get_bloginfo( 'description' ) ) : ?>
						<span class="vb-header__tagline"><?php bloginfo( 'description' ); ?></span>
					<?php endif; ?>
				</a>
			<?php endif; ?>
		</div>

		<nav class="vb-header__nav" id="vb-primary-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'visitbest' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'vb-header__menu',
					'fallback_cb'    => array( 'Visitbest_Header', 'fallback_menu' ),
					'depth'          => 2,
				)
			);
			?>
		</nav>

		<div class="vb-header__actions">
			<button
				type="button"
				class="vb-header__search-toggle"
				id="vb-search-toggle"
				aria-expanded="false"
				aria-controls="vb-header-search"
				aria-label="<?php esc_attr_e( 'Open search', 'visitbest' ); ?>"
			>
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
					<circle cx="11" cy="11" r="8"></circle>
					<path d="m21 21-4.3-4.3"></path>
				</svg>
			</button>

			<button
				type="button"
				class="vb-header__menu-toggle"
				id="vb-menu-toggle"
				aria-expanded="false"
				aria-controls="vb-primary-nav"
				aria-label="<?php esc_attr_e( 'Open menu', 'visitbest' ); ?>"
			>
				<span class="vb-header__menu-bar" aria-hidden="true"></span>
				<span class="vb-header__menu-bar" aria-hidden="true"></span>
				<span class="vb-header__menu-bar" aria-hidden="true"></span>
			</button>
		</div>
	</div>

	<div class="vb-header__search" id="vb-header-search" hidden>
		<div class="vb-container">
			<?php get_search_form(); ?>
		</div>
	</div>
</header>
