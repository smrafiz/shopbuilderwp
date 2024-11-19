<?php

namespace RT\ShopBuilderWP\Elementor;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RTMarquee extends Widget_Base {
	public function get_name() {
		return 'rt-marquee';
	}

	public function get_title() {
		return esc_html__( 'RT Marquee', 'shopbuilderwp' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'basic' ];
	}

	protected function register_controls() {

		// Content Tab Start
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'shopbuilderwp' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image Item', 'shopbuilderwp' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'marquee_direction',
			[
				'label'     => __( 'Direction', 'shopbuilderwp' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'marquee-top',
				'options'   => [
					'marquee-top'  => __( 'Top', 'shopbuilderwp' ),
					'marquee-bottom' => __( 'Bottom', 'shopbuilderwp' ),
				],
			]
		);

		$this->add_responsive_control(
			'marquee_height',
			[
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'mode'          => 'responsive',
				'label'   => esc_html__( 'Section Height', 'shopbuilderwp' ),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rt-marquee-wrap .rt-marquee' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'items',
			[
				'label'       => __( 'Image List', 'shopbuilderwp' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		?>


        <div class="rt-marquee-wrap">
            <div class="rt-marquee <?php echo esc_attr( $settings['marquee_direction'] ) ?>">
                <div class="rt-marquee-item">
                    <div class="marquee-item">
		                <?php foreach ( $settings['items'] as $item ) : ?>
                        <div class="item-image">
	                        <?php echo wp_get_attachment_image( $item['image']['id'], 'full' ); ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="rt-marquee-item">
                    <div class="marquee-item">
	                    <?php foreach ( $settings['items'] as $item ) : ?>
                            <div class="item-image">
			                    <?php echo wp_get_attachment_image( $item['image']['id'], 'full' ); ?>
                            </div>
	                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

		<?php
	}

}
