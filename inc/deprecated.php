<?php
/**
 * Where old functions retire.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Deprecated constants.
define( 'wi_URI', get_template_directory_uri() );
define( 'wi_DIR', get_template_directory() );

if ( ! function_exists( 'wi_paging_nav' ) ) {
	/**
	 * Build the pagination links
	 *
	 * @since 1.3.35
	 * @deprecated 1.3.45
	 */
	function wi_paging_nav() {
		_deprecated_function( __FUNCTION__, '1.3.45', 'the_posts_navigation()' );

		if ( function_exists( 'the_posts_pagination' ) ) {
			the_posts_pagination(
				array(
					'mid_size' => apply_filters( 'wi_pagination_mid_size', 1 ),
					'prev_text' => __( '&larr; Previous', 'witheme' ),
					'next_text' => __( 'Next &rarr;', 'witheme' ),
				)
			);
		}
	}
}

if ( ! function_exists( 'wi_additional_spacing' ) ) {
	/**
	 * Add fallback CSS for our mobile search icon color
	 *
	 * @deprecated 1.3.47
	 */
	function wi_additional_spacing() {
		// No longer needed.
	}
}

if ( ! function_exists( 'wi_mobile_search_spacing_fallback_css' ) ) {
	/**
	 * Enqueue our mobile search icon color fallback CSS
	 *
	 * @deprecated 1.3.47
	 */
	function wi_mobile_search_spacing_fallback_css() {
		// No longer needed.
	}
}

if ( ! function_exists( 'wi_addons_available' ) ) {
	/**
	 * Check to see if there's any addons not already activated
	 *
	 * @since 1.0.9
	 * @deprecated 1.3.47
	 */
	function wi_addons_available() {
		if ( defined( 'GP_PREMIUM_VERSION' ) ) {
			return false;
		}
	}
}

if ( ! function_exists( 'wi_no_addons' ) ) {
	/**
	 * Check to see if no addons are activated
	 *
	 * @since 1.0.9
	 * @deprecated 1.3.47
	 */
	function wi_no_addons() {
		if ( defined( 'GP_PREMIUM_VERSION' ) ) {
			return false;
		}
	}
}

if ( ! function_exists( 'wi_get_min_suffix' ) ) {
	/**
	 * Figure out if we should use minified scripts or not
	 *
	 * @since 1.3.29
	 * @deprecated 2.0
	 */
	function wi_get_min_suffix() {
		return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	}
}

if ( ! function_exists( 'wi_add_layout_meta_box' ) ) {
	/**
	 * Add layout metabox.
	 *
	 * @since 0.1
	 * @deprecated 2.0
	 */
	function wi_add_layout_meta_box() {
		_deprecated_function( __FUNCTION__, '2.0', 'wi_register_layout_meta_box()' );
	}
}

if ( ! function_exists( 'wi_show_layout_meta_box' ) ) {
	/**
	 * Show layout metabox.
	 *
	 * @since 0.1
	 * @deprecated 2.0
	 */
	function wi_show_layout_meta_box() {
		_deprecated_function( __FUNCTION__, '2.0', 'wi_do_layout_meta_box()' );
	}
}

if ( ! function_exists( 'wi_save_layout_meta' ) ) {
	/**
	 * Save layout metabox.
	 *
	 * @since 0.1
	 * @deprecated 2.0
	 */
	function wi_save_layout_meta() {
		_deprecated_function( __FUNCTION__, '2.0', 'wi_save_layout_meta_data()' );
	}
}

if ( ! function_exists( 'wi_add_footer_widget_meta_box' ) ) {
	/**
	 * Add footer widget metabox.
	 *
	 * @since 0.1
	 * @deprecated 2.0
	 */
	function wi_add_footer_widget_meta_box() {
		_deprecated_function( __FUNCTION__, '2.0', 'wi_register_layout_meta_box()' );
	}
}

if ( ! function_exists( 'wi_show_footer_widget_meta_box' ) ) {
	/**
	 * Show footer widget metabox.
	 *
	 * @since 0.1
	 * @deprecated 2.0
	 */
	function wi_show_footer_widget_meta_box() {
		_deprecated_function( __FUNCTION__, '2.0', 'wi_do_layout_meta_box()' );
	}
}

