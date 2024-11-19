<?php
/**
 * Shortcode: SBThemeInfo.
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
class SBThemeInfo {
	use SingletonTraits;

	/**
	 * Register to hook the shortcode.
	 */
	public function register() {
		add_shortcode( 'sb_theme_info', [ $this, 'render' ] );
	}

	/**
	 * Render the shortcode output.
	 *
	 * @return string Shortcode output.
	 */
	public function render() {
		ob_start();

		?>
			<ul class="sb-theme-info">
				<?php
					$theme_version              = get_custom_field( 'sb_themes_version' );
					$theme_last_update          = get_custom_field( 'sb_themes_last_update' );
					$theme_release_date         = get_custom_field( 'sb_themes_release_date' );
					$theme_wordpress_version    = get_custom_field( 'sb_themes_wordpress_version' );
					$theme_wc_version           = get_custom_field( 'sb_themes_wc_version' );
					$theme_shop_builder_version = get_custom_field( 'sb_themes_shopbuilder_version' );
				?>
				<li>Current Version: <span><?php echo esc_html( $theme_version ); ?></span></li>
				<li>Last Updated: <span><?php echo esc_html( $theme_last_update ); ?></span></li>
				<li>Release Date: <span><?php echo esc_html( $theme_release_date ); ?></span></li>
				<li>WordPress Version: <span><?php echo esc_html( $theme_wordpress_version ); ?></span></li>
				<li>Woocommerce: <span><?php echo esc_html( $theme_wc_version ); ?></span></li>
				<li>ShopBuilder: <span><?php echo esc_html( $theme_shop_builder_version ); ?></span></li>
			</ul>
			<?php

			wp_reset_postdata();

			return ob_get_clean();
	}
}
