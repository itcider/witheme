<?php
/**
 * The template for displaying Archive pages.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div <?php wi_do_attr( 'content' ); ?>>
		<main <?php wi_do_attr( 'main' ); ?>>
			<?php
			/**
			 * wi_before_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'wi_before_main_content' );

			if ( wi_has_default_loop() ) {
				if ( have_posts() ) :

					/**
					 * wi_archive_title hook.
					 *
					 * @since 0.1
					 *
					 * @hooked wi_archive_title - 10
					 */
					do_action( 'wi_archive_title' );

					/**
					 * wi_before_loop hook.
					 *
					 * @since 3.1.0
					 */
					do_action( 'wi_before_loop', 'archive' );

					while ( have_posts() ) :

						the_post();

						wi_do_template_part( 'archive' );

					endwhile;

					/**
					 * wi_after_loop hook.
					 *
					 * @since 2.3
					 */
					do_action( 'wi_after_loop', 'archive' );

				else :

					wi_do_template_part( 'none' );

				endif;
			}

			/**
			 * wi_after_main_content hook.
			 *
			 * @since 0.1
			 */
			do_action( 'wi_after_main_content' );
			?>
		</main>
	</div>

	<?php
	/**
	 * wi_after_primary_content_area hook.
	 *
	 * @since 2.0
	 */
	do_action( 'wi_after_primary_content_area' );

	wi_construct_sidebars();

	get_footer();
