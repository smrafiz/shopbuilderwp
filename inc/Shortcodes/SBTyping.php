<?php
/**
 * Shortcode: SBTyping.
 *
 * Renders dynamic taglines with animated typing effect.
 *
 * @package RT\ShopBuilderWP
 */

namespace RT\ShopBuilderWP\Shortcodes;

use RT\ShopBuilderWP\Traits\SingletonTraits;

/**
 * Shortcode: SBTyping.
 */
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
		$atts = shortcode_atts(
			[
				'words' => '',
			],
			$atts,
			'sb_dynamic_tagline'
		);

		$fixed_words  = [ 'Checkout', 'Cart' ];
		$random_words = [
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

		$words   = ! empty( $atts['words'] ) ? explode( ',', $atts['words'] ) : array_merge( $fixed_words, $random_words );
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
