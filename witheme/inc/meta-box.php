<?php
/**
 * Builds our main Layout meta box.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'admin_enqueue_scripts', 'wi_enqueue_meta_box_scripts' );
/**
 * Adds any scripts for this meta box.
 *
 * @since 2.0
 *
 * @param string $hook The current admin page.
 */
function wi_enqueue_meta_box_scripts( $hook ) {
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		$post_types = get_post_types( array( 'public' => true ) );
		$screen = get_current_screen();
		$post_type = $screen->id;

		if ( in_array( $post_type, (array) $post_types ) ) {
			wp_enqueue_style( 'wi-layout-metabox', get_template_directory_uri() . '/assets/css/admin/meta-box.css', array(), wi_VERSION );
		}
	}
}

add_action( 'add_meta_boxes', 'wi_register_layout_meta_box' );
/**
 * wi the layout metabox
 *
 * @since 2.0
 */
function wi_register_layout_meta_box() {
	if ( ! current_user_can( apply_filters( 'wi_metabox_capability', 'edit_theme_options' ) ) ) {
		return;
	}

	if ( ! defined( 'wi_LAYOUT_META_BOX' ) ) {
		define( 'wi_LAYOUT_META_BOX', true );
	}

	global $post;

	$blog_id = get_option( 'page_for_posts' );

	// No need for the Layout metabox on the blog page.
	if ( isset( $post->ID ) && $blog_id && (int) $blog_id === (int) $post->ID ) {
		return;
	}

	$post_types = get_post_types( array( 'public' => true ) );

	foreach ( $post_types as $type ) {
		if ( 'attachment' !== $type ) {
			add_meta_box(
				'wi_layout_options_meta_box',
				esc_html__( 'Layout', 'witheme' ),
				'wi_do_layout_meta_box',
				$type,
				'side'
			);
		}
	}
}

/**
 * Build our meta box.
 *
 * @since 2.0
 *
 * @param object $post All post information.
 */
