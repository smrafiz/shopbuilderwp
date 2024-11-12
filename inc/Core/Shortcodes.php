<?php

namespace RT\ShopBuilderWP\Core;

use RT\ShopBuilderWP\Shortcodes\SBTyping;
use RT\ShopBuilderWP\Shortcodes\SBWidgets;
use RT\ShopBuilderWP\Traits\SingletonTraits;
use RT\ShopBuilderWP\Shortcodes\SBPluginInfo;

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
			SBTyping::class,
			SBWidgets::class,
			SBPluginInfo::class,
		];

		foreach ( $widgets as $class ) {
			$class::instance()->register();
		}
	}
}
