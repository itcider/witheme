<?php
/**
 * The template for displaying 404 pages (Not Found).
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

			wi_do_template_part( '404' );

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
