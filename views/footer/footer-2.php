<?php
/**
 * Template part for displaying footer
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package shopbuilderwp
 */

$footer_width = 'container'.shopbuilderwp_option('rt_footer_width');
$copyright_center = shopbuilderwp_option('rt_social_footer') ? 'justify-content-between' : 'justify-content-center';
?>

<?php if ( is_active_sidebar( 'rt-footer-sidebar' ) ) : ?>
	<div class="footer-widgets-wrapper">
		<div class="footer-container <?php echo esc_attr($footer_width) ?>">
			<div class="footer-widgets row">
				<?php dynamic_sidebar( 'rt-footer-sidebar' ); ?>
			</div>
		</div>
	</div><!-- .site-info -->
<?php endif; ?>

<?php if ( ! empty( shopbuilderwp_option( 'rt_footer_copyright' ) ) ) : ?>
	<div class="footer-copyright-wrapper">
		<div class="footer-container <?php echo esc_attr( $footer_width ) ?>">
			<div class="copyright-text-wrap d-flex align-items-center <?php echo esc_attr($copyright_center); ?>">
				<div class="copyright-text">
					<?php shopbuilderwp_html( str_replace( '[y]', date( 'Y' ), shopbuilderwp_option( 'rt_footer_copyright' ) ) ); ?>
				</div>
				<?php if( shopbuilderwp_option('rt_social_footer') ) { ?>
				<div class="social-icon d-flex gap-20 align-items-center">
					<div class="social-icon d-flex column-gap-10">
						<?php if( shopbuilderwp_option( 'rt_follow_us_label' ) ) { ?><label><?php shopbuilderwp_html( shopbuilderwp_option( 'rt_follow_us_label' ), 'allow_title' ) ?></label><?php } ?>
						<?php shopbuilderwp_get_social_html( '#555' ); ?>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>

	</div>
<?php endif; ?>
