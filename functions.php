<?php
/**
 * witheme.
 *
 * Please do not make any edits to this file. All edits should be done in a child theme.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Set our theme version.
define( 'wi_VERSION', '3.3.2' );

if ( ! function_exists( 'wi_setup' ) ) {
	add_action( 'after_setup_theme', 'wi_setup' );
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since 0.1
	 */
	function wi_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'witheme' );

		// Add theme support for various features.
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'status' ) );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ) );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );

		$color_palette = wi_get_editor_color_palette();

		if ( ! empty( $color_palette ) ) {
			add_theme_support( 'editor-color-palette', $color_palette );
		}

		add_theme_support(
			'custom-logo',
			array(
				'height' => 70,
				'width' => 350,
				'flex-height' => true,
				'flex-width' => true,
			)
		);

		// Register primary menu.
		register_nav_menus(
			array(
				'primary' => __( '상단바 메뉴', 'witheme' ),
			)
		);

		/**
		 * Set the content width to something large
		 * We set a more accurate width in wi_smart_content_width()
		 */
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 1200; /* pixels */
		}

		// Add editor styles to the block editor.
		add_theme_support( 'editor-styles' );

		$editor_styles = apply_filters(
			'wi_editor_styles',
			array(
				'assets/css/admin/block-editor.css',
			)
		);

		add_editor_style( $editor_styles );
	}
}

/**
 * Get all necessary theme files
 */
$theme_dir = get_template_directory();

require $theme_dir . '/inc/theme-functions.php';
require $theme_dir . '/inc/defaults.php';
require $theme_dir . '/inc/class-css.php';
require $theme_dir . '/inc/css-output.php';
require $theme_dir . '/inc/general.php';
require $theme_dir . '/inc/customizer.php';
require $theme_dir . '/inc/markup.php';
require $theme_dir . '/inc/typography.php';
require $theme_dir . '/inc/plugin-compat.php';
require $theme_dir . '/inc/block-editor.php';
require $theme_dir . '/inc/class-typography.php';
require $theme_dir . '/inc/class-typography-migration.php';
require $theme_dir . '/inc/class-html-attributes.php';
require $theme_dir . '/inc/class-theme-update.php';
require $theme_dir . '/inc/class-rest.php';
require $theme_dir . '/inc/deprecated.php';

if ( is_admin() ) {
	require $theme_dir . '/inc/meta-box.php';
	require $theme_dir . '/inc/class-dashboard.php';
}

/**
 * Load our theme structure
 */
require $theme_dir . '/inc/structure/archives.php';
require $theme_dir . '/inc/structure/comments.php';
require $theme_dir . '/inc/structure/featured-images.php';
require $theme_dir . '/inc/structure/footer.php';
require $theme_dir . '/inc/structure/header.php';
require $theme_dir . '/inc/structure/navigation.php';
require $theme_dir . '/inc/structure/post-meta.php';
require $theme_dir . '/inc/structure/sidebars.php';
require $theme_dir . '/inc/structure/search-modal.php';
remove_filter( 'comment_text', 'make_clickable', 9 );
add_filter('comment_form_default_fields', 'website_remove');
function website_remove($fields)
{
   if(isset($fields['url']))
   unset($fields['url']);
   return $fields;
}
function the_breadcrumb() {
    global $post;
    echo '<nav role="navigation" aria-label="Breadcrumbs" class="bf-breadcrumb clearfix bc-top-style"><ul id="breadcrumbs" itemscope="" itemtype="http://schema.org/BreadcrumbList"><meta name="numberOfItems" content="4"><meta name="itemListOrder" content="Ascending">';
    if (!is_home()) {
        echo '<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem" class="bf-breadcrumb-item bf-breadcrumb-begin"> <span itemprop="name"><a itemprop="item" href="';
        echo get_option('home');
        echo '">';
        echo get_bloginfo( 'name' ); 
        echo '<meta itemprop="position" content="1"></a></li> &#62; ';
        if (is_category() || is_single()) {
            echo '</span><li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem" class="bf-breadcrumb-item"> <span itemprop="name"><meta itemprop="position" content="2"><a itemprop="item" config=';
            the_category(' </span></li> &#62; <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem" class="bf-breadcrumb-item"> <span itemprop="name">');
            if (is_single()) {
                echo '</span><meta itemprop="position" content="3"></li> &#62; <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem" class="bf-breadcrumb-item bf-breadcrumb-end"><meta itemprop="position" content="4"> <span itemprop="name">';
                the_title();
                echo '';
            }
        } elseif (is_page()) {
            if($post->post_parent){
                $anc = get_post_ancestors( $post->ID );
                $title = get_the_title();
                foreach ( $anc as $ancestor ) {
                    $output = '<a itemprop="item" href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a> &#62; ';
                }
                echo $output;
                echo '<strong title="'.$title.'"> '.$title.'</strong>';
            } else {
                echo '<strong> '.get_the_title().'</strong>';
            }
        }
    }
    elseif (is_tag()) {single_tag_title();}
    elseif (is_day()) {echo"Archive for "; the_time('F jS, Y'); echo'';}
    elseif (is_month()) {echo"Archive for "; the_time('F, Y'); echo'';}
    elseif (is_year()) {echo"Archive for "; the_time('Y'); echo'';}
    elseif (is_author()) {echo"Author Archive"; echo'';}
    elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "Blog Archives"; echo'';}
    elseif (is_search()) {echo"Search Results"; echo'';}
}
