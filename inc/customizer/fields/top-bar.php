<?php
/**
 * This file handles the customizer fields for the top bar.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

witheme_Customize_Field::add_title(
	'wi_top_bar_colors_title',
	array(
		'section' => 'wi_colors_section',
		'title' => __( 'Top Bar', 'witheme' ),
		'choices' => array(
			'toggleId' => 'top-bar-colors',
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[top_bar_background_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['top_bar_background_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'wi_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Background', 'witheme' ),
		'section' => 'wi_colors_section',
		'settings' => 'wi_settings[top_bar_background_color]',
		'active_callback' => 'wi_is_top_bar_active',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'top-bar-colors',
		),
		'output' => array(
			array(
				'element'  => '.top-bar',
				'property' => 'background-color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[top_bar_text_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['top_bar_text_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'wi_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Text', 'witheme' ),
		'section' => 'wi_colors_section',
		'active_callback' => 'wi_is_top_bar_active',
		'choices' => array(
			'toggleId' => 'top-bar-colors',
		),
		'output' => array(
			array(
				'element'  => '.top-bar',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_wrapper(
	'wi_top_bar_link_wrapper',
	array(
		'section' => 'wi_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'top-bar-colors',
			'items' => array(
				'top_bar_link_color',
				'top_bar_link_color_hover',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[top_bar_link_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['top_bar_link_color'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'wi_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Link', 'witheme' ),
		'section' => 'wi_colors_section',
		'active_callback' => 'wi_is_top_bar_active',
		'choices' => array(
			'wrapper' => 'top_bar_link_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
			'toggleId' => 'top-bar-colors',
		),
		'output' => array(
			array(
				'element'  => '.top-bar a',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[top_bar_link_color_hover]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['top_bar_link_color_hover'],
		'transport' => 'postMessage',
		'sanitize_callback' => 'wi_sanitize_rgba_color',
	),
	array(
		'label' => __( 'Link Hover', 'witheme' ),
		'section' => 'wi_colors_section',
		'active_callback' => 'wi_is_top_bar_active',
		'choices' => array(
			'wrapper' => 'top_bar_link_color_hover',
			'tooltip' => __( 'Choose Hover Color', 'witheme' ),
			'toggleId' => 'top-bar-colors',
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => '.top-bar a:hover',
				'property' => 'color',
			),
		),
	)
);
