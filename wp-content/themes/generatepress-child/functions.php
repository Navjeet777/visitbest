<?php
/**
 * Visitbest child theme bootstrap.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'VISITBEST_VERSION', '1.1.0' );
define( 'VISITBEST_DIR', get_stylesheet_directory() );
define( 'VISITBEST_URI', get_stylesheet_directory_uri() );

require VISITBEST_DIR . '/inc/class-theme-setup.php';
require VISITBEST_DIR . '/inc/class-assets.php';
require VISITBEST_DIR . '/inc/class-components.php';
require VISITBEST_DIR . '/inc/class-header.php';
require VISITBEST_DIR . '/inc/class-layout.php';
require VISITBEST_DIR . '/inc/class-homepage.php';
require VISITBEST_DIR . '/inc/integrations/generateblocks.php';
require VISITBEST_DIR . '/inc/patterns/register-patterns.php';
require VISITBEST_DIR . '/inc/templates/earphones.php';

Visitbest_Theme_Setup::init();
Visitbest_Assets::init();
Visitbest_Components::init();
Visitbest_Layout::init();
Visitbest_Homepage::init();
Visitbest_GenerateBlocks::init();
Visitbest_Patterns::init();
Visitbest_Earphones_Template::init();
