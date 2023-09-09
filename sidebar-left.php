<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div <?php wi_do_attr( 'left-sidebar' ); ?>>
	<div class="inside-left-sidebar">
		<?php
		/**
		 * wi_before_left_sidebar_content hook.
		 *
		 * @since 0.1
		 */
		do_action( 'wi_before_left_sidebar_content' );

		if ( ! dynamic_sidebar( 'sidebar-2' ) ) {
			wi_do_default_sidebar_widgets( 'left-sidebar' );
		}

		/**
		 * wi_after_left_sidebar_content hook.
		 *
		 * @since 0.1
		 */
		do_action( 'wi_after_left_sidebar_content' );
		?>
	</div>
</div>
