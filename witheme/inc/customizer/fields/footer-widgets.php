<?php
/**
 * This file handles the customizer fields for the footer widgets.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

witheme_Customize_Field::add_title(
	'wi_footer_widgets_colors_title',
	array(
		'section' => 'wi_colors_section',
		'title' => __( 'Footer Widgets', 'witheme' ),
		'choices' => array(
			'toggleId' => 'footer-widget-colors',
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[footer_widget_background_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_widget_background_color'],
		'sanitize_callback' => 'wi_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'footer-widget-colors',
			'wrapper' => 'footer_widget_background_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
		),
		'output' => array(
			array(
				'element'  => '.footer-widgets',
				'property' => 'background-color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[footer_widget_text_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_widget_text_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'footer-widget-colors',
			'wrapper' => 'footer_widget_text_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
		),
		'output' => array(
			array(
				'element'  => '.footer-widgets',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_wrapper(
	'wi_footer_widget_colors_wrapper',
	array(
		'section' => 'wi_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'footer-widget-colors',
			'items' => array(
				'footer_widget_link_color',
				'footer_widget_link_hover_color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[footer_widget_link_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_widget_link_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'footer-widget-colors',
			'wrapper' => 'footer_widget_link_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
		),
		'output' => array(
			array(
				'element'  => '.footer-widgets a',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[footer_widget_link_hover_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_widget_link_hover_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link Hover', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'footer-widget-colors',
			'wrapper' => 'footer_widget_link_hover_color',
			'tooltip' => __( 'Choose Hover Color', 'witheme' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => '.footer-widgets a:hover',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[footer_widget_title_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['footer_widget_title_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Widget Title', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'footer-widget-colors',
		),
		'output' => array(
			array(
				'element'  => '.footer-widgets .widget-title',
				'property' => 'color',
			),
		),
	)
);
