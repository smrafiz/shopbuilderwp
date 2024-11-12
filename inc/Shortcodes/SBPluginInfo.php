<?php

namespace RT\ShopBuilderWP\Shortcodes;

use RT\ShopBuilderWP\Traits\SingletonTraits;

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
		$transient_key = 'sb_plugin_data_' . $plugin_slug;
		$data          = get_transient( $transient_key );

		if ( false === $data ) {
			$api      = 'https://api.wordpress.org/plugins/info/1.2/?action=query_plugins&request[author]=techlabpro1';
			$response = wp_remote_get( $api );

			if ( is_wp_error( $response ) ) {
				return 'Error fetching plugin data.';
			}

			$response_data = json_decode( wp_remote_retrieve_body( $response ), true );
			$plugin_data   = array_filter(
				$response_data['plugins'],
				function ( $plugin ) use ( $plugin_slug ) {
					return $plugin['slug'] === $plugin_slug;
				}
			);

			$data = reset( $plugin_data );

			unset( $data['description'] );

			set_transient( $transient_key, $data, 7 * DAY_IN_SECONDS );
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
				$output      = "<strong>5</strong> (<strong>{$num_ratings}</strong> Reviews)";
				break;

			case 'version':
				$version = $data['version'] ?? 'N/A';
				$output  = "Current Version: <strong>{$version}</strong>";
				break;

			case 'last_updated':
				$last_updated = $data['last_updated'];
				$last_updated = gmdate( 'd M, Y', strtotime( $last_updated ) ) ?? 'N/A';
				$output       = "Last Updated: <strong>{$last_updated}</strong>";
				break;

			case 'wp_compat':
				$wp_compat = $data['tested'] ?? 'N/A';
				$output    = "WP Compatibility: <strong>{$wp_compat}+</strong>";
				break;

			default:
				$output = 'Invalid type specified..';
				break;
		}

		return $output;
	}
}
