<?php

namespace RT\ShopBuilderWP\Custom;

use RT\ShopBuilderWP\Helpers\Fns;
use RT\ShopBuilderWP\Options\Opt;
use RT\ShopBuilderWP\Traits\SingletonTraits;

class DynamicStyles {

	use SingletonTraits;

	protected $meta_data;

	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 30 );
	}

	public function enqueue_scripts() {
		$this->meta_data = get_post_meta( get_the_ID(), "rt_layout_meta_data", true );
		$dynamic_css     = $this->inline_style();
		wp_register_style( 'finwave-dynamic', false, 'finwave-main' );
		wp_enqueue_style( 'finwave-dynamic' );
		wp_add_inline_style( 'finwave-dynamic', $this->minify_css( $dynamic_css ) );
	}

	function minify_css( $css ) {
		$css = preg_replace( '/\/\*[^*]*\*+([^\/][^*]*\*+)*\//', '', $css ); // Remove comments
		$css = preg_replace( '/\s+/', ' ', $css ); // Remove multiple spaces
		$css = preg_replace( '/\s*([\{\};])\s*/', '$1', $css ); // Remove spaces around { } ; : ,

		return $css;
	}

	private function inline_style() {

		$primary_color   	= shopbuilderwp_option( 'rt_primary_color', '#006d5b' );
		$secondary_color 	= shopbuilderwp_option( 'rt_secondary_color', '#00473b' );
		$tertiary_color    	= shopbuilderwp_option( 'rt_tertiary_color', '#ffb000' );
		$body_bg_color   	= shopbuilderwp_option( 'rt_body_bg_color', '#ffffff' );
		$body_color      	= shopbuilderwp_option( 'rt_body_color', '#6e7676' );
		$border_color      	= shopbuilderwp_option( 'rt_border_color', '#e7e7e7' );
		$title_color     	= shopbuilderwp_option( 'rt_title_color', '#041b16' );
		$button_color    	= shopbuilderwp_option( 'rt_button_color', '#ffffff' );
		$button_text_color 	= shopbuilderwp_option( 'rt_button_text_color', '#00030C' );
		$meta_color      	= shopbuilderwp_option( 'rt_meta_color', '#006d5b' );
		$meta_light      	= shopbuilderwp_option( 'rt_meta_light', '#b2c2c0' );
		$gray10          	= shopbuilderwp_option( 'rt_gray10_color', '#f1f1f1' );
		$gray20          	= shopbuilderwp_option( 'rt_gray20_color', '#edf5f4' );

		ob_start(); ?>

		:root {
		--rt-primary-color: 	<?php echo esc_html( $primary_color ); ?>;
		--rt-secondary-color: 	<?php echo esc_html( $secondary_color ); ?>;
		--rt-tertiary-color: 	<?php echo esc_html( $tertiary_color ); ?>;
		--rt-body-bg-color: 	<?php echo esc_html( $body_bg_color ); ?>;
		--rt-body-color: 		<?php echo esc_html( $body_color ); ?>;
		--rt-border-color: 		<?php echo esc_html( $border_color ); ?>;
		--rt-title-color: 		<?php echo esc_html( $title_color ); ?>;
		--rt-button-color: 		<?php echo esc_html( $button_color ); ?>;
		--rt-button-text-color: <?php echo esc_html( $button_text_color ); ?>;
		--rt-meta-color: 		<?php echo esc_html( $meta_color ); ?>;
		--rt-meta-light: 		<?php echo esc_html( $meta_light ); ?>;
		--rt-gray10: 			<?php echo esc_html( $gray10 ); ?>;
		--rt-gray20: 			<?php echo esc_html( $gray20 ); ?>;
		--rt-body-rgb: 			<?php echo esc_html( Fns::hex2rgb( $body_color ) ); ?>;
		--rt-title-rgb: 		<?php echo esc_html( Fns::hex2rgb( $title_color ) ); ?>;
		--rt-primary-rgb: 		<?php echo esc_html( Fns::hex2rgb( $primary_color ) ); ?>;
		--rt-secondary-rgb: 	<?php echo esc_html( Fns::hex2rgb( $secondary_color ) ); ?>;
		--rt-tertiary-rgb: 		<?php echo esc_html( Fns::hex2rgb( $tertiary_color ) ); ?>;

		--rt-container-width: 	<?php echo shopbuilderwp_option( 'container_width' ); ?>px;
		}

		body {
		color: <?php echo esc_html( $body_color ); ?>;
		}

		<?php
		$this->site_fonts();
		$this->topbar_css();
		$this->header_css();
		$this->breadcrumb_css();
		$this->content_padding_css();
		$this->footer_css();
		$this->site_background();

		return ob_get_clean();
	}

	/**
	 * Topbar Settings
	 * @return void
	 */
	protected function topbar_css() {
		$_topbar_active_color = shopbuilderwp_option( 'rt_topbar_active_color' );
		echo self::css( 'body .site-header .finwave-topbar .topbar-container *:not(.dropdown-menu *)', 'color', 'rt_topbar_color' );
		echo self::css( 'body .site-header .finwave-topbar .topbar-container svg:not(.dropdown-menu svg)', 'fill', 'rt_topbar_color' );

		if ( ! empty( $_topbar_active_color ) ) : ?>
			body .site-header .finwave-topbar .topbar-container a:hover:not(.dropdown-menu a:hover),
			body .finwave-topbar #topbar-menu ul ul li.current_page_item > a,
			body .finwave-topbar #topbar-menu ul ul li.current-menu-ancestor > a,
			body .finwave-topbar #topbar-menu ul.finwave-topbar-menu > li.current-menu-item > a,
			body .finwave-topbar #topbar-menu ul.finwave-topbar-menu > li.current-menu-ancestor > a {
			color: <?php echo esc_attr( $_topbar_active_color ); ?>;
			}

			body .site-header .finwave-topbar .topbar-container a:hover:not(.dropdown-menu a:hover svg) svg,
			body .finwave-topbar #topbar-menu ul ul li.current-menu-ancestor > a svg,
			body .finwave-topbar #topbar-menu ul.finwave-topbar-menu > li.current-menu-item > a svg,
			body .finwave-topbar #topbar-menu ul.finwave-topbar-menu > li.current-menu-ancestor > a svg {
			fill: <?php echo esc_attr( $_topbar_active_color ); ?>;
			}
		<?php endif; ?>

		<?php
		echo self::css( 'body .finwave-topbar', 'background-color', 'rt_topbar_bg_color' );

	}


	/**
	 * Menu Color Settings
	 * @return void
	 */
	protected function header_css() {
		//Logo CSS
		$logo_width = '';
		$logo_mobile_width = '';

		$logo_dimension     = shopbuilderwp_option( 'rt_logo_width_height' );
		$logo_mobile_dimension     = shopbuilderwp_option( 'rt_mobile_logo_width_height' );
		$menu_border_bottom = shopbuilderwp_option( 'rt_menu_border_color' );

		if ( strpos( $logo_dimension, ',' ) ) {
			$logo_width = explode( ',', $logo_dimension );
		}
		if ( strpos( $logo_mobile_dimension, ',' ) ) {
			$logo_mobile_width = explode( ',', $logo_mobile_dimension );
		}

		//Default Menu
		$_menu_color        = shopbuilderwp_option( 'rt_menu_color' );
		$_menu_active_color = shopbuilderwp_option( 'rt_menu_active_color' );
		$_menu_bg_color     = shopbuilderwp_option( 'rt_menu_bg_color' );
		$_sub_menu_bg_color     = shopbuilderwp_option( 'rt_sub_menu_bg_color' );

		//Transparent Menu
		$_tr_menu_color        = shopbuilderwp_option( 'rt_tr_menu_color' );
		$_tr_menu_active_color = shopbuilderwp_option( 'rt_tr_menu_active_color' );

		$_header_border     = shopbuilderwp_option( 'rt_header_border' );
		$_breadcrumb_border = shopbuilderwp_option( 'rt_breadcrumb_border' );
		$_preloader_bg_color = shopbuilderwp_option( 'preloader_bg_color' );
		?>

		<?php //Header Logo CSS ?>
		<?php if ( Opt::$header_width == 'full' ) :
			$h_width = '100%';
			if ( ( $header_width = shopbuilderwp_option( 'rt_header_max_width' ) ) > 768 ) {
				$h_width = $header_width . 'px';
			}
			?>
			.header-container,
			.topbar-container {
				width: <?php echo esc_attr($h_width); ?>;
				max-width: 100%;
			}
		<?php endif; ?>

		<?php if ( ! empty( $logo_width ) ) : ?>
			.site-branding .rt-site-logo {
				max-width: <?php echo esc_attr( $logo_width[0] ?? '100%' ) ?>;
				max-height: <?php echo esc_attr( $logo_width[1] ?? 'auto' ) ?>;
				object-fit: contain;
			}
		<?php endif; ?>

		<?php if ( ! empty( $logo_mobile_width ) ) : ?>
			.site-branding .rt-mobile-logo {
			max-width: <?php echo esc_attr( $logo_mobile_width[0] ?? '100%' ) ?>;
			max-height: <?php echo esc_attr( $logo_mobile_width[1] ?? 'auto' ) ?>;
			object-fit: contain;
			}
		<?php endif; ?>

		<?php //Default Header ?>
		<?php if ( ! empty( $_menu_color ) ) : ?>
			body .finwave-navigation ul li a,
			body .finwave-offcanvas-drawer ul.menu li a,
			body .finwave-navigation ul li ul li a,
			body .menu-icon-wrapper .menu-search-bar {
				color: <?php echo esc_attr( $_menu_color ) ?>;
			}
			body .main-header-section svg,
			body .finwave-navigation .caret svg {
				fill: <?php echo esc_attr( $_menu_color ) ?>;
			}
			body .ham-burger .btn-hamburger span,
			body .menu-icon-wrapper .has-separator li:not(:last-child):after {
				background-color: <?php echo esc_attr( $_menu_color ) ?>;
			}
		<?php endif; ?>

		<?php if ( ! empty( $_menu_active_color ) ) : ?>
			body .finwave-navigation ul li a:hover,
			body .finwave-navigation ul li.current-menu-item > a,
			body .finwave-navigation ul li.current-menu-ancestor > a,
			body .finwave-offcanvas-drawer ul li.current-menu-ancestor > a,
			body .finwave-offcanvas-drawer ul.menu li a:hover,
			body .finwave-navigation ul li ul li a:hover {
				color: <?php echo esc_attr( $_menu_active_color ) ?>;
			}
			body .finwave-navigation ul li a:hover svg,
			body .finwave-navigation ul li.current-menu-item > a svg,
			body .finwave-navigation ul li.current-menu-ancestor > a svg {
				fill: <?php echo esc_attr( $_menu_active_color ) ?>;
			}
			body .menu-icon-wrapper .menu-bar:hover .btn-hamburger span {
				background-color: <?php echo esc_attr( $_menu_active_color ) ?>;
			}
		<?php endif; ?>

		<?php if ( ! empty( $_menu_bg_color ) ) : ?>
			body .main-header-section {
				background-color: <?php echo esc_attr( $_menu_bg_color ) ?>;
			}
		<?php endif; ?>

		<?php if ( ! empty( $_sub_menu_bg_color ) ) : ?>
			body .finwave-navigation ul > li > ul,
			body .finwave-navigation ul li.mega-menu > ul.dropdown-menu{
				background-color: <?php echo esc_attr( $_sub_menu_bg_color ) ?>;
			}
		<?php endif; ?>

		<?php //Transparent Header ?>
		<?php if ( ! empty( $_tr_menu_color ) ) : ?>
			body.has-trheader .site-header .site-branding h1 a,
			body.has-trheader .site-header .finwave-navigation *,
			body.has-trheader .site-header .finwave-navigation ul li a {
			color: <?php echo esc_attr( $_tr_menu_color ); ?>;
			}
			body.has-trheader .ham-burger .btn-hamburger span,
			body.tr-header-light .ham-burger .btn-hamburger span,
			body.has-trheader .menu-icon-wrapper .has-separator li:not(:last-child):after {
			background-color: <?php echo esc_attr( $_tr_menu_color ); ?> !important;
			}

			body.has-trheader .site-header .menu-icon-wrapper svg,
			body.has-trheader .site-header .finwave-topbar .caret svg,
			body.has-trheader .site-header .main-header-section .caret svg {
			fill: <?php echo esc_attr( $_tr_menu_color ); ?>
			}
		<?php endif; ?>

		<?php if ( ! empty( $_tr_menu_active_color ) ) : ?>
			body.has-trheader .site-header .finwave-navigation ul li a:hover,
			body.has-trheader .site-header .finwave-navigation ul li.current-menu-item > a,
			body.has-trheader .site-header .finwave-navigation ul li.current-menu-ancestor > a {
			color: <?php echo esc_attr( $_tr_menu_active_color ); ?>
			}
			body.has-trheader .menu-icon-wrapper .menu-bar:hover .btn-hamburger span {
				background-color: <?php echo esc_attr( $_tr_menu_active_color ); ?> !important;
			}
			body.has-trheader .main-header-section a:hover [class*=rticon] svg,
			body.has-trheader .site-header .finwave-navigation ul li.current-menu-ancestor > a svg,
			body.has-trheader .site-header .finwave-navigation ul li.current-menu-item > a svg {
			fill: <?php echo esc_attr( $_tr_menu_active_color ); ?>
			}
		<?php endif; ?>
		<?php if ( ! empty( $menu_border_bottom ) ) : ?>
			body .finwave-topbar,
			body .main-header-section,
			body .finwave-breadcrumb-wrapper {
			border-bottom-color: <?php echo esc_attr( $menu_border_bottom ); ?>;
			}
		<?php endif; ?>

		<?php if ( ! $_header_border ) : ?>
			body .main-header-section {border-bottom: none;}
		<?php endif; ?>
		<?php if ( ! $_breadcrumb_border ) : ?>
			body .finwave-breadcrumb-wrapper {border-bottom: none;}
		<?php endif; ?>

		<?php if ( ! empty( $_preloader_bg_color ) ) : ?>
			#preloader {
				background-color: <?php echo esc_attr( $_preloader_bg_color ); ?>;
			}
		<?php endif; ?>

		<?php
	}

	/**
	 * Breadcrumb Settings
	 * @return void
	 */
	protected function breadcrumb_css() {
		$breadcrumb_color          = shopbuilderwp_option( 'rt_breadcrumb_color' );
		$rt_breadcrumb_hover       = shopbuilderwp_option( 'rt_breadcrumb_hover' );
		$breadcrumb_active         = shopbuilderwp_option( 'rt_breadcrumb_active' );
		$rt_breadcrumb_title_color = shopbuilderwp_option( 'rt_breadcrumb_title_color' );
		$rt_banner_color_opacity = shopbuilderwp_option( 'rt_banner_color_opacity' );

		$rt_banner_padding_top = shopbuilderwp_option( 'rt_banner_padding_top' );
		$rt_banner_padding_bottom = shopbuilderwp_option( 'rt_banner_padding_bottom' );

		$rt_banner_overlay1_color = shopbuilderwp_option( 'rt_banner_overlay1_color' );
		$rt_banner_overlay2_color = shopbuilderwp_option( 'rt_banner_overlay2_color' );

		if ( ! empty( $rt_breadcrumb_title_color ) ) { ?>
			.finwave-breadcrumb-wrapper .entry-title {
				color: <?php echo esc_attr( $rt_breadcrumb_title_color ) ?> !important;
			}
		<?php }

		if ( ! empty( $breadcrumb_color ) ) { ?>
			.finwave-breadcrumb-wrapper .breadcrumb a,
			.finwave-breadcrumb-wrapper .entry-breadcrumb span a,
			.has-trheader .finwave-breadcrumb-wrapper .breadcrumb a,
			.finwave-breadcrumb-wrapper .entry-breadcrumb .dvdr {
				color: <?php echo esc_attr( $breadcrumb_color ) ?>;
			}
		<?php }

		if ( ! empty( $rt_breadcrumb_hover ) ) { ?>
			.finwave-breadcrumb-wrapper .breadcrumb a:hover,
			.finwave-breadcrumb-wrapper .entry-breadcrumb span a:hover {
			color: <?php echo esc_attr( $rt_breadcrumb_hover ) ?>;
			}
		<?php }

		if ( ! empty( $breadcrumb_active ) ) { ?>
			.finwave-breadcrumb-wrapper .breadcrumb li.active .title,
			.finwave-breadcrumb-wrapper .breadcrumb a:hover,
			.finwave-breadcrumb-wrapper .entry-breadcrumb span a:hover,
			.finwave-breadcrumb-wrapper .entry-breadcrumb .current-item,
			.has-trheader .finwave-breadcrumb-wrapper .breadcrumb li.active .title,
			.has-trheader .finwave-breadcrumb-wrapper .breadcrumb a:hover {
				color: <?php echo esc_attr( $breadcrumb_active ) ?>;
			}
		<?php }

		if ( ! empty( Opt::$banner_color ) ) { ?>
			.finwave-breadcrumb-wrapper,
			.finwave-breadcrumb-wrapper.has-bg {
				background-color: <?php echo esc_attr( Opt::$banner_color ); ?>;
			}
		<?php }

		if ( ! empty( $rt_banner_color_opacity ) ) { ?>
			.finwave-breadcrumb-wrapper.has-bg .banner-image {
				opacity: <?php echo esc_attr( $rt_banner_color_opacity ) ?>;
			}
		<?php }

		if ( ! empty( $rt_banner_padding_top ) ) { ?>
			.finwave-breadcrumb-wrapper {
				padding-top: <?php echo esc_attr( $rt_banner_padding_top ) ?>px !important;
			}
		<?php }

		if ( ! empty( $rt_banner_padding_bottom ) ) { ?>
			.finwave-breadcrumb-wrapper {
				padding-bottom: <?php echo esc_attr( $rt_banner_padding_bottom ) ?>px !important;
			}
		<?php }

		if ( ! empty( $rt_banner_overlay1_color && $rt_banner_overlay2_color ) ) { ?>
			.finwave-breadcrumb-wrapper.has-bg::before {
				background: linear-gradient(90deg, <?php echo esc_attr( $rt_banner_overlay1_color ) ?> 0%, <?php echo esc_attr( $rt_banner_overlay2_color ) ?> 100%);
			}
		<?php }

	}

	/**
	 * Content Padding
	 * @return void
	 */
	protected function content_padding_css() {

		if ( ! empty( Opt::$padding_top ) && 'default' !== Opt::$padding_top) { ?>
			.content-area {padding-top: <?php echo esc_attr( Opt::$padding_top ); ?>px;}
		<?php }

		if ( ! empty( Opt::$padding_bottom ) && 'default' !== Opt::$padding_bottom) { ?>
			.content-area {padding-bottom: <?php echo esc_attr( Opt::$padding_bottom ); ?>px;}
		<?php }

	}

		/**
		 * Footer CSS
		 * @return void
		 */
		protected function footer_css() {
			if ( shopbuilderwp_option( 'rt_footer_width' ) && shopbuilderwp_option( 'rt_footer_max_width' ) > 1400 ) {
				echo self::css( '.site-footer .footer-container', 'width', 'rt_footer_max_width', 'px;max-width: 100%' );
			}

			echo self::css( 'body .site-footer *:not(a), body .site-footer .widget', 'color', 'rt_footer_text_color' );

			echo self::css( 'body .site-footer .footer-sidebar a, body .site-footer .footer-sidebar .widget a, body .site-footer .footer-sidebar .phone-no a', 'color', 'rt_footer_link_color' );

			echo self::css( 'body .site-footer a:hover, body .site-footer .footer-sidebar a:hover', 'color', 'rt_footer_link_hover_color' );

			echo self::css( 'body .site-footer .footer-widgets-wrapper', 'background-color', 'rt_footer_bg' );
			echo self::css( 'body .site-footer .widget :is(td, th, select, .search-box)', 'border-color', 'rt_footer_input_border_color' );
			echo self::css( 'body .site-footer .widget-title, .finwave-footer-2 .site-footer .widget-title', 'color', 'rt_footer_widget_title_color' );

			echo self::css( 'body .site-footer .footer-copyright-wrapper, body .site-footer label, body .footer-copyright-wrapper .copyright-text', 'color', 'rt_copyright_text_color' );
			echo self::css( 'body .site-footer .footer-copyright-wrapper a', 'color', 'rt_copyright_link_color' );
			echo self::css( 'body .site-footer .footer-copyright-wrapper a:hover', 'color', 'rt_copyright_link_hover_color' );
			echo self::css( 'body .site-footer .footer-copyright-wrapper', 'background-color', 'rt_copyright_bg' );
		}


		/**
		 * Load site fonts
		 * @return void
		 */
		protected
		function site_fonts() {

			$typo_body           = json_decode( shopbuilderwp_option( 'rt_body_typo' ), true );
			$typo_menu           = json_decode( shopbuilderwp_option( 'rt_menu_typo' ), true );
			$typo_heading        = json_decode( shopbuilderwp_option( 'rt_all_heading_typo' ), true );
			$body_font_family    = $typo_body['font'] ?? 'Archivo';
			$heading_font_family = $typo_heading['font'] ?? $body_font_family;
			?>
			:root{
			--rt-body-font: '<?php echo esc_html( $typo_body['font'] ); ?>', sans-serif;;
			--rt-heading-font: '<?php echo esc_html( $heading_font_family ); ?>', sans-serif;
			--rt-menu-font: '<?php echo esc_html( $typo_body['font'] ); ?>', sans-serif;
			}

			<?php
			echo self::font_css( 'body', $typo_body );
			echo self::font_css( '.site-header', [ 'font' => $typo_menu['font'] ] );
			echo self::font_css( '.finwave-navigation ul li a', [
				'size'          => $typo_menu['size'],
				'regularweight' => $typo_menu['regularweight'],
				'lineheight'    => $typo_menu['lineheight']
			] );
			echo self::font_css( '.h1,.h2,.h3,.h4,.h5,.h6,h1,h2,h3,h4,h5,h6', [
				'font'          => $typo_heading['font'],
				'regularweight' => $typo_heading['regularweight']
			] );

			$heading_fonts = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ];
			foreach ( $heading_fonts as $heading ) {
				$font = json_decode( shopbuilderwp_option( "rt_heading_{$heading}_typo" ), true );
				if ( ! empty( $font['font'] ) ) {
					$selector = "$heading, .$heading";
					echo self::font_css( $selector, $font );
				}
			}
		}


		/**
		 * Generate CSS
		 *
		 * @param $selector
		 * @param $property
		 * @param $theme_mod
		 *
		 * @return string|void
		 */
		public
		static function css( $selector, $property, $theme_mod, $after_css = '' ) {
			$theme_mod = shopbuilderwp_option( $theme_mod );

			if ( ! empty( $theme_mod ) ) {
				return sprintf( '%s { %s:%s%s; }', $selector, $property, $theme_mod, $after_css );
			}
		}

		/**
		 * Font CSS
		 *
		 * @param $selector
		 * @param $property
		 * @param $theme_mod
		 * @param $after_css
		 *
		 * @return string
		 */
		public
		static function font_css( $selector, $font ) {
			$css = '';
			$css .= $selector . '{'; //Start CSS
			$css .= ! empty( $font['font'] ) ? "font-family: '" . $font['font'] . "', sans-serif;" : '';
			$css .= ! empty( $font['size'] ) ? "font-size: {$font['size']}px;" : '';
			$css .= ! empty( $font['lineheight'] ) ? "line-height: {$font['lineheight']}px;" : '';
			$css .= ! empty( $font['regularweight'] ) ? "font-weight: {$font['regularweight']};" : '';
			$css .= '}'; //End CSS

			return $css;
		}

		/**
		 * Site background
		 *
		 * @return string
		 */

		function site_background() {
			if ( ! empty( Opt::$pagebgimg ) ) {
				$bg = wp_get_attachment_image_src( Opt::$pagebgimg, 'full' );
				if ( ! empty( $bg[0] ) ) { ?>
					body {
					background-image: url(<?php echo esc_url( $bg[0] ) ?>);
					background-repeat: repeat;
					background-position: top center;
					background-size: 100%;
					}
					<?php
				}
			}
			if ( ! empty( Opt::$pagebgcolor ) && 'default' !== Opt::$pagebgcolor) { ?>
				body {
					background-color: <?php echo esc_attr( Opt::$pagebgcolor ); ?>;
				}
			<?php }
		}
	}
