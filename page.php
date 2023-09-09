<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
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
				while ( have_posts() ) :

					the_post();

					wi_do_template_part( 'page' );

				endwhile;
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
