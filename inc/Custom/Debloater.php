<?php
/**
 * Debloater Class.
 *
 * This class is used to debloat unnecessary wp functionalities.
 *
 * @package RT\ShopBuilderWP
 */

namespace RT\ShopBuilderWP\Custom;

use RT\ShopBuilderWP\Traits\SingletonTraits;

/**
 * Debloater.
 */
class Debloater {
	use SingletonTraits;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this
			->disable_emojis()
			->remove_embed_scripts()
			->remove_jQuery_migrate()
			->remove_dashicons()
			->remove_generator_meta()
			->remove_rsd_link()
			->remove_wlwmanifest_link()
			->remove_shortlink()
			->disable_wp_embeds()
			->disable_self_pingbacks()
			->disable_XMLRPC()
			->disable_site_rss_feeds()
			->remove_query_strings()
			->disable_gutenberg_editor()
			->limit_post_revisions();
	}

	/**
	 * Disable WordPress emojis.
	 *
	 * @return Debloater
	 */
	public function disable_emojis() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );

		return $this;
	}

	/**
	 * Remove embed scripts.
	 *
	 * @return Debloater
	 */
	public function remove_embed_scripts() {
		add_action(
			'wp_footer',
			function () {
				wp_dequeue_script( 'wp-embed' );
			}
		);

		return $this;
	}

	/**
	 * Remove jQuery migrate script.
	 *
	 * @return Debloater
	 */
	public function remove_jQuery_migrate() {
		add_action(
			'wp_default_scripts',
			function ( $scripts ) {
				if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
					$script = $scripts->registered['jquery'];
					if ( $script->deps ) {
						$script->deps = array_diff( $script->deps, [ 'jquery-migrate' ] );
					}
				}
			}
		);

		return $this;
	}

	/**
	 * Remove Dashicons from the frontend.
	 *
	 * @return Debloater
	 * @since  1.0.0
	 */
	public function remove_dashicons() {
		add_action(
			'wp_enqueue_scripts',
			function () {
				if ( ! is_admin() && ! is_admin_bar_showing() ) {
					wp_deregister_style( 'dashicons' );
				}
			}
		);

		return $this;
	}

	/**
	 * Remove WordPress generator meta tag.
	 *
	 * @return Debloater
	 * @since  1.0.0
	 */
	public function remove_generator_meta() {
		remove_action( 'wp_head', 'wp_generator' );

		return $this;
	}

	/**
	 * Remove RSD link.
	 *
	 * @return Debloater
	 * @since  1.0.0
	 */
	public function remove_rsd_link() {
		remove_action( 'wp_head', 'rsd_link' );

		return $this;
	}

	/**
	 * Remove the Windows Live Writer manifest link.
	 *
	 * @return Debloater
	 * @since  1.0.0
	 */
	public function remove_wlwmanifest_link() {
		remove_action( 'wp_head', 'wlwmanifest_link' );

		return $this;
	}

	/**
	 * Remove WordPress shortlink.
	 *
	 * @return Debloater
	 * @since  1.0.0
	 */
	public function remove_shortlink() {
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );

		return $this;
	}

	/**
	 * Disable WP embeds.
	 *
	 * @return Debloater
	 * @since  1.0.0
	 */
	public function disable_wp_embeds() {
		add_action(
			'init',
			function () {
				remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
				remove_action( 'wp_head', 'wp_oembed_add_host_js' );
				add_filter( 'embed_oembed_discover', '__return_false' );
				add_filter(
					'tiny_mce_plugins',
					function ( $plugins ) {
						return array_diff( $plugins, [ 'wpembed' ] );
					}
				);
				add_filter(
					'rewrite_rules_array',
					function ( $rules ) {
						foreach ( $rules as $rule => $rewrite ) {
							if ( false !== strpos( $rewrite, 'embed=true' ) ) {
								unset( $rules[ $rule ] );
							}
						}
						return $rules;
					}
				);
			},
			9999
		);

		return $this;
	}

	/**
	 * Disable self pingbacks.
	 *
	 * @return Debloater
	 * @since  1.0.0
	 */
	public function disable_self_pingbacks() {
		add_action(
			'pre_ping',
			function ( &$links ) {
				foreach ( $links as $l => $link ) {
					if ( 0 === strpos( $link, home_url() ) ) {
						unset( $links[ $l ] );
					}
				}
			}
		);

		return $this;
	}

	/**
	 * Disable XML-RPC.
	 *
	 * @return Debloater
	 * @since  1.0.0
	 */
	public function disable_XMLRPC() {
		add_filter( 'xmlrpc_enabled', '__return_false' );

		return $this;
	}

	/**
	 * Disable RSS feeds.
	 *
	 * @return Debloater
	 * @since  1.0.0
	 */
	public function disable_site_rss_feeds() {
		add_action(
			'do_feed',
			function () {
				$homepage_url = get_bloginfo( 'url' );

				wp_die(
					sprintf(
					/* translators: %s: Home page URL */
						esc_html__( 'No feed available, please visit our %s!', 'alsiha' ),
						'<a href="' . esc_url( $homepage_url ) . '">' . esc_html__( 'homepage', 'alsiha' ) . '</a>'
					)
				);
			},
			1
		);
		add_action( 'do_feed_rdf', [ $this, 'disable_rss_feeds' ], 1 );
		add_action( 'do_feed_rss', [ $this, 'disable_rss_feeds' ], 1 );
		add_action( 'do_feed_rss2', [ $this, 'disable_rss_feeds' ], 1 );
		add_action( 'do_feed_atom', [ $this, 'disable_rss_feeds' ], 1 );

		return $this;
	}

	/**
	 * Remove query strings from static resources.
	 *
	 * @return Debloater
	 * @since  1.0.0
	 */
	public function remove_query_strings() {
		add_action(
			'init',
			function () {
				if ( ! is_admin() ) {
					$remove_query_strings = function ( $src ) {
						if ( is_string( $src ) ) {
							$output = preg_split( '/(&ver|\?ver)/', $src );
							return $output[0];
						}
						return $src;
					};

					add_filter( 'script_loader_src', $remove_query_strings, 15 );
					add_filter( 'style_loader_src', $remove_query_strings, 15 );
				}
			}
		);

		return $this;
	}

	/**
	 * Disable Gutenberg editor and enable Classic Editor.
	 *
	 * @return Debloater
	 * @since  1.0.0
	 */
	public function disable_gutenberg_editor() {
		add_action(
			'wp_enqueue_scripts',
			function () {
				wp_dequeue_style( 'wp-block-library' );
				wp_dequeue_style( 'wp-block-library-theme' );
				wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS.
			},
			100
		);

		add_filter( 'use_block_editor_for_post', '__return_false', 10 );
		add_filter( 'use_block_editor_for_post_type', '__return_false', 10 );
		add_filter( 'use_block_editor_for_page', '__return_false', 10 );
		add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
		add_filter( 'use_widgets_block_editor', '__return_false' );

		// Enqueue the Classic Editor styles.
		add_action(
			'admin_enqueue_scripts',
			function () {
				wp_enqueue_style( 'classic-editor', includes_url( '/css/editor.min.css' ), [], '1.0' );
			}
		);

		// Replace Gutenberg with Classic Editor.
		add_action(
			'admin_init',
			function () {
				remove_action( 'admin_notices', [ 'Gutenberg_Admin', 'admin_notices' ] );
				remove_action( 'wp_enqueue_scripts', [ 'Gutenberg_Frontend', 'enqueue_block_assets' ] );
			}
		);

		return $this;
	}

	/**
	 * Limit the number of post-revisions.
	 *
	 * @return Debloater
	 * @since  1.0.0
	 */
	public function limit_post_revisions() {
		if ( ! defined( 'WP_POST_REVISIONS' ) ) {
			define( 'WP_POST_REVISIONS', 3 );
		}

		return $this;
	}

	/**
	 * Disable RSS feeds and display a message.
	 *
	 * @return void
	 */
	public function disable_rss_feeds() {
		wp_die(
			esc_html__( 'RSS feeds are disabled on this site. Please visit the homepage for updates.', 'shopbuilderwp' ),
			esc_html__( 'No RSS Feeds', 'shopbuilderwp' ),
			[ 'response' => 403 ]
		);
	}
}
