<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package shopbuilderwp
 */

use RT\ShopBuilderWP\Helpers\Fns;
use RT\ShopBuilderWP\Modules\Pagination;

get_header();
?>

	<div id="primary" class="content-area">
		<div class="container">
			<div class="row">
				<div class="<?php echo esc_attr( Fns::content_columns() ); ?>">
					<main id="main" class="site-main" role="main">
						<div class="row g-4">
							<?php
							if ( have_posts() ) :
								/* Start the Loop */
								while ( have_posts() ) :
									the_post();
									get_template_part( 'views/content', get_post_format() );
								endwhile;
							else :
								get_template_part( 'views/content', 'none' );
							endif;
							?>
						</div>
						<?php Pagination::pagination(); ?>
					</main><!-- #main -->
				</div><!-- .col- -->
				<?php get_sidebar(); ?>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- #primary -->
<?php
get_footer();