if ( ! function_exists( 'wi_save_footer_widget_meta' ) ) {
	/**
	 * Save footer widget metabox.
	 *
	 * @since 0.1
	 * @deprecated 2.0
	 */
	function wi_save_footer_widget_meta() {
		_deprecated_function( __FUNCTION__, '2.0', 'wi_save_layout_meta_data()' );
	}
}

if ( ! function_exists( 'wi_add_page_builder_meta_box' ) ) {
	/**
	 * Add page builder metabox.
	 *
	 * @since 0.1
	 * @deprecated 2.0
	 */
	function wi_add_page_builder_meta_box() {
		_deprecated_function( __FUNCTION__, '2.0', 'wi_register_layout_meta_box()' );
	}
}

if ( ! function_exists( 'wi_show_page_builder_meta_box' ) ) {
	/**
	 * Show page builder metabox.
	 *
	 * @since 0.1
	 * @deprecated 2.0
	 */
	function wi_show_page_builder_meta_box() {
		_deprecated_function( __FUNCTION__, '2.0', 'wi_do_layout_meta_box()' );
	}
}

if ( ! function_exists( 'wi_save_page_builder_meta' ) ) {
	/**
	 * Save page builder metabox.
	 *
	 * @since 0.1
	 * @deprecated 2.0
	 */
	function wi_save_page_builder_meta() {
		_deprecated_function( __FUNCTION__, '2.0', 'wi_save_layout_meta_data()' );
	}
}

if ( ! function_exists( 'wi_add_de_meta_box' ) ) {
	/**
	 * Add disable elements metabox.
	 *
	 * @since 0.1
	 * @deprecated 2.0
	 */
	function wi_add_de_meta_box() {
		_deprecated_function( __FUNCTION__, '2.0', 'wi_register_layout_meta_box()' );
	}
}

if ( ! function_exists( 'wi_show_de_meta_box' ) ) {
	/**
	 * Show disable elements metabox.
	 *
	 * @since 0.1
	 * @deprecated 2.0
	 */
	function wi_show_de_meta_box() {
		_deprecated_function( __FUNCTION__, '2.0', 'wi_do_layout_meta_box()' );
	}
}

if ( ! function_exists( 'wi_save_de_meta' ) ) {
	/**
	 * Save disable elements metabox.
	 *
	 * @since 0.1
	 * @deprecated 2.0
	 */
	function wi_save_de_meta() {
		_deprecated_function( __FUNCTION__, '2.0', 'wi_save_layout_meta_data()' );
	}
}

if ( ! function_exists( 'wi_add_base_inline_css' ) ) {
	/**
	 * Add base inline CSS.
	 *
	 * @since 0.1
	 * @deprecated 2.0
	 */
	function wi_add_base_inline_css() {
		_deprecated_function( __FUNCTION__, '2.0', 'wi_enqueue_dynamic_css()' );
	}
}

if ( ! function_exists( 'wi_color_scripts' ) ) {
	/**
	 * Enqueue base colors inline CSS.
	 *
	 * @since 0.1
	 * @deprecated 2.0
	 */
	function wi_color_scripts() {
		_deprecated_function( __FUNCTION__, '2.0', 'wi_enqueue_dynamic_css()' );
	}
}

if ( ! function_exists( 'wi_typography_scripts' ) ) {
	/**
	 * Enqueue typography CSS.
	 *
	 * @since 0.1
	 * @deprecated 2.0
	 */
	function wi_typography_scripts() {
		_deprecated_function( __FUNCTION__, '2.0', 'wi_enqueue_dynamic_css()' );
	}
}

if ( ! function_exists( 'wi_spacing_scripts' ) ) {
	/**
	 * Enqueue spacing CSS.
	 *
	 * @since 0.1
	 * @deprecated 2.0
	 */
	function wi_spacing_scripts() {
		_deprecated_function( __FUNCTION__, '2.0', 'wi_enqueue_dynamic_css()' );
	}
}

