<?php

namespace RT\ShopBuilderWP\Custom;

use RT\ShopBuilderWP\Traits\SingletonTraits;

/**
 * Extras.
 */
class Extras {
	use SingletonTraits;

	/**
	 * Register default hooks and actions for WordPress
	 *
	 * @return void
	 */
	public function __construct() {
		add_filter( 'body_class', [ $this, 'body_class' ] );
		add_action( 'wp_nav_menu_item_custom_fields', [ $this, 'menu_customize' ], 10, 2 );
		add_action( 'wp_update_nav_menu_item', [ $this, 'menu_update' ], 10, 2 );
		add_filter( 'wp_get_nav_menu_items', [ $this, 'menu_modify' ], 11, 3 );
		add_action( 'after_switch_theme', [ $this, 'rewrite_flush' ] );
		add_action( 'wp_head', [ $this, 'insert_social_in_head' ] );
		add_action( 'template_redirect', [ $this, 'w3c_validator' ] );
	}

	/*
	 * Body Class added
	 */
	public function body_class( $classes ) {
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		return $classes;
	}

	/*
	 * Menu Customize
	 */
	function menu_customize( $item_id, $item ) {
		// Mega menu
		$_mega_menu = get_post_meta( $item_id, 'shopbuilderwp_mega_menu', true );
		// Query string
		$menu_query_string = get_post_meta( $item_id, 'shopbuilderwp_menu_qs', true );
		?>

		<?php if ( $item->menu_item_parent < 1 ) : ?>
			<p class="description mega-menu-wrapper widefat">
				<label for="shopbuilderwp_mega_menu-<?php echo esc_attr( $item_id ); ?>" class="widefat">
					<?php _e( 'Make as Mega Menu', 'shopbuilderwp' ); ?><br>
					<select class="widefat" id="shopbuilderwp_mega_menu-<?php echo esc_attr( $item_id ); ?>" name="shopbuilderwp_mega_menu[<?php echo esc_attr( $item_id ); ?>]">
						<option value=""><?php _e( 'Choose Mega Menu', 'shopbuilderwp' ); ?></option>
						<?php
						for ( $item = 2; $item < 12; $item++ ) {
							$menu_item  = $item;
							$class_hide = null;
							$label_hide = '';
							if ( $item > 6 ) {
								$menu_item -= 5;
								$class_hide = ' hide-header';
								$label_hide = ' — Hide Col Title';
							}
							$class    = "mega-menu mega-menu-col-{$menu_item}" . $class_hide ?? '';
							$selected = ( $_mega_menu == $class ) ? ' selected="selected" ' : null;
							?>
							<option <?php echo esc_attr( $selected ); ?> value="<?php echo esc_attr( $class ); ?>">
								<?php printf( __( 'Mega menu - %1$s Col %2$s', 'shopbuilderwp' ), $menu_item, $label_hide ); ?>
							</option>
							<?php
						}
						?>
					</select>
				</label>
			</p>
		<?php endif; ?>

		<p class="description widefat">
			<label class="widefat" for="shopbuilderwp-menu-qs-<?php echo esc_attr( $item_id ); ?>">
				<?php echo esc_html__( 'Query String', 'shopbuilderwp' ); ?><br>
				<input type="text"
					   class="widefat"
					   id="shopbuilderwp-menu-qs-<?php echo esc_attr( $item_id ); ?>"
					   name="shopbuilderwp-menu-qs[<?php echo esc_attr( $item_id ); ?>]"
					   value="<?php echo esc_html( $menu_query_string ); ?>"
				/>
			</label>
		</p>


		<?php
	}

	/**
	 * Menu Update
	 *
	 * @param $menu_id
	 * @param $menu_item_db_id
	 *
	 * @return void
	 */
	function menu_update( $menu_id, $menu_item_db_id ) {
		$_mega_menu         = $_POST['shopbuilderwp_mega_menu'][ $menu_item_db_id ] ?? '';
		$query_string_value = $_POST['shopbuilderwp-menu-qs'][ $menu_item_db_id ] ?? '';

		update_post_meta( $menu_item_db_id, 'shopbuilderwp_mega_menu', $_mega_menu );
		update_post_meta( $menu_item_db_id, 'shopbuilderwp_menu_qs', $query_string_value );
	}

