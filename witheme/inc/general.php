<?php
/**
 * General functions.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'wi_scripts' ) ) {
	add_action( 'wp_enqueue_scripts', 'wi_scripts' );
	/**
	 * Enqueue scripts and styles
	 */
	function wi_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$dir_uri = get_template_directory_uri();

		if ( wi_is_using_flexbox() ) {
			// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison -- Intentionally loose.
			if ( is_singular() && ( comments_open() || '0' != get_comments_number() ) ) {
				wp_enqueue_style( 'wi-comments', $dir_uri . "/assets/css/components/comments{$suffix}.css", array(), wi_VERSION, 'all' );
			}

			if (
				is_active_sidebar( 'top-bar' ) ||
				is_active_sidebar( 'footer-bar' ) ||
				is_active_sidebar( 'footer-1' ) ||
				is_active_sidebar( 'footer-2' ) ||
				is_active_sidebar( 'footer-3' ) ||
				is_active_sidebar( 'footer-4' ) ||
				is_active_sidebar( 'footer-5' )
			) {
				wp_enqueue_style( 'wi-widget-areas', $dir_uri . "/assets/css/components/widget-areas{$suffix}.css", array(), wi_VERSION, 'all' );
			}

			wp_enqueue_style( 'wi-style', $dir_uri . "/assets/css/main{$suffix}.css", array(), wi_VERSION, 'all' );
		} else {
			if ( wi_get_option( 'combine_css' ) && $suffix ) {
				wp_enqueue_style( 'wi-style', $dir_uri . "/assets/css/all{$suffix}.css", array(), wi_VERSION, 'all' );
			} else {
				wp_enqueue_style( 'wi-style-grid', $dir_uri . "/assets/css/unsemantic-grid{$suffix}.css", false, wi_VERSION, 'all' );
				wp_enqueue_style( 'wi-style', $dir_uri . "/assets/css/style{$suffix}.css", array(), wi_VERSION, 'all' );
				wp_enqueue_style( 'wi-mobile-style', $dir_uri . "/assets/css/mobile{$suffix}.css", array(), wi_VERSION, 'all' );
			}
		}

		if ( 'font' === wi_get_option( 'icons' ) ) {
			wp_enqueue_style( 'wi-font-icons', $dir_uri . "/assets/css/components/font-icons{$suffix}.css", array(), wi_VERSION, 'all' );
		}

		if ( ! apply_filters( 'wi_fontawesome_essentials', false ) ) {
			wp_enqueue_style( 'font-awesome', $dir_uri . "/assets/css/components/font-awesome{$suffix}.css", false, '4.7', 'all' );
		}

		if ( is_rtl() ) {
			if ( wi_is_using_flexbox() ) {
				wp_enqueue_style( 'wi-rtl', $dir_uri . "/assets/css/main-rtl{$suffix}.css", array(), wi_VERSION, 'all' );
			} else {
				wp_enqueue_style( 'wi-rtl', $dir_uri . "/assets/css/style-rtl{$suffix}.css", array(), wi_VERSION, 'all' );
			}
		}

		if ( is_child_theme() && apply_filters( 'wi_load_child_theme_stylesheet', true ) ) {
			wp_enqueue_style( 'wi-child', get_stylesheet_uri(), array( 'wi-style' ), filemtime( get_stylesheet_directory() . '/style.css' ), 'all' );
		}

		if ( function_exists( 'wp_script_add_data' ) ) {
			wp_enqueue_script( 'wi-classlist', $dir_uri . "/assets/js/classList{$suffix}.js", array(), wi_VERSION, true );
			wp_script_add_data( 'wi-classlist', 'conditional', 'lte IE 11' );
		}

		if ( wi_has_active_menu() ) {
			wp_enqueue_script( 'wi-menu', $dir_uri . "/assets/js/menu{$suffix}.js", array(), wi_VERSION, true );
		}

		wp_localize_script(
			'wi-menu',
			'withemeMenu',
			apply_filters(
				'wi_localize_js_args',
				array(
					'toggleOpenedSubMenus' => true,
					'openSubMenuLabel' => esc_attr__( 'Open Sub-Menu', 'witheme' ),
					'closeSubMenuLabel' => esc_attr__( 'Close Sub-Menu', 'witheme' ),
				)
			)
		);

		if ( 'click' === wi_get_option( 'nav_dropdown_type' ) || 'click-arrow' === wi_get_option( 'nav_dropdown_type' ) ) {
			wp_enqueue_script( 'wi-dropdown-click', $dir_uri . "/assets/js/dropdown-click{$suffix}.js", array(), wi_VERSION, true );
		}

		if ( apply_filters( 'wi_enable_modal_script', false ) ) {
			wp_enqueue_script( 'wi-modal', $dir_uri . '/assets/dist/modal.js', array(), wi_VERSION, true );
		}

		if ( 'enable' === wi_get_option( 'nav_search' ) ) {
			wp_enqueue_script( 'wi-navigation-search', $dir_uri . "/assets/js/navigation-search{$suffix}.js", array(), wi_VERSION, true );

			wp_localize_script(
				'wi-navigation-search',
				'withemeNavSearch',
				array(
					'open' => esc_attr__( 'Open Search Bar', 'witheme' ),
					'close' => esc_attr__( 'Close Search Bar', 'witheme' ),
				)
			);
		}

		if ( 'enable' === wi_get_option( 'back_to_top' ) ) {
			wp_enqueue_script( 'wi-back-to-top', $dir_uri . "/assets/js/back-to-top{$suffix}.js", array(), wi_VERSION, true );

			wp_localize_script(
				'wi-back-to-top',
				'withemeBackToTop',
				apply_filters(
					'wi_back_to_top_js_args',
					array(
						'smooth' => true,
					)
				)
			);
		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}