function wi_do_layout_meta_box( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'wi_layout_nonce' );
	$stored_meta = (array) get_post_meta( $post->ID );
	$stored_meta['_wi-sidebar-layout-meta'][0] = ( isset( $stored_meta['_wi-sidebar-layout-meta'][0] ) ) ? $stored_meta['_wi-sidebar-layout-meta'][0] : '';
	$stored_meta['_wi-footer-widget-meta'][0] = ( isset( $stored_meta['_wi-footer-widget-meta'][0] ) ) ? $stored_meta['_wi-footer-widget-meta'][0] : '';
	$stored_meta['_wi-full-width-content'][0] = ( isset( $stored_meta['_wi-full-width-content'][0] ) ) ? $stored_meta['_wi-full-width-content'][0] : '';
	$stored_meta['_wi-disable-headline'][0] = ( isset( $stored_meta['_wi-disable-headline'][0] ) ) ? $stored_meta['_wi-disable-headline'][0] : '';

	$tabs = apply_filters(
		'wi_metabox_tabs',
		array(
			'sidebars' => array(
				'title' => esc_html__( 'Sidebars', 'witheme' ),
				'target' => '#wi-layout-sidebars',
				'class' => 'current',
			),
			'footer_widgets' => array(
				'title' => esc_html__( 'Footer Widgets', 'witheme' ),
				'target' => '#wi-layout-footer-widgets',
				'class' => '',
			),
			'disable_elements' => array(
				'title' => esc_html__( 'Disable Elements', 'witheme' ),
				'target' => '#wi-layout-disable-elements',
				'class' => '',
			),
			'container' => array(
				'title' => esc_html__( 'Content Container', 'witheme' ),
				'target' => '#wi-layout-page-builder-container',
				'class' => '',
			),
		)
	);
	?>
	<script>
		jQuery(document).ready(function($) {
			$( '.wi-meta-box-menu li a' ).on( 'click', function( event ) {
				event.preventDefault();
				$( this ).parent().addClass( 'current' );
				$( this ).parent().siblings().removeClass( 'current' );
				var tab = $( this ).attr( 'data-target' );

				// Page header module still using href.
				if ( ! tab ) {
					tab = $( this ).attr( 'href' );
				}

				$( '.wi-meta-box-content' ).children( 'div' ).not( tab ).css( 'display', 'none' );
				$( tab ).fadeIn( 100 );
			});
		});
	</script>
	<div id="wi-meta-box-container">
		<ul class="wi-meta-box-menu">
			<?php
			foreach ( (array) $tabs as $tab => $data ) {
				echo '<li class="' . esc_attr( $data['class'] ) . '"><a data-target="' . esc_attr( $data['target'] ) . '" href="#">' . esc_html( $data['title'] ) . '</a></li>';
			}

			do_action( 'wi_layout_meta_box_menu_item' );
			?>
		</ul>
		<div class="wi-meta-box-content">
			<div id="wi-layout-sidebars">
				<div class="wi_layouts">
					<label for="wi-sidebar-layout" class="wi-layout-metabox-section-title"><?php esc_html_e( '사이드바 설정', 'witheme' ); ?></label>

					<select name="_wi-sidebar-layout-meta" id="wi-sidebar-layout">
						<option value="" <?php selected( $stored_meta['_wi-sidebar-layout-meta'][0], '' ); ?>><?php esc_html_e( '기본', 'witheme' ); ?></option>
						<option value="right-sidebar" <?php selected( $stored_meta['_wi-sidebar-layout-meta'][0], '우측 사이드바' ); ?>><?php esc_html_e( '우측 사이드바', 'witheme' ); ?></option>
						<option value="left-sidebar" <?php selected( $stored_meta['_wi-sidebar-layout-meta'][0], '좌측 사이드바' ); ?>><?php esc_html_e( '좌측 사이드바', 'witheme' ); ?></option>
						<option value="no-sidebar" <?php selected( $stored_meta['_wi-sidebar-layout-meta'][0], '본문만' ); ?>><?php esc_html_e( '본문만', 'witheme' ); ?></option>
						<option value="both-sidebars" <?php selected( $stored_meta['_wi-sidebar-layout-meta'][0], '좌우 사이드바 모두' ); ?>><?php esc_html_e( '좌우 사이드바 모두', 'witheme' ); ?></option>
						<option value="both-left" <?php selected( $stored_meta['_wi-sidebar-layout-meta'][0], '모두 왼쪽' ); ?>><?php esc_html_e( '모두 왼쪽', 'witheme' ); ?></option>
						<option value="both-right" <?php selected( $stored_meta['_wi-sidebar-layout-meta'][0], '모두 오른쪽' ); ?>><?php esc_html_e( '모두 오른쪽', 'witheme' ); ?></option>
					</select>
				</div>
			</div>

			<div id="wi-layout-footer-widgets" style="display: none;">
				<div class="wi_footer_widget">
					<label for="wi-footer-widget" class="wi-layout-metabox-section-title"><?php esc_html_e( '하단 위젯', 'witheme' ); ?></label>

					<select name="_wi-footer-widget-meta" id="wi-footer-widget">
						<option value="" <?php selected( $stored_meta['_wi-footer-widget-meta'][0], '' ); ?>><?php esc_html_e( '기본', 'witheme' ); ?></option>
						<option value="0" <?php selected( $stored_meta['_wi-footer-widget-meta'][0], '0' ); ?>><?php esc_html_e( '0개의 하단위젯', 'witheme' ); ?></option>
						<option value="1" <?php selected( $stored_meta['_wi-footer-widget-meta'][0], '1' ); ?>><?php esc_html_e( '1개의 하단위젯', 'witheme' ); ?></option>
						<option value="2" <?php selected( $stored_meta['_wi-footer-widget-meta'][0], '2' ); ?>><?php esc_html_e( '2개의 하단위젯', 'witheme' ); ?></option>
						<option value="3" <?php selected( $stored_meta['_wi-footer-widget-meta'][0], '3' ); ?>><?php esc_html_e( '3개의 하단위젯', 'witheme' ); ?></option>
						<option value="4" <?php selected( $stored_meta['_wi-footer-widget-meta'][0], '4' ); ?>><?php esc_html_e( '4개의 하단위젯', 'witheme' ); ?></option>
						<option value="5" <?php selected( $stored_meta['_wi-footer-widget-meta'][0], '5' ); ?>><?php esc_html_e( '5개의 하단위젯', 'witheme' ); ?></option>
					</select>
				</div>
			</div>
			<div id="wi-layout-page-builder-container" style="display: none;">
				<label for="_wi-full-width-content" class="wi-layout-metabox-section-title"><?php esc_html_e( '본문', 'witheme' ); ?></label>

				<p class="page-builder-content" style="color:#666;font-size:13px;margin-top:0;">
					<?php esc_html_e( '본문 크기를 설정하세요.', 'witheme' ); ?>
				</p>

				<select name="_wi-full-width-content" id="_wi-full-width-content">
					<option value="" <?php selected( $stored_meta['_wi-full-width-content'][0], '' ); ?>><?php esc_html_e( '기본', 'witheme' ); ?></option>
					<option value="true" <?php selected( $stored_meta['_wi-full-width-content'][0], 'true' ); ?>><?php esc_html_e( '전체 화면', 'witheme' ); ?></option>
					<option value="contained" <?php selected( $stored_meta['_wi-full-width-content'][0], 'contained' ); ?>><?php esc_html_e( '포함됨', 'witheme' ); ?></option>
				</select>
			</div>
			<div id="wi-layout-disable-elements" style="display: none;">
				<label class="wi-layout-metabox-section-title"><?php esc_html_e( '요소 비활성화하기', 'witheme' ); ?></label>
				<?php if ( ! defined( 'wi_DE_VERSION' ) ) : ?>
					<div class="wi_disable_elements">
						<label for="meta-wi-disable-headline" style="display:block;margin: 0 0 1em;" title="<?php esc_attr_e( '본문 제목', 'witheme' ); ?>">
							<input type="checkbox" name="_wi-disable-headline" id="meta-wi-disable-headline" value="true" <?php checked( $stored_meta['_wi-disable-headline'][0], 'true' ); ?>>
							<?php esc_html_e( '본문 제목', 'witheme' ); ?>
						</label>

						<?php if ( ! defined( 'GP_PREMIUM_VERSION' ) ) : ?>
							<span style="display:block;padding-top:1em;border-top:1px solid #EFEFEF;">
								<a href="<?php echo wi_get_premium_url( 'https://wi.itcider.com/docs' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in function. ?>" target="_blank"><?php esc_html_e( '공식 문서 보기', 'witheme' ); ?></a>
							</span>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php do_action( 'wi_layout_disable_elements_section', $stored_meta ); ?>
			</div>
			<?php do_action( 'wi_layout_meta_box_content', $stored_meta ); ?>
		</div>
	</div>
	<?php
}

