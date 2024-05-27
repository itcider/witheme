<?php
/**
 * Integrate witheme with the WordPress block editor.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Check what sidebar layout we're using.
 * We need this function as the post meta in wi_get_layout() only runs
 * on is_singular()
 *
 * @since 2.2
 *
 * @param bool $meta Check for post meta.
 * @return string The saved sidebar layout.
 */
function wi_get_block_editor_sidebar_layout( $meta = true ) {
	$layout = wi_get_option( 'layout_setting' );

	if ( function_exists( 'get_current_screen' ) ) {
		$screen = get_current_screen();

		if ( is_object( $screen ) && 'post' === $screen->post_type ) {
			$layout = wi_get_option( 'single_layout_setting' );
		}
	}

	// Add in our default filter in case people have adjusted it.
	$layout = apply_filters( 'wi_sidebar_layout', $layout );

	if ( $meta ) {
		$layout_meta = get_post_meta( get_the_ID(), '_wi-sidebar-layout-meta', true );

		if ( $layout_meta ) {
			$layout = $layout_meta;
		}
	}

	return apply_filters( 'wi_block_editor_sidebar_layout', $layout );
}

/**
 * Check whether we're disabling the content title or not.
 * We need this function as the post meta in wi_show_title() only runs
 * on is_singular()
 *
 * @since 2.2
 */
function wi_get_block_editor_show_content_title() {
	$title = wi_show_title();

	$disable_title = get_post_meta( get_the_ID(), '_wi-disable-headline', true );

	if ( $disable_title ) {
		$title = false;
	}

	return apply_filters( 'wi_block_editor_show_content_title', $title );
}

/**
 * Get the content width for this post.
 *
 * @since 2.2
 */
function wi_get_block_editor_content_width() {
	$container_width = wi_get_option( 'container_width' );

	$content_width = $container_width;

	$right_sidebar_width = apply_filters( 'wi_right_sidebar_width', '25' );

	$left_sidebar_width = apply_filters( 'wi_left_sidebar_width', '25' );

	$layout = wi_get_block_editor_sidebar_layout();

	if ( 'left-sidebar' === $layout ) {
		$content_width = $container_width * ( ( 100 - $left_sidebar_width ) / 100 );
	} elseif ( 'right-sidebar' === $layout ) {
		$content_width = $container_width * ( ( 100 - $right_sidebar_width ) / 100 );
	} elseif ( 'no-sidebar' === $layout ) {
		$content_width = $container_width;
	} else {
		$content_width = $container_width * ( ( 100 - ( $left_sidebar_width + $right_sidebar_width ) ) / 100 );
	}

	return apply_filters( 'wi_block_editor_content_width', $content_width );
}

add_filter( 'block_editor_settings_all', 'wi_add_inline_block_editor_styles' );
/**
 * Add dynamic inline styles to the block editor content.
 *
 * @param array $editor_settings The existing editor settings.
 */
function wi_add_inline_block_editor_styles( $editor_settings ) {
	$show_editor_styles = apply_filters( 'wi_show_block_editor_styles', true );

	if ( $show_editor_styles ) {
		if ( wi_is_using_dynamic_typography() ) {
			$google_fonts_uri = witheme_Typography::get_google_fonts_uri();

			if ( $google_fonts_uri ) {
				// Need to use @import for now until this is ready: https://github.com/WordPress/gutenberg/pull/35950.
				$google_fonts_import = sprintf(
					'@import "%s";',
					$google_fonts_uri
				);

				$editor_settings['styles'][] = array( 'css' => $google_fonts_import );
			}
		}

		$editor_settings['styles'][] = array( 'css' => wp_strip_all_tags( wi_do_inline_block_editor_css() ) );

		if ( wi_is_using_dynamic_typography() ) {
			$editor_settings['styles'][] = array( 'css' => wp_strip_all_tags( witheme_Typography::get_css( 'core' ) ) );
		}
	}

	return $editor_settings;
}

add_action( 'enqueue_block_editor_assets', 'wi_enqueue_google_fonts' );
add_action( 'enqueue_block_editor_assets', 'wi_enqueue_backend_block_editor_assets' );
/**
 * Add CSS to the admin side of the block editor.
 *
 * @since 2.2
 */
