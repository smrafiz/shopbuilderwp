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
				<?php // echo shopbuilderwp_site_logo(); ?>

				<a href="<?php echo esc_url( home_url() ); ?>" class="custom-logo-link dark-logo" rel="home" aria-current="page">
					<?php shopbuilderwp_get_img( 'dark_logo.svg', true, 'width="172" height="46"' ) . "' alt='"; ?>
				</a>
				<a href="<?php echo esc_url( home_url() ); ?>" class="custom-logo-link light-logo" rel="home" aria-current="page">
					<?php shopbuilderwp_get_img( 'light_logo.svg', true, 'width="172" height="46"' ) . "' alt='"; ?>
				</a>

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
			<div class="shopbuilder-button rt-button sb-button">
				<a class="btn button-1" href="https://www.radiustheme.com/downloads/woocommerce-bundle/" target="_blank" data-text="Purchase Now">
                    <span class="elementor-button-wrap">
                        <span class="elementor-button-text">Purchase Now</span>
                        <span class="elementor-button-icon">
                        <svg width="20" height="14" viewBox="0 0 20 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.910156 7H18.9102M18.9102 7L12.9102 1M18.9102 7L12.9102 13" stroke="currentColor" stroke-width="1.71429" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        </span>
                    </span>
                </a>
			</div>
		</div><!-- .row -->
	</div><!-- .container -->
</div>
<?php

