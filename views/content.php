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
	<div class="article-inner-wrapper">
		<?php shopbuilderwp_post_thumbnail( 'shopbuilderwp-size3' ); ?>
		<div class="entry-wrapper">
			<header class="entry-header">
				<?php
				shopbuilderwp_separate_meta( 'title-above-meta' );
				if ( ! is_single() ) {
					the_title( sprintf( '<h2 class="entry-title default-max-width"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' );
				} else {
					the_title( '<h2 class="entry-title default-max-width">', '</h2>' );
				}

				if ( ! empty( $meta_list ) ) {
					echo shopbuilderwp_post_meta(
						[
							'with_list' => true,
							'with_icon' => true,
							'include'   => $meta_list,
						]
					);
				}
				?>
			</header>
			<div class="entry-content">
				<?php shopbuilderwp_entry_content(); ?>
			</div>
			<?php shopbuilderwp_entry_footer(); ?>
		</div>
	</div>
</article>
