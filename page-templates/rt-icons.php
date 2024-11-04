<?php
/**
 * Template Name: RT Icons
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package shopbuilderwp
 */

get_header(); ?>
	<div class="container">
		<div class="row pt-50 pb-50 d-flex gap-15">
			<?php
			echo shopbuilderwp_get_svg( 'search' );
			echo shopbuilderwp_get_svg( 'facebook' );
			echo shopbuilderwp_get_svg( 'twitter' );
			echo shopbuilderwp_get_svg( 'linkedin' );
			echo shopbuilderwp_get_svg( 'instagram' );
			echo shopbuilderwp_get_svg( 'pinterest' );
			echo shopbuilderwp_get_svg( 'tiktok' );
			echo shopbuilderwp_get_svg( 'youtube' );
			echo shopbuilderwp_get_svg( 'snapchat' );
			echo shopbuilderwp_get_svg( 'whatsapp' );
			echo shopbuilderwp_get_svg( 'reddit' );
			?>
		</div>
	</div>
<?php
get_footer();
