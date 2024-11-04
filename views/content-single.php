<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package shopbuilderwp
 */

use RT\ShopBuilderWP\Options\Opt;

?>
<article data-post-id="<?php the_ID(); ?>" <?php post_class( shopbuilderwp_post_class() ); ?>>
	<div class="single-inner-wrapper">
		<?php if ( ! in_array( Opt::$single_style, [ '2', '3', '4', '5' ] ) ) : ?>
			<?php shopbuilderwp_post_single_thumbnail(); ?>
		<?php endif; ?>
		<div class="entry-wrapper">
			<?php shopbuilderwp_single_entry_header(); ?>
				<div class="entry-content">
					<?php shopbuilderwp_entry_content() ?>
				</div>
			<?php shopbuilderwp_post_single_video(); ?>
			<?php shopbuilderwp_entry_footer(); ?>
			<?php shopbuilderwp_entry_profile(); ?>
		</div>
	</div>
</article>
