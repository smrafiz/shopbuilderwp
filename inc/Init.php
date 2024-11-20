<?php
/**
 *
 * This theme uses PSR-4 and OOP logic instead of procedural coding
 * Every function, hook and action is properly divided and organized inside related folders and files
 * Use the file `config/custom/custom.php` to write your custom functions
 *
 * @package shopbuilderwp
 */

namespace RT\ShopBuilderWP;

use RT\ShopBuilderWP\Traits\SingletonTraits;

/**
 * Theme Init.
 */
final class Init {
	use SingletonTraits;

	/**
	 * Class constructor
	 */
	public function __construct() {
		$this->register();
	}

	/**
	 * Instantiate all class
	 *
	 * @return void
	 */
	public function register() {
		Core\Tags::instance();
		Custom\WC::instance();
		Setup\Setup::instance();
		Setup\Menus::instance();
		Custom\Hooks::instance();
		Core\Sidebar::instance();
		Custom\Extras::instance();
		Setup\Enqueue::instance();
		Core\PostTypes::instance();
		Core\Elementor::instance();
		Core\Shortcodes::instance();
		Custom\Debloater::instance();
	}
}
