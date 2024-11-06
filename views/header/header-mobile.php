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
					<?php echo shopbuilderwp_site_logo(); ?>
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

