<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package shopbuilderwp
 */

get_header();

?>

<div id="primary" class="content-area">
	<div class="container 404-container">
		<main id="main" class="site-main error-404" role="main">
			<?php shopbuilderwp_get_img( '404.png', true, 'width="1007" height="530"' ) . "' alt='"; ?>

			<div class="error-info">
				<h2 class="error-title"><?php shopbuilderwp_html( '404', 'allow_title' ); ?></h2>
				<p><?php shopbuilderwp_html( 'The page you are looking for was moved, removed, renamed or might never have existed.', 'allow_title' ); ?></p>

				<div class="rt-button">
					<a class="btn btn-primary" href="<?php echo esc_url( home_url() ); ?>">
						<?php shopbuilderwp_html( 'Go to Home', 'allow_title' ); ?><i class="icon-rt-right-arrow"></i>
					</a>
				</div>

			</div>
		</main><!-- #main -->
	</div><!-- container - -->
</div><!-- #primary -->

<?php
get_footer();
