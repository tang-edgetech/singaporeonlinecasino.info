<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Hajimi_Header_Navigation_Widget extends \Elementor\Widget_Base {
    

    public function get_name() {
        return 'hajimi_header_navigation';
    }

    public function get_title() {
        return __( 'Header Navigation', 'hajimi' );
    }

    public function get_icon() {
        return 'eicon-nav-menu';
    }

    public function get_categories() {
        return [ 'hajimi' ];
    }

    public function get_keywords() {
        return [
            'hajimi',
            'menu',
            'header',
            'navigation',
            'item'
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
            'show_site_logo',
            [
                'label'        => __( 'Show Site Logo', 'hajimi' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => __( 'Yes', 'hajimi' ),
                'label_off'    => __( 'No', 'hajimi' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'widget_settings_additional',
            [
                'label' => __( 'Additional', 'hajimi' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'button_style',
			[
				'label' => esc_html__( 'Button Style', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'outline',
				'options' => [
					'outline' => esc_html__( 'Outline', 'hajimi' ),
					'solid' => esc_html__( 'Solid', 'hajimi' ),
				],
			]
		);

		$repeater->add_control(
			'button_label',
			[
				'label' => esc_html__( 'Label', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Read More', 'hajimi' ),
				'placeholder' => esc_html__( 'Type your title here', 'hajimi' ),
			]
		);

		$repeater->add_control(
			'button_link',
			[
				'label' => esc_html__( 'Button Link', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'label_block' => true,
			]
		);

        $this->add_control(
            'additional_buttons',
            [
                'label' => __( 'Buttons', 'hajimi' ),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'button_style' => 'outline',
                        'button_label' => esc_html__( 'Read More', 'hajimi' ),
                    ]
                ],
				'title_field' => '{{{ button_label }}}',
            ]
        );

        if ( function_exists( 'pll_current_language' ) ) {
            $this->add_control(
                'enable_polylang',
                [
                    'label'        => __( 'Enable Polylang Language Switcher', 'hajimi' ),
                    'type'         => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'     => __( 'Yes', 'hajimi' ),
                    'label_off'    => __( 'No', 'hajimi' ),
                    'return_value' => 'yes',
                    'default'      => '',
                ]
            );
        }

        $this->end_controls_section();

        $this->start_controls_section(
            'widget_settings_mobile',
            [
                'label' => __( 'Mobile', 'hajimi' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

		$this->add_control(
			'banner_image',
			[
				'label' => esc_html__( 'Banner Image', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);
        
		$this->add_control(
			'banner_link',
			[
				'label' => esc_html__( 'Banner Link', 'hajimi' ),
				'type' => \Elementor\Controls_Manager::URL,
				'options' => [ 'url', 'is_external', 'nofollow' ],
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
				'label_block' => true,
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

		$this->add_control(
			'navbar_col_left_gap',
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
					'unit' => 'rem',
					'size' => 1.5,
				],
				'selectors' => [
					'{{WRAPPER}} .your-class' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);
        
        $this->end_controls_section();

        $this->start_controls_section(
            'widget_additional_style',
            [
                'label' => __( 'Additional', 'hajimi' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $show_site_logo = $settings['show_site_logo'];
        $additional_buttons = $settings['additional_buttons'];
        $buttons = [];

        ?>
        <nav class="navbar px-3 px-xl-0 pt-2">
            <div class="navbar-row d-flex flex-wrap justify-content-between justify-content-xl-between">
                <div class="col-11 d-flex justify-content-between align-items-center">
                    <div class="navbar-col col-left">
                    <?php if( $show_site_logo ) { 
                        $custom_logo_id = get_theme_mod( 'custom_logo' );
                        $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                    ?>
                        <a href="<?= home_url();?>" class="navbar-brand">
                        <?php if( $logo ) {
                            echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . esc_attr( get_bloginfo('name') ) . '">';
                        } else {
                            echo '<h1 class="site-title">' . esc_html( get_bloginfo('name') ) . '</h1>';
                        } ?>
                        </a>
                    <?php } ?>
                    </div>
                    <div class="navbar-col col-right">

                    </div>
                </div>
            </div>
        </nav>
        <?php
    }
}