<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
					 * wi_before_loop hook.
					 *
					 * @since 3.1.0
					 */
					do_action( 'wi_before_loop', 'index' );

					while ( have_posts() ) :

						the_post();

						wi_do_template_part( 'index' );

					endwhile;

					/**
					 * wi_after_loop hook.
					 *
					 * @since 2.3
					 */
					do_action( 'wi_after_loop', 'index' );

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
