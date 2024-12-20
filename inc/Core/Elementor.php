<?php

namespace RT\ShopBuilderWP\Core;

use Elementor\Plugin;
use RT\ShopBuilderWP\Elementor\RTMarquee;
use RT\ShopBuilderWP\Elementor\RTImage;
use RT\ShopBuilderWP\Traits\SingletonTraits;

/**
 * Sidebar.
 */
class Elementor {
	use SingletonTraits;

	/**
	 * Sidebar constructor.
	 */
	public function __construct() {
		add_action( 'elementor/widgets/register', [ $this, 'register_widget' ] );
	}

	/**
	 * Widgets init.
	 *
	 * @return void
	 */
	public function register_widget() {
		$widgets = [
			RTMarquee::class,
			RTImage::class,
		];

		foreach ( $widgets as $class ) {
			Plugin::instance()->widgets_manager->register( new $class() );
		}
	}
}
