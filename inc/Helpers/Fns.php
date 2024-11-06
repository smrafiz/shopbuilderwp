<?php

namespace RT\ShopBuilderWP\Helpers;

use RT\ShopBuilderWP\Core\Sidebar;
use RT\ShopBuilderWP\Options\Opt;

/**
 * Extras.
 */
class Fns {

	/**
	 * Filters whether post thumbnail can be displayed.
	 *
	 * @return bool
	 */
	public static function can_show_post_thumbnail() {
		return ! post_password_required() && ! is_attachment() && has_post_thumbnail();
	}

	/**
	 * Social icon for the site
	 *
	 * @return mixed|null
	 */
	public static function get_socials() {
		return apply_filters(
			'shopbuilderwp_socials_icon',
			[
				'facebook'  => [
					'title' => __( 'Facebook', 'shopbuilderwp' ),
					'url'   => '#',
				],
				'twitter'   => [
					'title' => __( 'Twitter', 'shopbuilderwp' ),
					'url'   => '#',
				],
				'linkedin'  => [
					'title' => __( 'Linkedin', 'shopbuilderwp' ),
					'url'   => '#',
				],
				'youtube'   => [
					'title' => __( 'Youtube', 'shopbuilderwp' ),
					'url'   => '#',
				],
				'pinterest' => [
					'title' => __( 'Pinterest', 'shopbuilderwp' ),
					'url'   => '#',
				],
				'instagram' => [
					'title' => __( 'Instagram', 'shopbuilderwp' ),
					'url'   => '#',
				],
				'skype'     => [
					'title' => __( 'Skype', 'shopbuilderwp' ),
					'url'   => '#',
				],
				'tiktok'    => [
					'title' => __( 'TikTok', 'shopbuilderwp' ),
					'url'   => '#',
				],
			]
		);
	}

	/**
	 * Convert HEX to RGB color
	 *
	 * @param string $hex Hex color.
	 *
	 * @return string
	 */
	public static function hex2rgb( $hex ) {
		$hex = str_replace( '#', '', $hex );
		if ( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}
		$rgb = "$r, $g, $b";

		return $rgb;
	}

	/**
	 * Return Sidebar Column
	 *
	 * @return string
	 */
	public static function sidebar_columns() {
		return 'col-xl-4';
	}

	/**
	 * Return content columns
	 *
	 * @param string $full_width_col Column.
	 *
	 * @return string
	 */
	public static function content_columns( $full_width_col = 'col-12' ) {
		$sidebar = 'rt-sidebar';

		return ! is_active_sidebar( $sidebar ) ? $full_width_col : 'col-xl-8';
	}

	/**
	 * Return single content columns
	 *
	 * @return string
	 */
	public static function single_content_columns() {
		$sidebar = 'rt-single-sidebar';

		return is_active_sidebar( $sidebar ) ? 'col-xl-8' : 'col-xl-10 col-md-offset-1';
	}

	/**
	 * Return product single content columns
	 *
	 * @param string $full_width_col Column.
	 *
	 * @return string
	 */
	public static function product_single_columns( $full_width_col = 'col-12' ) {
		$sidebar = 'rt-single-sidebar';

		return ! is_active_sidebar( $sidebar ) ? $full_width_col : 'col-xl-8';
	}


	/**
	 * Get blog colum
	 *
	 * @return mixed|string
	 */
	public static function blog_column() {
		return 'col-lg-6';
	}

	/**
	 * Get all post-types
	 *
	 * @return array
	 */
	public static function get_post_types() {
		$post_types = get_post_types(
			[
				'public' => true,
			],
			'objects'
		);
		$post_types = wp_list_pluck( $post_types, 'label', 'name' );

		$exclude = apply_filters(
			'shopbuilderwp_exclude_post_type',
			[
				'attachment',
				'revision',
				'nav_menu_item',
				'elementor_library',
				'tpg_builder',
				'e-landing-page',
				'elementor-shopbuilderwp',
			]
		);

		foreach ( $exclude as $ex ) {
			unset( $post_types[ $ex ] );
		}

		return $post_types;
	}

	/**
	 * Check if is single fullwidth
	 *
	 * @return bool
	 */
	public static function is_single_fullwidth() {
		return false;
	}

	/**
	 * Get single meta lists
	 *
	 * @return array
	 */
	public static function single_meta_lists() {
		return [ 'author', 'date', 'category', 'comment' ];
	}

	/**
	 * Class list
	 *
	 * @param array $classes Classes.
	 *
	 * @return string
	 */
	public static function class_list( $classes ): string {
		return implode( ' ', $classes );
	}

	/**
	 * Get all default sidebar args for theme
	 *
	 * @param string $id ID.
	 *
	 * @return array|mixed|null
	 */
	public static function default_sidebar( $id = '' ) {
		$sidebar_lists = [
			'main'   => [
				'id'    => 'rt-sidebar',
				'name'  => __( 'Main Sidebar', 'shopbuilderwp' ),
				'class' => 'rt-sidebar',
			],
			'single' => [
				'id'    => 'rt-single-sidebar',
				'name'  => __( 'Single Sidebar', 'shopbuilderwp' ),
				'class' => 'rt-single-sidebar',
			],
			'footer' => [
				'id'    => 'rt-footer-sidebar',
				'name'  => 'Footer Sidebar',
				'class' => 'footer-sidebar col-lg-3 col-md-6',
			],
		];

		if ( class_exists( 'WooCommerce' ) ) {
			$sidebar_lists['woo-archive'] = [
				'id'    => 'rt-woo-archive-sidebar',
				'name'  => __( 'WooCommerce Archive Sidebar', 'shopbuilderwp' ),
				'class' => 'woo-archive-sidebar',
			];
			$sidebar_lists['woo-single']  = [
				'id'    => 'rt-woo-single-sidebar',
				'name'  => __( 'WooCommerce Single Sidebar', 'shopbuilderwp' ),
				'class' => 'woo-single-sidebar',
			];
		}

		if ( ! $id ) {
			return $sidebar_lists;
		}

		if ( isset( $sidebar_lists[ $id ] ) ) {
			return $sidebar_lists[ $id ]['id'];
		}

		return [];
	}

	/**
	 * Get Shop Grid Page URL
	 *
	 * @return string
	 */
	public static function shop_grid_page_url() {
		global $wp;

		return add_query_arg( $wp->query_string, '&displayview=grid', home_url( $wp->request ) );
	}

	/**
	 * Get Shop List Page URL
	 *
	 * @return string
	 */
	public static function shop_list_page_url() {
		global $wp;

		return add_query_arg( $wp->query_string, '&displayview=list', home_url( $wp->request ) );
	}
}
