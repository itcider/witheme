<?php
/**
 * This file handles the customizer fields for the Search Modal.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

witheme_Customize_Field::add_title(
	'wi_search_modal_colors_title',
	array(
		'section' => 'wi_colors_section',
		'title' => __( 'Search Modal', 'witheme' ),
		'choices' => array(
			'toggleId' => 'search-modal-colors',
		),
		'active_callback' => function() {
			if ( wi_get_option( 'nav_search_modal' ) ) {
				return true;
			}

			return false;
		},
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[search_modal_bg_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['search_modal_bg_color'],
		'sanitize_callback' => 'wi_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Field Background', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'search-modal-colors',
		),
		'output' => array(
			array(
				'element'  => ':root',
				'property' => '--gp-search-modal-bg-color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[search_modal_text_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['search_modal_text_color'],
		'sanitize_callback' => 'wi_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Field Text', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'search-modal-colors',
		),
		'output' => array(
			array(
				'element'  => ':root',
				'property' => '--gp-search-modal-text-color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[search_modal_overlay_bg_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['search_modal_overlay_bg_color'],
		'sanitize_callback' => 'wi_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Overlay Background', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'search-modal-colors',
		),
		'output' => array(
			array(
				'element'  => ':root',
				'property' => '--gp-search-modal-overlay-bg-color',
			),
		),
	)
);
