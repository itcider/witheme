<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div class="no-results not-found">
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
			<h1 class="entry-title"><?php _e( '요청하신 페이지가 없습니다. 검색을 해보시겠어요?', 'witheme' ); ?></h1>
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
		?>

		<div class="entry-content">

				<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

					<p>
						<?php
						printf(
							/* translators: 1: Admin URL */
							__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'witheme' ),
							esc_url( admin_url( 'post-new.php' ) )
						);
						?>
					</p>

				<?php elseif ( is_search() ) : ?>

					<p><?php _e( '검색 결과가 없습니다. 다른 검색어를 입력해주세요.', 'witheme' ); ?></p>
					<?php get_search_form(); ?>

				<?php else : ?>

					<p><?php _e( '당신이 입력한 검색어에 대한 결과입니다.', 'witheme' ); ?></p>
					<?php get_search_form(); ?>

				<?php endif; ?>

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
</div>
