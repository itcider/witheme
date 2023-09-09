<?php
/**
 * This file handles the customizer fields for the Body.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

witheme_Customize_Field::add_title(
	'wi_forms_colors_title',
	array(
		'section' => 'wi_colors_section',
		'title' => __( 'Forms', 'witheme' ),
		'choices' => array(
			'toggleId' => 'form-colors',
		),
	)
);

witheme_Customize_Field::add_wrapper(
	'wi_forms_background_wrapper',
	array(
		'section' => 'wi_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'form-colors',
			'items' => array(
				'form_background_color',
				'form_background_color_focus',
			),
		),
	)
);

$forms_selector = 'input[type="text"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], input[type="number"], input[type="tel"], textarea, select';
$forms_focus_selector = 'input[type="text"]:focus, input[type="email"]:focus, input[type="url"]:focus, input[type="password"]:focus, input[type="search"]:focus, input[type="number"]:focus, input[type="tel"]:focus, textarea:focus, select:focus';

witheme_Customize_Field::add_field(
	'wi_settings[form_background_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['form_background_color'],
		'sanitize_callback' => 'wi_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'form-colors',
			'wrapper' => 'form_background_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
		),
		'output' => array(
			array(
				'element'  => $forms_selector,
				'property' => 'background-color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[form_background_color_focus]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['form_background_color_focus'],
		'sanitize_callback' => 'wi_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background Focus', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'form-colors',
			'wrapper' => 'form_background_color_focus',
			'tooltip' => __( 'Choose Focus Color', 'witheme' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => $forms_focus_selector,
				'property' => 'background-color',
			),
		),
	)
);

witheme_Customize_Field::add_wrapper(
	'wi_forms_text_wrapper',
	array(
		'section' => 'wi_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'form-colors',
			'items' => array(
				'form_text_color',
				'form_text_color_focus',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[form_text_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['form_text_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'form-colors',
			'wrapper' => 'form_text_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
		),
		'output' => array(
			array(
				'element'  => $forms_selector,
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[form_text_color_focus]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['form_text_color_focus'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text Focus', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'form-colors',
			'wrapper' => 'form_text_color_focus',
			'tooltip' => __( 'Choose Focus Color', 'witheme' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => $forms_focus_selector,
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_wrapper(
	'wi_forms_border_wrapper',
	array(
		'section' => 'wi_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'form-colors',
			'items' => array(
				'form_border_color',
				'form_border_color_focus',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[form_border_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['form_border_color'],
		'sanitize_callback' => 'wi_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Border', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'form-colors',
			'wrapper' => 'form_border_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
		),
		'output' => array(
			array(
				'element'  => $forms_selector,
				'property' => 'border-color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[form_border_color_focus]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['form_border_color_focus'],
		'sanitize_callback' => 'wi_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Border Focus', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'form-colors',
			'wrapper' => 'form_border_color_focus',
			'tooltip' => __( 'Choose Focus Color', 'witheme' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => $forms_focus_selector,
				'property' => 'border-color',
			),
		),
	)
);
