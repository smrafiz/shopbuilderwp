<?php
/**
 * Template part for displaying banner content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package finwave
 */

/*banner title*/
if ( is_404() ) {
	$finwave_title = "Error Page";
}
elseif ( is_search() ) {
	$finwave_title = esc_html__( 'Search Results for : ', 'shopbuilderwp' ) . get_search_query();
}
elseif ( is_home() ) {
	if ( get_option( 'page_for_posts' ) ) {
		$finwave_title = get_the_title( get_option( 'page_for_posts' ) );
	}
	else {
		$finwave_title = apply_filters( 'theme_blog_title', esc_html__( 'All Posts', 'shopbuilderwp' ) );
	}
} elseif ( is_category() ) {
	$finwave_title = single_term_title( '', false );
} elseif ( is_archive() ) {
	$finwave_title = esc_html__( 'Our Recent Posts', 'shopbuilderwp' );
} elseif ( is_single() ) {
	$finwave_title = get_the_title();
} else {
	$finwave_title = get_the_title();
}

$banner_title = ! empty( get_field('page_title') ) ? get_field('page_title') : get_the_title();

?>

<div class="sb-breadcrumb-banner">
	<div class="container d-flex flex-column">
		<h1 class="entry-title"><?php echo esc_html( $banner_title );?></h1>
		<p><?php echo esc_html__( 'The WooCommerce Flash Sales feature boosts sales by creating urgency. Easily schedule ', 'shopbuilderwp' ); ?></p>
	</div>
</div>
