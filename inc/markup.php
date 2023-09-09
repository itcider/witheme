<?php
/**
 * Adds HTML markup.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'wi_body_classes' ) ) {
	add_filter( 'body_class', 'wi_body_classes' );
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes The existing classes.
	 * @since 0.1
	 */
	function wi_body_classes( $classes ) {
		$sidebar_layout       = wi_get_layout();
		$navigation_location  = wi_get_navigation_location();
		$navigation_alignment = wi_get_option( 'nav_alignment_setting' );
		$navigation_dropdown  = wi_get_option( 'nav_dropdown_type' );
		$header_alignment     = wi_get_option( 'header_alignment_setting' );
		$content_layout       = wi_get_option( 'content_layout_setting' );

		// These values all have defaults, but we like to be extra careful.
		$classes[] = ( $sidebar_layout ) ? $sidebar_layout : 'right-sidebar';
		$classes[] = ( $navigation_location ) ? $navigation_location : 'nav-below-header';
		$classes[] = ( $content_layout ) ? $content_layout : 'separate-containers';

		if ( ! wi_is_using_flexbox() ) {
			$footer_widgets = wi_get_footer_widgets();
			$header_layout  = wi_get_option( 'header_layout_setting' );

			$classes[] = ( $header_layout ) ? $header_layout : 'fluid-header';
			$classes[] = ( '' !== $footer_widgets ) ? 'active-footer-widgets-' . absint( $footer_widgets ) : 'active-footer-widgets-3';
		}

		if ( 'enable' === wi_get_option( 'nav_search' ) ) {
			$classes[] = 'nav-search-enabled';
		}

		// Only necessary for nav before or after header.
		if ( ! wi_is_using_flexbox() && 'nav-below-header' === $navigation_location || 'nav-above-header' === $navigation_location ) {
			if ( 'center' === $navigation_alignment ) {
				$classes[] = 'nav-aligned-center';
			} elseif ( 'right' === $navigation_alignment ) {
				$classes[] = 'nav-aligned-right';
			} elseif ( 'left' === $navigation_alignment ) {
				$classes[] = 'nav-aligned-left';
			}
		}

		if ( 'center' === $header_alignment ) {
			$classes[] = 'header-aligned-center';
		} elseif ( 'right' === $header_alignment ) {
			$classes[] = 'header-aligned-right';
		} elseif ( 'left' === $header_alignment ) {
			$classes[] = 'header-aligned-left';
		}

		if ( 'click' === $navigation_dropdown ) {
			$classes[] = 'dropdown-click';
			$classes[] = 'dropdown-click-menu-item';
		} elseif ( 'click-arrow' === $navigation_dropdown ) {
			$classes[] = 'dropdown-click-arrow';
			$classes[] = 'dropdown-click';
		} else {
			$classes[] = 'dropdown-hover';
		}

		if ( is_singular() ) {
			// Page builder container metabox option.
			// Used to be a single checkbox, hence the name/true value. Now it's a radio choice between full width and contained.
			$content_container = get_post_meta( get_the_ID(), '_wi-full-width-content', true );

			if ( $content_container ) {
				if ( 'true' === $content_container ) {
					$classes[] = 'full-width-content';
				}

				if ( 'contained' === $content_container ) {
					$classes[] = 'contained-content';
				}
			}

			if ( has_post_thumbnail() ) {
				$classes[] = 'featured-image-active';
			}
		}

		return $classes;
	}
}

if ( ! function_exists( 'wi_top_bar_classes' ) ) {
	add_filter( 'wi_top_bar_class', 'wi_top_bar_classes' );
	/**
	 * Adds custom classes to the header.
	 *
	 * @param array $classes The existing classes.
	 * @since 0.1
	 */
	function wi_top_bar_classes( $classes ) {
		$classes[] = 'top-bar';

		if ( 'contained' === wi_get_option( 'top_bar_width' ) ) {
			$classes[] = 'grid-container';

			if ( ! wi_is_using_flexbox() ) {
				$classes[] = 'grid-parent';
			}
		}

		$classes[] = 'top-bar-align-' . esc_attr( wi_get_option( 'top_bar_alignment' ) );

		return $classes;
	}
}

