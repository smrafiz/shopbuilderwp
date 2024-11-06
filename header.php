<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package shopbuilderwp
 */
use RT\ShopBuilderWP\Options\Opt;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<header id="masthead" class="site-header headroom" role="banner">
        <div class="header-desktop">
	        <?php get_template_part( 'views/header/header' ); ?>
        </div>
        <div class="header-mobile">
			<?php get_template_part( 'views/header/header', 'mobile' ); ?>
        </div>
	</header>

	<div id="content" class="site-content">
		<?php
        $banner_display = get_field('banner_display');

        if ( ! $banner_display ) {
            get_template_part( 'views/content-banner' );
        }

        ?>
