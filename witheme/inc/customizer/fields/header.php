<?php
/**
 * This file handles the customizer fields for the header.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

witheme_Customize_Field::add_title(
	'wi_header_colors_title',
	array(
		'section' => 'wi_colors_section',
		'title' => __( 'Header', 'witheme' ),
		'choices' => array(
			'toggleId' => 'header-colors',
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[header_background_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['header_background_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'wi_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Background', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'header-colors',
		),
		'output' => array(
			array(
				'element'  => '.site-header',
				'property' => 'background-color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[header_text_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['header_text_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'wi_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Text', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'header-colors',
		),
		'output' => array(
			array(
				'element'  => '.site-header',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_wrapper(
	'wi_header_link_wrapper',
	array(
		'section' => 'wi_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'header-colors',
			'items' => array(
				'header_link_color',
				'header_link_hover_color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[header_link_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['header_link_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'wi_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Link', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'header-colors',
			'wrapper' => 'header_link_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
		),
		'output' => array(
			array(
				'element'  => '.site-header a:not([rel="home"])',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[header_link_hover_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['header_link_hover_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'wi_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Link Hover', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'header-colors',
			'wrapper' => 'header_link_hover_color',
			'tooltip' => __( 'Choose Hover Color', 'witheme' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => '.site-header a:not([rel="home"]):hover',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[site_title_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['site_title_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'wi_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Site Title', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'header-colors',
		),
		'output' => array(
			array(
				'element'  => '.main-title a, .main-title a:hover',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[site_tagline_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['site_tagline_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'wi_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Tagline', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'header-colors',
		),
		'output' => array(
			array(
				'element'  => '.site-description',
				'property' => 'color',
			),
		),
	)
);