add_action( 'save_post', 'wi_save_layout_meta_data' );
/**
 * Saves the sidebar layout meta data.
 *
 * @since 2.0
 * @param int $post_id Post ID.
 */
function wi_save_layout_meta_data( $post_id ) {
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST['wi_layout_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['wi_layout_nonce'] ), basename( __FILE__ ) ) ) ? true : false;

	if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	$sidebar_layout_key   = '_wi-sidebar-layout-meta';
	$sidebar_layout_value = isset( $_POST[ $sidebar_layout_key ] )
		? sanitize_text_field( wp_unslash( $_POST[ $sidebar_layout_key ] ) )
		: '';

	if ( $sidebar_layout_value ) {
		update_post_meta( $post_id, $sidebar_layout_key, $sidebar_layout_value );
	} else {
		delete_post_meta( $post_id, $sidebar_layout_key );
	}

	$footer_widget_key   = '_wi-footer-widget-meta';
	$footer_widget_value = isset( $_POST[ $footer_widget_key ] )
		? sanitize_text_field( wp_unslash( $_POST[ $footer_widget_key ] ) )
		: '';

	// Check for empty string to allow 0 as a value.
	if ( '' !== $footer_widget_value ) {
		update_post_meta( $post_id, $footer_widget_key, $footer_widget_value );
	} else {
		delete_post_meta( $post_id, $footer_widget_key );
	}

	$page_builder_container_key   = '_wi-full-width-content';
	$page_builder_container_value = isset( $_POST[ $page_builder_container_key ] )
		? sanitize_text_field( wp_unslash( $_POST[ $page_builder_container_key ] ) )
		: '';

	if ( $page_builder_container_value ) {
		update_post_meta( $post_id, $page_builder_container_key, $page_builder_container_value );
	} else {
		delete_post_meta( $post_id, $page_builder_container_key );
	}

	// We only need this if the Disable Elements module doesn't exist.
	if ( ! defined( 'wi_DE_VERSION' ) ) {
		$disable_content_title_key   = '_wi-disable-headline';
		$disable_content_title_value = isset( $_POST[ $disable_content_title_key ] )
			? sanitize_text_field( wp_unslash( $_POST[ $disable_content_title_key ] ) )
			: '';

		if ( $disable_content_title_value ) {
			update_post_meta( $post_id, $disable_content_title_key, $disable_content_title_value );
		} else {
			delete_post_meta( $post_id, $disable_content_title_key );
		}
	}

	do_action( 'wi_layout_meta_box_save', $post_id );
}
