<?php
/**
 * This file handles the customizer fields for the back to top button.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

witheme_Customize_Field::add_title(
	'wi_back_to_top_colors_title',
	array(
		'section' => 'wi_colors_section',
		'title' => __( 'Back to Top', 'witheme' ),
		'choices' => array(
			'toggleId' => 'back-to-top-colors',
		),
		'active_callback' => function() {
			if ( wi_get_option( 'back_to_top' ) ) {
				return true;
			}

			return false;
		},
	)
);

witheme_Customize_Field::add_wrapper(
	'wi_back_to_top_background_wrapper',
	array(
		'section' => 'wi_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'back-to-top-colors',
			'items' => array(
				'back_to_top_background_color',
				'back_to_top_background_color_hover',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[back_to_top_background_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['back_to_top_background_color'],
		'sanitize_callback' => 'wi_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'back-to-top-colors',
			'wrapper' => 'back_to_top_background_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
		),
		'output' => array(
			array(
				'element'  => 'a.wi-back-to-top',
				'property' => 'background-color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[back_to_top_background_color_hover]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['back_to_top_background_color_hover'],
		'sanitize_callback' => 'wi_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background Hover', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'back-to-top-colors',
			'wrapper' => 'back_to_top_background_color_hover',
			'tooltip' => __( 'Choose Hover Color', 'witheme' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => 'a.wi-back-to-top:hover, a.wi-back-to-top:focus',
				'property' => 'background-color',
			),
		),
	)
);

witheme_Customize_Field::add_wrapper(
	'wi_back_to_top_text_wrapper',
	array(
		'section' => 'wi_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'back-to-top-colors',
			'items' => array(
				'back_to_top_text_color',
				'back_to_top_text_color_hover',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[back_to_top_text_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['back_to_top_text_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'button-colors',
			'wrapper' => 'back_to_top_text_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
		),
		'output' => array(
			array(
				'element'  => 'a.wi-back-to-top',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[back_to_top_text_color_hover]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['back_to_top_text_color_hover'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text Hover', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'back-to-top-colors',
			'wrapper' => 'back_to_top_text_color_hover',
			'tooltip' => __( 'Choose Hover Color', 'witheme' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => 'a.wi-back-to-top:hover, a.wi-back-to-top:focus',
				'property' => 'color',
			),
		),
	)
);
