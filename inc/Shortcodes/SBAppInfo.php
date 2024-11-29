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
class SBAppInfo {
	use SingletonTraits;

	/**
	 * Register to hook the shortcode.
	 */
	public function register() {
		add_shortcode( 'sb_app_info', [ $this, 'render' ] );
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
					$theme_version          = get_custom_field( 'sb_app_version' );
					$theme_last_update      = get_custom_field( 'sb_app_last_update' );
					$theme_release_date     = get_custom_field( 'sb_app_release_date' );
					$android_tested_version = get_custom_field( 'sb_app_android_tested_version' );
					$ios_tested_version     = get_custom_field( 'sb_app_ios_tested_version' );
					$requirements           = get_custom_field( 'sb_app_android_ios_requires' );
				?>
				<?php if ( $theme_version ) { ?>
					<li>Current Version: <span><?php echo esc_html( $theme_version ); ?></span></li>
				<?php } if ( $theme_last_update ) { ?>
					<li>Last Updated: <span><?php echo esc_html( $theme_last_update ); ?></span></li>
				<?php } if ( $theme_release_date ) { ?>
					<li>Release Date: <span><?php echo esc_html( $theme_release_date ); ?></span></li>
				<?php } if ( $android_tested_version ) { ?>
					<li>Android Tested Up to: <span><?php echo esc_html( $android_tested_version ); ?></span></li>
				<?php } if ( $ios_tested_version ) { ?>
					<li>iOS Tested Up to: <span><?php echo esc_html( $ios_tested_version ); ?></span></li>
				<?php } if ( $requirements ) { ?>
					<li>Requirements: <span><?php echo esc_html( $requirements ); ?></span></li>
				<?php } ?>
			</ul>
			<?php

			wp_reset_postdata();

			return ob_get_clean();
	}
}
