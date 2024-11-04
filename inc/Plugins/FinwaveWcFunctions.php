<?php
namespace RT\ShopBuilderWP\Plugins;
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

use RadiusTheme\SB\Helpers\BuilderFns;
use RT\ShopBuilderWP\Modules\Pagination;

class FinwaveWcFunctions {
	protected static $instance = null;

	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	public function __construct() {
		/* Theme supports for WooCommerce */
		add_action( 'after_setup_theme', array( $this, 'theme_support' ) );
		add_filter( 'body_class', array( $this, 'body_classes' ) );
		/* ====== Shop/Archive Wrapper ====== */
		// Remove
		remove_action( 'woo_main_before','woo_display_breadcrumbs', 10 );
		remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0 );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_sidebar','woocommerce_get_sidebar', 10 );
		remove_action( 'woocommerce_after_main_content','woocommerce_output_content_wrapper_end', 10 );
		remove_action( 'woocommerce_after_shop_loop',     'woocommerce_pagination', 10 );
		/* Shop top tab */
		remove_action( 'woocommerce_before_shop_loop','woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop','woocommerce_catalog_ordering', 30 );
		// Add
		add_action( 'woocommerce_before_main_content',array( $this, 'wrapper_start' ), 10 );
		add_action( 'woocommerce_after_main_content',array( $this, 'wrapper_end' ), 10 );
		add_action( 'woocommerce_before_shop_loop',array( $this, 'shop_topbar' ), 20 );
		add_action( 'loop_shop_per_page',array( $this, 'loop_shop_per_page' ), 20 );
		add_filter( 'loop_shop_columns',array( $this, 'loop_shop_columns' ),20 );
		add_action( 'woocommerce_after_shop_loop',array( $this, 'products_paginations' ), 10 );
		add_action('rdtheme_after_actions_button', array($this, 'actions_button_control' ), 20, 3 );

		/* ====== Product Single Wrapper ====== */
		add_action('woocommerce_share',[__CLASS__,'shopbuilderwp_product_share']);