if ( ! function_exists( 'wi_right_sidebar_classes' ) ) {
	add_filter( 'wi_right_sidebar_class', 'wi_right_sidebar_classes' );
	/**
	 * Adds custom classes to the right sidebar.
	 *
	 * @param array $classes The existing classes.
	 * @since 0.1
	 */
	function wi_right_sidebar_classes( $classes ) {
		$classes[] = 'widget-area';
		$classes[] = 'sidebar';
		$classes[] = 'is-right-sidebar';

		if ( ! wi_is_using_flexbox() ) {
			$right_sidebar_width = apply_filters( 'wi_right_sidebar_width', '25' );
			$left_sidebar_width = apply_filters( 'wi_left_sidebar_width', '25' );

			$right_sidebar_tablet_width = apply_filters( 'wi_right_sidebar_tablet_width', $right_sidebar_width );
			$left_sidebar_tablet_width = apply_filters( 'wi_left_sidebar_tablet_width', $left_sidebar_width );

			$classes[] = 'grid-' . $right_sidebar_width;
			$classes[] = 'tablet-grid-' . $right_sidebar_tablet_width;
			$classes[] = 'grid-parent';

			// Get the layout.
			$layout = wi_get_layout();

			if ( '' !== $layout ) {
				switch ( $layout ) {
					case 'both-left':
						$total_sidebar_width = $left_sidebar_width + $right_sidebar_width;
						$classes[] = 'pull-' . ( 100 - $total_sidebar_width );

						$total_sidebar_tablet_width = $left_sidebar_tablet_width + $right_sidebar_tablet_width;
						$classes[] = 'tablet-pull-' . ( 100 - $total_sidebar_tablet_width );
						break;
				}
			}
		}

		return $classes;
	}
}

if ( ! function_exists( 'wi_left_sidebar_classes' ) ) {
	add_filter( 'wi_left_sidebar_class', 'wi_left_sidebar_classes' );
	/**
	 * Adds custom classes to the left sidebar.
	 *
	 * @param array $classes The existing classes.
	 * @since 0.1
	 */
	function wi_left_sidebar_classes( $classes ) {
		$classes[] = 'widget-area';
		$classes[] = 'sidebar';
		$classes[] = 'is-left-sidebar';

		if ( ! wi_is_using_flexbox() ) {
			$right_sidebar_width = apply_filters( 'wi_right_sidebar_width', '25' );
			$left_sidebar_width = apply_filters( 'wi_left_sidebar_width', '25' );
			$total_sidebar_width = $left_sidebar_width + $right_sidebar_width;

			$right_sidebar_tablet_width = apply_filters( 'wi_right_sidebar_tablet_width', $right_sidebar_width );
			$left_sidebar_tablet_width = apply_filters( 'wi_left_sidebar_tablet_width', $left_sidebar_width );
			$total_sidebar_tablet_width = $left_sidebar_tablet_width + $right_sidebar_tablet_width;

			$classes[] = 'grid-' . $left_sidebar_width;
			$classes[] = 'tablet-grid-' . $left_sidebar_tablet_width;
			$classes[] = 'mobile-grid-100';
			$classes[] = 'grid-parent';

			// Get the layout.
			$layout = wi_get_layout();

			if ( '' !== $layout ) {
				switch ( $layout ) {
					case 'left-sidebar':
						$classes[] = 'pull-' . ( 100 - $left_sidebar_width );
						$classes[] = 'tablet-pull-' . ( 100 - $left_sidebar_tablet_width );
						break;

					case 'both-sidebars':
					case 'both-left':
						$classes[] = 'pull-' . ( 100 - $total_sidebar_width );
						$classes[] = 'tablet-pull-' . ( 100 - $total_sidebar_tablet_width );
						break;
				}
			}
		}

		return $classes;
	}
}

if ( ! function_exists( 'wi_content_classes' ) ) {
	add_filter( 'wi_content_class', 'wi_content_classes' );
	/**
	 * Adds custom classes to the content container.
	 *
	 * @param array $classes The existing classes.
	 * @since 0.1
	 */
	function wi_content_classes( $classes ) {
		$classes[] = 'content-area';

		if ( ! wi_is_using_flexbox() ) {
			$right_sidebar_width = apply_filters( 'wi_right_sidebar_width', '25' );
			$left_sidebar_width = apply_filters( 'wi_left_sidebar_width', '25' );
			$total_sidebar_width = $left_sidebar_width + $right_sidebar_width;

			$right_sidebar_tablet_width = apply_filters( 'wi_right_sidebar_tablet_width', $right_sidebar_width );
			$left_sidebar_tablet_width = apply_filters( 'wi_left_sidebar_tablet_width', $left_sidebar_width );
			$total_sidebar_tablet_width = $left_sidebar_tablet_width + $right_sidebar_tablet_width;

			$classes[] = 'grid-parent';
			$classes[] = 'mobile-grid-100';

			// Get the layout.
			$layout = wi_get_layout();

			if ( '' !== $layout ) {
				switch ( $layout ) {

					case 'right-sidebar':
						$classes[] = 'grid-' . ( 100 - $right_sidebar_width );
						$classes[] = 'tablet-grid-' . ( 100 - $right_sidebar_tablet_width );
						break;

					case 'left-sidebar':
						$classes[] = 'push-' . $left_sidebar_width;
						$classes[] = 'grid-' . ( 100 - $left_sidebar_width );
						$classes[] = 'tablet-push-' . $left_sidebar_tablet_width;
						$classes[] = 'tablet-grid-' . ( 100 - $left_sidebar_tablet_width );
						break;

					case 'no-sidebar':
						$classes[] = 'grid-100';
						$classes[] = 'tablet-grid-100';
						break;

					case 'both-sidebars':
						$classes[] = 'push-' . $left_sidebar_width;
						$classes[] = 'grid-' . ( 100 - $total_sidebar_width );
						$classes[] = 'tablet-push-' . $left_sidebar_tablet_width;
						$classes[] = 'tablet-grid-' . ( 100 - $total_sidebar_tablet_width );
						break;

					case 'both-right':
						$classes[] = 'grid-' . ( 100 - $total_sidebar_width );
						$classes[] = 'tablet-grid-' . ( 100 - $total_sidebar_tablet_width );
						break;

					case 'both-left':
						$classes[] = 'push-' . $total_sidebar_width;
						$classes[] = 'grid-' . ( 100 - $total_sidebar_width );
						$classes[] = 'tablet-push-' . $total_sidebar_tablet_width;
						$classes[] = 'tablet-grid-' . ( 100 - $total_sidebar_tablet_width );
						break;
				}
			}
		}

		return $classes;
	}
}

