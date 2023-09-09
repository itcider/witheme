<?php
/**
 * Build our admin dashboard.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * This class adds HTML attributes to various theme elements.
 */
class witheme_Dashboard {
	/**
	 * Class instance.
	 *
	 * @access private
	 * @var $instance Class instance.
	 */
	private static $instance;

	/**
	 * Initiator
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Get started.
	 */
	public function __construct() {
		// Load our old dashboard if we're using an old version of GP Premium.
		if ( defined( 'GP_PREMIUM_VERSION' ) && version_compare( GP_PREMIUM_VERSION, '2.1.0-alpha.1', '<' ) ) {
			require_once get_template_directory() . '/inc/dashboard.php';

			return;
		}

		add_action( 'admin_menu', array( $this, 'add_menu_item' ) );
		add_filter( 'admin_body_class', array( $this, 'set_admin_body_class' ) );
		add_action( 'in_admin_header', array( $this, 'add_header' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'wi_admin_dashboard', array( $this, 'start_customizing' ) );
		add_action( 'wi_admin_dashboard', array( $this, 'go_pro' ), 15 );
		add_action( 'wi_admin_dashboard', array( $this, 'reset' ), 100 );
	}

	/**
	 * Add our dashboard menu item.
	 */
	public function add_menu_item() {
		add_theme_page(
			esc_html__( 'witheme', 'witheme' ),
			esc_html__( 'witheme', 'witheme' ),
			apply_filters( 'wi_dashboard_page_capability', 'edit_theme_options' ),
			'wi-options',
			array( $this, 'page' )
		);
	}

	/**
	 * Get our dashboard pages so we can style them.
	 */
	public static function get_pages() {
		return apply_filters(
			'wi_dashboard_screens',
			array(
				'appearance_page_wi-options',
			)
		);
	}

	/**
	 * Add a body class on GP dashboard pages.
	 *
	 * @param string $classes The existing classes.
	 */
	public function set_admin_body_class( $classes ) {
		$dashboard_pages = self::get_pages();
		$current_screen = get_current_screen();

		if ( in_array( $current_screen->id, $dashboard_pages ) ) {
			$classes .= ' wi-dashboard-page';
		}

		return $classes;
	}

	/**
	 * Build our Dashboard header.
	 */
	public static function header() {
		?>
		<div class="witheme-dashboard-header">
			<div class="witheme-dashboard-header__title">
				<h1>
					<?php echo esc_html( get_admin_page_title() ); ?>
				</h1>
			</div>

			<?php self::navigation(); ?>
		</div>
		<?php
	}

	/**
	 * Build our Dashboard menu.
	 */
	public static function navigation() {
		$screen = get_current_screen();

		$tabs = apply_filters(
			'wi_dashboard_tabs',
			array(
				'dashboard' => array(
					'name' => __( '테마 설정', 'Wi theme' ),
					'url' => admin_url( 'themes.php?page=wi-options' ),
					'class' => 'appearance_page_wi-options' === $screen->id ? 'active' : '',
				),
			)
		);



		$tabs['support'] = array(
			'name' => __( '지원과 문의', 'witheme' ),
			'url' => 'https://support.itcider.com',
			'class' => '',
			'external' => true,
		);

		$tabs['documentation'] = array(
			'name' => __( '공식 문서', 'witheme' ),
			'url' => 'https://wi.itcider.com/docs',
			'class' => '',
			'external' => true,
		);
		?>
		<div class="witheme-dashboard-header__navigation">
			<?php
			foreach ( $tabs as $tab ) {
				printf(
					'<a href="%1$s" class="%2$s"%4$s>%3$s</a>',
					esc_url( $tab['url'] ),
					esc_attr( $tab['class'] ),
					esc_html( $tab['name'] ),
					! empty( $tab['external'] ) ? 'target="_blank" rel="noreferrer noopener"' : ''
				);
			}
			?>
		</div>
		<?php
	}

	/**
	 * Add our Dashboard headers.
	 */
	public function add_header() {
		$dashboard_pages = self::get_pages();
		$current_screen = get_current_screen();

		if ( in_array( $current_screen->id, $dashboard_pages ) ) {
			self::header();

			/**
			 * wi_dashboard_after_header hook.
			 *
			 * @since 2.0
			 */
			do_action( 'wi_dashboard_after_header' );
		}
	}

	/**
	 * Add our scripts to the page.
	 */
	public function enqueue_scripts() {
		$dashboard_pages = self::get_pages();
		$current_screen = get_current_screen();

		if ( in_array( $current_screen->id, $dashboard_pages ) ) {
			wp_enqueue_style(
				'wi-dashboard',
				get_template_directory_uri() . '/assets/dist/style-dashboard.css',
				array( 'wp-components' ),
				wi_VERSION
			);

			if ( 'appearance_page_wi-options' === $current_screen->id ) {
				wp_enqueue_script(
					'wi-dashboard',
					get_template_directory_uri() . '/assets/dist/dashboard.js',
					array( 'wp-api', 'wp-i18n', 'wp-components', 'wp-element', 'wp-api-fetch' ),
					wi_VERSION,
					true
				);

				wp_set_script_translations( 'wi-dashboard', 'witheme' );

				wp_localize_script(
					'wi-dashboard',
					'wiDashboard',
					array(
						'hasPremium' => defined( 'GP_PREMIUM_VERSION' ),
						'customizeSectionUrls' => array(
							'siteIdentitySection' => add_query_arg( rawurlencode( 'autofocus[section]' ), 'title_tagline', wp_customize_url() ),
							'colorsSection' => add_query_arg( rawurlencode( 'autofocus[section]' ), 'wi_colors_section', wp_customize_url() ),
							'typographySection' => add_query_arg( rawurlencode( 'autofocus[section]' ), 'wi_typography_section', wp_customize_url() ),
							'layoutSection' => add_query_arg( rawurlencode( 'autofocus[panel]' ), 'wi_layout_panel', wp_customize_url() ),
						),
					)
				);
			}
		}
	}

	/**
	 * Add the HTML for our page.
	 */
	public function page() {
		?>
		<div class="wrap">
			<div class="witheme-dashboard">
				<?php do_action( 'wi_admin_dashboard' ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Add the container for our start customizing app.
	 */
	public function start_customizing() {
		echo '<div id="witheme-dashboard-app"></div>';
	}

	/**
	 * Add the container for our start customizing app.
	 */
	public function go_pro() {
		echo '';
	}

	/**
	 * Add the container for our reset app.
	 */
	public function reset() {
		echo '<div id="witheme-reset"></div>';
	}
}

witheme_Dashboard::get_instance();
