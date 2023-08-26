<?php
/**
 * This file handles the customizer fields for the content.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // No direct access, please.
}

witheme_Customize_Field::add_title(
	'wi_content_colors_title',
	array(
		'section' => 'wi_colors_section',
		'title' => __( 'Content', 'witheme' ),
		'choices' => array(
			'toggleId' => 'content-colors',
		),
	)
);

$content_colors = '.separate-containers .inside-article, .separate-containers .comments-area, .separate-containers .page-header, .one-container .container, .separate-containers .paging-navigation, .inside-page-header';

witheme_Customize_Field::add_field(
	'wi_settings[content_background_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['content_background_color'],
		'sanitize_callback' => 'wi_sanitize_rgba_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Background', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'alpha' => true,
			'toggleId' => 'content-colors',
		),
		'output' => array(
			array(
				'element'  => $content_colors,
				'property' => 'background-color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[content_text_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['content_text_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Text', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'content-colors',
		),
		'output' => array(
			array(
				'element'  => $content_colors,
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_wrapper(
	'wi_content_link_wrapper',
	array(
		'section' => 'wi_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'content-colors',
			'items' => array(
				'content_link_color',
				'content_link_hover_color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[content_link_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['content_link_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'wrapper' => 'content_link_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
			'toggleId' => 'content-colors',
		),
		'output' => array(
			array(
				'element'  => '.inside-article a:not(.button):not(.wp-block-button__link), .inside-article a:not(.button):not(.wp-block-button__link):visited, .paging-navigation a, .paging-navigation a:visited, .comments-area a, .comments-area a:visited, .page-header a, .page-header a:visited',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[content_link_hover_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['content_link_hover_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Link Hover', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'wrapper' => 'content_link_hover_color',
			'tooltip' => __( 'Choose Hover Color', 'witheme' ),
			'toggleId' => 'content-colors',
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => '.inside-article a:not(.button):not(.wp-block-button__link):hover, .paging-navigation a:hover, .comments-area a:hover, .page-header a:hover',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[content_title_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['content_title_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Content Title', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'content-colors',
		),
		'output' => array(
			array(
				'element'  => '.entry-header h1,.page-header h1',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_wrapper(
	'wi_archive_content_title_link_wrapper',
	array(
		'section' => 'wi_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'content-colors',
			'items' => array(
				'blog_post_title_color',
				'blog_post_title_hover_color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[blog_post_title_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['blog_post_title_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Archive Content Title', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'wrapper' => 'blog_post_title_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
			'toggleId' => 'content-colors',
		),
		'output' => array(
			array(
				'element'  => '.entry-title a,.entry-title a:visited',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[blog_post_title_hover_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['blog_post_title_hover_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Archive Content Title Hover', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'wrapper' => 'blog_post_title_hover_color',
			'tooltip' => __( 'Choose Hover Color', 'witheme' ),
			'toggleId' => 'content-colors',
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => '.entry-title a:hover',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[entry_meta_text_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['entry_meta_text_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Entry Meta Text', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'toggleId' => 'content-colors',
		),
		'output' => array(
			array(
				'element'  => '.entry-meta',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_wrapper(
	'wi_entry_meta_link_wrapper',
	array(
		'section' => 'wi_colors_section',
		'choices' => array(
			'type' => 'color',
			'toggleId' => 'content-colors',
			'items' => array(
				'entry_meta_link_color',
				'entry_meta_link_color_hover',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[entry_meta_link_color]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['entry_meta_link_color'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Entry Meta Links', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'wrapper' => 'entry_meta_link_color',
			'tooltip' => __( 'Choose Initial Color', 'witheme' ),
			'toggleId' => 'content-colors',
		),
		'output' => array(
			array(
				'element'  => '.entry-meta a',
				'property' => 'color',
			),
		),
	)
);

witheme_Customize_Field::add_field(
	'wi_settings[entry_meta_link_color_hover]',
	'witheme_Customize_Color_Control',
	array(
		'default' => $color_defaults['entry_meta_link_color_hover'],
		'sanitize_callback' => 'wi_sanitize_hex_color',
		'transport' => 'postMessage',
	),
	array(
		'label' => __( 'Entry Meta Links Hover', 'witheme' ),
		'section' => 'wi_colors_section',
		'choices' => array(
			'wrapper' => 'entry_meta_link_color_hover',
			'tooltip' => __( 'Choose Hover Color', 'witheme' ),
			'toggleId' => 'content-colors',
			'hideLabel' => true,
		),
		'output' => array(
			array(
				'element'  => '.entry-meta a:hover',
				'property' => 'color',
			),
		),
	)
);

$headings = array(
	array(
		'slug' => 'h1_color',
		'label' => __( 'Heading 1 (H1) Color', 'witheme' ),
		'selector' => 'h1',
	),
	array(
		'slug' => 'h2_color',
		'label' => __( 'Heading 2 (H2) Color', 'witheme' ),
		'selector' => 'h2',
	),
	array(
		'slug' => 'h3_color',
		'label' => __( 'Heading 3 (H3) Color', 'witheme' ),
		'selector' => 'h3',
	),
	array(
		'slug' => 'h4_color',
		'label' => __( 'Heading 4 (H4) Color', 'witheme' ),
		'selector' => 'h4',
	),
	array(
		'slug' => 'h5_color',
		'label' => __( 'Heading 5 (H5) Color', 'witheme' ),
		'selector' => 'h5',
	),
	array(
		'slug' => 'h6_color',
		'label' => __( 'Heading 6 (H6) Color', 'witheme' ),
		'selector' => 'h6',
	),
);

foreach ( $headings as $heading ) {
	witheme_Customize_Field::add_field(
		'wi_settings[' . $heading['slug'] . ']',
		'witheme_Customize_Color_Control',
		array(
			'default' => $color_defaults[ $heading['slug'] ],
			'sanitize_callback' => 'wi_sanitize_hex_color',
			'transport' => 'postMessage',
		),
		array(
			'label' => $heading['label'],
			'section' => 'wi_colors_section',
			'choices' => array(
				'toggleId' => 'content-colors',
			),
			'output' => array(
				array(
					'element'  => $heading['selector'],
					'property' => 'color',
				),
			),
		)
	);
}
