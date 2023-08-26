<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to wi_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

/**
 * wi_before_comments hook.
 *
 * @since 0.1
 */
do_action( 'wi_before_comments' );
?>
<div id="comments">

	<?php
	/**
	 * wi_inside_comments hook.
	 *
	 * @since 1.3.47
	 */
	do_action( 'wi_inside_comments' );

	if ( have_comments() ) :
		$comments_number = get_comments_number();
		$comments_title = apply_filters(
			'wi_comment_form_title',
			sprintf(
				esc_html(
					/* translators: 1: number of comments, 2: post title */
					_nx(
						'%1$s개의 댓글이 있습니다. &ldquo;%2$s&rdquo;',
						'%1$s개의 댓글들이 있습니다. &ldquo;%2$s&rdquo;',
						$comments_number,
						'comments title',
						'witheme'
					)
				),
				number_format_i18n( $comments_number ),
				get_the_title()
			)
		);

		// phpcs:ignore -- Title escaped in output.
		echo apply_filters(
			'wi_comments_title_output',
			sprintf(
				'<h3 class="comments-title">%s</h3>',
				esc_html( $comments_title )
			),
			$comments_title,
			$comments_number
		);

		/**
		 * wi_below_comments_title hook.
		 *
		 * @since 0.1
		 */
		do_action( 'wi_below_comments_title' );

		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
			?>
			<nav id="comment-nav-above" class="comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'witheme' ); ?></h2>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; 이전 댓글 보기', 'witheme' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( '최신 댓글 보기 &rarr;', 'witheme' ) ); ?></div>
			</nav><!-- #comment-nav-above -->
		<?php endif; ?>

		<ol class="comment-list">
			<?php
			/*
			 * Loop through and list the comments. Tell wp_list_comments()
			 * to use wi_comment() to format the comments.
			 * If you want to override this in a child theme, then you can
			 * define wi_comment() and that will be used instead.
			 * See wi_comment() in inc/template-tags.php for more.
			 */
			wp_list_comments(
				array(
					'callback' => 'wi_comment',
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
			?>
			<nav id="comment-nav-below" class="comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'witheme' ); ?></h2>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; 이전 댓글 보기', 'witheme' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( '최신 댓글 보기 &rarr;', 'witheme' ) ); ?></div>
			</nav><!-- #comment-nav-below -->
			<?php
		endif;

	endif;

	// phpcs:ignore WordPress.PHP.StrictComparisons.LooseComparison
	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="no-comments"><?php esc_html_e( '댓글 입력이 불가합니다.', 'witheme' ); ?></p>
		<?php
	endif;

	comment_form();
	?>

</div><!-- #comments -->