	/**
	 * Modify Menu item
	 *
	 * @param $items
	 * @param $menu
	 * @param $args
	 *
	 * @return mixed
	 */
	function menu_modify( $items, $menu, $args ) {
		foreach ( $items as $item ) {
			$menu_query_string = get_post_meta( $item->ID, 'shopbuilderwp_menu_qs', true );
			if ( $menu_query_string ) {
				$item->url = add_query_arg( $menu_query_string, '', $item->url );
			}
		}

		return $items;
	}

	/**
	 * Search form modify
	 *
	 * @return string
	 */
	public function search_form() {
		$output = '
		<form method="get" class="shopbuilderwp-search-form" action="' . esc_url( home_url( '/' ) ) . '">
            <div class="search-box">
				<input type="text" class="form-control" placeholder="' . esc_attr__( 'Search here...', 'shopbuilderwp' ) . '" value="' . get_search_query() . '" name="s" />
				<button class="item-btn" type="submit">
					' . shopbuilderwp_get_svg( 'search', false ) . '
					<span class="btn-label">' . esc_html__( 'Search', 'shopbuilderwp' ) . '</span>
				</button>
            </div>
		</form>
		';

		return $output;
	}

	/**
	 * Flush Rewrite on CPT activation
	 *
	 * @return empty
	 */
	public function rewrite_flush() {
		// Flush the rewrite rules only on theme activation
		flush_rewrite_rules();
	}

	public function insert_social_in_head() {
		global $post;

		if ( ! isset( $post ) ) {
			return;
		}

		$title = get_the_title();

		if ( is_singular( 'post' ) ) {
			$link = get_the_permalink() . '?v=' . time();
			echo '<meta property="og:url" content="' . $link . '" />';
			echo '<meta property="og:type" content="article" />';
			echo '<meta property="og:title" content="' . $title . '" />';

			if ( ! empty( $post->post_content ) ) {
				echo '<meta property="og:description" content="' . wp_trim_words(
					$post->post_content,
					150
				) . '" />';
			}
			$attachment_id = get_post_thumbnail_id( $post->ID );
			if ( ! empty( $attachment_id ) ) {
				$thumbnail = wp_get_attachment_image_src( $attachment_id, 'full' );
				if ( ! empty( $thumbnail ) ) {
					$attachment    = get_post( $attachment_id );
					$thumbnail[0] .= '?v=' . time();
					echo '<meta property="og:image" content="' . $thumbnail[0] . '" />';
					echo '<link itemprop="thumbnailUrl" href="' . $thumbnail[0] . '">';
					echo '<meta property="og:image:type" content="' . $attachment->post_mime_type . '">';
				}
			}
			echo '<meta property="og:site_name" content="' . get_bloginfo( 'name' ) . '" />';
			echo '<meta name="twitter:card" content="summary" />';
			echo '<meta property="og:updated_time" content="' . time() . '" />';
		}
	}

	// W3C validator passing code
	public function w3c_validator() {
		ob_start(
			function ( $buffer ) {
				$buffer = str_replace( [ '<script type="text/javascript">', "<script type='text/javascript'>" ], '<script>', $buffer );
				return $buffer;
			}
		);
		ob_start(
			function ( $buffer2 ) {
				$buffer2 = str_replace( [ "<script type='text/javascript' src" ], '<script src', $buffer2 );
				return $buffer2;
			}
		);
		ob_start(
			function ( $buffer3 ) {
				$buffer3 = str_replace( [ 'type="text/css"', "type='text/css'", 'type="text/css"' ], '', $buffer3 );
				return $buffer3;
			}
		);
		ob_start(
			function ( $buffer4 ) {
				$buffer4 = str_replace( [ '<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"' ], '<iframe', $buffer4 );
				return $buffer4;
			}
		);
		ob_start(
			function ( $buffer5 ) {
				$buffer5 = str_replace( [ 'aria-required="true"' ], '', $buffer5 );
				return $buffer5;
			}
		);
	}
}
