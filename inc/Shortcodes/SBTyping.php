<?php

namespace RT\ShopBuilderWP\Shortcodes;

use Elementor\Plugin;
use RT\ShopBuilderWP\Traits\SingletonTraits;

class SBTyping {
	use SingletonTraits;

	/**
	 * Register to hook the shortcode.
	 */
	public function register() {
		add_shortcode( 'sb_dynamic_tagline', [ $this, 'render' ] );
	}

	/**
	 * Render the shortcode output.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string Shortcode output.
	 */
	public function render( $atts ) {
		$fixed_words  = [ 'Checkout', 'Cart' ];
		$random_words = [
			'Checkout',
			'Cart',
			'Orders',
			'Payments',
			'Sales',
			'Products',
			'Shopping',
			'Revenue',
			'Experience',
			'Growth',
		];

		shuffle( $random_words );

		$words   = array_merge( $fixed_words, $random_words );
		$output  = '<div class="sb-headline clip is-full-width">';
		$output .= '<span class="sb-words-wrapper">';

		foreach ( $words as $index => $word ) {
			$class   = ( 0 === $index ) ? 'is-visible' : 'is-hidden';
			$output .= '<b class="' . esc_attr( $class ) . '">' . esc_html( $word ) . '</b>';
		}

		$output .= '</span>';
		$output .= '</div>';

		return $output;
	}
}
