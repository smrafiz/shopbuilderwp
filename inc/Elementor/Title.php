<?php

namespace RT\ShopBuilderWP\Elementor;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Title extends Widget_Base {
	public function __construct( $data = [], $args = null ) {
		parent::__construct( $data, $args );
	}

	public function get_name() {
		return 'sb-title';
	}
}
