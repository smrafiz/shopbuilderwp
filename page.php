<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package shopbuilderwp
 */


get_header();

?>
    <div id="primary" class="content-area">
        <div class="container">
            <div class="row align-stretch">
                <div class="col-12">
                    <main id="main" class="site-main" role="main">
		                <?php
		                while ( have_posts() ) :
			                the_post();
			                get_template_part( 'views/content', 'page' );
			                if ( comments_open() || get_comments_number() ) :
				                comments_template();
			                endif;
		                endwhile;
		                ?>
                    </main><!-- #main -->
                </div><!-- .col- -->
				<?php //get_sidebar(); ?>
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- #primary -->
<?php
get_footer();
