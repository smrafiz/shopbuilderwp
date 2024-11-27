<?php
/**
 * Shortcode: SBPluginInfo.
 *
 * Renders plugin info.
 *
 * @package RT\ShopBuilderWP
 */

namespace RT\ShopBuilderWP\Shortcodes;

use RT\ShopBuilderWP\Traits\SingletonTraits;

/**
 * Shortcode: SBPluginInfo.
 */
class SBPluginInfo {
	use SingletonTraits;

	/**
	 * Register to hook the shortcode.
	 */
	public function register() {
		add_shortcode( 'sb_plugin_info', [ $this, 'render' ] );
	}

	/**
	 * Render the shortcode output.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string Shortcode output.
	 */
	public function render( $atts ) {
		$atts = shortcode_atts(
			[
				'type' => 'downloads',
			],
			$atts,
			'sb_plugin_info'
		);

		$plugin_slug   = 'shopbuilder';
		$transient_key = 'sb_plugin_cache_data_' . $plugin_slug;
		$data          = get_transient( $transient_key );

		if ( false === $data ) {
			$api_url = 'https://api.wordpress.org/plugins/info/1.2/?action=query_plugins&request[author]=techlabpro1';

			$curl = curl_init();

			curl_setopt_array(
				$curl,
				[
					CURLOPT_URL            => $api_url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_TIMEOUT        => 10,
					CURLOPT_SSL_VERIFYPEER => true,
					CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
					CURLOPT_HTTPHEADER     => [ 'Content-Type: application/json' ],
				]
			);

			$response  = curl_exec( $curl );
			$http_code = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
			$error     = curl_error( $curl );

			curl_close( $curl );

			if ( false === $response || 200 !== $http_code ) {
				$error_message = false === $response ? $error : "HTTP Code: $http_code";

				return 'Error fetching plugin data: ' . $error_message;
			}

			$response_data = json_decode( $response, true );
			$plugin_data   = array_filter(
				$response_data['plugins'],
				function ( $plugin ) use ( $plugin_slug ) {
					return $plugin['slug'] === $plugin_slug;
				}
			);

			$data = reset( $plugin_data );

			unset( $data['description'] );

			set_transient( $transient_key, $data, 3 * DAY_IN_SECONDS );
		}

		if ( empty( $data ) ) {
			return 'No plugin data available.';
		}

		switch ( $atts['type'] ) {
			case 'downloads':
				$downloads = $data['downloaded'] ?? 'N/A';
				$output    = '<strong>' . number_format( $downloads ) . '</strong> Downloads';
				break;

			case 'active_installs':
				$active_installs = $data['active_installs'] ?? 'N/A';
				$output          = '<strong>' . number_format( $active_installs ) . '+</strong> Active Installs';
				break;

			case 'reviews':
				$ratings     = $data['ratings'] ?? [];
				$num_ratings = ! empty( $ratings[5] ) ? number_format( $ratings[5] ) : 'N/A';
				$output      = "<strong>5</strong> (<strong>$num_ratings</strong> Reviews)";
				break;

			case 'version':
				$version = $data['version'] ?? 'N/A';
				$output  = "Current Version: <strong>$version</strong>";
				break;

			case 'last_updated':
				$last_updated = $data['last_updated'];
				$last_updated = gmdate( 'd M, Y', strtotime( $last_updated ) ) ?? 'N/A';
				$output       = "Last Updated: <strong>$last_updated</strong>";
				break;

			case 'wp_compat':
				$wp_compat = $data['tested'] ?? 'N/A';
				$output    = "WP Compatibility: <strong>$wp_compat+</strong>";
				break;

			default:
				$output = 'Invalid type specified..';
				break;
		}

		return $output;
	}
}
