<?php
/**
 * Template part for displaying footer
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package shopbuilderwp
 */
?>

<?php if ( is_active_sidebar( 'rt-footer-sidebar' ) ) : ?>
	<div class="footer-widgets-wrapper">
		<div class="rt-container">
			<div class="footer-widgets row">
				<?php dynamic_sidebar( 'rt-footer-sidebar' ); ?>
			</div>
		</div>
	</div><!-- .site-info -->
<?php endif; ?>

<div class="footer-copyright-wrapper text-center">
	<div class="rt-container">
		<div class="copy-right-wrap d-flex align-items-center">
			<div class="copyright-text"><?php shopbuilderwp_html( str_replace( '[y]', date( 'Y' ), '@ Copyright <a href="https://radiustheme.com" rel="nofollow" target="_blank">RadiusTheme</a> [y] | All Right Reserved.' ) ); ?></div>
			<div class="payment-text"><?php echo esc_html__('Secure Payment:', 'shopbuilderwp') ?><?php shopbuilderwp_get_img( 'payment_logo.svg', true, 'width="150" height="18"' ) . "' alt='"; ?></div>
		</div>
	</div>
</div>
