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
	'wi_body_colors_title',
	array(
		'section' => 'wi_colors_section',
		'title' => __( 'Body', 'witheme' ),
		'choices' => array(
			'toggleId' => 'base-colors',
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[background_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $defaults['background_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'base-colors',
		),
		'output' => array(
			array(
				'element'  => 'body',
				'property' => 'background-color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[text_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $defaults['text_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'base-colors',
		),
		'output' => array(
			array(
				'element'  => 'body',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_wrapper(
	'wi_body_link_wrapper',
	array(
		'section' => 'wi_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'base-colors',
			'items' => array(
				'link_color',
				'link_color_hover',
				'link_color_visited',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[link_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $defaults['link_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'wrapper' => 'link_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
			'toggleId' => 'base-colors',
		),
		'output' => array(
			array(
				'element'  => 'a, a:visited',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[link_color_hover]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $defaults['link_color_hover'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link Hover', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'wrapper' => 'link_color_hover',
			'tooltip' => __( 'Choose Hover Color', 'witheme' ),
			'toggleId' => 'base-colors',
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => 'a:hover',
				'property' => 'color',
			),
		),
	)
);

if ( '' !== wi_get_option( 'link_color_visited' ) ) {
	witheme_Customize_Field::add_field(
		'wi_settings[link_color_visited]',
		'witheme_Customize_Color_Control',
		array(
			'default' => $defaults['link_color_visited'],
			'sanitize_callback' => 'wi_sanitize_hex_color',
			'transport' => 'refresh',
		),
		array(
			'label' => __( 'Link Color Visited', 'witheme' ),
			'section' => 'wi_colors_section',
			'choices' => array(
				'wrapper' => 'link_color_visited',
				'tooltip' => __( 'Choose Visited Color', 'witheme' ),
				'toggleId' => 'base-colors',
				'hideLabel' => true,
			),
		)
	);
}