		//Filter Hooks
		add_filter( 'woocommerce_show_page_title','__return_false' );
		add_filter( 'woocommerce_sale_flash',array( $this, 'sale_flash' ), 10, 3 );
		add_filter( 'rtsb/quick_checkout/button/text',array( $this, 'quick_checkout_text' ), 10);
		add_filter( 'rtsb/quick_checkout/button/icon',array( $this, 'quick_checkout_icon' ), 10);
		add_filter( 'rtsb/module/compare/icon_html',array( $this, 'compare_button_icon' ), 10);
		add_filter( 'rtsb/module/quick_view/icon_html',array( $this, 'quick_view_icon' ), 10);
		// Countdown
		add_filter( 'rtsb/module/flash_sale_countdown/loop_counter_positions', array( $this, 'flash_sale_countdown_positions' ) );

	}

	public function theme_support(  ) {
		add_theme_support( 'woocommerce');
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	public function body_classes( $classes ) {
		if( isset( $_GET["displayview"] ) && $_GET["displayview"] == 'list' ) {
			$classes[] = 'product-list-view';
		}
		else {
			$classes[] = 'product-grid-view';
		}

		if ( is_singular( 'product' ) || ( class_exists( ShopBuilder::class ) && is_singular( BuilderFns::$post_type_tb ) ) ) {
			$classes[] = 'single-product-layout';
			if ( function_exists( 'rtwpvg' ) ) {
				$classes[] = 'thumb-pos-' . rtwpvg()->get_option('thumbnail_position');
			}
		}

		return $classes;
	}
	public static function get_custom_template_part( $template, $args = array() ){
		$template = 'woocommerce/custom/template-parts/' . $template;
		self::get_template_part( $template, $args );
	}
	// Template Loader
	public static function get_template_part( $template, $args = array() ){
		extract( $args );

		$template = '/' . $template . '.php';

		if ( file_exists( get_stylesheet_directory() . $template ) ) {
			$file = get_stylesheet_directory() . $template;
		}
		else {
			$file = get_template_directory() . $template;
		}

		require $file;
	}

	public function wrapper_start(  ) {
		self::get_custom_template_part( 'shop-header' );
	}

	public function wrapper_end(  ) {
		self::get_custom_template_part( 'shop-footer' );
	}

	public function shop_topbar(  ) {
		self::get_custom_template_part( 'shop-top' );
	}
	public function loop_shop_per_page(){
		$shop_posts_per_page = shopbuilderwp_option('products_per_page');
		if (!empty($shop_posts_per_page)) {
			$products = $shop_posts_per_page;
		} else {
			$products = '8';
		}
		return $products;
	}

	public function products_paginations(  ) {
		Pagination::pagination();
	}

	public function loop_shop_columns(  ) {
		if( isset($_GET["displayview"]) && $_GET["displayview"] == 'list' ) {
			$cols = 1;
		} else {
			$cols = shopbuilderwp_option('products_cols_width');
		}
		return $cols;
	}
	//Shop category
	public static function get_top_category_name(){
		global $product;
		$terms = wc_get_product_terms( $product->get_id(), 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) );
		if ( empty( $terms ) ) {
			return '';
		}
		if ( $terms[0]->parent == 0 ) {
			$cat = $terms[0];
		}
		else {
			$ancestors = get_ancestors( $terms[0]->term_id, 'product_cat', 'taxonomy' );
			$cat_id    = end( $ancestors );
			$cat       = get_term( $cat_id, 'product_cat' );

		}
		return '<div class="shop-cat"><a href="' . esc_url( get_term_link( $cat->term_id, 'product_cat' ) ) . '">' . $cat->name . '</a></div>';
	}

	/*Shop Get sale percentage*/
	public function sale_flash( $args, $post, $product  ) {
		if ( 'percentage' == shopbuilderwp_option('wc_sale_label')  ) {
			if ( $product->get_type() === 'variable' ) {
				$product_variation_prices = $product->get_variation_prices();
				$highest_sale_percent = 0;
				foreach( $product_variation_prices['regular_price'] as $key => $regular_price ) {
					$sale_price = $product_variation_prices['sale_price'][$key];
					if ( $sale_price < $regular_price ) {
						$sale_percent = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
						if ( $sale_percent > $highest_sale_percent ) {
							$highest_sale_percent = $sale_percent;
						}
					}
				}
				return sprintf('<span class="variable onsale rt-prodcut-badge-1">-%s%%</span>', $highest_sale_percent );
			} else {
				$regular_price = $product->get_regular_price();
				$sale_percent = 0;
				if ( intval( $regular_price ) > 0 ) {
					$sale_percent = round( ( ( $regular_price - $product->get_sale_price() ) / $regular_price ) * 100 );
				}
				return sprintf('<span class="normal onsale rt-prodcut-badge-1">-%s%%</span>', $sale_percent );
			}

		} else {
			$price = $product->get_regular_price();
			$sale  = $product->get_sale_price();
			if ( !$price ) {
				return $args;
			}
			$discount = ( ( $price - $sale ) / $price ) * 100;
			$discount = round( $discount );
			return sprintf('<span class="text onsale rt-prodcut-badge-1">' . esc_html__( 'Sale!', 'shopbuilderwp' ) . '</span>', $discount );
		}
	}

	/*Shop meta action*/
	public function actions_button_control( $product, $module_data,$add_to_cart=false ) {
		if( ! $product ){
			return ;
		}
		$product_id = $product->get_id();

		if ($add_to_cart && isset($module_data['wc_shop_add_to_cart']) && $module_data['wc_shop_add_to_cart']){
			self::print_add_to_cart_icon($product_id, true, true);
		}
		if( isset( $module_data['wc_shop_wishlist_icon'] ) && $module_data['wc_shop_wishlist_icon'] ){
			do_action( 'rtsb/modules/wishlist/print_button', $product_id );
		}
		if( isset( $module_data['wc_shop_quickview_icon'] ) && $module_data['wc_shop_quickview_icon'] ){
			do_action( 'rtsb/modules/quick_view/print_button', $product_id );
		}
		if( isset( $module_data['wc_shop_compare_icon'] ) && $module_data['wc_shop_compare_icon'] ){
			do_action( 'rtsb/modules/compare/print_button', $product_id );
		}
		if( isset( $module_data['wc_shop_qcheckout_icon'] ) && $module_data['wc_shop_qcheckout_icon'] ){
			do_action( 'rtsb/modules/quick_checkout/print_button', $product_id );
		}
	}

	public function quick_checkout_text( $text ) {
		if (!is_singular('product')){
			$text = '';
		}
		return $text;
	}
	public function quick_checkout_icon( $icon ) {
		if (!is_singular('product')){
			$icon = '<i class="rtsb-icon rtsb-icon-pay"></i>';
		}
		return $icon;
	}
	public function compare_button_icon( $icon ) {

		$icon = '<i class="icon-rt-filter"></i>';

		return $icon;
	}
	public function quick_view_icon( $icon ) {

		$icon = '<i class="icon-rt-search-1"></i>';

		return $icon;
	}
	public static function print_add_to_cart_icon( $product_id, $icon = true, $text = true ){
		if ( defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Widget_Base' ) ) {
			if ( \Elementor\Plugin::$instance->preview->is_preview_mode() || \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<i class="icon-rt-shopping-cart-minus"></i>';
				return;
			}
		}

		global $product;
		$quantity = 1;
		$class = implode( ' ', array_filter( array(
			'action-cart',
			'product_type_' . $product->get_type(),
			$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
			$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
		) ) );

		$html = '';

		$product_cart_id = WC()->cart->generate_cart_id( $product_id );
		$in_cart = WC()->cart->find_product_in_cart( $product_cart_id );

		if ( $in_cart ) {
			if ( $text ) {
				$html .= '<i class="icon-rt-check"></i><span>Already Added Cart</span>';
			}
		} else {
			if ( $icon ) {
				$html .= '<i class="icon-rt-cart"></i>';
			}

			if ( $text ) {
				$html .= '<span>' . $product->add_to_cart_text() . '</span>';
			}
		}

		if ( $in_cart ) {
			echo sprintf( '<a rel="nofollow" title="%s" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s">' . $html . '</a>',
				esc_attr( $product->add_to_cart_text() ),
				esc_url( wc_get_cart_url() ),
				esc_attr( isset( $quantity ) ? $quantity : 1 ),
				esc_attr( $product->get_id() ),
				esc_attr( $product->get_sku() )
			);
		} else {
			echo sprintf( '<a rel="nofollow" title="%s" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">' . $html . '</a>',
				esc_attr( $product->add_to_cart_text() ),
				esc_url( $product->add_to_cart_url() ),
				esc_attr( isset( $quantity ) ? $quantity : 1 ),
				esc_attr( $product->get_id() ),
				esc_attr( $product->get_sku() ),
				esc_attr( isset( $class ) ? $class : 'action-cart' )
			);
		}
	}
	// Countdown hook
	public function flash_sale_countdown_positions( $positions ) {

		$positions['before_add_to_cart']['hooks']= [
			'shopbuilderwp_shop_layout_before_cart_button'
		];
		$positions['after_add_to_cart']['hooks']= [
			'shopbuilderwp_shop_layout_after_cart_button'
		];

		return $positions;
	}

	public static function shopbuilderwp_product_share(  ) {
		echo '<div class="product-single-social-shares-btns">';
		self::shopbuilderwp_product_social_share();
		echo '</div>';
	}

	public static function shopbuilderwp_product_social_share(){
		$url   = urlencode( get_permalink() );
		$title = urlencode( get_the_title() );


		$defaults = array(
			'facebook' => array(
				'url'  => "http://www.facebook.com/sharer.php?u=$url",
				'icon' => 'fab fa-facebook-f',
				'class' => 'bg-fb'
			),
			'twitter'  => array(
				'url'  => "https://twitter.com/intent/tweet?source=$url&text=$title:$url",
				'icon' => 'fab fa-x-twitter',
				'class' => 'bg-twitter'
			),
			'linkedin' => array(
				'url'  => "http://www.linkedin.com/shareArticle?mini=true&url=$url&title=$title",
				'icon' => 'fab fa-linkedin-in',
				'class' => 'bg-linked'
			),
			'pinterest'=> array(
				'url'  => "http://pinterest.com/pin/create/button/?url=$url&description=$title",
				'icon' => 'fab fa-pinterest-p',
				'class' => 'bg-pinterst'
			),
		);

		foreach ( $defaults as $key => $value ) {
			if ( !$value ) {
				unset( $defaults[$key] );
			}
		}

		$sharers = apply_filters( 'rdtheme_social_sharing_icons', $defaults );

		?>
		<div class="post-share-btn">
			<ul class="item-social">
				<li class="item-label"><?php esc_html_e( 'Share:', 'shopbuilderwp' );?></li>
				<?php foreach ( $sharers as $key => $sharer ){ ?>
					<li>
						<a href="<?php echo esc_url( $sharer['url'] );?>" class="<?php echo esc_attr( $sharer['class'] );?>">
							<i class="<?php echo esc_attr( $sharer['icon'] );?>"></i>
						</a>
					</li>
				<?php } ?>
			</ul>
		</div>
	<?php }
}
