<?php

namespace RT\ShopBuilderWP\Custom;

use RT\ShopBuilderWP\Traits\SingletonTraits;

/**
 * Extras.
 */
class WC {
	use SingletonTraits;

	/**
	 * Register default hooks and actions for WordPress
	 */
	public function __construct() {
		/**
		 * Action
		 */
		add_action( 'template_redirect', [ $this, 'custom_redirection' ] );

		/**
		 * Filters
		 */
		add_filter( 'woocommerce_get_image_size_single', [ $this, 'get_single_image_size' ], 99 );
		add_filter( 'woocommerce_get_image_size_thumbnail', [ $this, 'get_thumbnail_image_size' ], 99 );
		add_filter( 'woocommerce_gallery_thumbnail_size', [ $this, 'get_gallery_image_size' ], 99 );
		add_filter( 'woocommerce_get_endpoint_url', [ $this, 'my_account_endpoint_urls' ], 10, 2 );
		add_filter( 'elementor/files/svg/allowed_elements', [ $this, 'add_additional_attributes' ] );

		/**
		 * Enable the template preview page.
		 */
		add_filter( 'rtsb/builder/args/publicly_queryable', '__return_true' );

		/**
		 * Enable big image.
		 */
		add_filter( 'big_image_size_threshold', '__return_false' );
	}

	/**
	 * Custom single image size.
	 *
	 * @return int[]
	 */
	public function get_single_image_size() {
		return [
			'width'  => 600,
			'height' => 720,
			'crop'   => 0,
		];
	}

	/**
	 * Custom thumbnail size.
	 *
	 * @return int[]
	 */
	public function get_thumbnail_image_size() {
		return [
			'width'  => 500,
			'height' => 600,
			'crop'   => 0,
		];
	}

	/**
	 * Custom gallery size.
	 *
	 * @return string
	 */
	public function get_gallery_image_size() {
		return 'medium';
	}

	/**
	 * Custom endpoint urls.
	 *
	 * @param string $url URL.
	 * @param string $endpoint Endpoint.
	 *
	 * @return string
	 */
	public function my_account_endpoint_urls( $url, $endpoint ) {
		$page = get_queried_object();

		if ( ! is_object( $page ) ) {
			return $url;
		}

		if ( is_user_logged_in() && 'rtsb_builder' !== $page->post_type ) {
			return $url;
		}

		switch ( $endpoint ) {
			case 'orders':
				$url = home_url( '/rtsb-template/my-account-order-template-1/' );
				break;
			case 'downloads':
				$url = home_url( '/rtsb-template/my-account-downloads-template-1/' );
				break;
			case 'edit-address':
				$url = home_url( '/rtsb-template/my-account-address-template-1/' );
				break;
			case 'edit-account':
				$url = home_url( '/rtsb-template/my-account-details-template-1/' );
				break;
			case 'view-order':
				$url = home_url( '/rtsb-template/my-account-order-details-template-1/' );
				break;
			case 'lost-password':
				$url = home_url( '/rtsb-template/lost-password-template-1/' );
				break;
			case 'customer-logout':
				$url = home_url( '/rtsb-template/login-register-template-1/' );
				break;
		}

		return $url;
	}

	/**
	 * Custom redirection.
	 */
	public function custom_redirection() {
		global $wp;

		if ( ! is_user_logged_in() && ( 'my-account' == $wp->request ) || ( 'my-account/my_returns' == $wp->request ) && ( 'lost-password' != $wp->request )
		) {
			wp_safe_redirect( home_url( 'rtsb-template/my-account-dashboard-template-1' ) );
			exit;
		}
	}

	/**
	 * Add additional attributes to SVG.
	 *
	 * @param array $elements Allowed elements.
	 *
	 * @return array
	 */
	public function add_additional_attributes( $elements ) {
		$additional_attr = [
			'feFlood',
			'feColorMatrix',
			'feOffset',
			'feComposite',
			'feBlend',
		];

		return array_merge( $elements, $additional_attr );
	}
}
