<?php
/**
 * The template for displaying posts within the loop.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php wi_do_microdata( 'article' ); ?>>
	<div class="inside-article">
		<?php
		/**
		 * wi_before_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked wi_featured_page_header_inside_single - 10
		 */
		do_action( 'wi_before_content' );

		if ( wi_show_entry_header() ) :
			?>
			<header <?php wi_do_attr( 'entry-header' ); ?>>
				<?php
				/**
				 * wi_before_entry_title hook.
				 *
				 * @since 0.1
				 */
				do_action( 'wi_before_entry_title' );

				if ( wi_show_title() ) {
					$params = wi_get_the_title_parameters();

					the_title( $params['before'], $params['after'] );
				}

				/**
				 * wi_after_entry_title hook.
				 *
				 * @since 0.1
				 *
				 * @hooked wi_post_meta - 10
				 */
				do_action( 'wi_after_entry_title' );
				?>
			</header>
			<?php
		endif;

		/**
		 * wi_after_entry_header hook.
		 *
		 * @since 0.1
		 *
		 * @hooked wi_post_image - 10
		 */
		do_action( 'wi_after_entry_header' );

		$itemprop = '';

		if ( 'microdata' === wi_get_schema_type() ) {
			$itemprop = ' itemprop="text"';
		}

		if ( wi_show_excerpt() ) :
			?>

			<div class="entry-summary"<?php echo $itemprop; // phpcs:ignore -- No escaping needed. ?>>
				<?php the_excerpt(); ?>
			</div>

		<?php else : ?>

			<div class="entry-content"<?php echo $itemprop; // phpcs:ignore -- No escaping needed. ?>>
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'witheme' ),
						'after'  => '</div>',
					)
				);
				?>
			</div>

			<?php
		endif;

		/**
		 * wi_after_entry_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked wi_footer_meta - 10
		 */
		do_action( 'wi_after_entry_content' );

		/**
		 * wi_after_content hook.
		 *
		 * @since 0.1
		 */
		do_action( 'wi_after_content' );
		?>
	</div>
</article>
