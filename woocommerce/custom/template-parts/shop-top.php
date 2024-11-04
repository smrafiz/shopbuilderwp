<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */
if ( !woocommerce_products_will_display() ) {
	return;
}
use RT\ShopBuilderWP\Helpers\Fns;
$shopview = isset($_GET["displayview"]) && $_GET["displayview"] == 'list' ? 'list' : 'grid';
$shopview_list_class = 'list' == $shopview ? 'selected':'';
$shopview_grid_class = 'grid' == $shopview ? 'selected':'';
?>
<div class="woo-shop-top">
	<div class="limit-sort-wrap">
		<div class="limit-show rtsb-archive-result-count"><?php woocommerce_result_count();?></div>
	</div>
	<div class="view-mode" id="rt-shop-view-mode">
		<ul>
			<li class="sort-list rtsb-archive-catalog-ordering">
				<?php woocommerce_catalog_ordering();?>
				<span class="line"></span>
			</li>
			<li class="grid-view-nav <?php echo esc_attr($shopview_grid_class); ?>">
				<a href="<?php echo Fns::shop_grid_page_url(); ?>" >
					<i class="icon-rt-grid"></i></a>
				<span class="line"></span>
			</li>
			<li class="list-view-nav <?php echo esc_attr($shopview_list_class); ?>">
				<a href="<?php echo Fns::shop_list_page_url(); ?>"><i class="icon-rt-list"></i></a>
			</li>
		</ul>
	</div>
</div>
