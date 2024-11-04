<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package shopbuilderwp
 */

?>
<article data-post-id="<?php the_ID(); ?>" <?php post_class( shopbuilderwp_post_class() ); ?>>
	<div class="single-inner-wrapper">
		<?php shopbuilderwp_single_entry_header(); ?>
		<?php shopbuilderwp_post_single_thumbnail(); ?>
		<div class="entry-wrapper">
				<div class="entry-content">
					<?php shopbuilderwp_entry_content() ?>
				</div>
			<?php shopbuilderwp_post_single_video(); ?>
			<?php shopbuilderwp_entry_footer(); ?>
			<?php shopbuilderwp_entry_profile(); ?>
		</div>
	</div>
</article>
