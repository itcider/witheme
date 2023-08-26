<?php
/**
 * Helper functions for the Customizer.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'wi_is_posts_page' ) ) {
	/**
	 * Check to see if we're on a posts page
	 *
	 * @since 1.3.39
	 */
	function wi_is_posts_page() {
		return ( is_home() || is_archive() || is_tax() ) ? true : false;
	}
}

if ( ! function_exists( 'wi_is_footer_bar_active' ) ) {
	/**
	 * Check to see if we're using our footer bar widget
	 *
	 * @since 1.3.42
	 */
	function wi_is_footer_bar_active() {
		return ( is_active_sidebar( 'footer-bar' ) ) ? true : false;
	}
}

if ( ! function_exists( 'wi_is_top_bar_active' ) ) {
	/**
	 * Check to see if the top bar is active
	 *
	 * @since 1.3.45
	 */
	function wi_is_top_bar_active() {
		$top_bar = is_active_sidebar( 'top-bar' ) ? true : false;
		return apply_filters( 'wi_is_top_bar_active', $top_bar );
	}
}

if ( ! function_exists( 'wi_customize_partial_blogname' ) ) {
	/**
	 * Render the site title for the selective refresh partial.
	 *
	 * @since 1.3.41
	 */
	function wi_customize_partial_blogname() {
		bloginfo( 'name' );
	}
}

if ( ! function_exists( 'wi_customize_partial_blogdescription' ) ) {
	/**
	 * Render the site tagline for the selective refresh partial.
	 *
	 * @since 1.3.41
	 */
	function wi_customize_partial_blogdescription() {
		bloginfo( 'description' );
	}
}

if ( ! function_exists( 'wi_enqueue_color_palettes' ) ) {
	add_action( 'customize_controls_enqueue_scripts', 'wi_enqueue_color_palettes' );
	/**
	 * Add our custom color palettes to the color pickers in the Customizer.
	 *
	 * @since 1.3.42
	 */
	function wi_enqueue_color_palettes() {
		// Old versions of WP don't get nice things.
		if ( ! function_exists( 'wp_add_inline_script' ) ) {
			return;
		}

		// Grab our palette array and turn it into JS.
		$palettes = wp_json_encode( wi_get_default_color_palettes() );

		// Add our custom palettes.
		// json_encode takes care of escaping.
		wp_add_inline_script( 'wp-color-picker', 'jQuery.wp.wpColorPicker.prototype.options.palettes = ' . $palettes . ';' );
	}
}

if ( ! function_exists( 'wi_sanitize_integer' ) ) {
	/**
	 * Sanitize integers.
	 *
	 * @since 1.0.8
	 * @param string $input The value to check.
	 */
	function wi_sanitize_integer( $input ) {
		return absint( $input );
	}
}

if ( ! function_exists( 'wi_sanitize_decimal_integer' ) ) {
	/**
	 * Sanitize integers that can use decimals.
	 *
	 * @since 1.3.41
	 * @param string $input The value to check.
	 */
	function wi_sanitize_decimal_integer( $input ) {
		return abs( floatval( $input ) );
	}
}

/**
 * Sanitize integers that can use decimals.
 *
 * @since 3.1.0
 * @param string $input The value to check.
 */
function wi_sanitize_empty_decimal_integer( $input ) {
	if ( '' === $input ) {
		return '';
	}

	return abs( floatval( $input ) );
}

/**
 * Sanitize integers that can use negative decimals.
 *
 * @since 3.1.0
 * @param string $input The value to check.
 */
function wi_sanitize_empty_negative_decimal_integer( $input ) {
	if ( '' === $input ) {
		return '';
	}

	return floatval( $input );
}

/**
 * Sanitize a positive number, but allow an empty value.
 *
 * @since 2.2
 * @param string $input The value to check.
 */
function wi_sanitize_empty_absint( $input ) {
	// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison -- Intentially loose.
	if ( '' == $input ) {
		return '';
	}

	return absint( $input );
}

