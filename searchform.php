<?php
/**
 * The template for displaying search forms in wi
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo apply_filters( 'wi_search_label', _x( 'Search for:', 'label', 'witheme' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr( apply_filters( 'wi_search_placeholder', _x( 'Search &hellip;', 'placeholder', 'witheme' ) ) ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" title="<?php echo esc_attr( apply_filters( 'wi_search_label', _x( 'Search for:', 'label', 'witheme' ) ) ); ?>">
	</label>
	<?php
	if ( wi_is_using_flexbox() ) {
		printf(
			'<button class="search-submit" aria-label="%1$s">%2$s</button>',
			esc_attr( apply_filters( 'wi_search_button', _x( 'Search', 'submit button', 'witheme' ) ) ),
			wi_get_svg_icon( 'search' ) // phpcs:ignore -- Escaping not necessary here.
		);
	} else {
		printf(
			'<input type="submit" class="search-submit" value="%s">',
			apply_filters( 'wi_search_button', _x( 'Search', 'submit button', 'witheme' ) ) // phpcs:ignore -- Escaping not necessary here.
		);
	}
	?>
</form>
