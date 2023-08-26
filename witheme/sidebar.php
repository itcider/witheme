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
<div <?php wi_do_attr( 'right-sidebar' ); ?>>
	<div class="inside-right-sidebar">
		<?php
		/**
		 * wi_before_right_sidebar_content hook.
		 *
		 * @since 0.1
		 */
		do_action( 'wi_before_right_sidebar_content' );

		if ( ! dynamic_sidebar( 'sidebar-1' ) ) {
			wi_do_default_sidebar_widgets( 'right-sidebar' );
		}

		/**
		 * wi_after_right_sidebar_content hook.
		 *
		 * @since 0.1
		 */
		do_action( 'wi_after_right_sidebar_content' );
		?>
	</div>
</div>
