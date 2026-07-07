<?php
/**
 * Front page template — replaces broken GenerateBlocks page content.
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="vb-homepage-main site-main" role="main">
	<?php Visitbest_Homepage::render(); ?>
</main>

<?php
get_footer();
