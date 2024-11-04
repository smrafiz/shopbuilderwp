<?php
/**
 * Template part for displaying header offcanvas
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package shopbuilderwp
 */
use RT\ShopBuilderWP\Options\Opt;
use RT\ShopBuilderWP\Helpers\Fns;
$logo_h1 = ! is_singular( [ 'post' ] );
$topinfo = ( shopbuilderwp_option( 'rt_contact_address' ) || shopbuilderwp_option( 'rt_phone' ) || shopbuilderwp_option( 'rt_email' ) || shopbuilderwp_option( 'rt_email' ) ) ? true : false;
?>


<div class="finwave-offcanvas-drawer">
	<div class="offcanvas-logo">
		<?php echo shopbuilderwp_site_logo( $logo_h1 ); ?>
		<a class="trigger-icon trigger-off-canvas" href="#">×</a>
	</div>
	<?php if( shopbuilderwp_option( 'rt_about_label' ) || shopbuilderwp_option( 'rt_about_text' ) ) { ?>
	<div class="offcanvas-about offcanvas-address">
		<?php if( shopbuilderwp_option( 'rt_about_label' ) ) { ?><label><?php echo shopbuilderwp_option( 'rt_about_label' ) ?></label><?php } ?>
		<?php if( shopbuilderwp_option( 'rt_about_text' ) ) { ?><p><?php echo shopbuilderwp_option( 'rt_about_text' ) ?></p><?php } ?>
	</div>
	<?php } ?>
	<nav class="offcanvas-navigation" role="navigation">
		<?php
		if ( has_nav_menu( 'primary' ) ) :
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'walker'         => new RT\ShopBuilderWP\Core\WalkerNav(),
				)
			);
		endif;
		?>
	</nav><!-- .finwave-navigation -->

	<div class="offcanvas-address">
		<?php if( $topinfo ) { ?>
			<?php if( shopbuilderwp_option( 'rt_contact_info_label' ) ) { ?><label><?php echo shopbuilderwp_option( 'rt_contact_info_label' ) ?></label><?php } ?>
			<ul class="offcanvas-info">
				<?php if( shopbuilderwp_option( 'rt_contact_address' ) ) { ?>
					<li><i class="icon-rt-location-4"></i><?php shopbuilderwp_html( shopbuilderwp_option( 'rt_contact_address' ) , false );?> </li>
				<?php } if( shopbuilderwp_option( 'rt_phone' ) ) { ?>
					<li><i class="icon-rt-phone-2"></i><a href="tel:<?php echo esc_attr( shopbuilderwp_option( 'rt_phone' ) );?>"><?php shopbuilderwp_html( shopbuilderwp_option( 'rt_phone' ) , false );?></a> </li>
				<?php } if( shopbuilderwp_option( 'rt_email' ) ) { ?>
					<li><i class="icon-rt-email"></i><a href="mailto:<?php echo esc_attr( shopbuilderwp_option( 'rt_email' ) );?>"><?php shopbuilderwp_html( shopbuilderwp_option( 'rt_email' ) , false );?></a> </li>
				<?php } if( shopbuilderwp_option( 'rt_website' ) ) { ?>
					<li><i class="icon-rt-development-service"></i><?php shopbuilderwp_html( shopbuilderwp_option( 'rt_website' ) , false );?></li>
				<?php } ?>
			</ul>
		<?php } ?>

		<?php if( shopbuilderwp_option( 'rt_offcanvas_social' ) ) { ?>
			<div class="offcanvas-social-icon">
				<?php shopbuilderwp_get_social_html( '#555' ); ?>
			</div>
		<?php } ?>
	</div>

</div><!-- .container -->

<div class="finwave-body-overlay"></div>
