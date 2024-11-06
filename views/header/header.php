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
		<div class="row navigation-menu-wrap m-0">
			<div class="site-branding">
				<?php echo shopbuilderwp_site_logo(); ?>
			</div><!-- .site-branding -->
			<nav class="shopbuilderwp-navigation" role="navigation">
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
            <div class="shopbuilder-button rt-button">
                <a class="btn button-1" href="https://www.radiustheme.com/downloads/woocommerce-bundle/" target="_blank"><?php echo esc_html__('Purchase Now', 'shopbuilderwp'); ?></a>
            </div>
		</div><!-- .row -->
	</div><!-- .container -->
</div>
<?php

