<?php
/**
 * LayoutControls
 */

namespace RT\ShopBuilderWP\Traits;

// Do not allow directly accessing this file.
use RT\ShopBuilderWP\Helpers\Fns;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

trait LayoutControlsTraits {
	public function get_layout_controls( $prefix = '' ) {

		$_left_text  = __( 'Left Sidebar', 'shopbuilderwp' );
		$_right_text = __( 'Right Sidebar', 'shopbuilderwp' );
		$left_text   = $_left_text;
		$right_text  = $_right_text;
		$image_left  = 'sidebar-left.png';
		$image_right = 'sidebar-right.png';

		if ( is_rtl() ) {
			$left_text   = $_right_text;
			$right_text  = $_left_text;
			$image_left  = 'sidebar-right.png';
			$image_right = 'sidebar-left.png';
		}

		return apply_filters( "shopbuilderwp_{$prefix}_layout_controls", [

			$prefix . '_layout' => [
				'type'    => 'image_select',
				'label'   => __( 'Choose Layout', 'shopbuilderwp' ),
				'default' => 'right-sidebar',
				'choices' => [
					'left-sidebar'  => [
						'image' => shopbuilderwp_get_img( $image_left ),
						'name'  => $left_text,
					],
					'full-width'    => [
						'image' => shopbuilderwp_get_img( 'sidebar-full.png' ),
						'name'  => __( 'Full Width', 'shopbuilderwp' ),
					],
					'right-sidebar' => [
						'image' => shopbuilderwp_get_img( $image_right ),
						'name'  => $right_text,
					],
				]
			],

			$prefix . '_sidebar' => [
				'type'    => 'select',
				'label'   => __( 'Choose a Sidebar', 'shopbuilderwp' ),
				'default' => 'default',
				'choices' => Fns::sidebar_lists()
			],

			$prefix . '_page_bg_image' => [
				'type'         => 'image',
				'label'        => __( 'Page Background Image', 'shopbuilderwp' ),
				'description'  => __( 'Upload Background Image', 'shopbuilderwp' ),
				'button_label' => __( 'Background Image', 'shopbuilderwp' ),
			],

			$prefix . '_page_bg_color' => [
				'type'         => 'color',
				'label'        => __( 'Page Background Color', 'shopbuilderwp' ),
				'description'  => __( 'Inter Background Color', 'shopbuilderwp' ),
			],

			$prefix . '_header_heading' => [
				'type'  => 'heading',
				'label' => __( 'Header Settings', 'shopbuilderwp' ),
			],

			$prefix . '_header_style' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Header Layout', 'shopbuilderwp' ),
				'choices' => [
					'default' => __( '--Default--', 'shopbuilderwp' ),
					'1'       => __( 'Layout 1', 'shopbuilderwp' ),
					'2'       => __( 'Layout 2', 'shopbuilderwp' ),
				],
			],

			$prefix . '_top_bar' => [
				'type'    => 'select',
				'label'   => __( 'Top Bar', 'shopbuilderwp' ),
				'default' => 'default',
				'choices' => [
					'default' => __( '--Default--', 'shopbuilderwp' ),
					'on'      => __( 'On', 'shopbuilderwp' ),
					'off'     => __( 'Off', 'shopbuilderwp' ),
				]
			],

			$prefix . '_banner_heading' => [
				'type'  => 'heading',
				'label' => __( 'Banner Settings', 'shopbuilderwp' ),
			],

			$prefix . '_banner' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Banner Visibility', 'shopbuilderwp' ),
				'choices' => [
					'default' => __( '--Default--', 'shopbuilderwp' ),
					'on'      => __( 'On', 'shopbuilderwp' ),
					'off'     => __( 'Off', 'shopbuilderwp' ),
				],
			],

			$prefix . '_breadcrumb_title' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Banner Title', 'shopbuilderwp' ),
				'choices' => [
					'default' => __( '--Default--', 'shopbuilderwp' ),
					'on'      => __( 'On', 'shopbuilderwp' ),
					'off'     => __( 'Off', 'shopbuilderwp' ),
				],
			],

			$prefix . '_breadcrumb' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Banner Breadcrumb', 'shopbuilderwp' ),
				'choices' => [
					'default' => __( '--Default--', 'shopbuilderwp' ),
					'on'      => __( 'On', 'shopbuilderwp' ),
					'off'     => __( 'Off', 'shopbuilderwp' ),
				],
			],

			$prefix . '_banner_image' => [
				'type'         => 'image',
				'label'        => __( 'Banner Image', 'shopbuilderwp' ),
				'description'  => __( 'Upload Banner Image', 'shopbuilderwp' ),
				'button_label' => __( 'Banner Image', 'shopbuilderwp' ),
			],

			$prefix . '_banner_color' => [
				'type'         => 'color',
				'label'        => __( 'Banner Background Color', 'shopbuilderwp' ),
				'description'  => __( 'Inter Background Color', 'shopbuilderwp' ),
			],

			$prefix . '_footer_heading' => [
				'type'  => 'heading',
				'label' => __( 'Footer Settings', 'shopbuilderwp' ),
			],

			$prefix . '_footer_style'  => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Footer Layout', 'shopbuilderwp' ),
				'choices' => [
					'default' => __( '--Default--', 'shopbuilderwp' ),
					'1'       => __( 'Layout 1', 'shopbuilderwp' ),
					'2'       => __( 'Layout 2', 'shopbuilderwp' ),
				],
			],

		] );


	}


}
