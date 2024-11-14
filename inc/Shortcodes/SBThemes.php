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
class SBThemes {
	use SingletonTraits;

	/**
	 * Register to hook the shortcode.
	 */
	public function register() {
		add_shortcode( 'sb_themes', [ $this, 'render' ] );
	}

	/**
	 * Render the shortcode output.
	 *
	 * @return string Shortcode output.
	 */
	public function render() {
		ob_start();

		$args  = [
			'post_type'      => 'sb_theme',
			'posts_per_page' => -1,
			'orderby'        => 'date',
			'post_status'    => 'publish',
		];
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			?>
			<div class="sb-themes-wrapper">
				<?php
				while ( $query->have_posts() ) {
					$query->the_post();

					$theme_last_update = get_custom_field( 'sb_theme_last_update' );
					$theme_price       = get_custom_field( 'sb_theme_price' );
					?>
					<div class="sb-theme-item">
						<?php
						if ( has_post_thumbnail() ) {
							?>
							<div class="item-thumb">
								<a href='<?php echo esc_url( get_the_permalink() ); ?>' target="_blank">
									<?php the_post_thumbnail( 'shopbuilderwp-theme' ); ?>
								</a>
							</div>
						<?php } ?>
						<div class="item-content">
							<h3 class="item-title"><a href='<?php echo esc_url( get_the_permalink() ); ?>' target="_blank"><?php the_title(); ?></a></h3>
							<div class="item-details">
								<div class="excerpt"><?php the_excerpt(); ?></div>
								<?php
								if ( $theme_last_update ) {
									?>
									<div class="item-update">
										Last Updated: <?php echo esc_html( $theme_last_update ); ?>
									</div>
									<?php
								}
								?>
							</div>
							<div class="item-footer">
								<?php
								if ( $theme_price ) {
									?>
									<div class="price"><?php echo esc_html( $theme_price ); ?></div>
									<?php
								}
								?>
								<div class="details-btn">
									<a href="<?php the_permalink(); ?>">More Details</a>
								</div>
							</div>
						</div>

					</div>
					<?php
				}
				?>
			</div>
			<?php
		}
		wp_reset_postdata();

		return ob_get_clean();
	}
}