if ( ! function_exists( 'wi_get_setting' ) ) {
	/**
	 * A wrapper function to get our settings.
	 *
	 * @since 1.3.40
	 *
	 * @param string $setting The option name to look up.
	 * @return string The option value.
	 * @todo Ability to specify different option name and defaults.
	 */
	function wi_get_setting( $setting ) {
		return wi_get_option( $setting );
	}
}
if ( ! function_exists( 'wi_right_sidebar_class' ) ) {
	/**
	 * Display the classes for the sidebar.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function wi_right_sidebar_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV.
		echo 'class="' . join( ' ', wi_get_right_sidebar_class( $class ) ) . '"'; // phpcs:ignore
	}
}

if ( ! function_exists( 'wi_get_right_sidebar_class' ) ) {
	/**
	 * Retrieve the classes for the sidebar.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function wi_get_right_sidebar_class( $class = '' ) {

		$classes = array();

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}

			$classes = array_merge( $classes, $class );
		}

		$classes = array_map( 'esc_attr', $classes );

		return apply_filters( 'wi_right_sidebar_class', $classes, $class );
	}
}

if ( ! function_exists( 'wi_left_sidebar_class' ) ) {
	/**
	 * Display the classes for the sidebar.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function wi_left_sidebar_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV.
		echo 'class="' . join( ' ', wi_get_left_sidebar_class( $class ) ) . '"'; // phpcs:ignore
	}
}

if ( ! function_exists( 'wi_get_left_sidebar_class' ) ) {
	/**
	 * Retrieve the classes for the sidebar.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function wi_get_left_sidebar_class( $class = '' ) {

		$classes = array();

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}

			$classes = array_merge( $classes, $class );
		}

		$classes = array_map( 'esc_attr', $classes );

		return apply_filters( 'wi_left_sidebar_class', $classes, $class );
	}
}

if ( ! function_exists( 'wi_content_class' ) ) {
	/**
	 * Display the classes for the content.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function wi_content_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV.
		echo 'class="' . join( ' ', wi_get_content_class( $class ) ) . '"'; // phpcs:ignore
	}
}

if ( ! function_exists( 'wi_get_content_class' ) ) {
	/**
	 * Retrieve the classes for the content.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function wi_get_content_class( $class = '' ) {

		$classes = array();

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}

			$classes = array_merge( $classes, $class );
		}

		$classes = array_map( 'esc_attr', $classes );

		return apply_filters( 'wi_content_class', $classes, $class );
	}
}

if ( ! function_exists( 'wi_header_class' ) ) {
	/**
	 * Display the classes for the header.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function wi_header_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV.
		echo 'class="' . join( ' ', wi_get_header_class( $class ) ) . '"'; // phpcs:ignore
	}
}

if ( ! function_exists( 'wi_get_header_class' ) ) {
	/**
	 * Retrieve the classes for the content.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function wi_get_header_class( $class = '' ) {

		$classes = array();

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}

			$classes = array_merge( $classes, $class );
		}

		$classes = array_map( 'esc_attr', $classes );

		return apply_filters( 'wi_header_class', $classes, $class );
	}
}

if ( ! function_exists( 'wi_inside_header_class' ) ) {
	/**
	 * Display the classes for inside the header.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function wi_inside_header_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV.
		echo 'class="' . join( ' ', wi_get_inside_header_class( $class ) ) . '"'; // phpcs:ignore
	}
}

if ( ! function_exists( 'wi_get_inside_header_class' ) ) {
	/**
	 * Retrieve the classes for inside the header.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function wi_get_inside_header_class( $class = '' ) {

		$classes = array();

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}

			$classes = array_merge( $classes, $class );
		}

		$classes = array_map( 'esc_attr', $classes );

		return apply_filters( 'wi_inside_header_class', $classes, $class );
	}
}

if ( ! function_exists( 'wi_container_class' ) ) {
	/**
	 * Display the classes for the container.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function wi_container_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV.
		echo 'class="' . join( ' ', wi_get_container_class( $class ) ) . '"'; // phpcs:ignore
	}
}

if ( ! function_exists( 'wi_get_container_class' ) ) {
	/**
	 * Retrieve the classes for the content.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function wi_get_container_class( $class = '' ) {

		$classes = array();

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}

			$classes = array_merge( $classes, $class );
		}

		$classes = array_map( 'esc_attr', $classes );

		return apply_filters( 'wi_container_class', $classes, $class );
	}
}

if ( ! function_exists( 'wi_navigation_class' ) ) {
	/**
	 * Display the classes for the navigation.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function wi_navigation_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV.
		echo 'class="' . join( ' ', wi_get_navigation_class( $class ) ) . '"'; // phpcs:ignore
	}
}

if ( ! function_exists( 'wi_get_navigation_class' ) ) {
	/**
	 * Retrieve the classes for the navigation.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function wi_get_navigation_class( $class = '' ) {

		$classes = array();

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}

			$classes = array_merge( $classes, $class );
		}

		$classes = array_map( 'esc_attr', $classes );

		return apply_filters( 'wi_navigation_class', $classes, $class );
	}
}

if ( ! function_exists( 'wi_inside_navigation_class' ) ) {
	/**
	 * Display the classes for the inner navigation.
	 *
	 * @since 1.3.41
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function wi_inside_navigation_class( $class = '' ) {
		$classes = array();

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}

			$classes = array_merge( $classes, $class );
		}

		$classes = array_map( 'esc_attr', $classes );

		$return = apply_filters( 'wi_inside_navigation_class', $classes, $class );

		// Separates classes with a single space, collates classes for post DIV.
		echo 'class="' . join( ' ', $return ) . '"'; // phpcs:ignore
	}
}

if ( ! function_exists( 'wi_menu_class' ) ) {
	/**
	 * Display the classes for the navigation.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function wi_menu_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV.
		echo 'class="' . join( ' ', wi_get_menu_class( $class ) ) . '"'; // phpcs:ignore
	}
}

if ( ! function_exists( 'wi_get_menu_class' ) ) {
	/**
	 * Retrieve the classes for the navigation.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function wi_get_menu_class( $class = '' ) {

		$classes = array();

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}

			$classes = array_merge( $classes, $class );
		}

		$classes = array_map( 'esc_attr', $classes );

		return apply_filters( 'wi_menu_class', $classes, $class );
	}
}

if ( ! function_exists( 'wi_main_class' ) ) {
	/**
	 * Display the classes for the <main> container.
	 *
	 * @since 1.1.0
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function wi_main_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV.
		echo 'class="' . join( ' ', wi_get_main_class( $class ) ) . '"'; // phpcs:ignore
	}
}

if ( ! function_exists( 'wi_get_main_class' ) ) {
	/**
	 * Retrieve the classes for the footer.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function wi_get_main_class( $class = '' ) {

		$classes = array();

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}

			$classes = array_merge( $classes, $class );
		}

		$classes = array_map( 'esc_attr', $classes );

		return apply_filters( 'wi_main_class', $classes, $class );
	}
}

if ( ! function_exists( 'wi_footer_class' ) ) {
	/**
	 * Display the classes for the footer.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function wi_footer_class( $class = '' ) {
		// Separates classes with a single space, collates classes for post DIV.
		echo 'class="' . join( ' ', wi_get_footer_class( $class ) ) . '"'; // phpcs:ignore
	}
}

if ( ! function_exists( 'wi_get_footer_class' ) ) {
	/**
	 * Retrieve the classes for the footer.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function wi_get_footer_class( $class = '' ) {

		$classes = array();

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}

			$classes = array_merge( $classes, $class );
		}

		$classes = array_map( 'esc_attr', $classes );

		return apply_filters( 'wi_footer_class', $classes, $class );
	}
}

if ( ! function_exists( 'wi_inside_footer_class' ) ) {
	/**
	 * Display the classes for the footer.
	 *
	 * @since 0.1
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function wi_inside_footer_class( $class = '' ) {
		$classes = array();

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}

			$classes = array_merge( $classes, $class );
		}

		$classes = array_map( 'esc_attr', $classes );

		$return = apply_filters( 'wi_inside_footer_class', $classes, $class );

		// Separates classes with a single space, collates classes for post DIV.
		echo 'class="' . join( ' ', $return ) . '"'; // phpcs:ignore
	}
}

if ( ! function_exists( 'wi_top_bar_class' ) ) {
	/**
	 * Display the classes for the top bar.
	 *
	 * @since 1.3.45
	 * @param string|array $class One or more classes to add to the class list.
	 */
	function wi_top_bar_class( $class = '' ) {
		$classes = array();

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}

			$classes = array_merge( $classes, $class );
		}

		$classes = array_map( 'esc_attr', $classes );

		$return = apply_filters( 'wi_top_bar_class', $classes, $class );

		// Separates classes with a single space, collates classes for post DIV.
		echo 'class="' . join( ' ', $return ) . '"'; // phpcs:ignore
	}
}

