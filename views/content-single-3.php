<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package shopbuilderwp
 */

$meta_list = shopbuilderwp_option( 'rt_single_meta', '', true );
$meta      = shopbuilderwp_option( 'rt_blog_above_meta_visibility' );
$meta      = shopbuilderwp_option( 'rt_single_above_meta_style' );
if ( shopbuilderwp_option( 'rt_single_above_meta_visibility' ) ) {
	$category_index = array_search( 'category', $meta_list );
	unset( $meta_list[ $category_index ] );
}
?>
<article data-post-id="<?php the_ID(); ?>" <?php post_class( shopbuilderwp_post_class() ); ?>>
	<div class="single-inner-wrapper">
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
