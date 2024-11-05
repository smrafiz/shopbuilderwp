<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package shopbuilderwp
 */

use RT\ShopBuilderWP\Helpers\Fns;

$classes = Fns::class_list(
	[
		'site-footer',
	]
);
?>
		</div><!-- #content -->
		<footer class="<?php echo esc_attr( $classes ); ?>" role="contentinfo">
			<?php get_template_part( 'views/footer/footer' ); ?>
		</footer><!-- #colophon -->
		</div><!-- #page -->

		<?php shopbuilderwp_scroll_top(); ?>

		<?php wp_footer(); ?>

	</body>
</html>
