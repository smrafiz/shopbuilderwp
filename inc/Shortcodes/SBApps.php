<?php
/**
 * Shortcode: SBThemes.
 *
 * Renders the themes.
 *
 * @package RT\ShopBuilderWP
 */

namespace RT\ShopBuilderWP\Shortcodes;

use WP_Query;
use RT\ShopBuilderWP\Traits\SingletonTraits;

/**
 * Shortcode: SBThemes.
 */
class SBApps {
	use SingletonTraits;

	/**
	 * Register to hook the shortcode.
	 */
	public function register() {
		add_shortcode( 'sb_apps', [ $this, 'render' ] );
	}

	/**
	 * Render the shortcode output.
	 *
	 * @return string Shortcode output.
	 */
	public function render() {
		ob_start();

		$args  = [
			'post_type'      => 'sb_app',
			'posts_per_page' => - 1,
			'orderby'        => 'date',
			'post_status'    => 'publish',
		];
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			?>
			<div class="sb-themes-wrapper sb-apps">
				<?php
				$i = 100;
				while ( $query->have_posts() ) {
					$query->the_post();
					$app_last_update = get_custom_field( 'sb_app_last_update' );
					$app_price       = get_custom_field( 'sb_app_price' );

					?>
					<div class="sb-theme-item sb-app-item animated fadeInUp" style="animation-delay: <?php echo absint( $i ); ?>ms">
						<?php
						if ( has_post_thumbnail() ) {
							?>
							<div class="item-thumb">
								<a href='<?php echo esc_url( get_the_permalink() ); ?>' target="_blank">
									<?php the_post_thumbnail( 'full' ); ?>
								</a>
							</div>
						<?php } ?>
						<div class="item-content">
							<h2 class="item-title">
								<a href='<?php echo esc_url( get_the_permalink() ); ?>'><?php the_title(); ?></a>
							</h2>
							<?php
							if ( $app_last_update ) {
								?>
								<div class="item-update">
									Last Updated: <span><?php echo esc_html( $app_last_update ); ?></span>
								</div>
								<?php
							}
							?>
							<div class="item-details">
								<div class="excerpt"><?php the_excerpt(); ?></div>
							</div>
							<div class="item-footer">
								<?php
								if ( $app_price ) {
									?>
									<div class="price"><?php echo esc_html( $app_price ); ?></div>
									<?php
								}
								?>
								<div class="details-btn rt-button sb-button">
									<a class="btn button-1" href="<?php the_permalink(); ?>" data-text="More Details">
										<span class="elementor-button-wrap">
											<span class="elementor-button-text">More Details</span>
											<span class="elementor-button-icon">
											<svg width="20" height="14" viewBox="0 0 20 14" fill="none"
												 xmlns="http://www.w3.org/2000/svg">
												<path d="M0.910156 7H18.9102M18.9102 7L12.9102 1M18.9102 7L12.9102 13"
													  stroke="currentColor" stroke-width="1.71429"
													  stroke-linecap="round" stroke-linejoin="round"/>
											</svg>
											</span>
										</span>
									</a>
								</div>
							</div>
						</div>

					</div>
					<?php
					$i = $i + 100;
				}
				?>
			</div>
			<?php
		}
		wp_reset_postdata();

		return ob_get_clean();
	}
}
