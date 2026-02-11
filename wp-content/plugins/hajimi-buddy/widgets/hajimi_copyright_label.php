<?php

class Hajimi_Copyright_Label_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'hajimi_copyright_label';
    }

    public function get_title() {
        return __( 'Copyright Label', 'hajimi' );
    }

    public function get_icon() {
        return 'eicon-footer';
    }

    public function get_categories() {
        return [ 'hajimi' ];
    }

    public function get_keywords() {
        return [
            'hajimi',
            'copyright',
            'footer',
            'label',
            'text'
        ];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'widget_settings',
            [
                'label' => __( 'Content', 'hajimi' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'layout',
            [
                'label'   => __( 'Style', 'hajimi' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default'   => __( 'Default', 'hajimi' ),
                    'style-1' => __( 'Style 1', 'hajimi' ),
                ],
            ]
        );

        $this->add_control(
            'copyright_label_tag',
            [
                'label'   => __( 'Style', 'hajimi' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'p',
                'options' => [
                    'h1'   => __( 'H1', 'hajimi' ),
                    'h2'   => __( 'H2', 'hajimi' ),
                    'h3'   => __( 'H3', 'hajimi' ),
                    'h4'   => __( 'H4', 'hajimi' ),
                    'h5'   => __( 'H5', 'hajimi' ),
                    'h6'   => __( 'H6', 'hajimi' ),
                    'p' => __( 'Paragraph', 'hajimi' ),
                    'span' => __( 'SPAN', 'hajimi' ),
                ],
            ]
        );

        $this->add_control(
            'copyright_label',
            [
                'label'       => __( 'Label', 'hajimi' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => 'Hajimi. All Right Reserved.',
                'placeholder' => __( 'Enter copyright text', 'hajimi' ),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'widget_style',
            [
                'label' => __( 'Style', 'hajimi' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

		$this->add_responsive_control(
			'label_text_alignment',
			[
				'label' => esc_html__( 'Alignment', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'hajimi' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'hajimi' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'hajimi' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .hajimi-copyright' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .hajimi-copyright .hajimi-copyright-label',
			]
		);

		$this->add_control(
			'label_text_color',
			[
				'label' => esc_html__( 'Text Color', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .hajimi-copyright .hajimi-copyright-label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'label_padding',
			[
				'label' => esc_html__( 'Padding', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'rem',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .hajimi-copyright' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
		$this->add_responsive_control(
			'label_margin',
			[
				'label' => esc_html__( 'Margin', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'rem',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .hajimi-copyright' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'label_border',
				'selector' => '{{WRAPPER}} .hajimi-copyright',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'label_box_shadow',
				'selector' => '{{WRAPPER}} .hajimi-copyright',
			]
		);

		$this->add_responsive_control(
			'label_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem', 'custom' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'rem',
					'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .hajimi-copyright' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $layout = $settings['layout'];
        if( $layout == 'style-1' ) {
            $copyright_prefix = 'Copyright';

        }
        else {
            $copyright_prefix = '';
        }
        $copyright_prefix .= ' &copy;'. date('Y') . ' ';
        $copyright_label = $settings['copyright_label'];
        $copyright_label_tag = $settings['copyright_label_tag'];
        ?>
        <div class="hajimi-copyright layout-<?= $layout;?>">
            <<?= $copyright_label_tag;?> class="hajimi-copyright-label"><?= $copyright_prefix . ' ' . $copyright_label;?></<?= $copyright_label_tag;?>>
        </div>
        <?php
    }
}