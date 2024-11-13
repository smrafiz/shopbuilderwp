<?php

namespace RT\ShopBuilderWP\Custom;

use RT\ShopBuilderWP\Traits\SingletonTraits;

/**
 * Extras.
 */
class Hooks {
	use SingletonTraits;

	/**
	 * Register default hooks and actions for WordPress
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ __CLASS__, 'meta_css' ] );
		add_action( 'wp_head', [ __CLASS__, 'wp_footer_hook' ] );
	}

	public static function wp_footer_hook() {
		?>
		<style>
			.shopbuilderwp-header-footer .site-header {
				opacity: 1;
			}
		</style>

		<?php
	}

	/**
	 * Single post meta visibility
	 *
	 * @param $screen
	 *
	 * @return void
	 */
	public static function meta_css( $screen ) {
		if ( 'post.php' !== $screen ) {
			return;
		}
		global $typenow;
		$display = 'post' === $typenow ? 'table-row' : 'none';
		?>
		<style>
			.single_post_style {
				display: <?php echo esc_attr( $display ); ?>;
			}
		</style>
		<?php
	}
}
