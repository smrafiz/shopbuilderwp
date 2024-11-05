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
		<div class="footer-container">
			<div class="footer-widgets row">
				<?php dynamic_sidebar( 'rt-footer-sidebar' ); ?>
			</div>
		</div>
	</div><!-- .site-info -->
<?php endif; ?>

<div class="footer-copyright-wrapper text-center">
	<div class="footer-container">
		<div class="d-flex align-items-center">
			<div class="copyright-text">
				<?php shopbuilderwp_html( str_replace( '[y]', date( 'Y' ), 'Copyright @[y] | RadiusTheme' ) ); ?>
			</div>
		</div>
	</div>
</div>