function wi_enqueue_backend_block_editor_assets() {
	wp_enqueue_script(
		'wi-block-editor',
		trailingslashit( get_template_directory_uri() ) . 'assets/dist/block-editor.js',
		array( 'wp-data', 'wp-dom-ready', 'wp-element', 'wp-plugins', 'wp-polyfill' ),
		wi_VERSION,
		true
	);

	$color_settings = wp_parse_args(
		get_option( 'wi_settings', array() ),
		wi_get_color_defaults()
	);

	$spacing_settings = wp_parse_args(
		get_option( 'wi_spacing_settings', array() ),
		wi_spacing_get_defaults()
	);

	$text_color = wi_get_option( 'text_color' );

	if ( $color_settings['content_text_color'] ) {
		$text_color = $color_settings['content_text_color'];
	}

	$sidebar_layout = get_post_meta( get_the_ID(), '_wi_sidebar_layout', true );
	$content_area_type = get_post_meta( get_the_ID(), '_wi-full-width-content', true );

	wp_localize_script(
		'wi-block-editor',
		'withemeBlockEditor',
		array(
			'sidebarLayout' => $sidebar_layout ? $sidebar_layout : wi_get_block_editor_sidebar_layout( false ),
			'containerWidth' => wi_get_option( 'container_width' ),
			'contentPaddingRight' => absint( $spacing_settings['content_right'] ) . 'px',
			'contentPaddingLeft' => absint( $spacing_settings['content_left'] ) . 'px',
			'rightSidebarWidth' => apply_filters( 'wi_right_sidebar_width', '25' ),
			'leftSidebarWidth' => apply_filters( 'wi_left_sidebar_width', '25' ),
			'text_color' => $text_color,
			'show_editor_styles' => apply_filters( 'wi_show_block_editor_styles', true ),
			'contentAreaType' => $content_area_type ? $content_area_type : apply_filters( 'wi_block_editor_content_area_type', '' ),
			'customContentWidth' => apply_filters( 'wi_block_editor_container_width', '' ),
		)
	);

	wp_register_style( 'wi-block-editor', false, array(), true, true );
	wp_add_inline_style( 'wi-block-editor', wi_do_inline_block_editor_css( 'block-editor' ) );
	wp_enqueue_style( 'wi-block-editor' );
}

/**
 * Write our CSS for the block editor.
 *
 * @since 2.2
 * @param string $for Define whether this CSS for the block content or the block editor.
 */
