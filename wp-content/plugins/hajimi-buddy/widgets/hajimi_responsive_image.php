<?php
if ( ! defined( 'ABSPATH' ) ) exit;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class Hajimi_Responsive_Image extends \Elementor\Widget_Base {

    public function get_name() {
        return 'hajimi_responsive_image';
    }

    public function get_title() {
        return __( 'Hajimi Responsive Image', 'hajimi' );
    }

    public function get_icon() {
        return 'eicon-e-image';
    }

    public function get_categories() {
        return [ 'hajimi' ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'General', 'hajimi' ),
            ]
        );

		$this->add_control(
			'image',
			[
				'label' => esc_html__( 'Choose Image', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['image'],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'media_responsive',
			[
				'label' => esc_html__( 'Breakpoint', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'mobile',
				'options' => [
					'mobile' => esc_html__( 'Mobile', 'hajimi' ),
					'tablet' => esc_html__( 'Tablet', 'hajimi' ),   
					'none' => esc_html__( 'None', 'hajimi' ),
                ]
			]
		);

		$this->add_control(
			'image_mobile',
			[
				'label' => esc_html__( 'Choose Mobile Image', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['image'],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);


        $this->end_controls_section();

        $this->start_controls_section(
            'main_image',
            [
                'label' => __( 'Image', 'hajimi' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .hajimi-magic-image',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'image_box_shadow',
				'selector' => '{{WRAPPER}} .hajimi-magic-image',
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label' => esc_html__( 'padding', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'em',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .hajimi-magic-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label' => esc_html__( 'Width', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .hajimi-magic-image' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_max_width',
			[
				'label' => esc_html__( 'Width', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'selectors' => [
					'{{WRAPPER}} .hajimi-magic-image' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label' => esc_html__( 'Width', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .hajimi-magic-image' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
            'image_object_fit',
            [
				'label' => esc_html__( 'Object FIt', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'fill'       => __( 'Fill', 'hajimi' ),
                    'contain'    => __( 'Contain', 'hajimi' ),
                    'cover'      => __( 'Cover', 'hajimi' ),
                    'none'       => __( 'None', 'hajimi' ),
                    'scale-down' => __( 'Scale Down', 'hajimi' ),
                ],
				'selectors' => [
					'{{WRAPPER}} .hajimi-magic-image img' => 'object-fit: {{VALUE}};',
				],
                'condition' => [
                    'image_height!' => '',
                ]
            ]
        );

        $this->add_responsive_control(
            'image_object_position',
            [
				'label' => esc_html__( 'Object Position', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'center center',
                'options' => [
                    'left top'       => __( 'Left Top', 'hajimi' ),
                    'left center'    => __( 'Left Center', 'hajimi' ),
                    'left bottom'    => __( 'Left Bottom', 'hajimi' ),
                    'center top'     => __( 'Center Top', 'hajimi' ),
                    'center center'  => __( 'Center Center', 'hajimi' ),
                    'center bottom'  => __( 'Center Bottom', 'hajimi' ),
                    'right top'      => __( 'Right Top', 'hajimi' ),
                    'right center'   => __( 'Right Center', 'hajimi' ),
                    'right bottom'   => __( 'Right Bottom', 'hajimi' ),
                ],
				'selectors' => [
					'{{WRAPPER}} .hajimi-magic-image img' => 'object-position: {{VALUE}};',
				],
                'condition' => [
                    'image_height!' => '',
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings();
        $responsive = $settings['media_responsive'];
        $image = $settings['image'];
        $image_mobile = $settings['image_mobile'];
        $media_type = '(min-width: 768px)';
        if( $responsive == 'tablet' ) {
            $media_type = '(min-width: 1200px)';
        }
        if( empty($image_mobile['url']) ) {
            $image_mobile = $image;
        }
    ?>
        <div class="hajimi-magic-image">
            <picture>
                <?php if( $responsive == 'mobile' || $responsive == 'tablet' ) { ?><source media="<?= $media_type;?>" srcset="<?= $image['url'];?>"/><?php } ?>
                <img src="<?= $image_mobile['url'];?>"<?= ( !empty($image_mobile['alt']) ) ? ' alt="'.$image_mobile['alt'].'"' : '';?>/>
            </picture>
        </div>
    <?php
    }
}

\Elementor\Plugin::instance()->widgets_manager->register( new Hajimi_Responsive_Image() );