if ( ! function_exists( 'wi_sanitize_checkbox' ) ) {
	/**
	 * Sanitize checkbox values.
	 *
	 * @since 1.0.8
	 * @param string $checked The value to check.
	 */
	function wi_sanitize_checkbox( $checked ) {
		// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison -- Intentially loose.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
}

if ( ! function_exists( 'wi_sanitize_blog_excerpt' ) ) {
	/**
	 * Sanitize blog excerpt.
	 * Needed because GP Premium calls the control ID which is different from the settings ID.
	 *
	 * @since 1.0.8
	 * @param string $input The value to check.
	 */
	function wi_sanitize_blog_excerpt( $input ) {
		$valid = array(
			'full',
			'excerpt',
		);

		if ( in_array( $input, $valid ) ) {
			return $input;
		} else {
			return 'full';
		}
	}
}

if ( ! function_exists( 'wi_sanitize_hex_color' ) ) {
	/**
	 * Sanitize colors.
	 * Allow blank value.
	 *
	 * @since 1.2.9.6
	 * @param string $color The color to check.
	 */
	function wi_sanitize_hex_color( $color ) {
		// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison -- Intentially loose.
		if ( '' === $color ) {
			return '';
		}

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}

		// Sanitize CSS variables.
		if ( strpos( $color, 'var(' ) !== false ) {
			return sanitize_text_field( $color );
		}

		// Sanitize rgb() values.
		if ( strpos( $color, 'rgb(' ) !== false ) {
			$color = str_replace( ' ', '', $color );

			sscanf( $color, 'rgb(%d,%d,%d)', $red, $green, $blue );
			return 'rgb(' . $red . ',' . $green . ',' . $blue . ')';
		}

		// Sanitize rgba() values.
		if ( strpos( $color, 'rgba' ) !== false ) {
			$color = str_replace( ' ', '', $color );
			sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

			return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
		}

		return '';
	}
}

/**
 * Sanitize RGBA colors.
 *
 * @since 2.2
 * @param string $color The color to check.
 */
function wi_sanitize_rgba_color( $color ) {
	if ( '' === $color ) {
		return '';
	}

	if ( false === strpos( $color, 'rgba' ) ) {
		return wi_sanitize_hex_color( $color );
	}

	$color = str_replace( ' ', '', $color );
	sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

	return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
}

