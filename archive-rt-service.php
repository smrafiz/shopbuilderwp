<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package shopbuilderwp
 */

use RT\ShopBuilderWP\Helpers\Fns;
use RT\ShopBuilderWP\Options\Opt;
use RT\ShopBuilderWP\Modules\Pagination;

get_header();
$post_classes = "";

if ( Opt::$layout == 'right-sidebar' || Opt::$layout == 'left-sidebar' ) {
	$post_classes = 'col-sm-6 col-lg-6';
} else {
	$post_classes = 'col-sm-6 col-xl-4 col-lg-4';
}

if( shopbuilderwp_option('rt_service_style') == 4 ) {
	if ( ( Opt::$layout == 'right-sidebar' || Opt::$layout == 'left-sidebar' ) ) {
		$post_classes = 'col-12';
	} else {
		$post_classes = 'dsad col-sm-6 col-lg-6';
	}
}

if ( shopbuilderwp_option( 'rt_service_style' ) == 'default' ){
	$service_archive_layout 		= "rt-service-default rt-service-multi-layout-1";
} elseif ( shopbuilderwp_option( 'rt_service_style' ) == '2' ){
	$service_archive_layout 		= "rt-service-default rt-service-multi-layout-2";
} elseif ( shopbuilderwp_option( 'rt_service_style' ) == '3' ){
	$service_archive_layout 		= "rt-service-default rt-service-multi-layout-3";
} elseif ( shopbuilderwp_option( 'rt_service_style' ) == '4' ){
	$service_archive_layout 		= "rt-service-default rt-service-multi-layout-4";
} elseif ( shopbuilderwp_option( 'rt_service_style' ) == '5' ){
	$service_archive_layout 		= "rt-service-default rt-service-multi-layout-5";
} else {
	$service_archive_layout 		= "rt-service-default rt-service-multi-layout-1";
}
$content_columns = Fns::content_columns();

?>

<div id="primary" class="content-area">
	<div class="container">
		<div class="row">
			<div class="<?php echo esc_attr( $service_archive_layout );?> <?php echo esc_attr( $content_columns ); ?>">
				<main id="main" class="site-main">
					<?php if ( have_posts() ) :?>
						<div class="row g-4 item-parent rt-masonry-grid">
							<?php while ( have_posts() ) : the_post(); ?>
								<div class="<?php echo esc_attr( $post_classes );?> item rt-grid-item">
									<?php get_template_part( 'views/content-service', shopbuilderwp_option( 'rt_service_style' ) ); ?>
								</div>
							<?php endwhile; ?>
						</div>
					<?php else:?>
						<?php get_template_part( 'views/content', 'none' );?>
					<?php endif;?>
					<?php Pagination::pagination(); ?>
				</main>
			</div>
			<?php //get_sidebar(); ?>

			<?php

			if ( is_active_sidebar( Fns::default_sidebar('service') ) ) {
				shopbuilderwp_sidebar( Fns::default_sidebar('service')  );
			} else {
				shopbuilderwp_sidebar( Fns::default_sidebar('main') );
			}

			?>

		</div>
	</div>
</div>
<?php get_footer(); ?>
