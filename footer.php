<?php
/**
 * The template for displaying the footer.
 *
 * @package witheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

	</div>
</div>

<?php
/**
 * wi_before_footer hook.
 *
 * @since 0.1
 */
do_action( 'wi_before_footer' );
?>

<div <?php wi_do_attr( 'footer' ); ?>>
	<?php
	/**
	 * wi_before_footer_content hook.
	 *
	 * @since 0.1
	 */
	do_action( 'wi_before_footer_content' );

	/**
	 * wi_footer hook.
	 *
	 * @since 1.3.42
	 *
	 * @hooked wi_construct_footer_widgets - 5
	 * @hooked wi_construct_footer - 10
	 */
	do_action( 'wi_footer' );

	/**
	 * wi_after_footer_content hook.
	 *
	 * @since 0.1
	 */
	do_action( 'wi_after_footer_content' );
	?>
</div>

<?php
/**
 * wi_after_footer hook.
 *
 * @since 2.1
 */
do_action( 'wi_after_footer' );

wp_footer();
?>

</body>
</html>