if ( ! function_exists( 'wi_sanitize_choices' ) ) {
	/**
	 * Sanitize choices.
	 *
	 * @since 1.3.24
	 * @param string $input The value to check.
	 * @param object $setting The setting object.
	 */
	function wi_sanitize_choices( $input, $setting ) {
		// Ensure input is a slug.
		$input = sanitize_key( $input );

		// Get list of choices from the control.
		// associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it.
		// otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}

/**
 * Sanitize our Google Font variants
 *
 * @since 2.0
 * @param string $input The value to check.
 */
function wi_sanitize_variants( $input ) {
	if ( is_array( $input ) ) {
		$input = implode( ',', $input );
	}
	return sanitize_text_field( $input );
}

add_action( 'customize_controls_enqueue_scripts', 'wi_do_control_inline_scripts', 100 );
/**
 * Add misc inline scripts to our controls.
 *
 * We don't want to add these to the controls themselves, as they will be repeated
 * each time the control is initialized.
 *
 * @since 2.0
 */
function wi_do_control_inline_scripts() {
	wp_localize_script(
		'witheme-typography-customizer',
		'gp_customize',
		array(
			'nonce' => wp_create_nonce( 'gp_customize_nonce' ),
		)
	);

	$number_of_fonts = apply_filters( 'wi_number_of_fonts', 200 );

	wp_localize_script(
		'witheme-typography-customizer',
		'withemeTypography',
		array(
			'googleFonts' => apply_filters( 'wi_typography_customize_list', wi_get_all_google_fonts( $number_of_fonts ) ),
		)
	);

	wp_localize_script( 'witheme-typography-customizer', 'typography_defaults', wi_typography_default_fonts() );

	wp_enqueue_script( 'witheme-customizer-controls', trailingslashit( get_template_directory_uri() ) . 'inc/customizer/controls/js/customizer-controls.js', array( 'customize-controls', 'jquery' ), wi_VERSION, true );
	wp_localize_script( 'witheme-customizer-controls', 'witheme_defaults', wi_get_defaults() );
	wp_localize_script( 'witheme-customizer-controls', 'witheme_color_defaults', wi_get_color_defaults() );
	wp_localize_script( 'witheme-customizer-controls', 'witheme_typography_defaults', wi_get_default_fonts() );
	wp_localize_script( 'witheme-customizer-controls', 'witheme_spacing_defaults', wi_spacing_get_defaults() );

	wp_localize_script(
		'witheme-customizer-controls',
		'withemeCustomizeControls',
		array(
			'mappedTypographyData' => array(
				'typography' => witheme_Typography_Migration::get_mapped_typography_data(),
				'fonts' => witheme_Typography_Migration::get_mapped_font_data(),
			),
		)
	);

	wp_enqueue_script(
		'wi-customizer-controls',
		trailingslashit( get_template_directory_uri() ) . 'assets/dist/customizer.js',
		// We're including wp-color-picker for localized strings, nothing more.
		array( 'lodash', 'react', 'react-dom', 'wp-components', 'wp-element', 'wp-hooks', 'wp-i18n', 'wp-polyfill', 'jquery', 'customize-base', 'customize-controls', 'wp-color-picker' ),
		wi_VERSION,
		true
	);

	if ( function_exists( 'wp_set_script_translations' ) ) {
		wp_set_script_translations( 'wi-customizer-controls', 'witheme' );
	}

	$color_palette = get_theme_support( 'editor-color-palette' );
	$colors = array();

	if ( is_array( $color_palette ) ) {
		foreach ( $color_palette as $key => $value ) {
			foreach ( $value as $color ) {
				$colors[] = array(
					'name' => $color['name'],
					'color' => $color['color'],
				);
			}
		}
	}

	wp_localize_script(
		'wi-customizer-controls',
		'wiCustomizerControls',
		array(
			'palette' => $colors,
			'showGoogleFonts' => apply_filters( 'wi_font_manager_show_google_fonts', true ),
			'colorPickerShouldShift' => function_exists( 'did_filter' ),
		)
	);

	wp_enqueue_style(
		'wi-customizer-controls',
		trailingslashit( get_template_directory_uri() ) . 'assets/dist/style-customizer.css',
		array( 'wp-components' ),
		wi_VERSION
	);

	$global_colors = wi_get_global_colors();
	$global_colors_css = ':root {';

	if ( ! empty( $global_colors ) ) {
		foreach ( (array) $global_colors as $key => $data ) {
			$global_colors_css .= '--' . $data['slug'] . ':' . $data['color'] . ';';
		}
	}

	$global_colors_css .= '}';

	wp_add_inline_style( 'wi-customizer-controls', $global_colors_css );
}

if ( ! function_exists( 'wi_customizer_live_preview' ) ) {
	add_action( 'customize_preview_init', 'wi_customizer_live_preview', 100 );
	/**
	 * Add our live preview scripts
	 *
	 * @since 0.1
	 */
	function wi_customizer_live_preview() {
		$spacing_settings = wp_parse_args(
			get_option( 'wi_spacing_settings', array() ),
			wi_spacing_get_defaults()
		);

		wp_enqueue_script( 'wi-themecustomizer', trailingslashit( get_template_directory_uri() ) . 'inc/customizer/controls/js/customizer-live-preview.js', array( 'customize-preview' ), wi_VERSION, true );

		wp_localize_script(
			'wi-themecustomizer',
			'witheme_live_preview',
			array(
				'mobile' => wi_get_media_query( 'mobile' ),
				'tablet' => wi_get_media_query( 'tablet_only' ),
				'desktop' => wi_get_media_query( 'desktop' ),
				'contentLeft' => absint( $spacing_settings['content_left'] ),
				'contentRight' => absint( $spacing_settings['content_right'] ),
				'isFlex' => wi_is_using_flexbox(),
				'isRTL' => is_rtl(),
			)
		);

		wp_enqueue_script(
			'wi-postMessage',
			trailingslashit( get_template_directory_uri() ) . 'inc/customizer/controls/js/postMessage.js',
			array( 'jquery', 'customize-preview', 'wp-hooks' ),
			wi_VERSION,
			true
		);

		global $wi_customize_fields;
		wp_localize_script( 'wi-postMessage', 'gpPostMessageFields', $wi_customize_fields );
	}
}

/**
 * Check to see if we have a logo or not.
 *
 * Used as an active callback. Calling has_custom_logo creates a PHP notice for
 * multisite users.
 *
 * @since 2.0.1
 */
function wi_has_custom_logo_callback() {
	if ( get_theme_mod( 'custom_logo' ) ) {
		return true;
	}

	return false;
}

/**
 * Save our preset layout controls. These should always save to be "current".
 *
 * @since 2.2
 */
function wi_sanitize_preset_layout() {
	return 'current';
}

/**
 * Display options if we're using the Floats structure.
 */
function wi_is_using_floats_callback() {
	return 'floats' === wi_get_option( 'structure' );
}

/**
 * Callback to determine whether to show the inline logo option.
 */
function wi_show_inline_logo_callback() {
	return 'floats' === wi_get_option( 'structure' ) && wi_has_logo_site_branding();
}
