<?php
/**
 * The template for displaying single posts.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php wi_do_microdata( 'article' ); ?>>
	<div class="inside-article">
	<?php the_breadcrumb(); ?>
	<?php
		echo '</span>';
	?>
	<meta itemprop="item" content="https://<?php echo $_SERVER[ "HTTP_HOST" ]; ?><?php echo $_SERVER[ "REQUEST_URI" ]; ?>">
	<?php
		echo '</li></ul></nav>';
	?>
		<?php
		/**
		 * wi_before_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked wi_featured_page_header_inside_single - 10
		 */
		do_action( 'wi_before_content' );

		if ( wi_show_entry_header() ) :
			?>
			<header <?php wi_do_attr( 'entry-header' ); ?>>
				<?php
				/**
				 * wi_before_entry_title hook.
				 *
				 * @since 0.1
				 */
				do_action( 'wi_before_entry_title' );

				if ( wi_show_title() ) {
					$params = wi_get_the_title_parameters();

					the_title( $params['before'], $params['after'] );
				}

				/**
				 * wi_after_entry_title hook.
				 *
				 * @since 0.1
				 *
				 * @hooked wi_post_meta - 10
				 */
				do_action( 'wi_after_entry_title' );
				?>
			</header>
			<?php
		endif;

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

			<div class="book-toc">
				<p class="toc_title"></p>
			</div>
		<div class="entry-content"<?php echo $itemprop; // phpcs:ignore -- No escaping needed. ?>>
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'witheme' ),
					'after'  => '</div>',
				)
			);
			?>
			<div class="related-posts">
				<h3><?php $categories = get_the_category();
echo esc_html( $categories[0]->name ); ?></span> 카테고리의 다른 글</h3>
<?php 
$post_id = get_the_ID();
    $cat_ids = array();
    $categories = get_the_category( $post_id );

    if(!empty($categories) && is_wp_error($categories)):
        foreach ($categories as $category):
            array_push($cat_ids, $category->term_id);
        endforeach;
    endif;

    $current_post_type = get_post_type($post_id);
    $query_args = array( 

        'category__in' => wp_get_post_categories($post->ID),
        'post_type'      => $current_post_type,
        'post__not_in' => array(get_the_ID()),
        'posts_per_page'  => '5',
	'orderby' => 'rand'

     );

    $related_cats_post = new WP_Query( $query_args );

    if($related_cats_post->have_posts()):
         while($related_cats_post->have_posts()): $related_cats_post->the_post(); ?>
            <ul>
				<a href="<?php the_permalink(); ?>">
					<li>
							<?php the_title(); ?>                 
					</li>
				</a>
            </ul>
        <?php endwhile;

        // Restore original Post Data
        wp_reset_postdata();
     endif; ?>
</div><!-- 관련 글 -->
		</div>
		

		<?php
		/**
		 * wi_after_entry_content hook.
		 *
		 * @since 0.1
		 *
		 * @hooked wi_footer_meta - 10
		 */
		do_action( 'wi_after_entry_content' );

		/**
		 * wi_after_content hook.
		 *
		 * @since 0.1
		 */
		do_action( 'wi_after_content' );
		?>
		
	</div>
</article>
