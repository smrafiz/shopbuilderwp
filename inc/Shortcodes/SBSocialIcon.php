<?php
/**
 * Shortcode: SBSocialIcon.
 *
 * Renders the themes.
 *
 * @package RT\ShopBuilderWP
 */

namespace RT\ShopBuilderWP\Shortcodes;
use RT\ShopBuilderWP\Traits\SingletonTraits;

/**
 * Shortcode: SBThemes.
 */
class SBSocialIcon {
	use SingletonTraits;

	/**
	 * Register to hook the shortcode.
	 */
	public function register() {
		add_shortcode( 'sb_social_icon', [ $this, 'render' ] );
	}

	/**
	 * Render the shortcode output.
	 *
	 * @return string Shortcode output.
	 */
	public function render() {
		ob_start();

			?>
		<ul class="rt-social">
			<li class="rt-social-item rt-social-1">
				<a class="rt-social-link fb" href="https://www.facebook.com/radiustheme/" target="_blank" rel="noopener"><?php echo shopbuilderwp_get_svg('facebook') ?></a>
			</li>
			<li class="rt-social-item rt-social-2">
				<a class="rt-social-link tw" href="https://twitter.com/radiustheme/" target="_blank" rel="noopener"><?php echo shopbuilderwp_get_svg('twitter') ?></a>
			</li>
			<li class="rt-social-item rt-social-3">
				<a class="rt-social-link in" href="https://www.linkedin.com/company/radiustheme/" target="_blank" rel="noopener"><?php echo shopbuilderwp_get_svg('linkedin') ?></a>
			</li>
			<li class="rt-social-item rt-social-4">
				<a class="rt-social-link yu" href="https://www.youtube.com/c/RadiusTheme" target="_blank" rel="noopener"><?php echo shopbuilderwp_get_svg('youtube') ?></a>
			</li>
			<li class="rt-social-item rt-social-5"><a class="rt-social-link env" href="https://themeforest.net/user/radiustheme" target="_blank" rel="noopener"><?php echo shopbuilderwp_get_svg('envato') ?></a></li>
		</ul>
			<?php

		wp_reset_postdata();

		return ob_get_clean();
	}
}
