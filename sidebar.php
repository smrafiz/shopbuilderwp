<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package shopbuilderwp
 */


use RT\ShopBuilderWP\Helpers\Fns;

if ( is_singular() && is_active_sidebar( Fns::default_sidebar('single') ) ) {
	shopbuilderwp_sidebar( Fns::default_sidebar('single')  );
} else {
	shopbuilderwp_sidebar( Fns::default_sidebar('main') );
}