if ( ! function_exists( 'wi_header_classes' ) ) {
	add_filter( 'wi_header_class', 'wi_header_classes' );
	/**
	 * Adds custom classes to the header.
	 *
	 * @param array $classes The existing classes.
	 * @since 0.1
	 */
	function wi_header_classes( $classes ) {
		$classes[] = 'site-header';

		if ( 'contained-header' === wi_get_option( 'header_layout_setting' ) ) {
			$classes[] = 'grid-container';

			if ( ! wi_is_using_flexbox() ) {
				$classes[] = 'grid-parent';
			}
		}

		if ( wi_has_inline_mobile_toggle() ) {
			$classes[] = 'has-inline-mobile-toggle';
		}

		return $classes;
	}
}

if ( ! function_exists( 'wi_inside_header_classes' ) ) {
	add_filter( 'wi_inside_header_class', 'wi_inside_header_classes' );
	/**
	 * Adds custom classes to inside the header.
	 *
	 * @param array $classes The existing classes.
	 * @since 0.1
	 */
	function wi_inside_header_classes( $classes ) {
		$classes[] = 'inside-header';

		if ( 'full-width' !== wi_get_option( 'header_inner_width' ) ) {
			$classes[] = 'grid-container';

			if ( ! wi_is_using_flexbox() ) {
				$classes[] = 'grid-parent';
			}
		}

		return $classes;
	}
}

if ( ! function_exists( 'wi_navigation_classes' ) ) {
	add_filter( 'wi_navigation_class', 'wi_navigation_classes' );
	/**
	 * Adds custom classes to the navigation.
	 *
	 * @param array $classes The existing classes.
	 * @since 0.1
	 */
	function wi_navigation_classes( $classes ) {
		$classes[] = 'main-navigation';

		if ( 'contained-nav' === wi_get_option( 'nav_layout_setting' ) ) {
			if ( wi_is_using_flexbox() ) {
				$navigation_location = wi_get_navigation_location();

				if ( 'nav-float-right' !== $navigation_location && 'nav-float-left' !== $navigation_location ) {
					$classes[] = 'grid-container';
				}
			} else {
				$classes[] = 'grid-container';
				$classes[] = 'grid-parent';
			}
		}

		if ( wi_is_using_flexbox() ) {
			$nav_alignment = wi_get_option( 'nav_alignment_setting' );

			if ( 'center' === $nav_alignment ) {
				$classes[] = 'nav-align-center';
			} elseif ( 'right' === $nav_alignment ) {
				$classes[] = 'nav-align-right';
			} elseif ( is_rtl() && 'left' === $nav_alignment ) {
				$classes[] = 'nav-align-left';
			}

			if ( wi_has_menu_bar_items() ) {
				$classes[] = 'has-menu-bar-items';
			}
		}

		$submenu_direction = 'right';

		if ( 'left' === wi_get_option( 'nav_dropdown_direction' ) ) {
			$submenu_direction = 'left';
		}

		if ( 'nav-left-sidebar' === wi_get_navigation_location() ) {
			$submenu_direction = 'right';

			if ( 'both-right' === wi_get_layout() ) {
				$submenu_direction = 'left';
			}
		}

		if ( 'nav-right-sidebar' === wi_get_navigation_location() ) {
			$submenu_direction = 'left';

			if ( 'both-left' === wi_get_layout() ) {
				$submenu_direction = 'right';
			}
		}

		$classes[] = 'sub-menu-' . $submenu_direction;

		return $classes;
	}
}

