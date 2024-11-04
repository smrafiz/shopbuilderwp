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

if ( shopbuilderwp_option( 'rt_project_style' ) == 'default' ){
	$project_archive_layout 		= "rt-project-default rt-project-multi-layout-default";
} elseif ( shopbuilderwp_option( 'rt_project_style' ) == '2' ){
	$project_archive_layout 		= "rt-project-default rt-project-multi-layout-2";
} elseif ( shopbuilderwp_option( 'rt_project_style' ) == '3' ){
	$project_archive_layout 		= "rt-project-default rt-project-multi-layout-3";
} elseif ( shopbuilderwp_option( 'rt_project_style' ) == '4' ){
	$project_archive_layout 		= "rt-project-default rt-project-multi-layout-4";
} elseif ( shopbuilderwp_option( 'rt_project_style' ) == '5' ){
	$project_archive_layout 		= "rt-project-default rt-project-multi-layout-5";
} else {
	$project_archive_layout 		= "rt-project-default rt-project-multi-layout-1";
}
$content_columns = Fns::content_columns();

?>

<div id="primary" class="content-area">
	<div class="container">
		<div class="row">
			<div class="<?php echo esc_attr( $project_archive_layout );?> <?php echo esc_attr( $content_columns ); ?>">
				<main id="main" class="site-main">
					<?php if ( have_posts() ) :?>
						<div class="row g-4 item-parent">
							<?php while ( have_posts() ) : the_post(); ?>
								<div class="<?php echo esc_attr( $post_classes );?> item">
									<?php get_template_part( 'views/content-project', shopbuilderwp_option( 'rt_project_style' ) ); ?>
								</div>
							<?php endwhile; ?>
						</div>
					<?php else:?>
						<?php get_template_part( 'views/content', 'none' );?>
					<?php endif;?>
					<?php Pagination::pagination(); ?>
				</main>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
