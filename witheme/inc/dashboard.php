<?php
/**
 * Builds our admin page.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'wi_create_menu' ) ) {
	add_action( 'admin_menu', 'wi_create_menu' );
	/**
	 * Adds our "witheme" dashboard menu item
	 *
	 * @since 0.1
	 */
	function wi_create_menu() {
		$wi_page = add_theme_page( esc_html__( 'witheme', 'witheme' ), esc_html__( 'witheme', 'witheme' ), apply_filters( 'wi_dashboard_page_capability', 'edit_theme_options' ), 'wi-options', 'wi_settings_page' );
		add_action( "admin_print_styles-$wi_page", 'wi_options_styles' );
	}
}

if ( ! function_exists( 'wi_options_styles' ) ) {
	/**
	 * Adds any necessary scripts to the GP dashboard page
	 *
	 * @since 0.1
	 */
	function wi_options_styles() {
		wp_enqueue_style( 'wi-options', get_template_directory_uri() . '/assets/css/admin/style.css', array(), wi_VERSION );
	}
}

if ( ! function_exists( 'wi_settings_page' ) ) {
	/**
	 * Builds the content of our GP dashboard page
	 *
	 * @since 0.1
	 */
	function wi_settings_page() {
		?>
		<div class="wrap">
			<div class="metabox-holder">
				<div class="gp-masthead clearfix">
					<div class="gp-container">
						<div class="gp-title">
							<a href="<?php echo wi_get_premium_url( 'https://wi.itcider.com' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in function. ?>" target="_blank">witheme</a> <span class="gp-version"><?php echo esc_html( wi_VERSION ); ?></span>
						</div>
						<div class="gp-masthead-links">
							<?php if ( ! defined( 'GP_PREMIUM_VERSION' ) ) : ?>
								<a style="font-weight: bold;" href="<?php echo wi_get_premium_url( 'https://wi.itcider.com/premium/' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in function. ?>" target="_blank"><?php esc_html_e( 'Premium', 'witheme' ); ?></a>
							<?php endif; ?>
							<a href="<?php echo esc_url( 'https://wi.itcider.com/support' ); ?>" target="_blank"><?php esc_html_e( 'Support', 'witheme' ); ?></a>
							<a href="<?php echo esc_url( 'https://docs.wi.itcider.com' ); ?>" target="_blank"><?php esc_html_e( 'Documentation', 'witheme' ); ?></a>
						</div>
					</div>
				</div>

				<?php
				/**
				 * wi_dashboard_after_header hook.
				 *
				 * @since 2.0
				 */
				do_action( 'wi_dashboard_after_header' );
				?>

				<div class="gp-container">
					<div class="postbox-container clearfix" style="float: none;">
						<div class="grid-container grid-parent">

							<?php
							/**
							 * wi_dashboard_inside_container hook.
							 *
							 * @since 2.0
							 */
							do_action( 'wi_dashboard_inside_container' );
							?>

							<div class="form-metabox grid-70" style="padding-left: 0;">
								<h2 style="height:0;margin:0;"><!-- admin notices below this element --></h2>
								<form method="post" action="options.php">
									<?php settings_fields( 'wi-settings-group' ); ?>
									<?php do_settings_sections( 'wi-settings-group' ); ?>
									<div class="customize-button hide-on-desktop">
										<?php
										printf(
											'<a id="wi_customize_button" class="button button-primary" href="%1$s">%2$s</a>',
											esc_url( admin_url( 'customize.php' ) ),
											esc_html__( 'Customize', 'witheme' )
										);
										?>
									</div>

									<?php
									/**
									 * wi_inside_options_form hook.
									 *
									 * @since 0.1
									 */
									do_action( 'wi_inside_options_form' );
									?>
								</form>

								<?php
								$modules = array(
									'Backgrounds' => array(
										'url' => wi_get_premium_url( 'https://wi.itcider.com/premium/#backgrounds', false ),
									),
									'Blog' => array(
										'url' => wi_get_premium_url( 'https://wi.itcider.com/premium/#blog', false ),
									),
									'Colors' => array(
										'url' => wi_get_premium_url( 'https://wi.itcider.com/premium/#colors', false ),
									),
									'Copyright' => array(
										'url' => wi_get_premium_url( 'https://wi.itcider.com/premium/#copyright', false ),
									),
									'Disable Elements' => array(
										'url' => wi_get_premium_url( 'https://wi.itcider.com/premium/#disable-elements', false ),
									),
									'Elements' => array(
										'url' => wi_get_premium_url( 'https://wi.itcider.com/premium/#elements', false ),
									),
									'Import / Export' => array(
										'url' => wi_get_premium_url( 'https://wi.itcider.com/premium/#import-export', false ),
									),
									'Menu Plus' => array(
										'url' => wi_get_premium_url( 'https://wi.itcider.com/premium/#menu-plus', false ),
									),
									'Secondary Nav' => array(
										'url' => wi_get_premium_url( 'https://wi.itcider.com/premium/#secondary-nav', false ),
									),
									'Sections' => array(
										'url' => wi_get_premium_url( 'https://wi.itcider.com/premium/#sections', false ),
									),
									'Site Library' => array(
										'url' => wi_get_premium_url( 'https://wi.itcider.com/site-library', false ),
									),
									'Spacing' => array(
										'url' => wi_get_premium_url( 'https://wi.itcider.com/premium/#spacing', false ),
									),
									'Typography' => array(
										'url' => wi_get_premium_url( 'https://wi.itcider.com/premium/#typography', false ),
									),
									'WooCommerce' => array(
										'url' => wi_get_premium_url( 'https://wi.itcider.com/premium/#woocommerce', false ),
									),
								);

								if ( ! defined( 'GP_PREMIUM_VERSION' ) ) :
									?>
									<div class="postbox wi-metabox">
										<h3 class="hndle"><?php esc_html_e( 'Premium Modules', 'witheme' ); ?></h3>
										<div class="inside" style="margin:0;padding:0;">
											<div class="premium-addons">
												<?php
												foreach ( $modules as $module => $info ) {
													?>
													<div class="add-on activated gp-clear addon-container grid-parent">
														<div class="addon-name column-addon-name" style="">
															<a href="<?php echo esc_url( $info['url'] ); ?>" target="_blank"><?php echo esc_html( $module ); ?></a>
														</div>
														<div class="addon-action addon-addon-action" style="text-align:right;">
															<a href="<?php echo esc_url( $info['url'] ); ?>" target="_blank"><?php esc_html_e( 'Learn more', 'witheme' ); ?></a>
														</div>
													</div>
													<div class="gp-clear"></div>
												<?php } ?>
											</div>
										</div>
									</div>
									<?php
								endif;

								/**
								 * wi_options_items hook.
								 *
								 * @since 0.1
								 */
								do_action( 'wi_options_items' );

								$typography_section = 'customize.php?autofocus[section]=font_section';
								$colors_section = 'customize.php?autofocus[section]=body_section';

								if ( function_exists( 'witheme_is_module_active' ) ) {
									if ( witheme_is_module_active( 'wi_package_typography', 'wi_TYPOGRAPHY' ) ) {
										$typography_section = 'customize.php?autofocus[panel]=wi_typography_panel';
									}

									if ( witheme_is_module_active( 'wi_package_colors', 'wi_COLORS' ) ) {
										$colors_section = 'customize.php?autofocus[panel]=wi_colors_panel';
									}
								}

								$quick_settings = array(
									'logo' => array(
										'title' => __( 'Upload Logo', 'witheme' ),
										'icon' => 'dashicons-format-image',
										'url' => admin_url( 'customize.php?autofocus[control]=custom_logo' ),
									),
									'typography' => array(
										'title' => __( 'Customize Fonts', 'witheme' ),
										'icon' => 'dashicons-editor-textcolor',
										'url' => admin_url( $typography_section ),
									),
									'colors' => array(
										'title' => __( 'Customize Colors', 'witheme' ),
										'icon' => 'dashicons-admin-customizer',
										'url' => admin_url( $colors_section ),
									),
									'layout' => array(
										'title' => __( 'Layout Options', 'witheme' ),
										'icon' => 'dashicons-layout',
										'url' => admin_url( 'customize.php?autofocus[panel]=wi_layout_panel' ),
									),
									'all' => array(
										'title' => __( 'All Options', 'witheme' ),
										'icon' => 'dashicons-admin-generic',
										'url' => admin_url( 'customize.php' ),
									),
								);
								?>
							</div>

							<div class="wi-right-sidebar grid-30" style="padding-right: 0;">
								<div class="postbox wi-metabox start-customizing">
									<h3 class="hndle"><?php esc_html_e( 'Start Customizing', 'witheme' ); ?></h3>
									<div class="inside">
										<ul>
											<?php
											foreach ( $quick_settings as $key => $data ) {
												printf(
													'<li><span class="dashicons %1$s"></span> <a href="%2$s">%3$s</a></li>',
													esc_attr( $data['icon'] ),
													esc_url( $data['url'] ),
													esc_html( $data['title'] )
												);
											}
											?>
										</ul>

										<p><?php esc_html_e( 'Want to learn more about the theme? Check out our extensive documentation.', 'witheme' ); ?></p>
										<a href="https://docs.wi.itcider.com"><?php esc_html_e( 'Visit documentation &rarr;', 'witheme' ); ?></a>
									</div>
								</div>

								<?php
								/**
								 * wi_admin_right_panel hook.
								 *
								 * @since 0.1
								 */
								do_action( 'wi_admin_right_panel' );
								?>

								<div class="postbox wi-metabox" id="gen-delete">
									<h3 class="hndle"><?php esc_html_e( 'Reset Settings', 'witheme' ); ?></h3>
									<div class="inside">
										<p><?php esc_html_e( 'Deleting your settings can not be undone.', 'witheme' ); ?></p>
										<form method="post">
											<p><input type="hidden" name="wi_reset_customizer" value="wi_reset_customizer_settings" /></p>
											<p>
												<?php
												$warning = 'return confirm("' . esc_html__( 'Warning: This will delete your settings.', 'witheme' ) . '")';
												wp_nonce_field( 'wi_reset_customizer_nonce', 'wi_reset_customizer_nonce' );

												submit_button(
													esc_attr__( 'Reset', 'witheme' ),
													'button-primary',
													'submit',
													false,
													array(
														'onclick' => esc_js( $warning ),
													)
												);
												?>
											</p>

										</form>
										<?php
										/**
										 * wi_delete_settings_form hook.
										 *
										 * @since 0.1
										 */
										do_action( 'wi_delete_settings_form' );
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="gp-options-footer">
						<span>
							<?php
							printf(
								/* translators: %s: Heart icon */
								_x( 'Made with %s by Tom Usborne', 'made with love', 'witheme' ),
								'<span style="color:#D04848" class="dashicons dashicons-heart"></span>'
							);
							?>
						</span>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'wi_reset_customizer_settings' ) ) {
	add_action( 'admin_init', 'wi_reset_customizer_settings' );
	/**
	 * Reset customizer settings
	 *
	 * @since 0.1
	 */
	function wi_reset_customizer_settings() {
		if ( empty( $_POST['wi_reset_customizer'] ) || 'wi_reset_customizer_settings' !== $_POST['wi_reset_customizer'] ) {
			return;
		}

		$nonce = isset( $_POST['wi_reset_customizer_nonce'] ) ? sanitize_key( $_POST['wi_reset_customizer_nonce'] ) : '';

		if ( ! wp_verify_nonce( $nonce, 'wi_reset_customizer_nonce' ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		delete_option( 'wi_settings' );
		delete_option( 'wi_dynamic_css_output' );
		delete_option( 'wi_dynamic_css_cached_version' );
		remove_theme_mod( 'font_body_variants' );
		remove_theme_mod( 'font_body_category' );

		wp_safe_redirect( admin_url( 'themes.php?page=wi-options&status=reset' ) );
		exit;
	}
}

if ( ! function_exists( 'wi_admin_errors' ) ) {
	add_action( 'admin_notices', 'wi_admin_errors' );
	/**
	 * Add our admin notices
	 *
	 * @since 0.1
	 */
	function wi_admin_errors() {
		$screen = get_current_screen();

		if ( 'appearance_page_wi-options' !== $screen->base ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) && 'true' === $_GET['settings-updated'] ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Only checking. False positive.
			add_settings_error( 'wi-notices', 'true', esc_html__( 'Settings saved.', 'witheme' ), 'updated' );
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Only checking. False positive.
		if ( isset( $_GET['status'] ) && 'imported' === $_GET['status'] ) {
			add_settings_error( 'wi-notices', 'imported', esc_html__( 'Import successful.', 'witheme' ), 'updated' );
		}

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Only checking. False positive.
		if ( isset( $_GET['status'] ) && 'reset' === $_GET['status'] ) {
			add_settings_error( 'wi-notices', 'reset', esc_html__( 'Settings removed.', 'witheme' ), 'updated' );
		}

		settings_errors( 'wi-notices' );
	}
}