if ( ! function_exists( 'wi_widgets_init' ) ) {
	add_action( 'widgets_init', 'wi_widgets_init' );
	/**
	 * Register widgetized area and update sidebar with default widgets
	 */
	function wi_widgets_init() {
		$widgets = array(
			'sidebar-1' => __( '우측 사이드바', 'witheme' ),
			'sidebar-2' => __( '좌측 사이드바', 'witheme' ),
			'header' => __( '헤더', 'witheme' ),
			'footer-1' => __( '하단 위젯 1', 'witheme' ),
			'footer-2' => __( '하단 위젯 2', 'witheme' ),
			'footer-3' => __( '하단 위젯 3', 'witheme' ),
			'footer-4' => __( '하단 위젯 4', 'witheme' ),
			'footer-5' => __( '하단 위젯 5', 'witheme' ),
			'footer-bar' => __( '하단바', 'witheme' ),
			'top-bar' => __( '탑 바', 'witheme' ),
		);

		foreach ( $widgets as $id => $name ) {
			register_sidebar(
				array(
					'name'          => $name,
					'id'            => $id,
					'before_widget' => '<aside id="%1$s" class="widget inner-padding %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => apply_filters( 'wi_start_widget_title', '<h2 class="widget-title">' ),
					'after_title'   => apply_filters( 'wi_end_widget_title', '</h2>' ),
				)
			);
		}
	}
}

if ( ! function_exists( 'wi_smart_content_width' ) ) {
	add_action( 'wp', 'wi_smart_content_width' );
	/**
	 * Set the $content_width depending on layout of current page
	 * Hook into "wp" so we have the correct layout setting from wi_get_layout()
	 * Hooking into "after_setup_theme" doesn't get the correct layout setting
	 */
	function wi_smart_content_width() {
		global $content_width;

		$container_width = wi_get_option( 'container_width' );
		$right_sidebar_width = apply_filters( 'wi_right_sidebar_width', '25' );
		$left_sidebar_width = apply_filters( 'wi_left_sidebar_width', '25' );
		$layout = wi_get_layout();

		if ( 'left-sidebar' === $layout ) {
			$content_width = $container_width * ( ( 100 - $left_sidebar_width ) / 100 );
		} elseif ( 'right-sidebar' === $layout ) {
			$content_width = $container_width * ( ( 100 - $right_sidebar_width ) / 100 );
		} elseif ( 'no-sidebar' === $layout ) {
			$content_width = $container_width;
		} else {
			$content_width = $container_width * ( ( 100 - ( $left_sidebar_width + $right_sidebar_width ) ) / 100 );
		}
	}
}

