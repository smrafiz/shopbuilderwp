<?php
/**
 * Template part for displaying header offcanvas
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package fasheno
 */

?>

<div class="shopbuilderwp-offcanvas-drawer">
	<div class="offcanvas-drawer-wrap">
		<nav class="offcanvas-navigation" role="navigation">
			<?php
			if ( has_nav_menu( 'primary' ) ) :
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'walker'         => has_nav_menu( 'primary' ) ? new RT\ShopBuilderWP\Core\WalkerNav() : '',
					)
				);
			endif;
			?>
		</nav><!-- .fasheno-navigation -->
	</div>
</div><!-- .container -->