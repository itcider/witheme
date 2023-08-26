<?php
/**
 * Footer elements.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'wi_construct_footer' ) ) {
	add_action( 'wi_footer', 'wi_construct_footer' );
	/**
	 * Build our footer.
	 *
	 * @since 1.3.42
	 */
	function wi_construct_footer() {
		?>
		<footer <?php wi_do_attr( 'site-info' ); ?>>
			<div <?php wi_do_attr( 'inside-site-info' ); ?>>
				<?php
				/**
				 * wi_before_copyright hook.
				 *
				 * @since 0.1
				 *
				 * @hooked wi_footer_bar - 15
				 */
				do_action( 'wi_before_copyright' );
				?>
				<div class="copyright-bar">
					<?php
					/**
					 * wi_credits hook.
					 *
					 * @since 0.1
					 *
					 * @hooked wi_add_footer_info - 10
					 */
					do_action( 'wi_credits' );
					?>
				</div>
			</div>
		</footer>
		<?php
	}
}

if ( ! function_exists( 'wi_footer_bar' ) ) {
	add_action( 'wi_before_copyright', 'wi_footer_bar', 15 );
	/**
	 * Build our footer bar
	 *
	 * @since 1.3.42
	 */
	function wi_footer_bar() {
		if ( ! is_active_sidebar( 'footer-bar' ) ) {
			return;
		}
		?>
		<div class="footer-bar">
			<?php dynamic_sidebar( 'footer-bar' ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'wi_add_footer_info' ) ) {
	add_action( 'wi_credits', 'wi_add_footer_info' );
	/**
	 * Add the copyright to the footer
	 *
	 * @since 0.1
	 */
	function wi_add_footer_info() {
		$copyright = sprintf(
			'<span class="copyright">&copy; %1$s %2$s</span> <br> %4$s <a href="%3$s"%6$s>%5$s</a>',
			date( 'Y' ), // phpcs:ignore
			get_bloginfo( 'name' ),
			esc_url( 'https://wi.itcider.com' ),
			_x( '', 'witheme', 'witheme' ),
			__( 'Wi theme v3.3.1 by itcider', 'witheme' ),
			'microdata' === wi_get_schema_type() ? ' itemprop="url"' : ''
		);

		echo apply_filters( 'wi_copyright', $copyright ); // phpcs:ignore
	}
}

/**
 * Build our individual footer widgets.
 * Displays a sample widget if no widget is found in the area.
 *
 * @since 2.0
 *
 * @param int $widget_width The width class of our widget.
 * @param int $widget The ID of our widget.
 */
function wi_do_footer_widget( $widget_width, $widget ) {
	$widget_classes = sprintf(
		'footer-widget-%s',
		absint( $widget )
	);

	if ( ! wi_is_using_flexbox() ) {
		$widget_width = apply_filters( "wi_footer_widget_{$widget}_width", $widget_width );
		$tablet_widget_width = apply_filters( "wi_footer_widget_{$widget}_tablet_width", '50' );

		$widget_classes = sprintf(
			'footer-widget-%1$s grid-parent grid-%2$s tablet-grid-%3$s mobile-grid-100',
			absint( $widget ),
			absint( $widget_width ),
			absint( $tablet_widget_width )
		);
	}
	?>
	<div class="<?php echo $widget_classes; // phpcs:ignore ?>">
		<?php dynamic_sidebar( 'footer-' . absint( $widget ) ); ?>
	</div>
	<?php
}

if ( ! function_exists( 'wi_construct_footer_widgets' ) ) {
	add_action( 'wi_footer', 'wi_construct_footer_widgets', 5 );
	/**
	 * Build our footer widgets.
	 *
	 * @since 1.3.42
	 */
	function wi_construct_footer_widgets() {
		// Get how many widgets to show.
		$widgets = wi_get_footer_widgets();

		if ( ! empty( $widgets ) && 0 !== $widgets ) :

			// If no footer widgets exist, we don't need to continue.
			if ( ! is_active_sidebar( 'footer-1' ) && ! is_active_sidebar( 'footer-2' ) && ! is_active_sidebar( 'footer-3' ) && ! is_active_sidebar( 'footer-4' ) && ! is_active_sidebar( 'footer-5' ) ) {
				return;
			}

			// Set up the widget width.
			$widget_width = '';

			if ( 1 === (int) $widgets ) {
				$widget_width = '100';
			}

			if ( 2 === (int) $widgets ) {
				$widget_width = '50';
			}

			if ( 3 === (int) $widgets ) {
				$widget_width = '33';
			}

			if ( 4 === (int) $widgets ) {
				$widget_width = '25';
			}

			if ( 5 === (int) $widgets ) {
				$widget_width = '20';
			}
			?>
			<div id="footer-widgets" class="site footer-widgets">
				<div <?php wi_do_attr( 'footer-widgets-container' ); ?>>
					<div class="inside-footer-widgets">
						<?php
						if ( $widgets >= 1 ) {
							wi_do_footer_widget( $widget_width, 1 );
						}

						if ( $widgets >= 2 ) {
							wi_do_footer_widget( $widget_width, 2 );
						}

						if ( $widgets >= 3 ) {
							wi_do_footer_widget( $widget_width, 3 );
						}

						if ( $widgets >= 4 ) {
							wi_do_footer_widget( $widget_width, 4 );
						}

						if ( $widgets >= 5 ) {
							wi_do_footer_widget( $widget_width, 5 );
						}
						?>
					</div>
				</div>
			</div>
			<?php
		endif;

		/**
		 * wi_after_footer_widgets hook.
		 *
		 * @since 0.1
		 */
		do_action( 'wi_after_footer_widgets' );
	}
}


if ( ! function_exists( 'wi_back_to_top' ) ) {
	add_action( 'wi_after_footer', 'wi_back_to_top' );
	/**
	 * Build the back to top button
	 *
	 * @since 1.3.24
	 */

	function wi_back_to_top() {
		$wi_settings = wp_parse_args(
			get_option( 'wi_settings', array() ),
			wi_get_defaults()
		);

		if ( 'enable' !== $wi_settings['back_to_top'] ) {
			return;
		}
		
		echo apply_filters( // phpcs:ignore
			'wi_back_to_top_output',
			sprintf(
				'
				<div class="sharebtn">
					<ul class="btnconf">
						<li class="lefttoolbox">
							<a title="%1$s" onclick="clip(); return false;"  aria-label="%1$s" rel="nofollow" href="#" id="wi-url" class="wi-url" data-scroll-speed="%2$s" data-start-scroll="%3$s">
								<img src="/wp-content/themes/witheme/img/url.png" width="40" height="40" alt="링크 복사하기">
							</a>
							<a title="%1$s" aria-label="%1$s" rel="nofollow" id="wi-share" class="wi-share" data-scroll-speed="%2$s" data-start-scroll="%3$s" onclick="snsShare(&#039;title&#039;,&#039;url&#039;)">
								<img src="/wp-content/themes/witheme/img/share.png" width="40" height="40" alt="링크 복사하기">
							</a>
						</li>
						<li class="righttoolbox">
							<a title="%1$s" aria-label="%1$s" rel="nofollow" href="https://ohon.net" id="wi-search" class="wi-search" data-scroll-speed="%2$s" data-start-scroll="%3$s">
								<img src="/wp-content/themes/witheme/img/search.png" width="40" height="40" alt="링크 복사하기">
							</a>
							<a title="%1$s" aria-label="%1$s" rel="nofollow" href="#" class="wi-back-to-top" id="wi-back-to-top" data-scroll-speed="%2$s" data-start-scroll="%3$s">
								<img src="/wp-content/themes/witheme/img/up.png" width="40" height="40" alt="링크 복사하기">
							</a>
						</li>
					</ul>
				</div>
				',
				esc_attr__( 'Wi 테마 도구', 'witheme' ),
				absint( apply_filters( 'wi_back_to_top_scroll_speed', 400 ) ),
				absint( apply_filters( 'wi_back_to_top_start_scroll', 300 ) ),
				esc_attr( apply_filters( 'wi_back_to_top_icon', 'fa-angle-up' ) ),
				wi_get_svg_icon( 'arrow-up' )
			)
		);
	}
}
