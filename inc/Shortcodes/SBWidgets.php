<?php
/**
 * Shortcode: SBWidgets.
 *
 * Renders ShopBuilder widgets with tabs.
 *
 * @package RT\ShopBuilderWP
 */

namespace RT\ShopBuilderWP\Shortcodes;

use Elementor\Plugin;
use RT\ShopBuilderWP\Traits\SingletonTraits;

/**
 * Shortcode: SBWidgets.
 */
class SBWidgets {
	use SingletonTraits;

	/**
	 * Register to hook the shortcode.
	 */
	public function register() {
		add_shortcode( 'sb_widgets', [ $this, 'render' ] );
	}

	/**
	 * Render the shortcode output.
	 *
	 * @return string Shortcode output.
	 */
	public function render() {
		ob_start();
		wp_enqueue_script( 'sb-isotope' );

		$terms = get_terms(
			[
				'taxonomy'   => 'widget_category',
				'hide_empty' => true,
				'orderby'    => 'name',
				'order'      => 'DSC',
			]
		);

		?>

		<div class="sb-isotope-wrapper">
			<div class="filter-wrapper">
				<div class="isotope-tab">
					<a class="nav-item current" data-filter="*">All Widgets</a>
					<?php
					foreach ( $terms as $term ) :
						$term_name = str_replace( ' ', '-', strtolower( $term->name ) );
						?>
						<a class="nav-item" data-filter=".<?php echo esc_attr( $term_name ); ?>"><?php echo esc_html( $term->name ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>
			<?php
			$args  = [
				'post_type'      => 'sb_widget',
				'posts_per_page' => -1,
				'orderby'        => 'name',
				'order'          => 'DSC',
				'post_status'    => 'publish',
			];
			$query = new \WP_Query( $args );

			?>
			<div id="sb-preloader">
				<div class="loader"></div>
			</div>
			<div class="widgets-wrapper">
				<div class="featured-container">
					<?php
					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) {
							$query->the_post();
							$terms       = wp_get_post_terms( get_the_ID(), 'widget_category' );
							$single_term = $terms[0] ?? '';
							$single_term = ! empty( $single_term ) ? str_replace( ' ', '-', strtolower( $single_term->name ) ) : '';
							$is_pro      = get_custom_field( 'sb_widgets_is_pro' ) ? 'Pro' : '';
							$badge       = get_custom_field( 'sb_widgets_badge' ) ?? '';
							$btn_url     = get_custom_field( 'sb_widgets_btn_link' ) ?? '';

							?>
							<div class="<?php echo esc_attr( $single_term ); ?>">
								<div class="widget-box">
									<?php
									if ( ! empty( $is_pro ) ) {
										?>
										<div class="badge"><?php echo esc_html( $badge ); ?></div>
										<?php
									}

									if ( ! empty( $is_pro ) ) {
										?>
										<div class="pro-badge">Pro</div>
										<?php
									}
									?>
									<div class="media-icon"><?php the_post_thumbnail(); ?></div>
									<h3 class="title"><a target="_blank" href="<?php echo esc_url( $btn_url ); ?>"><?php the_title(); ?></a></h3>
								</div>
							</div>
							<?php
						}
					}

					wp_reset_postdata();
					?>
				</div>
			</div>

		</div>
		<?php
		if ( Plugin::$instance->editor->is_edit_mode() ) {
			?>
			<script>jQuery('.featured-container').isotope();</script>
			<?php
		}
		return ob_get_clean();
	}
}