if ( ! function_exists( 'wi_inside_navigation_classes' ) ) {
	add_filter( 'wi_inside_navigation_class', 'wi_inside_navigation_classes' );
	/**
	 * Adds custom classes to the inner navigation.
	 *
	 * @param array $classes The existing classes.
	 * @since 1.3.41
	 */
	function wi_inside_navigation_classes( $classes ) {
		$classes[] = 'inside-navigation';

		if ( 'full-width' !== wi_get_option( 'nav_inner_width' ) ) {
			$classes[] = 'grid-container';

			if ( ! wi_is_using_flexbox() ) {
				$classes[] = 'grid-parent';
			}
		}

		return $classes;
	}
}

if ( ! function_exists( 'wi_menu_classes' ) ) {
	add_filter( 'wi_menu_class', 'wi_menu_classes' );
	/**
	 * Adds custom classes to the menu.
	 *
	 * @param array $classes The existing classes.
	 * @since 0.1
	 */
	function wi_menu_classes( $classes ) {
		$classes[] = 'menu';
		$classes[] = 'sf-menu';

		return $classes;
	}
}

if ( ! function_exists( 'wi_footer_classes' ) ) {
	add_filter( 'wi_footer_class', 'wi_footer_classes' );
	/**
	 * Adds custom classes to the footer.
	 *
	 * @param array $classes The existing classes.
	 * @since 0.1
	 */
	function wi_footer_classes( $classes ) {
		$classes[] = 'site-footer';

		if ( 'contained-footer' === wi_get_option( 'footer_layout_setting' ) ) {
			$classes[] = 'grid-container';

			if ( ! wi_is_using_flexbox() ) {
				$classes[] = 'grid-parent';
			}
		}

		if ( is_active_sidebar( 'footer-bar' ) ) {
			$classes[] = 'footer-bar-active';
			$classes[] = 'footer-bar-align-' . esc_attr( wi_get_option( 'footer_bar_alignment' ) );
		}

		return $classes;
	}
}

if ( ! function_exists( 'wi_inside_footer_classes' ) ) {
	add_filter( 'wi_inside_footer_class', 'wi_inside_footer_classes' );
	/**
	 * Adds custom classes to the footer.
	 *
	 * @param array $classes The existing classes.
	 * @since 0.1
	 */
	function wi_inside_footer_classes( $classes ) {
		$classes[] = 'footer-widgets-container';

		if ( 'full-width' !== wi_get_option( 'footer_inner_width' ) ) {
			$classes[] = 'grid-container';

			if ( ! wi_is_using_flexbox() ) {
				$classes[] = 'grid-parent';
			}
		}

		return $classes;
	}
}

if ( ! function_exists( 'wi_main_classes' ) ) {
	add_filter( 'wi_main_class', 'wi_main_classes' );
	/**
	 * Adds custom classes to the <main> element
	 *
	 * @param array $classes The existing classes.
	 * @since 1.1.0
	 */
	function wi_main_classes( $classes ) {
		$classes[] = 'site-main';

		return $classes;
	}
}

add_filter( 'wi_page_class', 'wi_do_page_container_classes' );
/**
 * Adds custom classes to the #page element
 *
 * @param array $classes The existing classes.
 * @since 3.0.0
 */
function wi_do_page_container_classes( $classes ) {
	$classes[] = 'site';
	$classes[] = 'grid-container';
	$classes[] = 'container';

	if ( wi_is_using_hatom() ) {
		$classes[] = 'hfeed';
	}

	if ( ! wi_is_using_flexbox() ) {
		$classes[] = 'grid-parent';
	}

	return $classes;
}

add_filter( 'wi_comment-author_class', 'wi_do_comment_author_classes' );
/**
 * Adds custom classes to the comment author element
 *
 * @param array $classes The existing classes.
 * @since 3.0.0
 */
function wi_do_comment_author_classes( $classes ) {
	$classes[] = 'comment-author';

	if ( wi_is_using_hatom() ) {
		$classes[] = 'vcard';
	}

	return $classes;
}

if ( ! function_exists( 'wi_post_classes' ) ) {
	add_filter( 'post_class', 'wi_post_classes' );
	/**
	 * Adds custom classes to the <article> element.
	 * Remove .hentry class from pages to comply with structural data guidelines.
	 *
	 * @param array $classes The existing classes.
	 * @since 1.3.39
	 */
	function wi_post_classes( $classes ) {
		if ( 'page' === get_post_type() || ! wi_is_using_hatom() ) {
			$classes = array_diff( $classes, array( 'hentry' ) );
		}

		return $classes;
	}
}
