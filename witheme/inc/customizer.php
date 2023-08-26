<?php
/**
 * Builds our Customizer controls.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'customize_register', 'wi_set_customizer_helpers', 1 );
/**
 * Set up helpers early so they're always available.
 * Other modules might need access to them at some point.
 *
 * @since 2.0
 */
function wi_set_customizer_helpers() {
	require_once trailingslashit( get_template_directory() ) . 'inc/customizer/customizer-helpers.php';
}

if ( ! function_exists( 'wi_customize_register' ) ) {
	add_action( 'customize_register', 'wi_customize_register', 20 );
	/**
	 * Add our base options to the Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	function wi_customize_register( $wp_customize ) {
		if ( version_compare( PHP_VERSION, '5.6', '<' ) ) {
			return;
		}

		$defaults = wi_get_defaults();
		$color_defaults = wi_get_color_defaults();
		$typography_defaults = wi_get_default_fonts();

		if ( $wp_customize->get_control( 'blogdescription' ) ) {
			$wp_customize->get_control( 'blogdescription' )->priority = 3;
			$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		}

		if ( $wp_customize->get_control( 'blogname' ) ) {
			$wp_customize->get_control( 'blogname' )->priority = 1;
			$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		}

		if ( $wp_customize->get_control( 'custom_logo' ) ) {
			$wp_customize->get_setting( 'custom_logo' )->transport = 'refresh';
		}

		if ( method_exists( $wp_customize, 'register_control_type' ) ) {
			$wp_customize->register_control_type( 'wi_Customize_Misc_Control' );
			$wp_customize->register_control_type( 'wi_Range_Slider_Control' );
		}

		if ( method_exists( $wp_customize, 'register_section_type' ) ) {
			$wp_customize->register_section_type( 'witheme_Upsell_Section' );
		}

		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial(
				'blogname',
				array(
					'selector' => '.main-title a',
					'render_callback' => 'wi_customize_partial_blogname',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'blogdescription',
				array(
					'selector' => '.site-description',
					'render_callback' => 'wi_customize_partial_blogdescription',
				)
			);
		}

		

		$wp_customize->add_setting(
			'wi_settings[hide_title]',
			array(
				'default' => $defaults['hide_title'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'wi_settings[hide_title]',
			array(
				'type' => 'checkbox',
				'label' => __( '사이트 제목 숨기기', 'witheme' ),
				'section' => 'title_tagline',
				'priority' => 2,
			)
		);

		$wp_customize->add_setting(
			'wi_settings[hide_tagline]',
			array(
				'default' => $defaults['hide_tagline'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'wi_settings[hide_tagline]',
			array(
				'type' => 'checkbox',
				'label' => __( '태그라인 숨기기', 'witheme' ),
				'section' => 'title_tagline',
				'priority' => 4,
			)
		);

		if ( ! function_exists( 'the_custom_logo' ) ) {
			$wp_customize->add_setting(
				'wi_settings[logo]',
				array(
					'default' => $defaults['logo'],
					'type' => 'option',
					'sanitize_callback' => 'esc_url_raw',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Image_Control(
					$wp_customize,
					'wi_settings[logo]',
					array(
						'label' => __( 'Logo', 'witheme' ),
						'section' => 'title_tagline',
						'settings' => 'wi_settings[logo]',
					)
				)
			);
		}

		$wp_customize->add_setting(
			'wi_settings[retina_logo]',
			array(
				'default' => $defaults['retina_logo'],
				'type' => 'option',
				'sanitize_callback' => 'esc_url_raw',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'wi_settings[retina_logo]',
				array(
					'label' => __( 'Retina Logo', 'witheme' ),
					'section' => 'title_tagline',
					'settings' => 'wi_settings[retina_logo]',
					'active_callback' => 'wi_has_custom_logo_callback',
				)
			)
		);

		$wp_customize->add_setting(
			'wi_settings[logo_width]',
			array(
				'default' => $defaults['logo_width'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_empty_absint',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new wi_Range_Slider_Control(
				$wp_customize,
				'wi_settings[logo_width]',
				array(
					'label' => __( 'Logo Width', 'witheme' ),
					'section' => 'title_tagline',
					'settings' => array(
						'desktop' => 'wi_settings[logo_width]',
					),
					'choices' => array(
						'desktop' => array(
							'min' => 20,
							'max' => 1200,
							'step' => 10,
							'edit' => true,
							'unit' => 'px',
						),
					),
					'active_callback' => 'wi_has_custom_logo_callback',
				)
			)
		);

		$wp_customize->add_setting(
			'wi_settings[inline_logo_site_branding]',
			array(
				'default' => $defaults['inline_logo_site_branding'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'wi_settings[inline_logo_site_branding]',
			array(
				'type' => 'checkbox',
				'label' => esc_html__( 'Place logo next to title', 'witheme' ),
				'section' => 'title_tagline',
				'active_callback' => 'wi_show_inline_logo_callback',
			)
		);

		$wp_customize->add_section(
			'wi_colors_section',
			array(
				'title' => esc_attr__( '색상', 'witheme' ),
				'priority' => 30,
			)
		);

		witheme_Customize_Field::add_title(
			'wi_color_manager_title',
			array(
				'section' => 'wi_colors_section',
				'title' => __( '사이트 전체 색상', 'witheme' ),
			)
		);

		witheme_Customize_Field::add_field(
			'wi_settings[global_colors]',
			'witheme_Customize_React_Control',
			array(
				'default' => $defaults['global_colors'],
				'sanitize_callback' => function( $colors ) {
					if ( ! is_array( $colors ) ) {
						return;
					}

					$new_settings = array();

					foreach ( (array) $colors as $key => $data ) {
						if ( empty( $data['slug'] ) || empty( $data['color'] ) ) {
							continue;
						}

						$slug = preg_replace( '/[^a-z0-9-\s]+/i', '', $data['slug'] );
						$slug = strtolower( $slug );
						$new_settings[ $key ]['name'] = sanitize_text_field( $slug );
						$new_settings[ $key ]['slug'] = sanitize_text_field( $slug );
						$new_settings[ $key ]['color'] = wi_sanitize_rgba_color( $data['color'] );
					}

					// Reset array keys starting at 0.
					$new_settings = array_values( $new_settings );

					return $new_settings;
				},
				'transport' => 'postMessage',
			),
			array(
				'type' => 'wi-color-manager-control',
				'label' => __( 'Choose Color', 'witheme' ),
				'section' => 'wi_colors_section',
				'choices' => array(
					'alpha' => true,
					'showPalette' => false,
					'showReset' => false,
					'showVarName' => true,
				),
			)
		);

		$fields_dir = trailingslashit( get_template_directory() ) . 'inc/customizer/fields';
		require_once $fields_dir . '/body.php';
		require_once $fields_dir . '/top-bar.php';
		require_once $fields_dir . '/header.php';
		require_once $fields_dir . '/primary-navigation.php';

		do_action( 'wi_customize_after_primary_navigation', $wp_customize );

		require_once $fields_dir . '/buttons.php';
		require_once $fields_dir . '/content.php';
		require_once $fields_dir . '/forms.php';
		require_once $fields_dir . '/sidebar-widgets.php';
		require_once $fields_dir . '/footer-widgets.php';
		require_once $fields_dir . '/footer-bar.php';
		require_once $fields_dir . '/back-to-top.php';
		require_once $fields_dir . '/search-modal.php';

		do_action( 'wi_customize_after_controls', $wp_customize );

		$wp_customize->add_section(
			'wi_typography_section',
			array(
				'title' => esc_attr__( '타이포그래피', 'witheme' ),
				'priority' => 35,
				'active_callback' => function() {
					if ( ! wi_is_using_dynamic_typography() ) {
						return false;
					}

					return true;
				},
			)
		);

		witheme_Customize_Field::add_title(
			'wi_font_manager_title',
			array(
				'section' => 'wi_typography_section',
				'title' => __( '폰트 관리자', 'witheme' ),
			)
		);

		witheme_Customize_Field::add_field(
			'wi_settings[font_manager]',
			'witheme_Customize_React_Control',
			array(
				'default' => $defaults['font_manager'],
				'sanitize_callback' => function( $fonts ) {
					if ( ! is_array( $fonts ) ) {
						return;
					}

					$options = array(
						'fontFamily' => 'sanitize_text_field',
						'googleFont' => 'rest_sanitize_boolean',
						'googleFontApi' => 'absint',
						'googleFontCategory' => 'sanitize_text_field',
						'googleFontVariants' => 'sanitize_text_field',
					);

					$new_settings = array();

					foreach ( (array) $fonts as $key => $data ) {
						if ( empty( $data['fontFamily'] ) ) {
							continue;
						}

						foreach ( $options as $option => $sanitize ) {
							if ( array_key_exists( $option, $data ) ) {
								$new_settings[ $key ][ $option ] = $sanitize( $data[ $option ] );
							}
						}
					}

					// Reset array keys starting at 0.
					$new_settings = array_values( $new_settings );

					return $new_settings;
				},
				'transport' => 'refresh',
			),
			array(
				'type' => 'wi-font-manager-control',
				'label' => __( '폰트 추가하기', 'witheme' ),
				'section' => 'wi_typography_section',
			)
		);

		witheme_Customize_Field::add_field(
			'wi_settings[google_font_display]',
			'',
			array(
				'default' => $defaults['google_font_display'],
				'sanitize_callback' => 'wi_sanitize_choices',
				'transport' => 'refresh',
			),
			array(
				'type' => 'select',
				'label' => __( 'Google font-display', 'witheme' ),
				'description' => sprintf(
					'<a href="%s" target="_blank" rel="noreferrer noopener">%s</a>',
					'https://developer.mozilla.org/en-US/docs/Web/CSS/@font-face/font-display',
					esc_html__( 'Learn about font-display', 'witheme' )
				),
				'section' => 'wi_typography_section',
				'choices' => array(
					'auto' => esc_html__( '자동', 'witheme' ),
					'block' => esc_html__( '블록', 'witheme' ),
					'swap' => esc_html__( '스왑', 'witheme' ),
					'fallback' => esc_html__( '폴백', 'witheme' ),
					'optional' => esc_html__( '옵션', 'witheme' ),
				),
				'active_callback' => function() {
					$font_manager = wi_get_option( 'font_manager' );
					$has_google_font = false;

					foreach ( (array) $font_manager as $key => $data ) {
						if ( ! empty( $data['googleFont'] ) ) {
							$has_google_font = true;
							break;
						}
					}

					return $has_google_font;
				},
			)
		);

		witheme_Customize_Field::add_title(
			'wi_typography_manager_title',
			array(
				'section' => 'wi_typography_section',
				'title' => __( '타이핑 매니저', 'witheme' ),
			)
		);

		witheme_Customize_Field::add_field(
			'wi_settings[typography]',
			'witheme_Customize_React_Control',
			array(
				'default' => $defaults['typography'],
				'sanitize_callback' => function( $settings ) {
					if ( ! is_array( $settings ) ) {
						return;
					}

					$options = array(
						'selector' => 'sanitize_text_field',
						'customSelector' => 'sanitize_text_field',
						'fontFamily' => 'sanitize_text_field',
						'fontWeight' => 'sanitize_text_field',
						'textTransform' => 'sanitize_text_field',
						'textDecoration' => 'sanitize_text_field',
						'fontStyle' => 'sanitize_text_field',
						'fontSize' => 'wi_sanitize_empty_decimal_integer',
						'fontSizeTablet' => 'wi_sanitize_empty_decimal_integer',
						'fontSizeMobile' => 'wi_sanitize_empty_decimal_integer',
						'fontSizeUnit' => 'sanitize_text_field',
						'lineHeight' => 'wi_sanitize_empty_decimal_integer',
						'lineHeightTablet' => 'wi_sanitize_empty_decimal_integer',
						'lineHeightMobile' => 'wi_sanitize_empty_decimal_integer',
						'lineHeightUnit' => 'sanitize_text_field',
						'letterSpacing' => 'wi_sanitize_empty_negative_decimal_integer',
						'letterSpacingTablet' => 'wi_sanitize_empty_negative_decimal_integer',
						'letterSpacingMobile' => 'wi_sanitize_empty_negative_decimal_integer',
						'letterSpacingUnit' => 'sanitize_text_field',
						'marginBottom' => 'wi_sanitize_empty_decimal_integer',
						'marginBottomTablet' => 'wi_sanitize_empty_decimal_integer',
						'marginBottomMobile' => 'wi_sanitize_empty_decimal_integer',
						'marginBottomUnit' => 'sanitize_text_field',
						'module' => 'sanitize_text_field',
						'group' => 'sanitize_text_field',
					);

					$new_settings = array();

					foreach ( (array) $settings as $key => $data ) {
						if ( empty( $data['selector'] ) ) {
							continue;
						}

						foreach ( $options as $option => $sanitize ) {
							if ( array_key_exists( $option, $data ) ) {
								$new_settings[ $key ][ $option ] = $sanitize( $data[ $option ] );
							}
						}
					}

					// Reset array keys starting at 0.
					$new_settings = array_values( $new_settings );

					return $new_settings;
				},
				'transport' => 'refresh',
			),
			array(
				'type' => 'wi-typography-control',
				'label' => __( 'Configure', 'witheme' ),
				'section' => 'wi_typography_section',
			)
		);

		if ( ! $wp_customize->get_panel( 'wi_layout_panel' ) ) {
			$wp_customize->add_panel(
				'wi_layout_panel',
				array(
					'priority' => 25,
					'title' => __( '사이트 설정', 'witheme' ),
				)
			);
		}

		$wp_customize->add_section(
			'wi_layout_container',
			array(
				'title' => __( '사이트 넓이', 'witheme' ),
				'priority' => 10,
				'panel' => 'wi_layout_panel',
			)
		);

		$wp_customize->add_setting(
			'wi_settings[container_width]',
			array(
				'default' => $defaults['container_width'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_integer',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			new wi_Range_Slider_Control(
				$wp_customize,
				'wi_settings[container_width]',
				array(
					'type' => 'witheme-range-slider',
					'label' => __( '사이트 넓이', 'witheme' ),
					'section' => 'wi_layout_container',
					'settings' => array(
						'desktop' => 'wi_settings[container_width]',
					),
					'choices' => array(
						'desktop' => array(
							'min' => 700,
							'max' => 2000,
							'step' => 5,
							'edit' => true,
							'unit' => 'px',
						),
					),
					'priority' => 0,
				)
			)
		);

		$wp_customize->add_section(
			'wi_top_bar',
			array(
				'title' => __( '탑 바', 'witheme' ),
				'priority' => 15,
				'panel' => 'wi_layout_panel',
			)
		);

		$wp_customize->add_setting(
			'wi_settings[top_bar_width]',
			array(
				'default' => $defaults['top_bar_width'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'wi_settings[top_bar_width]',
			array(
				'type' => 'select',
				'label' => __( '탑 바 Width', 'witheme' ),
				'section' => 'wi_top_bar',
				'choices' => array(
					'full' => __( 'Full', 'witheme' ),
					'contained' => __( 'Contained', 'witheme' ),
				),
				'settings' => 'wi_settings[top_bar_width]',
				'priority' => 5,
				'active_callback' => 'wi_is_top_bar_active',
			)
		);

		$wp_customize->add_setting(
			'wi_settings[top_bar_inner_width]',
			array(
				'default' => $defaults['top_bar_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'wi_settings[top_bar_inner_width]',
			array(
				'type' => 'select',
				'label' => __( '탑 바 Inner Width', 'witheme' ),
				'section' => 'wi_top_bar',
				'choices' => array(
					'full' => __( 'Full', 'witheme' ),
					'contained' => __( 'Contained', 'witheme' ),
				),
				'settings' => 'wi_settings[top_bar_inner_width]',
				'priority' => 10,
				'active_callback' => 'wi_is_top_bar_active',
			)
		);

		$wp_customize->add_setting(
			'wi_settings[top_bar_alignment]',
			array(
				'default' => $defaults['top_bar_alignment'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'wi_settings[top_bar_alignment]',
			array(
				'type' => 'select',
				'label' => __( '탑 바 Alignment', 'witheme' ),
				'section' => 'wi_top_bar',
				'choices' => array(
					'left' => __( 'Left', 'witheme' ),
					'center' => __( 'Center', 'witheme' ),
					'right' => __( 'Right', 'witheme' ),
				),
				'settings' => 'wi_settings[top_bar_alignment]',
				'priority' => 15,
				'active_callback' => 'wi_is_top_bar_active',
			)
		);

		$wp_customize->add_section(
			'wi_layout_header',
			array(
				'title' => __( '상단바', 'witheme' ),
				'priority' => 20,
				'panel' => 'wi_layout_panel',
			)
		);

		$wp_customize->add_setting(
			'wi_header_helper',
			array(
				'default' => 'current',
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_preset_layout',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'wi_header_helper',
			array(
				'type' => 'select',
				'label' => __( '상단바 형태', 'witheme' ),
				'section' => 'wi_layout_header',
				'choices' => array(
					'current' => __( '기본', 'witheme' ),
					'default' => __( '왼쪽 정렬', 'witheme' ),
					'nav-left' => __( '오른쪽 정렬' ),
					'classic' => __( '클래식', 'witheme' ),
					'nav-before' => __( '상단바 위 메뉴', 'witheme' ),
					'nav-after' => __( '상단바 아래 메뉴', 'witheme' ),
					'nav-before-centered' => __( '상단바 위 메뉴 - 중앙 정렬', 'witheme' ),
					'nav-after-centered' => __( '상단바 아래 메뉴 - 중앙 정렬', 'witheme' ),
				),
				'settings' => 'wi_header_helper',
				'priority' => 4,
			)
		);

		if ( ! $wp_customize->get_setting( 'wi_settings[site_title_font_size]' ) ) {
			$typography_defaults = wi_get_default_fonts();

			$wp_customize->add_setting(
				'wi_settings[site_title_font_size]',
				array(
					'default' => $typography_defaults['site_title_font_size'],
					'type' => 'option',
					'sanitize_callback' => 'absint',
					'transport' => 'postMessage',
				)
			);
		}

		if ( ! $wp_customize->get_setting( 'wi_spacing_settings[header_top]' ) ) {
			$spacing_defaults = wi_spacing_get_defaults();

			$wp_customize->add_setting(
				'wi_spacing_settings[header_top]',
				array(
					'default' => $spacing_defaults['header_top'],
					'type' => 'option',
					'sanitize_callback' => 'absint',
					'transport' => 'postMessage',
				)
			);
		}

		if ( ! $wp_customize->get_setting( 'wi_spacing_settings[header_bottom]' ) ) {
			$spacing_defaults = wi_spacing_get_defaults();

			$wp_customize->add_setting(
				'wi_spacing_settings[header_bottom]',
				array(
					'default' => $spacing_defaults['header_bottom'],
					'type' => 'option',
					'sanitize_callback' => 'absint',
					'transport' => 'postMessage',
				)
			);
		}

		$wp_customize->add_setting(
			'wi_settings[header_layout_setting]',
			array(
				'default' => $defaults['header_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'wi_settings[header_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( '상단바 크기', 'witheme' ),
				'section' => 'wi_layout_header',
				'choices' => array(
					'fluid-header' => __( '전체 화면', 'witheme' ),
					'contained-header' => __( '본문과 똑같이', 'witheme' ),
				),
				'settings' => 'wi_settings[header_layout_setting]',
				'priority' => 5,
			)
		);

		$wp_customize->add_setting(
			'wi_settings[header_inner_width]',
			array(
				'default' => $defaults['header_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'wi_settings[header_inner_width]',
			array(
				'type' => 'select',
				'label' => __( '상단바 내용 정렬', 'witheme' ),
				'section' => 'wi_layout_header',
				'choices' => array(
					'contained' => __( '본문과 똑같이', 'witheme' ),
					'full-width' => __( '전체 화면', 'witheme' ),
				),
				'settings' => 'wi_settings[header_inner_width]',
				'priority' => 6,
			)
		);

		$wp_customize->add_setting(
			'wi_settings[header_alignment_setting]',
			array(
				'default' => $defaults['header_alignment_setting'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'wi_settings[header_alignment_setting]',
			array(
				'type' => 'select',
				'label' => __( '상단바 정렬', 'witheme' ),
				'section' => 'wi_layout_header',
				'choices' => array(
					'left' => __( '좌측', 'witheme' ),
					'center' => __( '중앙', 'witheme' ),
					'right' => __( '우측', 'witheme' ),
				),
				'settings' => 'wi_settings[header_alignment_setting]',
				'priority' => 10,
			)
		);

		$wp_customize->add_section(
			'wi_layout_navigation',
			array(
				'title' => __( '상단바 메뉴', 'witheme' ),
				'priority' => 30,
				'panel' => 'wi_layout_panel',
			)
		);

		$wp_customize->add_setting(
			'wi_settings[nav_layout_setting]',
			array(
				'default' => $defaults['nav_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'wi_settings[nav_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( '메뉴 크기', 'witheme' ),
				'section' => 'wi_layout_navigation',
				'choices' => array(
					'fluid-nav' => __( '전체 화면', 'witheme' ),
					'contained-nav' => __( '본문과 동일', 'witheme' ),
				),
				'settings' => 'wi_settings[nav_layout_setting]',
				'priority' => 15,
			)
		);

		$wp_customize->add_setting(
			'wi_settings[nav_inner_width]',
			array(
				'default' => $defaults['nav_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'wi_settings[nav_inner_width]',
			array(
				'type' => 'select',
				'label' => __( '메뉴 목록 크기', 'witheme' ),
				'section' => 'wi_layout_navigation',
				'choices' => array(
					'contained' => __( '본문과 동일', 'witheme' ),
					'full-width' => __( '전체 화면', 'witheme' ),
				),
				'settings' => 'wi_settings[nav_inner_width]',
				'priority' => 16,
			)
		);

		$wp_customize->add_setting(
			'wi_settings[nav_alignment_setting]',
			array(
				'default' => $defaults['nav_alignment_setting'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'wi_settings[nav_alignment_setting]',
			array(
				'type' => 'select',
				'label' => __( '메뉴 위치', 'witheme' ),
				'section' => 'wi_layout_navigation',
				'choices' => array(
					'left' => __( '왼쪽', 'witheme' ),
					'center' => __( '중앙', 'witheme' ),
					'right' => __( '오른쪽', 'witheme' ),
				),
				'settings' => 'wi_settings[nav_alignment_setting]',
				'priority' => 20,
			)
		);

		$wp_customize->add_setting(
			'wi_settings[nav_position_setting]',
			array(
				'default' => $defaults['nav_position_setting'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
				'transport' => 'refresh',
			)
		);

		$wp_customize->add_control(
			'wi_settings[nav_position_setting]',
			array(
				'type' => 'select',
				'label' => __( '메뉴 위치', 'witheme' ),
				'section' => 'wi_layout_navigation',
				'choices' => array(
					'nav-below-header' => __( '제목 아래', 'witheme' ),
					'nav-above-header' => __( '제목 위', 'witheme' ),
					'nav-float-right' => __( '제목 오른쪽', 'witheme' ),
					'nav-float-left' => __( '제목 왼쪽', 'witheme' ),
					'nav-left-sidebar' => __( '왼쪽 사이드바', 'witheme' ),
					'nav-right-sidebar' => __( '오른쪽 사이드바', 'witheme' ),
					'' => __( '메뉴 숨기기', 'witheme' ),
				),
				'settings' => 'wi_settings[nav_position_setting]',
				'priority' => 22,
			)
		);

		$wp_customize->add_setting(
			'wi_settings[nav_drop_point]',
			array(
				'default' => $defaults['nav_drop_point'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_empty_absint',
			)
		);

		$wp_customize->add_control(
			new wi_Range_Slider_Control(
				$wp_customize,
				'wi_settings[nav_drop_point]',
				array(
					'label' => __( '메뉴바 위치', 'witheme' ),
					'sub_description' => __( '로고 아래로 메뉴바 위치를 변경하는 픽셀', 'witheme' ),
					'section' => 'wi_layout_navigation',
					'settings' => array(
						'desktop' => 'wi_settings[nav_drop_point]',
					),
					'choices' => array(
						'desktop' => array(
							'min' => 500,
							'max' => 2000,
							'step' => 10,
							'edit' => true,
							'unit' => 'px',
						),
					),
					'priority' => 22,
				)
			)
		);

		$wp_customize->add_setting(
			'wi_settings[nav_dropdown_type]',
			array(
				'default' => $defaults['nav_dropdown_type'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'wi_settings[nav_dropdown_type]',
			array(
				'type' => 'select',
				'label' => __( '모바일 메뉴', 'witheme' ),
				'section' => 'wi_layout_navigation',
				'choices' => array(
					'hover' => __( '마우스 오버', 'witheme' ),
					'click' => __( '메뉴 아이템', 'witheme' ),
					'click-arrow' => __( '화살표', 'witheme' ),
				),
				'settings' => 'wi_settings[nav_dropdown_type]',
				'priority' => 22,
			)
		);

		$wp_customize->add_setting(
			'wi_settings[nav_dropdown_direction]',
			array(
				'default' => $defaults['nav_dropdown_direction'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'wi_settings[nav_dropdown_direction]',
			array(
				'type' => 'select',
				'label' => __( '모바일 메뉴바 위치', 'witheme' ),
				'section' => 'wi_layout_navigation',
				'choices' => array(
					'right' => __( '오른쪽', 'witheme' ),
					'left' => __( '왼쪽', 'witheme' ),
				),
				'settings' => 'wi_settings[nav_dropdown_direction]',
				'priority' => 22,
			)
		);

		$wp_customize->add_setting(
			'wi_settings[nav_search]',
			array(
				'default' => $defaults['nav_search'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'wi_settings[nav_search]',
			array(
				'type' => 'select',
				'label' => __( 'Navigation Search', 'witheme' ),
				'section' => 'wi_layout_navigation',
				'choices' => array(
					'enable' => __( 'Enable', 'witheme' ),
					'disable' => __( 'Disable', 'witheme' ),
				),
				'settings' => 'wi_settings[nav_search]',
				'priority' => 23,
				'active_callback' => function() {
					return 'enable' === wi_get_option( 'nav_search' );
				},
			)
		);

		$wp_customize->add_setting(
			'wi_settings[nav_search_modal]',
			array(
				'default' => $defaults['nav_search_modal'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'wi_settings[nav_search_modal]',
			array(
				'type' => 'checkbox',
				'label' => esc_html__( '상단바 검색버튼 활성화하기', 'witheme' ),
				'section' => 'wi_layout_navigation',
				'priority' => 23,
				'active_callback' => function() {
					return 'disable' === wi_get_option( 'nav_search' );
				},
			)
		);

		$wp_customize->add_setting(
			'wi_settings[content_layout_setting]',
			array(
				'default' => $defaults['content_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'wi_settings[content_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( '정렬 방식', 'witheme' ),
				'section' => 'wi_layout_container',
				'choices' => array(
					'separate-containers' => __( '사이드바 분리', 'witheme' ),
					'one-container' => __( '사이드바 통합', 'witheme' ),
				),
				'settings' => 'wi_settings[content_layout_setting]',
				'priority' => 25,
			)
		);

		$wp_customize->add_setting(
			'wi_settings[container_alignment]',
			array(
				'default' => $defaults['container_alignment'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'wi_settings[container_alignment]',
			array(
				'type' => 'select',
				'label' => __( '컨텐츠 정렬', 'witheme' ),
				'section' => 'wi_layout_container',
				'choices' => array(
					'boxes' => __( '박스', 'witheme' ),
					'text' => __( '글자', 'witheme' ),
				),
				'settings' => 'wi_settings[container_alignment]',
				'priority' => 30,
			)
		);

		$wp_customize->add_section(
			'wi_layout_sidebars',
			array(
				'title' => __( '사이드바', 'witheme' ),
				'priority' => 40,
				'panel' => 'wi_layout_panel',
			)
		);

		$wp_customize->add_setting(
			'wi_settings[layout_setting]',
			array(
				'default' => $defaults['layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'wi_settings[layout_setting]',
			array(
				'type' => 'select',
				'label' => __( '기본 사이드바 세팅', 'witheme' ),
				'section' => 'wi_layout_sidebars',
				'choices' => array(
					'left-sidebar' => __( '사이드바 / 블로그 글', 'witheme' ),
					'right-sidebar' => __( '블로그 글 / 사이드바', 'witheme' ),
					'no-sidebar' => __( '블로그 글만', 'witheme' ),
					'both-sidebars' => __( '사이드바 / 블로그 글 / 사이드바', 'witheme' ),
					'both-left' => __( '사이드바 / 사이드바 / 블로그 글', 'witheme' ),
					'both-right' => __( '블로그 글 / 사이드바 / 사이드바', 'witheme' ),
				),
				'settings' => 'wi_settings[layout_setting]',
				'priority' => 30,
			)
		);

		$wp_customize->add_setting(
			'wi_settings[blog_layout_setting]',
			array(
				'default' => $defaults['blog_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'wi_settings[blog_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( '블로그 메인 화면 사이드바 설정', 'witheme' ),
				'section' => 'wi_layout_sidebars',
				'choices' => array(
					'left-sidebar' => __( '사이드바 / 블로그 글', 'witheme' ),
					'right-sidebar' => __( '블로그 글 / 사이드바', 'witheme' ),
					'no-sidebar' => __( '블로그 글만', 'witheme' ),
					'both-sidebars' => __( '사이드바 / 블로그 글 / 사이드바', 'witheme' ),
					'both-left' => __( '사이드바 / 사이드바 / 블로그 글', 'witheme' ),
					'both-right' => __( '블로그 글 / 사이드바 / 사이드바', 'witheme' ),
				),
				'settings' => 'wi_settings[blog_layout_setting]',
				'priority' => 35,
			)
		);

		$wp_customize->add_setting(
			'wi_settings[single_layout_setting]',
			array(
				'default' => $defaults['single_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'wi_settings[single_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( '블로그 글 사이드바 설정', 'witheme' ),
				'section' => 'wi_layout_sidebars',
				'choices' => array(
					'left-sidebar' => __( '사이드바 / 블로그 글', 'witheme' ),
					'right-sidebar' => __( '블로그 글 / 사이드바', 'witheme' ),
					'no-sidebar' => __( '블로그 글만', 'witheme' ),
					'both-sidebars' => __( '사이드바 / 블로그 글 / 사이드바', 'witheme' ),
					'both-left' => __( '사이드바 / 사이드바 / 블로그 글', 'witheme' ),
					'both-right' => __( '블로그 글 / 사이드바 / 사이드바', 'witheme' ),
				),
				'settings' => 'wi_settings[single_layout_setting]',
				'priority' => 36,
			)
		);

		$wp_customize->add_section(
			'wi_layout_footer',
			array(
				'title' => __( '하단바', 'witheme' ),
				'priority' => 50,
				'panel' => 'wi_layout_panel',
			)
		);

		$wp_customize->add_setting(
			'wi_settings[footer_layout_setting]',
			array(
				'default' => $defaults['footer_layout_setting'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'wi_settings[footer_layout_setting]',
			array(
				'type' => 'select',
				'label' => __( '하단바 크기', 'witheme' ),
				'section' => 'wi_layout_footer',
				'choices' => array(
					'fluid-footer' => __( '전체 화면', 'witheme' ),
					'contained-footer' => __( '본문과 동일', 'witheme' ),
				),
				'settings' => 'wi_settings[footer_layout_setting]',
				'priority' => 40,
			)
		);

		$wp_customize->add_setting(
			'wi_settings[footer_inner_width]',
			array(
				'default' => $defaults['footer_inner_width'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'wi_settings[footer_inner_width]',
			array(
				'type' => 'select',
				'label' => __( '하단바 메뉴 설정', 'witheme' ),
				'section' => 'wi_layout_footer',
				'choices' => array(
					'contained' => __( '본문과 동일', 'witheme' ),
					'full-width' => __( '전체 화면', 'witheme' ),
				),
				'settings' => 'wi_settings[footer_inner_width]',
				'priority' => 41,
			)
		);

		$wp_customize->add_setting(
			'wi_settings[footer_widget_setting]',
			array(
				'default' => $defaults['footer_widget_setting'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'wi_settings[footer_widget_setting]',
			array(
				'type' => 'select',
				'label' => __( '하단 위젯 갯수', 'witheme' ),
				'section' => 'wi_layout_footer',
				'choices' => array(
					'0' => '0',
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
				),
				'settings' => 'wi_settings[footer_widget_setting]',
				'priority' => 45,
			)
		);

		$wp_customize->add_setting(
			'wi_settings[footer_bar_alignment]',
			array(
				'default' => $defaults['footer_bar_alignment'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'wi_settings[footer_bar_alignment]',
			array(
				'type' => 'select',
				'label' => __( 'Footer Bar Alignment', 'witheme' ),
				'section' => 'wi_layout_footer',
				'choices' => array(
					'left' => __( 'Left', 'witheme' ),
					'center' => __( 'Center', 'witheme' ),
					'right' => __( 'Right', 'witheme' ),
				),
				'settings' => 'wi_settings[footer_bar_alignment]',
				'priority' => 47,
				'active_callback' => 'wi_is_footer_bar_active',
			)
		);

		$wp_customize->add_setting(
			'wi_settings[back_to_top]',
			array(
				'default' => $defaults['back_to_top'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'wi_settings[back_to_top]',
			array(
				'type' => 'select',
				'label' => __( '도구 모음 활성화 여부', 'witheme' ),
				'section' => 'wi_layout_footer',
				'choices' => array(
					'enable' => __( '활성화하기', 'witheme' ),
					'' => __( '비활성화하기', 'witheme' ),
				),
				'settings' => 'wi_settings[back_to_top]',
				'priority' => 50,
			)
		);

		$wp_customize->add_section(
			'wi_blog_section',
			array(
				'title' => __( '블로그 설정', 'witheme' ),
				'priority' => 55,
				'panel' => 'wi_layout_panel',
			)
		);

		$wp_customize->add_setting(
			'wi_settings[post_content]',
			array(
				'default' => $defaults['post_content'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_blog_excerpt',
			)
		);

		$wp_customize->add_control(
			'blog_content_control',
			array(
				'type' => 'select',
				'label' => __( '블로그 글 목록', 'witheme' ),
				'section' => 'wi_blog_section',
				'choices' => array(
					'full' => __( '전체 내용', 'witheme' ),
					'excerpt' => __( '요약 (추천)', 'witheme' ),
				),
				'settings' => 'wi_settings[post_content]',
				'priority' => 10,
			)
		);

		if ( ! function_exists( 'wi_blog_customize_register' ) && ! defined( 'GP_PREMIUM_VERSION' ) ) {
			$wp_customize->add_control(
				new wi_Customize_Misc_Control(
					$wp_customize,
					'blog_get_addon_desc',
					array(
						'section' => 'wi_blog_section',
						'type' => 'addon',
						'label' => __( 'Learn more', 'witheme' ),
						'description' => __( '블로그 설정에 대해서 더 알고 싶으시다면 아래 버튼을 눌러주세요.', 'witheme' ),
						'url' => wi_get_premium_url( 'https://wi.itcider.com/docs/blogconfig', false ),
						'priority' => 30,
						'settings' => ( isset( $wp_customize->selective_refresh ) ) ? array() : 'blogname',
					)
				)
			);
		}

	

		$wp_customize->add_section(
			'wi_general_section',
			array(
				'title' => __( '아이콘 및 링크 설정', 'witheme' ),
				'priority' => 99,
			)
		);

		if ( ! apply_filters( 'wi_fontawesome_essentials', false ) ) {
			$wp_customize->add_setting(
				'wi_settings[font_awesome_essentials]',
				array(
					'default' => $defaults['font_awesome_essentials'],
					'type' => 'option',
					'sanitize_callback' => 'wi_sanitize_checkbox',
				)
			);

			$wp_customize->add_control(
				'wi_settings[font_awesome_essentials]',
				array(
					'type' => 'checkbox',
					'label' => __( 'Load essential icons only', 'witheme' ),
					'description' => __( 'Load essential Font Awesome icons instead of the full library.', 'witheme' ),
					'section' => 'wi_general_section',
					'settings' => 'wi_settings[font_awesome_essentials]',
				)
			);
		}

		$show_flexbox_option = true;

		if ( defined( 'GP_PREMIUM_VERSION' ) && version_compare( GP_PREMIUM_VERSION, '1.11.0-alpha.1', '<' ) ) {
			$show_flexbox_option = false;
		}

		if ( wi_is_using_flexbox() ) {
			$show_flexbox_option = false;
		}

		$show_flexbox_option = apply_filters( 'wi_show_flexbox_customizer_option', $show_flexbox_option );

		if ( $show_flexbox_option ) {
			$wp_customize->add_setting(
				'wi_settings[structure]',
				array(
					'default' => $defaults['structure'],
					'type' => 'option',
					'sanitize_callback' => 'wi_sanitize_choices',
				)
			);

			$wp_customize->add_control(
				'wi_settings[structure]',
				array(
					'type' => 'select',
					'label' => __( 'Structure', 'witheme' ),
					'section' => 'wi_general_section',
					'choices' => array(
						'flexbox' => __( 'Flexbox', 'witheme' ),
						'floats' => __( 'Floats', 'witheme' ),
					),
					'description' => sprintf(
						'<strong>%1$s</strong> %2$s',
						__( 'Caution:', 'witheme' ),
						sprintf(
							/* translators: Learn more here */
							__( 'Switching your structure can change how your website displays. Review your website thoroughly before publishing this change, or use a staging site to review the potential changes. Learn more %s.', 'witheme' ),
							'<a href="https://wi.itcider.com/docs/" target="_blank" rel="noopener noreferrer">' . __( 'here', 'witheme' ) . '</a>'
						)
					),
					'settings' => 'wi_settings[structure]',
				)
			);
		}

		$wp_customize->add_setting(
			'wi_settings[icons]',
			array(
				'default' => $defaults['icons'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'wi_settings[icons]',
			array(
				'type' => 'select',
				'label' => __( '아이콘 타입', 'witheme' ),
				'section' => 'wi_general_section',
				'choices' => array(
					'svg' => __( 'SVG', 'witheme' ),
					'font' => __( 'Font', 'witheme' ),
				),
				'settings' => 'wi_settings[icons]',
			)
		);

		$wp_customize->add_setting(
			'wi_settings[underline_links]',
			array(
				'default' => $defaults['underline_links'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_choices',
			)
		);

		$wp_customize->add_control(
			'wi_settings[underline_links]',
			array(
				'type' => 'select',
				'label' => __( '링크 밑줄', 'witheme' ),
				'description' => __( '링크 아래에 밑줄이 그어질 것인지 설정합니다.', 'witheme' ),
				'section' => 'wi_general_section',
				'choices' => array(
					'always' => __( '항상', 'witheme' ),
					'hover' => __( '마우스 오버시에', 'witheme' ),
					'not-hover' => __( '마우스 오버가 아닐 시에', 'witheme' ),
					'never' => __( '사용 안 함', 'witheme' ),
				),
				'settings' => 'wi_settings[underline_links]',
			)
		);

		$wp_customize->add_setting(
			'wi_settings[combine_css]',
			array(
				'default' => $defaults['combine_css'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'wi_settings[combine_css]',
			array(
				'type' => 'checkbox',
				'label' => __( 'Combine CSS', 'witheme' ),
				'description' => __( 'Reduce the number of CSS file requests and use a lite version of our grid system.', 'witheme' ),
				'section' => 'wi_general_section',
				'active_callback' => 'wi_is_using_floats_callback',
			)
		);

		$wp_customize->add_setting(
			'wi_settings[dynamic_css_cache]',
			array(
				'default' => $defaults['dynamic_css_cache'],
				'type' => 'option',
				'sanitize_callback' => 'wi_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'wi_settings[dynamic_css_cache]',
			array(
				'type' => 'checkbox',
				'label' => __( '다이나믹 css 캐시하기', 'witheme' ),
				'description' => __( '성능 향상을 위해서 다이나믹 css 사용하기', 'witheme' ),
				'section' => 'wi_general_section',
			)
		);

		$show_legacy_typography_option = true;

		if ( defined( 'GP_PREMIUM_VERSION' ) && version_compare( GP_PREMIUM_VERSION, '2.1.0-alpha.1', '<' ) ) {
			$show_legacy_typography_option = false;
		}

		if ( wi_is_using_dynamic_typography() ) {
			$show_legacy_typography_option = false;
		}

		$show_legacy_typography_option = apply_filters( 'wi_show_legacy_typography_customizer_option', $show_legacy_typography_option );

		if ( $show_legacy_typography_option ) {
			$wp_customize->add_setting(
				'wi_settings[use_dynamic_typography]',
				array(
					'default' => $defaults['use_dynamic_typography'],
					'type' => 'option',
					'sanitize_callback' => 'wi_sanitize_checkbox',
				)
			);

			$wp_customize->add_control(
				'wi_settings[use_dynamic_typography]',
				array(
					'type' => 'checkbox',
					'label' => __( 'Use dynamic typography system', 'witheme' ),
					'description' => sprintf(
						/* translators: Learn more here */
						__( 'Switching to our dynamic typography system can change how your fonts display. Review your website thoroughly before publishing this change. Learn more %s.', 'witheme' ),
						'<a href="https://wi.itcider.com/docs/" target="_blank" rel="noopener noreferrer">' . __( 'here', 'witheme' ) . '</a>'
					),
					'section' => 'wi_general_section',
					'settings' => 'wi_settings[use_dynamic_typography]',
				)
			);
		}
	}
}