if ( ! function_exists( 'wi_body_schema' ) ) {
	/**
	 * Figure out which schema tags to apply to the <body> element.
	 *
	 * @since 1.3.15
	 */
	function wi_body_schema() {
		// Set up blog variable.
		$blog = ( is_home() || is_archive() || is_attachment() || is_tax() || is_single() ) ? true : false;

		// Set up default itemtype.
		$itemtype = 'WebPage';

		// Get itemtype for the blog.
		$itemtype = ( $blog ) ? 'Blog' : $itemtype;

		// Get itemtype for search results.
		$itemtype = ( is_search() ) ? 'SearchResultsPage' : $itemtype;

		// Get the result.
		$result = esc_html( apply_filters( 'wi_body_itemtype', $itemtype ) );

		// Return our HTML.
		echo "itemtype='https://schema.org/$result' itemscope='itemscope'"; // phpcs:ignore
	}
}

if ( ! function_exists( 'wi_article_schema' ) ) {
	/**
	 * Figure out which schema tags to apply to the <article> element
	 * The function determines the itemtype: wi_article_schema( 'BlogPosting' )
	 *
	 * @since 1.3.15
	 * @param string $type The type of schema.
	 */
	function wi_article_schema( $type = 'CreativeWork' ) {
		// Get the itemtype.
		$itemtype = esc_html( apply_filters( 'wi_article_itemtype', $type ) );

		// Print the results.
		echo "itemtype='https://schema.org/$itemtype' itemscope='itemscope'"; // phpcs:ignore
	}
}

