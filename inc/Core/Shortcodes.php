<?php

namespace RT\ShopBuilderWP\Core;

use RT\ShopBuilderWP\Shortcodes\SBTyping;
use RT\ShopBuilderWP\Shortcodes\SBWidgets;
use RT\ShopBuilderWP\Traits\SingletonTraits;

/**
 * Sidebar.
 */
class Shortcodes {
	use SingletonTraits;

	/**
	 * Sidebar constructor.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_shortcodes' ] );
	}

	/**
	 * Register all shortcodes.
	 *
	 * @return void
	 */
	public function register_shortcodes() {
		$widgets = [
			SBWidgets::class,
			SBTyping::class,
		];

		foreach ( $widgets as $class ) {
			$class::instance()->register();
		}
	}
}
