<?php
/**
 * Template part for displaying header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package shopbuilderwp
 */
?>

<div class="main-header-section">
	<div class="header-container rt-container">
		<div class="row navigation-menu-wrap align-middle m-0">
			<div class="site-branding">
				<?php echo shopbuilderwp_site_logo(); ?>
			</div><!-- .site-branding -->
			<nav class="shopbuilderwp-navigation pl-15 pr-15" role="navigation">
				<?php
				wp_nav_menu(
					[
						'theme_location' => 'primary',
						'menu_class'     => 'shopbuilderwp-navbar',
						'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
						'fallback_cb'    => 'shopbuilderwp_custom_menu_cb',
						'walker'         => has_nav_menu( 'primary' ) ? new RT\ShopBuilderWP\Core\WalkerNav() : '',
					]
				);
				?>
			</nav><!-- .shopbuilderwp-navigation -->
		</div><!-- .row -->
	</div><!-- .container -->
</div>
<?php

