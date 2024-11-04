<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
use RadiusTheme\SB\Helpers\Fns;
use RT\ShopBuilderWP\Plugins\FinwaveWcFunctions;
global $product;
$product_id  = $product->get_id();
$cat = shopbuilderwp_option('wc_woo_cat') ? FinwaveWcFunctions::get_top_category_name() : false;

?>
<div class="rt-product-block rt-product-grid">
	<div class="rt-product-thumb">
		<?php if ( shopbuilderwp_option( 'wc_shop_sale_flash' ) ) woocommerce_show_product_loop_sale_flash(); ?>
		<a href="<?php the_permalink();?>"><?php woocommerce_template_loop_product_thumbnail(); ?></a>
		<?php do_action('toyup_shop_layout_after_image'); ?>
		<?php do_action('toyup_shop_layout_before_cart_button'); ?>
		<div class="rt-shop-meta rtsb-action-buttons">
			<?php
			if ( shopbuilderwp_option('wc_woo_cart') ) FinwaveWcFunctions::print_add_to_cart_icon( $product_id, true, true );
			$module_data = [
				'wc_shop_quickview_icon' => shopbuilderwp_option( 'wc_shop_quickview_icon' ),
				'wc_shop_wishlist_icon'  => shopbuilderwp_option( 'wc_shop_wishlist_icon' ),
				'wc_shop_compare_icon'   => shopbuilderwp_option( 'wc_shop_compare_icon' ),
				'wc_shop_qcheckout_icon' => shopbuilderwp_option( 'wc_shop_qcheckout_icon' ),
			];
			do_action('rdtheme_after_actions_button', $product, $module_data);
			?>
		</div>
		<?php do_action('toyup_shop_layout_after_cart_button'); ?>
	</div>
	<div class="rt-content-area">
		<?php if ( shopbuilderwp_option('rt_woo_variation_attr') ) { ?>
			<?php do_action('rtwpvs_show_archive_variation'); ?>
		<?php } ?>

		<?php if ( $cat ): ?>
			<?php shopbuilderwp_html( $cat, false );?>
		<?php endif; ?>

		<h3 class="rt-shop-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>

		<?php if ( shopbuilderwp_option('wc_shop_rating') == 1 ) { ?>
			<div class="rating-custom">
				<?php if( function_exists( 'rtsb' ) ){
					Fns::get_product_rating_html();
					$rating_count = $product->get_rating_count(); ?>
					<?php } else {
					wc_get_template( 'rating.php' );
				} ?>
			</div>
		<?php } ?>

		<?php if ( $price_html = $product->get_price_html() ) { ?>
			<div class="rt-price price"><?php shopbuilderwp_html( $price_html, false ); ?></div>
		<?php } ?>
	</div>
</div>