function wi_do_inline_block_editor_css( $for = 'block-content' ) {
	$css = new witheme_CSS();

	$css->set_selector( ':root' );

	$global_colors = wi_get_global_colors();

	if ( ! empty( $global_colors ) ) {
		foreach ( (array) $global_colors as $key => $data ) {
			if ( ! empty( $data['slug'] ) && ! empty( $data['color'] ) ) {
				$css->add_property( '--' . $data['slug'], $data['color'] );
			}
		}

		foreach ( (array) $global_colors as $key => $data ) {
			if ( ! empty( $data['slug'] ) && ! empty( $data['color'] ) ) {
				$css->set_selector( '.has-' . $data['slug'] . '-color' );
				$css->add_property( 'color', 'var(--' . $data['slug'] . ')' );

				$css->set_selector( '.has-' . $data['slug'] . '-background-color' );
				$css->add_property( 'background-color', 'var(--' . $data['slug'] . ')' );
			}
		}
	}

	// If this CSS is for the editor only (not the block content), we can return here.
	if ( 'block-editor' === $for ) {
		return $css->css_output();
	}

	$color_settings = wp_parse_args(
		get_option( 'wi_settings', array() ),
		wi_get_color_defaults()
	);

	$font_settings = wp_parse_args(
		get_option( 'wi_settings', array() ),
		wi_get_default_fonts()
	);

	$content_width = wi_get_block_editor_content_width();

	$spacing_settings = wp_parse_args(
		get_option( 'wi_spacing_settings', array() ),
		wi_spacing_get_defaults()
	);

	$content_width_calc = sprintf(
		'calc(%1$s - %2$s - %3$s)',
		absint( $content_width ) . 'px',
		absint( $spacing_settings['content_left'] ) . 'px',
		absint( $spacing_settings['content_right'] ) . 'px'
	);

	$css->set_selector( 'body' );
	$css->add_property(
		'--content-width',
		'true' === get_post_meta( get_the_ID(), '_wi-full-width-content', true )
			? '100%'
			: $content_width_calc
	);

	$css->set_selector( 'body .wp-block' );
	$css->add_property( 'max-width', 'var(--content-width)' );

	$css->set_selector( '.wp-block[data-align="full"]' );
	$css->add_property( 'max-width', 'none' );

	$css->set_selector( '.wp-block[data-align="wide"]' );
	$css->add_property( 'max-width', absint( $content_width ), false, 'px' );

	$underline_links = wi_get_option( 'underline_links' );

	if ( 'never' !== $underline_links ) {
		if ( 'always' === $underline_links ) {
			$css->set_selector( '.wp-block a' );
			$css->add_property( 'text-decoration', 'underline' );
		}

		if ( 'hover' === $underline_links ) {
			$css->set_selector( '.wp-block a' );
			$css->add_property( 'text-decoration', 'none' );

			$css->set_selector( '.wp-block a:hover, .wp-block a:focus' );
			$css->add_property( 'text-decoration', 'underline' );
		}

		if ( 'not-hover' === $underline_links ) {
			$css->set_selector( '.wp-block a' );
			$css->add_property( 'text-decoration', 'underline' );

			$css->set_selector( '.wp-block a:hover, .wp-block a:focus' );
			$css->add_property( 'text-decoration', 'none' );
		}

		$css->set_selector( 'a.button, .wp-block-button__link' );
		$css->add_property( 'text-decoration', 'none' );
	} else {
		$css->set_selector( '.wp-block a' );
		$css->add_property( 'text-decoration', 'none' );
	}

	if ( apply_filters( 'wi_do_group_inner_container_style', true ) ) {
		$css->set_selector( '.wp-block-group__inner-container' );
		$css->add_property( 'max-width', absint( $content_width ), false, 'px' );
		$css->add_property( 'margin-left', 'auto' );
		$css->add_property( 'margin-right', 'auto' );
		$css->add_property( 'padding', wi_padding_css( $spacing_settings['content_top'], $spacing_settings['content_right'], $spacing_settings['content_bottom'], $spacing_settings['content_left'] ) );
	}

	$css->set_selector( 'a.button, a.button:visited, .wp-block-button__link:not(.has-background)' );
	$css->add_property( 'color', $color_settings['form_button_text_color'] );
	$css->add_property( 'background-color', $color_settings['form_button_background_color'] );
	$css->add_property( 'padding', '10px 20px' );
	$css->add_property( 'border', '0' );
	$css->add_property( 'border-radius', '0' );

	$css->set_selector( 'a.button:hover, a.button:active, a.button:focus, .wp-block-button__link:not(.has-background):active, .wp-block-button__link:not(.has-background):focus, .wp-block-button__link:not(.has-background):hover' );
	$css->add_property( 'color', $color_settings['form_button_text_color_hover'] );
	$css->add_property( 'background-color', $color_settings['form_button_background_color_hover'] );

	if ( ! wi_is_using_dynamic_typography() ) {
		$body_family = wi_get_font_family_css( 'font_body', 'wi_settings', wi_get_default_fonts() );
		$h1_family = wi_get_font_family_css( 'font_heading_1', 'wi_settings', wi_get_default_fonts() );
		$h2_family = wi_get_font_family_css( 'font_heading_2', 'wi_settings', wi_get_default_fonts() );
		$h3_family = wi_get_font_family_css( 'font_heading_3', 'wi_settings', wi_get_default_fonts() );
		$h4_family = wi_get_font_family_css( 'font_heading_4', 'wi_settings', wi_get_default_fonts() );
		$h5_family = wi_get_font_family_css( 'font_heading_5', 'wi_settings', wi_get_default_fonts() );
		$h6_family = wi_get_font_family_css( 'font_heading_6', 'wi_settings', wi_get_default_fonts() );
		$buttons_family = wi_get_font_family_css( 'font_buttons', 'wi_settings', wi_get_default_fonts() );
	}

	$css->set_selector( 'body' );

	if ( ! wi_is_using_dynamic_typography() ) {
		$css->add_property( 'font-family', $body_family );
		$css->add_property( 'font-size', absint( $font_settings['body_font_size'] ), false, 'px' );
	}

	if ( $color_settings['content_text_color'] ) {
		$css->add_property( 'color', $color_settings['content_text_color'] );
	} else {
		$css->add_property( 'color', wi_get_option( 'text_color' ) );
	}

	$css->set_selector( '.content-title-visibility' );

	if ( $color_settings['content_text_color'] ) {
		$css->add_property( 'color', $color_settings['content_text_color'] );
	} else {
		$css->add_property( 'color', wi_get_option( 'text_color' ) );
	}

	if ( ! wi_is_using_dynamic_typography() ) {
		$css->set_selector( 'body, p' );
		$css->add_property( 'line-height', floatval( $font_settings['body_line_height'] ) );

		$css->set_selector( 'p' );
		$css->add_property( 'margin-top', '0px' );
		$css->add_property( 'margin-bottom', $font_settings['paragraph_margin'], false, 'em' );
	}

	$css->set_selector( 'h1' );

	if ( ! wi_is_using_dynamic_typography() ) {
		$css->add_property( 'font-family', 'inherit' === $h1_family || '' === $h1_family ? $body_family : $h1_family );
		$css->add_property( 'font-weight', $font_settings['heading_1_weight'] );
		$css->add_property( 'text-transform', $font_settings['heading_1_transform'] );
		$css->add_property( 'font-size', absint( $font_settings['heading_1_font_size'] ), false, 'px' );
		$css->add_property( 'line-height', floatval( $font_settings['heading_1_line_height'] ), false, 'em' );
		$css->add_property( 'margin-bottom', floatval( $font_settings['heading_1_margin_bottom'] ), false, 'px' );
		$css->add_property( 'margin-top', '0' );
	}

	$css->add_property( 'color', $color_settings['h1_color'] );

	if ( $color_settings['content_title_color'] ) {
		$css->set_selector( '.edit-post-visual-editor__post-title-wrapper h1' );
		$css->add_property( 'color', $color_settings['content_title_color'] );
	}

	$css->set_selector( 'h2' );

	if ( ! wi_is_using_dynamic_typography() ) {
		$css->add_property( 'font-family', $h2_family );
		$css->add_property( 'font-weight', $font_settings['heading_2_weight'] );
		$css->add_property( 'text-transform', $font_settings['heading_2_transform'] );
		$css->add_property( 'font-size', absint( $font_settings['heading_2_font_size'] ), false, 'px' );
		$css->add_property( 'line-height', floatval( $font_settings['heading_2_line_height'] ), false, 'em' );
		$css->add_property( 'margin-bottom', floatval( $font_settings['heading_2_margin_bottom'] ), false, 'px' );
		$css->add_property( 'margin-top', '0' );
	}

	$css->add_property( 'color', $color_settings['h2_color'] );

	$css->set_selector( 'h3' );

	if ( ! wi_is_using_dynamic_typography() ) {
		$css->add_property( 'font-family', $h3_family );
		$css->add_property( 'font-weight', $font_settings['heading_3_weight'] );
		$css->add_property( 'text-transform', $font_settings['heading_3_transform'] );
		$css->add_property( 'font-size', absint( $font_settings['heading_3_font_size'] ), false, 'px' );
		$css->add_property( 'line-height', floatval( $font_settings['heading_3_line_height'] ), false, 'em' );
		$css->add_property( 'margin-bottom', floatval( $font_settings['heading_3_margin_bottom'] ), false, 'px' );
		$css->add_property( 'margin-top', '0' );
	}

	$css->add_property( 'color', $color_settings['h3_color'] );

	$css->set_selector( 'h4' );

	if ( ! wi_is_using_dynamic_typography() ) {
		$css->add_property( 'font-family', $h4_family );
		$css->add_property( 'font-weight', $font_settings['heading_4_weight'] );
		$css->add_property( 'text-transform', $font_settings['heading_4_transform'] );
		$css->add_property( 'margin-bottom', '20px' );
		$css->add_property( 'margin-top', '0' );

		if ( '' !== $font_settings['heading_4_font_size'] ) {
			$css->add_property( 'font-size', absint( $font_settings['heading_4_font_size'] ), false, 'px' );
		} else {
			$css->add_property( 'font-size', 'inherit' );
		}

		if ( '' !== $font_settings['heading_4_line_height'] ) {
			$css->add_property( 'line-height', floatval( $font_settings['heading_4_line_height'] ), false, 'em' );
		}
	}

	$css->add_property( 'color', $color_settings['h4_color'] );

	$css->set_selector( 'h5' );

	if ( ! wi_is_using_dynamic_typography() ) {
		$css->add_property( 'font-family', $h5_family );
		$css->add_property( 'font-weight', $font_settings['heading_5_weight'] );
		$css->add_property( 'text-transform', $font_settings['heading_5_transform'] );
		$css->add_property( 'margin-bottom', '20px' );
		$css->add_property( 'margin-top', '0' );

		if ( '' !== $font_settings['heading_5_font_size'] ) {
			$css->add_property( 'font-size', absint( $font_settings['heading_5_font_size'] ), false, 'px' );
		} else {
			$css->add_property( 'font-size', 'inherit' );
		}

		if ( '' !== $font_settings['heading_5_line_height'] ) {
			$css->add_property( 'line-height', floatval( $font_settings['heading_5_line_height'] ), false, 'em' );
		}
	}

	$css->add_property( 'color', $color_settings['h5_color'] );

	$css->set_selector( 'h6' );

	if ( ! wi_is_using_dynamic_typography() ) {
		$css->add_property( 'font-family', $h6_family );
		$css->add_property( 'font-weight', $font_settings['heading_6_weight'] );
		$css->add_property( 'text-transform', $font_settings['heading_6_transform'] );
		$css->add_property( 'margin-bottom', '20px' );
		$css->add_property( 'margin-top', '0' );

		if ( '' !== $font_settings['heading_6_font_size'] ) {
			$css->add_property( 'font-size', absint( $font_settings['heading_6_font_size'] ), false, 'px' );
		} else {
			$css->add_property( 'font-size', 'inherit' );
		}

		if ( '' !== $font_settings['heading_6_line_height'] ) {
			$css->add_property( 'line-height', floatval( $font_settings['heading_6_line_height'] ), false, 'em' );
		}
	}

	$css->add_property( 'color', $color_settings['h6_color'] );

	$css->set_selector( 'a.button, .block-editor-block-list__layout .wp-block-button .wp-block-button__link' );

	if ( ! wi_is_using_dynamic_typography() ) {
		$css->add_property( 'font-family', $buttons_family );
		$css->add_property( 'font-weight', $font_settings['buttons_font_weight'] );
		$css->add_property( 'text-transform', $font_settings['buttons_font_transform'] );

		if ( '' !== $font_settings['buttons_font_size'] ) {
			$css->add_property( 'font-size', absint( $font_settings['buttons_font_size'] ), false, 'px' );
		} else {
			$css->add_property( 'font-size', 'inherit' );
		}
	}

	if ( version_compare( $GLOBALS['wp_version'], '5.7-alpha.1', '>' ) ) {
		$css->set_selector( '.block-editor__container .edit-post-visual-editor' );
		$css->add_property( 'background-color', wi_get_option( 'background_color' ) );

		$css->set_selector( 'body' );

		if ( $color_settings['content_background_color'] ) {
			$css->add_property( 'background-color', $color_settings['content_background_color'] );
		} else {
			$css->add_property( 'background-color', wi_get_option( 'background_color' ) );
		}
	} else {
		$css->set_selector( 'body' );
		$css->add_property( 'background-color', wi_get_option( 'background_color' ) );

		if ( $color_settings['content_background_color'] ) {
			$body_background = wi_get_option( 'background_color' );
			$content_background = $color_settings['content_background_color'];

			$css->add_property( 'background', 'linear-gradient(' . $content_background . ',' . $content_background . '), linear-gradient(' . $body_background . ',' . $body_background . ')' );
		}
	}

	$css->set_selector( 'a, a:visited' );

	if ( $color_settings['content_link_color'] ) {
		$css->add_property( 'color', $color_settings['content_link_color'] );
	} else {
		$css->add_property( 'color', wi_get_option( 'link_color' ) );
	}

	$css->set_selector( 'a:hover, a:focus, a:active' );

	if ( $color_settings['content_link_hover_color'] ) {
		$css->add_property( 'color', $color_settings['content_link_hover_color'] );
	} else {
		$css->add_property( 'color', wi_get_option( 'link_color_hover' ) );
	}

	return $css->css_output();
}