/**
 * Process database updates if necessary.
 * There's nothing in here yet, but we're setting the version to use later.
 *
 * @since 2.1
 * @deprecated 3.0.0
 */
function wi_do_admin_db_updates() {
	// Replaced by wi_Theme_Update().
}

/**
 * Process important database updates when someone visits the front or backend.
 *
 * @since 2.3
 * @deprecated 3.0.0
 */
function wi_do_db_updates() {
	// Replaced by wi_Theme_Update().
}

if ( ! function_exists( 'wi_update_logo_setting' ) ) {
	/**
	 * Migrate the old logo database entry to the new custom_logo theme mod (WordPress 4.5)
	 *
	 * @since 1.3.29
	 * @deprecated 3.0.0
	 */
	function wi_update_logo_setting() {
		// Replaced by wi_Theme_Update().
	}
}

if ( ! function_exists( 'wi_typography_convert_values' ) ) {
	/**
	 * Take the old body font value and strip it of variants
	 * This should only run once
	 *
	 * @since 3.3.2
	 * @deprecated 3.0.0
	 */
	function wi_typography_convert_values() {
		// Replaced by wi_Theme_Update().
	}
}

/**
 * Execute functions after existing sites update.
 *
 * We check to see if options already exist. If they do, we can assume the user has
 * updated the theme, and not installed it from scratch.
 *
 * We run this right away in the Dashboard to avoid other migration functions from
 * setting options and causing these functions to run on fresh installs.
 *
 * @since 2.0
 * @deprecated 3.0.0
 */
function wi_migrate_existing_settings() {
	// Replaced by wi_Theme_Update().
}

/**
 * Output CSS for the icon fonts.
 *
 * @since 2.3
 * @deprecated 3.0.0
 */
function wi_do_icon_css() {
	$output = false;

	if ( 'font' === wi_get_option( 'icons' ) ) {
		$url = trailingslashit( get_template_directory_uri() );

		if ( defined( 'wi_MENU_PLUS_VERSION' ) ) {
			$output .= '.main-navigation .slideout-toggle a:before,
			.slide-opened .slideout-overlay .slideout-exit:before {
				font-family: witheme;
			}

			.slideout-navigation .dropdown-menu-toggle:before {
				content: "\f107" !important;
			}

			.slideout-navigation .sfHover > a .dropdown-menu-toggle:before {
				content: "\f106" !important;
			}';
		}
	}

	if ( $output ) {
		return str_replace( array( "\r", "\n", "\t" ), '', $output );
	}
}
