<?php

namespace RT\ShopBuilderWP\Core;

use RT\ShopBuilderWP\Traits\SingletonTraits;

/**
 * Sidebar.
 */
class PostTypes {
	use SingletonTraits;

	/**
	 * Sidebar constructor.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_post_type' ] );
	}

	public function register_post_type() {
		$this->register_sb_theme();
		$this->register_sb_widget();
		$this->register_sb_app();
		$this->register_sb_widget_cat();
	}

	/**
	 * Register custom post type
	 *
	 * @return void
	 */
	private function register_sb_theme() {
		$labels = [
			'name'               => 'SB Themes',
			'singular_name'      => 'SB Theme',
			'menu_name'          => 'SB Themes',
			'name_admin_bar'     => 'SB Theme',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New SB Theme',
			'new_item'           => 'New SB Theme',
			'edit_item'          => 'Edit SB Theme',
			'view_item'          => 'View SB Theme',
			'all_items'          => 'All SB Themes',
			'search_items'       => 'Search SB Themes',
			'parent_item_colon'  => 'Parent SB Themes:',
			'not_found'          => 'No sb themes found.',
			'not_found_in_trash' => 'No sb themes found in Trash.',
		];

		$args = [
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'shopbuilder-themes' ],
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 5,
			'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
		];

		register_post_type( 'sb_theme', $args );
	}

	/**
	 * Register custom post type for widget
	 *
	 * @return void
	 */
	private function register_sb_widget() {
		$labels = [
			'name'               => 'SB Widgets',
			'singular_name'      => 'SB Widget',
			'menu_name'          => 'SB Widgets',
			'name_admin_bar'     => 'SB Widget',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New SB Widget',
			'new_item'           => 'New SB Widget',
			'edit_item'          => 'Edit SB Widget',
			'view_item'          => 'View SB Widget',
			'all_items'          => 'All SB Widgets',
			'search_items'       => 'Search SB Widgets',
			'parent_item_colon'  => 'Parent SB Widgets:',
			'not_found'          => 'No sb widgets found.',
			'not_found_in_trash' => 'No sb widgets found in Trash.',
		];

		$args = [
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'sb_widgets' ],
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 5,
			'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
		];

		register_post_type( 'sb_widget', $args );
	}

	/**
	 * Register custom post type for apps
	 *
	 * @return void
	 */
	private function register_sb_app() {
		$labels = [
			'name'               => 'SB Apps',
			'singular_name'      => 'SB App',
			'menu_name'          => 'SB Apps',
			'name_admin_bar'     => 'SB App',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New SB App',
			'new_item'           => 'New SB App',
			'edit_item'          => 'Edit SB App',
			'view_item'          => 'View SB App',
			'all_items'          => 'All SB  Apps',
			'search_items'       => 'Search SB Apps',
			'parent_item_colon'  => 'Parent SB Apps:',
			'not_found'          => 'No sb apps found.',
			'not_found_in_trash' => 'No sb apps found in Trash.',
		];

		$args = [
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => [ 'slug' => 'shopbuilder-apps' ],
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 5,
			'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
		];

		register_post_type( 'sb_app', $args );
	}

	/**
	 * Register custom taxonomy
	 *
	 * @return void
	 */
	private function register_sb_widget_cat() {
		$labels = [
			'name'              => 'Widget Categories',
			'singular_name'     => 'Widget Categorie',
			'search_items'      => 'Search Widget Categories',
			'all_items'         => 'All Widget Categories',
			'parent_item'       => 'Parent Widget Categorie',
			'parent_item_colon' => 'Parent Widget Categorie:',
			'edit_item'         => 'Edit Widget Categorie',
			'update_item'       => 'Update Widget Categorie',
			'add_new_item'      => 'Add New Widget Categorie',
			'new_item_name'     => 'New Widget Categorie Name',
			'menu_name'         => 'Widget Categories',
		];

		$args = [
			'hierarchical'      => true,
			'labels'            => $labels,
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => [ 'slug' => 'widget_category' ],
		];

		register_taxonomy( 'widget_category', 'sb_widget', $args );
	}
}