if ( ! function_exists( 'wi_page_menu_args' ) ) {
	add_filter( 'wp_page_menu_args', 'wi_page_menu_args' );
	/**
	 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
	 *
	 * @since 0.1
	 *
	 * @param array $args The existing menu args.
	 * @return array Menu args.
	 */
	function wi_page_menu_args( $args ) {
		$args['show_home'] = true;

		return $args;
	}
}

if ( ! function_exists( 'wi_disable_title' ) ) {
	add_filter( 'wi_show_title', 'wi_disable_title' );
	/**
	 * Remove our title if set.
	 *
	 * @since 1.3.18
	 *
	 * @param bool $title Whether the title is displayed or not.
	 * @return bool Whether to display the content title.
	 */
	function wi_disable_title( $title ) {
		if ( is_singular() ) {
			$disable_title = get_post_meta( get_the_ID(), '_wi-disable-headline', true );

			if ( $disable_title ) {
				$title = false;
			}
		}

		return $title;
	}
}

if ( ! function_exists( 'wi_resource_hints' ) ) {
	add_filter( 'wp_resource_hints', 'wi_resource_hints', 10, 2 );
	/**
	 * Add resource hints to our Google fonts call.
	 *
	 * @since 1.3.42
	 *
	 * @param array  $urls           URLs to print for resource hints.
	 * @param string $relation_type  The relation type the URLs are printed.
	 * @return array $urls           URLs to print for resource hints.
	 */
	function wi_resource_hints( $urls, $relation_type ) {
		$handle = wi_is_using_dynamic_typography() ? 'wi-google-fonts' : 'wi-fonts';
		$hint_type = apply_filters( 'wi_google_font_resource_hint_type', 'preconnect' );
		$has_crossorigin_support = version_compare( $GLOBALS['wp_version'], '4.7-alpha', '>=' );

		if ( wp_style_is( $handle, 'queue' ) ) {
			if ( $relation_type === $hint_type ) {
				if ( $has_crossorigin_support && 'preconnect' === $hint_type ) {
					$urls[] = array(
						'href' => 'https://fonts.gstatic.com',
						'crossorigin',
					);

					$urls[] = array(
						'href' => 'https://fonts.googleapis.com',
						'crossorigin',
					);
				} else {
					$urls[] = 'https://fonts.gstatic.com';
					$urls[] = 'https://fonts.googleapis.com';
				}
			}

			if ( 'dns-prefetch' !== $hint_type ) {
				$googleapis_index = array_search( 'fonts.googleapis.com', $urls );

				if ( false !== $googleapis_index ) {
					unset( $urls[ $googleapis_index ] );
				}
			}
		}

		return $urls;
	}
}

if ( ! function_exists( 'wi_remove_caption_padding' ) ) {
	add_filter( 'img_caption_shortcode_width', 'wi_remove_caption_padding' );
	/**
	 * Remove WordPress's default padding on images with captions
	 *
	 * @param int $width Default WP .wp-caption width (image width + 10px).
	 * @return int Updated width to remove 10px padding.
	 */
	function wi_remove_caption_padding( $width ) {
		return $width - 10;
	}
}

if ( ! function_exists( 'wi_enhanced_image_navigation' ) ) {
	add_filter( 'attachment_link', 'wi_enhanced_image_navigation', 10, 2 );
	/**
	 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages.
	 *
	 * @param string $url The input URL.
	 * @param int    $id The ID of the post.
	 */
	function wi_enhanced_image_navigation( $url, $id ) {
		if ( ! is_attachment() && ! wp_attachment_is_image( $id ) ) {
			return $url;
		}

		$image = get_post( $id );
		// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison -- Intentially loose.
		if ( ! empty( $image->post_parent ) && $image->post_parent != $id ) {
			$url .= '#main';
		}

		return $url;
	}
}

