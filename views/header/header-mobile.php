<?php
/**
 * Template part for displaying header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package fasheno
 */
?>

	<div class="main-header-section mobile-header-section">
		<div class="header-container rt-container">
			<div class="row navigation-menu-wrap align-middle m-0">
				<div class="site-branding">
					<?php //echo shopbuilderwp_site_logo(); ?>
                    <a href="<?php echo esc_url( home_url()); ?>" class="custom-logo-link dark-logo" rel="home" aria-current="page">
						<?php shopbuilderwp_get_img( 'dark_logo.svg', true, 'width="172" height="46"' ) . "' alt='"; ?>
                    </a>
                    <a href="<?php echo esc_url( home_url()); ?>" class="custom-logo-link light-logo" rel="home" aria-current="page">
						<?php shopbuilderwp_get_img( 'light_logo.svg', true, 'width="172" height="46"' ) . "' alt='"; ?>
                    </a>
                </div><!-- .site-branding -->

                <ul class="menu-icon-action">
                    <li class="ham-burger mobile-hamburg">
                        <button type="button" class="menu-bar trigger-off-canvas" aria-label="hamburger menu">
							<span class="btn-hamburger">
								<span></span>
								<span></span>
								<span></span>
							</span>
                        </button>
                    </li>
                </ul>

			</div><!-- .row -->
		</div><!-- .container -->
	</div>

<?php get_template_part( 'views/header/offcanvas', 'drawer' ); ?>

<?php

