<?php
/**
 *
 * This theme uses PSR-4 and OOP logic instead of procedural coding
 * Every function, hook and action is properly divided and organized inside related folders and files
 * Use the file `inc/Custom/Custom.php` to write your custom functions
 *
 * @package shopbuilderwp
 */

if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) :
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
endif;

if ( class_exists( 'RT\\ShopBuilderWP\\Init' ) ) :
	RT\ShopBuilderWP\Init::instance();
	do_action('shopbuilderwp_theme_init');
endif;

add_editor_style( 'style-editor.css' );
