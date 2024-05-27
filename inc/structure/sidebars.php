<?php
/**
 * Build the sidebars.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'wi_construct_sidebars' ) ) {
	/**
	 * Construct the sidebars.
	 *
	 * @since 0.1
	 */
	function wi_construct_sidebars() {
		$layout = wi_get_layout();

		// When to show the right sidebar.
		$rs = array( 'right-sidebar', 'both-sidebars', 'both-right', 'both-left' );

		// When to show the left sidebar.
		$ls = array( 'left-sidebar', 'both-sidebars', 'both-right', 'both-left' );

		// If left sidebar, show it.
		if ( in_array( $layout, $ls ) ) {
			get_sidebar( 'left' );
		}

		// If right sidebar, show it.
		if ( in_array( $layout, $rs ) ) {
			get_sidebar();
		}
	}

	/**
	 * The below hook was removed in 2.0, but we'll keep the call here so child themes
	 * don't lose their sidebar when they update the theme.
	 */
	add_action( 'wi_sidebars', 'wi_construct_sidebars' );
}

/**
 * Show sidebar widgets if no widgets are added to the sidebar area.
 *
 * @since 2.2
 *
 * @param string $area Left or right sidebar.
 */
function wi_do_default_sidebar_widgets( $area ) {
	if ( 'nav-' . $area === wi_get_navigation_location() ) { // phpcs:ignore -- False positive.
		return;
	}

	if ( function_exists( 'wi_secondary_nav_get_defaults' ) ) {
		$secondary_nav = wp_parse_args(
			get_option( 'wi_secondary_nav_settings', array() ),
			wi_secondary_nav_get_defaults()
		);

		if ( 'secondary-nav-' . $area === $secondary_nav['secondary_nav_position_setting'] ) {
			return;
		}
	}

	if ( ! apply_filters( 'wi_show_default_sidebar_widgets', true ) || wi_is_using_flexbox() ) {
		return;
	}
	?>
	<aside id="search" class="widget widget_search">
		<?php get_search_form(); ?>
	</aside>

	<aside id="archives" class="widget">
		<h2 class="widget-title"><?php esc_html_e( 'Archives', 'witheme' ); ?></h2>
		<ul>
			<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
		</ul>
	</aside>
	<?php
}
