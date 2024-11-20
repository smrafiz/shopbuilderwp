<?php
namespace RT\ShopBuilderWP\Elementor;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class RTImage extends Widget_Base {
	public function get_name() {
		return 'rt-image';
	}

	public function get_title() {
		return esc_html__( 'RT Image', 'shopbuilderwp' );
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'basic' ];
	}

	public function get_script_depends() {
		return [ 'sb-parallax' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'shopbuilderwp' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'shopbuilderwp' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'mouse_animation',
			[
				'label'        => __( 'Mouse Animation', 'shopbuilderwp' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'shopbuilderwp' ),
				'label_off'    => __( 'Hide', 'shopbuilderwp' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->add_control(
			'data_depth',
			[
				'label'       => esc_html__( 'Data Depth', 'shopbuilderwp' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => '2.00',
				'condition'   => [
					'mouse_animation' => 'yes',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$mouse_animation = ( $settings['mouse_animation'] == 'yes' ) ? 'rt-image-parallax' : '';

		?>

        <div class="rt-image <?php echo esc_attr( $mouse_animation ); ?>">
            <div class="rt-mouse-parallax">
                <div class="item-image" data-depth="<?php echo esc_attr( $settings['data_depth'] ); ?>">
		            <?php echo wp_get_attachment_image( $settings['image']['id'], 'full' ); ?>
                </div>
            </div>
        </div>

		<?php
	}

}
