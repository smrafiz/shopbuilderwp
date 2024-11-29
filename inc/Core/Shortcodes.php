<?php

namespace RT\ShopBuilderWP\Core;

use RT\ShopBuilderWP\Shortcodes\SBApps;
use RT\ShopBuilderWP\Shortcodes\SBThemes;
use RT\ShopBuilderWP\Shortcodes\SBTyping;
use RT\ShopBuilderWP\Shortcodes\SBAppInfo;
use RT\ShopBuilderWP\Shortcodes\SBWidgets;
use RT\ShopBuilderWP\Traits\SingletonTraits;
use RT\ShopBuilderWP\Shortcodes\SBThemeInfo;
use RT\ShopBuilderWP\Shortcodes\SBSocialIcon;
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
			SBApps::class,
			SBThemes::class,
			SBTyping::class,
			SBWidgets::class,
			SBAppInfo::class,
			SBThemeInfo::class,
			SBPluginInfo::class,
			SBSocialIcon::class,
		];

		foreach ( $widgets as $class ) {
			$class::instance()->register();
		}
	}
}
