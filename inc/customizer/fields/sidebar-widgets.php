<?php
/**
 * This file handles the customizer fields for the sidebar widgets.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

witheme_Customize_Field::add_title(
	'wi_sidebar_widgets_colors_title',
	array(
		'section' => 'wi_colors_section',
		'title' => __( 'Sidebar Widgets', 'witheme' ),
		'choices' => array(
			'toggleId' => 'sidebar-widget-colors',
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[sidebar_widget_background_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['sidebar_widget_background_color'],
		'sanitize_callback' => 'wi_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'sidebar-widget-colors',
			'wrapper' => 'sidebar_widget_background_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
		),
		'output' => array(
			array(
				'element'  => '.sidebar .widget',
				'property' => 'background-color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[sidebar_widget_text_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['sidebar_widget_text_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'sidebar-widget-colors',
			'wrapper' => 'sidebar_widget_text_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
		),
		'output' => array(
			array(
				'element'  => '.sidebar .widget',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_wrapper(
	'wi_sidebar_widget_colors_wrapper',
	array(
		'section' => 'wi_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'sidebar-widget-colors',
			'items' => array(
				'sidebar_widget_link_color',
				'sidebar_widget_link_hover_color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[sidebar_widget_link_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['sidebar_widget_link_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'sidebar-widget-colors',
			'wrapper' => 'sidebar_widget_link_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
		),
		'output' => array(
			array(
				'element'  => '.sidebar .widget a',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[sidebar_widget_link_hover_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['sidebar_widget_link_hover_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link Hover', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'sidebar-widget-colors',
			'wrapper' => 'sidebar_widget_link_hover_color',
			'tooltip' => __( 'Choose Hover Color', 'witheme' ),
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => '.sidebar .widget a:hover',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[sidebar_widget_title_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['sidebar_widget_title_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Widget Title', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'sidebar-widget-colors',
		),
		'output' => array(
			array(
				'element'  => '.sidebar .widget .widget-title',
				'property' => 'color',
			),
		),
	)
);
