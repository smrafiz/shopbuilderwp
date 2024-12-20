<?php

namespace RT\ShopBuilderWP\Setup;

use RT\ShopBuilderWP\Helpers\Constants;
use RT\ShopBuilderWP\Traits\SingletonTraits;

/**
 * Enqueue.
 */
class Enqueue {
	use SingletonTraits;

	/**
	 * Register default hooks and actions for WordPress
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ], 12 );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 25 );
	}

	/**
	 * Register all necessary scripts and styles for the theme
	 *
	 * @return void
	 */
	public function register_scripts() {
		wp_register_style( 'sb-magnific-popup', shopbuilderwp_get_file( '/assets/vendors/magnific-popup/magnific-popup.css' ), [], Constants::get_version() );
		wp_register_script( 'sb-magnific-popup', shopbuilderwp_get_file( '/assets/vendors/magnific-popup/magnific-popup.js' ), [ 'jquery' ], Constants::get_version(), true );
		wp_register_script( 'sb-isotope', shopbuilderwp_get_file( '/assets/vendors/isotope/isotope.pkgd.min.js' ), [ 'jquery' ], Constants::get_version(), true );
		wp_register_script( 'sb-headroom', shopbuilderwp_get_file( '/assets/vendors/headroom/headroom.js' ), [ 'jquery' ], Constants::get_version(), true );
		wp_register_script( 'sb-parallax', shopbuilderwp_get_file( '/assets/vendors/parallax/parallax.js' ), [ 'jquery' ], Constants::get_version(), true );
	}

	/**
	 * Enqueue all necessary scripts and styles for the theme
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		// CSS.
		wp_enqueue_style( 'sb-magnific-popup' );
		wp_enqueue_style( 'shopbuilderwp-main', shopbuilderwp_get_css( 'style' ), [], Constants::get_version() );

		// JS.
		wp_enqueue_script( 'sb-magnific-popup' );
		wp_enqueue_script( 'sb-headroom' );
		wp_enqueue_script( 'shopbuilderwp-main', shopbuilderwp_get_js( 'scripts' ), [ 'jquery', 'imagesloaded' ], Constants::get_version(), true );

		// Extra.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// localize script.
		$shopbuilderwp_localize_data = [
			'rtl'                => is_rtl() ? 'rtl' : 'ltr',

			// Ajax.
			'ajaxURL'            => admin_url( 'admin-ajax.php' ),
			'shopbuilderwpNonce' => wp_create_nonce( 'rt-shopbuilderwp-nonce' ),
		];
		wp_localize_script( 'shopbuilderwp-main', 'shopbuilderwpObj', $shopbuilderwp_localize_data );
	}
}