if ( ! function_exists( 'wi_categorized_blog' ) ) {
	/**
	 * Determine whether blog/site has more than one category.
	 *
	 * @since 1.2.5
	 *
	 * @return bool True of there is more than one category, false otherwise.
	 */
	function wi_categorized_blog() {
		if ( false === ( $all_the_cool_cats = get_transient( 'wi_categories' ) ) ) { // phpcs:ignore
			// Create an array of all the categories that are attached to posts.
			$all_the_cool_cats = get_categories(
				array(
					'fields'     => 'ids',
					'hide_empty' => 1,

					// We only need to know if there is more than one category.
					'number'     => 2,
				)
			);

			// Count the number of categories that are attached to the posts.
			$all_the_cool_cats = count( $all_the_cool_cats );

			set_transient( 'wi_categories', $all_the_cool_cats );
		}

		if ( $all_the_cool_cats > 1 ) {
			// This blog has more than 1 category so twentyfifteen_categorized_blog should return true.
			return true;
		} else {
			// This blog has only 1 category so twentyfifteen_categorized_blog should return false.
			return false;
		}
	}
}

if ( ! function_exists( 'wi_category_transient_flusher' ) ) {
	add_action( 'edit_category', 'wi_category_transient_flusher' );
	add_action( 'save_post', 'wi_category_transient_flusher' );
	/**
	 * Flush out the transients used in {@see wi_categorized_blog()}.
	 *
	 * @since 1.2.5
	 */
	function wi_category_transient_flusher() {
		// Like, beat it. Dig?
		delete_transient( 'wi_categories' );
	}
}

if ( ! function_exists( 'wi_get_default_color_palettes' ) ) {
	/**
	 * Set up our colors for the color picker palettes and filter them so you can change them.
	 *
	 * @since 1.3.42
	 */
	function wi_get_default_color_palettes() {
		$palettes = array(
			'#000000',
			'#FFFFFF',
			'#F1C40F',
			'#E74C3C',
			'#1ABC9C',
			'#1e72bd',
			'#8E44AD',
			'#00CC77',
		);

		return apply_filters( 'wi_default_color_palettes', $palettes );
	}
}

add_filter( 'wi_fontawesome_essentials', 'wi_set_font_awesome_essentials' );
/**
 * Check to see if we should include the full Font Awesome library or not.
 *
 * @since 2.0
 *
 * @param bool $essentials The existing value.
 * @return bool
 */
function wi_set_font_awesome_essentials( $essentials ) {
	if ( wi_get_option( 'font_awesome_essentials' ) ) {
		return true;
	}

	return $essentials;
}

add_filter( 'wi_dynamic_css_skip_cache', 'wi_skip_dynamic_css_cache' );
/**
 * Skips caching of the dynamic CSS if set to false.
 *
 * @since 2.0
 *
 * @param bool $cache The existing value.
 * @return bool
 */
function wi_skip_dynamic_css_cache( $cache ) {
	if ( ! wi_get_option( 'dynamic_css_cache' ) ) {
		return true;
	}

	return $cache;
}

add_filter( 'wp_headers', 'wi_set_wp_headers' );
/**
 * Set any necessary headers.
 *
 * @param array $headers The existing headers.
 *
 * @since 2.3
 */
function wi_set_wp_headers( $headers ) {
	$headers['X-UA-Compatible'] = 'IE=edge';

	return $headers;
}

add_filter( 'wi_after_element_class_attribute', 'wi_set_microdata_markup', 10, 2 );
/**
 * Adds microdata to elements.
 *
 * @since 3.0.0
 * @param string $output The existing output after the class attribute.
 * @param string $context What element we're targeting.
 */
function wi_set_microdata_markup( $output, $context ) {
	if ( 'left_sidebar' === $context || 'right_sidebar' === $context ) {
		$context = 'sidebar';
	}

	if ( 'footer' === $context ) {
		return $output;
	}

	if ( 'site-info' === $context ) {
		$context = 'footer';
	}

	$microdata = wi_get_microdata( $context );

	if ( $microdata ) {
		return $microdata;
	}

	return $output;
}

add_action( 'wp_footer', 'wi_do_a11y_scripts' );
/**
 * Enqueue scripts in the footer.
 *
 * @since 3.1.0
 */
function wi_do_a11y_scripts() {
	if ( apply_filters( 'wi_print_a11y_script', true ) ) {
		// Add our small a11y script inline.
		printf(
			'<script id="wi-a11y">%s</script>',
			'!function(){"use strict";if("querySelector"in document&&"addEventListener"in window){var e=document.body;e.addEventListener("mousedown",function(){e.classList.add("using-mouse")}),e.addEventListener("keydown",function(){e.classList.remove("using-mouse")})}}();'
		);
	}
}
