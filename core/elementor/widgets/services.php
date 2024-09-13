<?php
namespace EB_ELEMENTOR_PLUGIN\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/* --------------------------------------------------------------------------
* Elementor Gallery
* Author: Eagle Themes
* Since: 1.0.0
---------------------------------------------------------------------------*/
class EB_SERVICES extends Widget_Base {

	/* Retrieve the widget name. */
	public function get_name() {
		return 'eb_services';
	}

	/* Retrieve the widget title. */
	public function get_title() {
		return __( 'EB Services', 'eagle-booking' );
	}

	/* Retrieve the widget icon. */
	public function get_icon() {
		return 'eicon-editor-list-ul';
	}

	/* Retrieve the list of categories the widget belongs to.*/
	public function get_categories() {
		return [ 'eaglebooking' ];
	}

	/*Retrieve the list of scripts the widget depended on. */
	public function get_script_depends() {
		return [ 'core-js', 'core-css' ];
	}

	/* Register the widget controls. */
	protected function register_controls() {

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Layout', 'eagle-booking' ),
				'tab' => Controls_Manager::TAB_LAYOUT,
			]
		);

		// Items to Display
		$this->add_control(
			'items',
			[
				'label' => __( 'Items to Display', 'eagle-booking' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '10',
			]
		);

		// Columns
		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'eagle-booking' ),
				'type' => Controls_Manager::SELECT,
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'options' => [
					'1'  => '1',
					'2'  => '2',
					'3'  => '3',
					'4'  => '4',
					'5'  => '5',
					'6'  => '6'
				],

				'desktop_default' => '4',
				'tablet_default' => '2',
				'mobile_default' => '1',
			]
		);

			// Vertical Spacing
			$this->add_control(
				'vertical_spacing',
					[
					'label' => esc_html__( 'Vertical Spacing', 'eagle-booking' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 30,
					],

					'selectors' => [
						'{{WRAPPER}} .eb-services' => 'column-gap: {{SIZE}}{{UNIT}};',
					],
				]

			);

			// Horizontal Spacing
			$this->add_control(
				'horizontal_spacing',
					[
					'label' => esc_html__( 'Horizontal Spacing', 'eagle-booking' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 30,
					],

					'selectors' => [
						'{{WRAPPER}} .eb-services' => 'row-gap: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'padding',
				[
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'label' => esc_html__( 'Padding', 'eagle-booking' ),
					'size_units' => [ 'px' ],
					'default' => [
						'top' => '15',
						'right' => '15',
						'bottom' => '15',
						'left' => '15',
						'isLinked' => true,
					],
					'selectors' => [
						'{{WRAPPER}} .eb-service-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'background', [
					'label' => __( 'Background Color', 'eagle-booking' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .eb-service-item' => 'background: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'border',
					'label' => esc_html__( 'Border', 'eagle-booking' ),
					'fields_options' => [
						'border' => [
							'default' => 'solid',
						],
						'width' => [
							'default' => [
								'top' => '1',
								'right' => '1',
								'bottom' => '1',
								'left' => '1',
								'isLinked' => false,
							],
						],
						'color' => [
							'default' => '#ededed',
						],
					],
					'selector' => '{{WRAPPER}} .eb-service-item'
				]
			);

			$this->add_control(
				'sperator_color', [
					'label' => __( 'Seperator Color', 'eagle-booking' ),
					'type' => \Elementor\Controls_Manager::COLOR,
					'default' => '#ededed',
					'selectors' => [
						'{{WRAPPER}} .eb-service-item span:after' => 'background: {{VALUE}}',
					],
				]
			);

			$this->add_responsive_control(
				'border_radius',
				[
					'label' => esc_html__( 'Border Radius', 'eagle-booking' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px'],
					'default' => [
						'top' => '4',
						'right' => '4',
						'bottom' => '4',
						'left' => '4',
						'isLinked' => false,
					],
					'selectors' => [
						'{{WRAPPER}} .eb-service-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		// Order By
		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'eagle-booking' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ID',
				'options' => [
					'none'  => __( 'None', 'eagle-booking' ),
					'ID'  => __( 'ID', 'eagle-booking' ),
					'title'  => __( 'Title', 'eagle-booking' ),
					'date'  => __( 'Date', 'eagle-booking' ),
					'rand'  => __( 'Random', 'eagle-booking' ),
					'menu_order'  => __( 'Menu Order', 'eagle-booking' ),
				],
			]
		);

		// Order
		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'eagle-booking' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'ASC',
				'options' => [
					'ASC'  => __( 'ASC', 'eagle-booking' ),
					'DESC'  => __( 'DESC', 'eagle-booking' ),
				],
			]
		);

		// Offset
		$this->add_control(
			'offset',
			[
				'label' => __( 'Offset', 'eagle-booking' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_icon',
			[
				'label' => __( 'Icon', 'eagle-booking' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color', [
				'label' => __( 'Icon Color', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eb-service-item i' => 'color: {{VALUE}}',
				],
			]
		);

		// Vertical Spacing
		$this->add_control(
			'icon_size',
				[
				'label' => esc_html__( 'Size', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],

				'selectors' => [
					'{{WRAPPER}} .eb-service-item i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]

		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'Title', 'eagle-booking' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color', [
				'label' => __( 'Color', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eb-service-item .title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'eagle-booking' ),
				'selector' => '{{WRAPPER}}  .eb-service-item .title',

			],

		);

		$this->end_controls_section();
	}

	/* Render */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$desktop_cols = !empty( $settings['columns'] ) ? $settings['columns'] : 4;
        $tablet_cols = !empty( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : 3;
        $mobile_cols = !empty( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : 1;

		// Services QRY
		$eb_services_qry = array(
			'post_type' => 'eagle_services',
			'posts_per_page' => $settings['items'],
			'orderby' => $settings['orderby'],
			'order' => $settings['order'],
			'offset' => $settings['offset']
		);

		$eb_services_qry = new \WP_Query($eb_services_qry);

		$class = 'eb-g-lg-'.$desktop_cols.' '.'eb-g-md-'.$tablet_cols.' '.'eb-g-sm-'.$mobile_cols;

	    ?>

		<div class="<?php echo esc_attr( $class ) ?> eb-services">

			<?php

				if ( $eb_services_qry->have_posts() ) : while ( $eb_services_qry->have_posts() ) : $eb_services_qry->the_post();

					$eb_service_id = get_the_ID();

					$service_title = get_the_title( $eb_service_id );

					$eb_service_icon_type = get_post_meta( $eb_service_id, 'eagle_booking_mtb_service_icon_type', true );

					if ( $eb_service_icon_type === 'fontawesome') {

						$eb_service_icon = get_post_meta( $eb_service_id, 'eagle_booking_mtb_service_icon_fontawesome', true );

					} elseif (  $eb_service_icon_type == 'fonticon'  ) {

						$eb_service_icon = get_post_meta( $eb_service_id, 'eagle_booking_mtb_service_icon', true );

					} else {

						$eb_service_icon = get_post_meta( $eb_service_id, 'eagle_booking_mtb_service_image', true );
					}

					$html = '<div class="eb-service-item">';
					$html .= '<span class="icon">';

					if ( $eb_service_icon_type === 'customicon' ) {

						$html .= '<img src="' .esc_url( $eb_service_icon ).'">';

					} else {

						$html .= '<i class="'. $eb_service_icon. '"></i>';

					}

					$html .= '</span>';

					$html .= '<h5 class="title">'.$service_title.'</h5>';

					$html .= '</div>';


					echo $html;

				endwhile;

			endif;

			?>

		</div>
<?php

	}

}
