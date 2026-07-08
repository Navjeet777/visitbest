<?php
/**
 * Single post article header (above the fold).
 *
 * @package Visitbest
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id   = get_the_ID();
$category  = Visitbest_Components::get_primary_category( $post_id );
$author_id = (int) get_the_author_meta( 'ID' );
?>

<header class="vb-single-header vb-container" aria-labelledby="vb-single-title">
	<?php if ( $category ) : ?>
		<p class="vb-single-header__badge">
			<a class="vb-badge" href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
				<?php echo esc_html( $category->name ); ?>
			</a>
		</p>
	<?php endif; ?>

	<h1 id="vb-single-title" class="vb-single-header__title vb-heading-1">
		<?php the_title(); ?>
	</h1>

	<div class="vb-single-header__meta">
		<div class="vb-single-header__meta-primary">
			<?php if ( $author_id ) : ?>
				<a class="vb-single-header__author" href="<?php echo esc_url( get_author_posts_url( $author_id ) ); ?>">
					<?php echo get_avatar( $author_id, 32, '', '', array( 'class' => 'vb-single-header__avatar' ) ); ?>
					<span><?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?></span>
				</a>
			<?php endif; ?>

			<span class="vb-meta vb-single-header__date">
				<time datetime="<?php echo esc_attr( get_the_modified_date( DATE_W3C ) ); ?>">
					<?php echo Visitbest_Single::get_date_label( $post_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>
				</time>
			</span>

			<span class="vb-meta vb-body-muted vb-single-header__reading-time">
				<?php
				printf(
					/* translators: %d: reading time in minutes */
					esc_html__( '%d min read', 'visitbest' ),
					(int) Visitbest_Components::get_reading_time( $post_id )
				);
				?>
			</span>
		</div>

		<?php Visitbest_Components::share_buttons(); ?>
	</div>

	<div class="vb-single-header__media">
		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="vb-single-header__figure">
				<?php
				echo get_the_post_thumbnail(
					$post_id,
					'visitbest-featured',
					array(
						'class'         => 'vb-single-header__image',
						'loading'       => 'eager',
						'fetchpriority' => 'high',
						'decoding'      => 'async',
						'alt'           => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
				?>
			</figure>
		<?php else : ?>
			<div class="vb-single-header__placeholder" aria-hidden="true"></div>
		<?php endif; ?>
	</div>
</header>
