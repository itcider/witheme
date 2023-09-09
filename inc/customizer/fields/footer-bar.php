<?php
/**
 * This file handles the customizer fields for the footer bar.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

witheme_Customize_Field::add_title(
	'wi_footer_bar_colors_title',
	array(
		'section' => 'wi_colors_section',
		'title' => __( 'Footer Bar', 'witheme' ),
		'choices' => array(
			'toggleId' => 'footer-bar-colors',
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[footer_background_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_background_color'],
		'sanitize_callback' => 'wi_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'footer-bar-colors',
			'wrapper' => 'footer_background_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
		),
		'output' => array(
			array(
				'element'  => '.site-info',
				'property' => 'background-color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[footer_text_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_text_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'footer-bar-colors',
			'wrapper' => 'footer_text_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
		),
		'output' => array(
			array(
				'element'  => '.site-info',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_wrapper(
	'wi_footer_bar_colors_wrapper',
	array(
		'section' => 'wi_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'footer-bar-colors',
			'items' => array(
				'footer_link_color',
				'footer_link_hover_color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[footer_link_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_link_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'footer-bar-colors',
			'wrapper' => 'footer_link_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
		),
		'output' => array(
			array(
				'element'  => '.site-info a',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[footer_link_hover_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_link_hover_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link Hover', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'footer-bar-colors',
			'wrapper' => 'footer_link_hover_color',
			'tooltip' => __( 'Choose Hover Color', 'witheme' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => '.site-info a:hover',
				'property' => 'color',
			),
		),
	)
);
