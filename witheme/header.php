<?php
/**
 * The template for displaying the header.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php wi_do_microdata( 'body' ); ?>>
	<?php
	/**
	 * wp_body_open hook.
	 *
	 * @since 2.3
	 */
	do_action( 'wp_body_open' ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- core WP hook.

	/**
	 * wi_before_header hook.
	 *
	 * @since 0.1
	 *
	 * @hooked wi_do_skip_to_content_link - 2
	 * @hooked wi_top_bar - 5
	 * @hooked wi_add_navigation_before_header - 5
	 */
	do_action( 'wi_before_header' );

	/**
	 * wi_header hook.
	 *
	 * @since 1.3.42
	 *
	 * @hooked wi_construct_header - 10
	 */
	do_action( 'wi_header' );

	/**
	 * wi_after_header hook.
	 *
	 * @since 0.1
	 *
	 * @hooked wi_featured_page_header - 10
	 */
	do_action( 'wi_after_header' );
	?>

	<div <?php wi_do_attr( 'page' ); ?>>
		<?php
		/**
		 * wi_inside_site_container hook.
		 *
		 * @since 2.4
		 */
		do_action( 'wi_inside_site_container' );
		?>
		<div <?php wi_do_attr( 'site-content' ); ?>>
			<?php
			/**
			 * wi_inside_container hook.
			 *
			 * @since 0.1
			 */
			do_action( 'wi_inside_container' );
