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
		add_action( 'pre_get_posts', [ __CLASS__, 'modify_rtsb_templates_page' ] );
	}

	/**
	 * Footer hook
	 *
	 * @return void
	 */
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
	 * Single post meta-visibility
	 *
	 * @param object $screen Screen object.
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

	/**
	 * Modify templates page
	 *
	 * @param object $q Query object.
	 *
	 * @return object
	 */
	public static function modify_rtsb_templates_page( $q ) {
		if ( is_admin() ) {
			return $q;
		}

		$p_ids = [ 5734, 5740, 5751, 5773, 5797, 5837, 5860, 5895, 5900, 5911, 5916, 5924, 5935, 5937, 5943, 5948, 5960, 5966 ];

		if ( 'rtsb_builder' === get_post_type( get_the_id() ) ) {
			$page = get_queried_object();

			if ( 2061 === $page->ID || 7836 === $page->ID || 7887 === $page->ID || 7932 === $page->ID || 2059 === $page->ID || 2064 === $page->ID || 2065 === $page->ID ) {
				$q->set( 'post__not_in', $p_ids );
			}

			if ( 2059 === $page->ID ) {
				$q->set( 'posts_per_page', 15 );
			}
		}

		if ( is_post_type_archive( 'product' ) ) {
			$q->set( 'post__not_in', $p_ids );
			$q->set( 'posts_per_page', 9 );
		}

		return $q;
	}
}
