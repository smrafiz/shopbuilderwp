<?php

namespace RT\ShopBuilderWP\Helpers;

class Constants {

	const FINWAVE_VERSION = '1.0.0';

	public static function get_version() {
		return WP_DEBUG ? time() : self::FINWAVE_VERSION;
	}
}

