<?php
/**
 * The template for displaying 404 pages.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="inside-article">

	<?php
	/**
	 * wi_before_content hook.
	 *
	 * @since 0.1
	 *
	 * @hooked wi_featured_page_header_inside_single - 10
	 */
	do_action( 'wi_before_content' );
	?>

	<header <?php wi_do_attr( 'entry-header' ); ?>>
		<?php // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML is allowed in filter here. ?>
		<h1 class="entry-title" itemprop="headline"><?php echo apply_filters( 'wi_404_title', __( '죄송합니다. 원하시는 정보를 찾지 못했습니다.', 'witheme' ) ); ?></h1>
	</header>

	<?php
	/**
	 * wi_after_entry_header hook.
	 *
	 * @since 0.1
	 *
	 * @hooked wi_post_image - 10
	 */
	do_action( 'wi_after_entry_header' );

	$itemprop = '';

	if ( 'microdata' === wi_get_schema_type() ) {
		$itemprop = ' itemprop="text"';
	}
	?>

	<div class="entry-content"<?php echo $itemprop; // phpcs:ignore -- No escaping needed. ?>>
		<?php
		printf(
			'<p>%s</p>',
			apply_filters( 'wi_404_text', __( '현재 찾으시는 페이지가 없어보여요. 검색해보시겠어요?', 'witheme' ) ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- HTML is allowed in filter here.
		);

		get_search_form();
		?>
	</div>

	<?php
	/**
	 * wi_after_content hook.
	 *
	 * @since 0.1
	 */
	do_action( 'wi_after_content' );
	?>

</div>
