<?php
/**
 * Template part for displaying banner content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package finwave
 */
use RadiusTheme\SB\Helpers\BuilderFns;
/*banner title*/
if ( is_404() ) {
	$banner_title = 'Error Page';
} elseif ( is_search() ) {
	$banner_title = esc_html__( 'Search Results for : ', 'shopbuilderwp' ) . get_search_query();
} elseif ( is_home() ) {
	if ( get_option( 'page_for_posts' ) ) {
		$banner_title = get_the_title( get_option( 'page_for_posts' ) );
	} else {
		$banner_title = apply_filters( 'theme_blog_title', esc_html__( 'All Posts', 'shopbuilderwp' ) );
	}
} elseif ( is_category() ) {
	$banner_title = single_term_title( '', false );
} elseif ( is_archive() ) {
	$banner_title = esc_html__( 'Our Recent Posts', 'shopbuilderwp' );
} elseif ( is_single() ) {
	$banner_title = get_the_title();
} else {
	$banner_title = get_the_title();
}


if ( class_exists( 'WooCommerce' ) ) {
	if ( is_shop() ) {
		$banner_title = esc_html__( 'Shop', 'shopbuilderwp' );
	} elseif ( class_exists( BuilderFns::class ) && is_singular( BuilderFns::$post_type_tb ) ) {
		$banner_title  = get_the_title();
	} elseif ( is_product_category() ) {
		$category = get_queried_object();
		if ( $category ) {
			$banner_title = $category->name;
		}
	} elseif ( is_product() ) {
		$banner_title  = get_the_title();
	} else {
		$banner_title = $banner_title;
	}
}

$banner_title     = ! empty( get_custom_field( 'page_title' ) ) ? get_custom_field( 'page_title' ) : $banner_title;
$page_description = get_custom_field( 'page_description' );

?>

<div class="sb-breadcrumb-banner">
	<div class="container d-flex flex-column">
		<h1 class="entry-title"><?php echo esc_html( $banner_title ); ?></h1>
		<?php if ( $page_description ) { ?><p><?php shopbuilderwp_html( $page_description, false ); ?></p><?php } ?>
	</div>
</div>
