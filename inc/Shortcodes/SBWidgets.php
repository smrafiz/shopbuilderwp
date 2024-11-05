<?php

namespace RT\ShopBuilderWP\Shortcodes;

use Elementor\Plugin;
use RT\ShopBuilderWP\Traits\SingletonTraits;

class SBWidgets {
	use SingletonTraits;

	/**
	 * Register to hook the shortcode.
	 */
	public function register() {
		add_shortcode( 'sb_widgets_tab_shortcode', [ $this, 'render' ] );
	}

	/**
	 * Render the shortcode output.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string Shortcode output.
	 */
	public function render( $atts ) {
		ob_start();

		$terms = get_terms(
			[
				'taxonomy'   => 'widget_category',
				'hide_empty' => true,
				'orderby'    => 'name',
				'order'      => 'DSC',
			]
		);

		?>

		<div class="isotop-wrapper" id="inner-isotope">
			<div class="filter-wrapper">
				<div class="isotope-classes-tab">
					<a class="nav-item current" data-filter="*"><?php echo esc_html__( 'All Widgets', 'storefront-child' ); ?></a>
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
			<div id="preloader">
				<div class="loader"></div>
			</div>
			<div class="widgets-wrapper">
				<div class="featuredContainer">
					<?php
					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) {
							$query->the_post();
							$terms       = wp_get_post_terms( get_the_ID(), 'widget_category' );
							$single_term = $terms[0];
							$single_term = str_replace( ' ', '-', strtolower( $single_term->name ) );
							$meta        = get_post_meta( get_the_ID(), '_sb_widget_post_meta_key', true );
							$is_pro      = $meta['is_pro'] == 1 ? 'Pro' : '';

							$badge = $meta['badge'] ? $meta['badge'] : '';

							$btn_url = $meta['btn_url'] ? $meta['btn_url'] : '';

							?>
							<div class="<?php echo esc_attr( $single_term ); ?>">
								<div class="widget-box">
									<?php
									if ( ! empty( $is_pro ) ) {
										?>
										<div class="badge"><?php echo esc_html( $badge ); ?></div>
									<?php } ?>
									<?php
									if ( ! empty( $is_pro ) ) {
										?>
										<div class="pro-badge"><?php esc_html_e( 'Pro', 'storefront-child' ); ?></div>
									<?php } ?>
									<div class="media-icon">
										<?php the_post_thumbnail(); ?>
									</div>
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
			<script>jQuery('.featuredContainer').isotope();</script>
			<?php
		}
		return ob_get_clean();
	}
}
