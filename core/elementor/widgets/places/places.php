<?php
namespace EB_ELEMENTOR_PLUGIN\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/* --------------------------------------------------------------------------
* Elementor Places
* Author: Eagle Themes (Jomin Muskaj)
* Since: 1.0.0s
---------------------------------------------------------------------------*/
class EB_PLACES extends Widget_Base {

	/* Retrieve the widget name. */
	public function get_name() {
		return 'eb_places';
	}

	/* Retrieve the widget title. */
	public function get_title() {
		return __( 'EB Places', 'eagle' );
	}

	/* Retrieve the widget icon. */
	public function get_icon() {
		return 'eicon-featured-image';
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
			'section_layout',
			[
				'label' => __( 'Layout', 'eagle-booking' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Layout
		$this->add_control(
			'layout',
			[
				'label' => __( 'Layout', 'eagle-booking' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal'  => __( 'Normal', 'eagle-booking' ),
					'grid'  => __( 'Grid', 'eagle-booking' ),
					'carousel'  => __( 'Carousel', 'eagle-booking' ),
				],
			]
		);

		// Items
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

				'condition' => [
					'layout!' => 'grid',
				],

				'desktop_default' => '4',
				'tablet_default' => '3',
				'mobile_default' => '1',
			]
		);

		// Height
		$this->add_control(
			'height',
				[
				'label' => esc_html__( 'Height', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 400,
				],

				'selectors' => [
					'{{WRAPPER}} .eb-place-item' => 'height: {{SIZE}}{{UNIT}};',
				],
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
					'{{WRAPPER}} .eb-places' => 'column-gap: {{SIZE}}{{UNIT}};',
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

				'condition' => [
					'layout!' => 'carousel',
				],

				'selectors' => [
					'{{WRAPPER}} .eb-places' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		// Order By
		$this->add_control(
			'order_by',
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

		// Loop (Carousel)
		$this->add_control(
			'loop',
			[
				'label' => __( 'Loop', 'eagle-booking' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'True', 'eagle-booking' ),
				'label_off' => __( 'False', 'eagle-booking' ),
				'return_value' => 'true',
				'conditions' => [
					'terms' => [
						[
							'name' => 'layout',
							'operator' => 'in',
							'value' => [
								'carousel',
							],
						],
					],
				],
			]
		);

		// Navigation (Carousel)
		$this->add_control(
			'navigation',
			[
				'label' => __( 'Navigation', 'eagle-booking' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'True', 'eagle-booking' ),
				'label_off' => __( 'False', 'eagle-booking' ),
				'return_value' => 'true',
				'conditions' => [
					'terms' => [
						[
							'name' => 'layout',
							'operator' => 'in',
							'value' => [
								'carousel',
							],
						],
					],
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Image', 'eagle-booking' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'eagle-booking' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eb-place-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'background',
				'label' => __( 'Gradient Overlay', 'eagle-booking' ),
				'types' => [ 'gradient' ],
				'selector' => '{{WRAPPER}} .eb-place-item:after',
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

		// Title
		$this->add_control(
			'title',
			[
				'label' => __( 'Show', 'eagle-booking' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'True', 'eagle-booking' ),
				'label_off' => __( 'False', 'eagle-booking' ),
				'return_value' => 'true',
				'default' => 'true'

			]
		);

		$this->add_control(
			'title_color', [
				'label' => __( 'Text Color', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .eb-place-item .title' => 'color: {{VALUE}}',
				],
				'condition' => [
					'title' => 'true',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'eagle-booking' ),
				'selector' => '{{WRAPPER}}  .eb-place-item .title',
				'condition' => [
					'title' => 'true',
				],

			],

		);

		$this->end_controls_section();

	}

	/* Render */
	protected function render() {

		$settings = $this->get_settings_for_display();

		// Places QRY
		$eb_args = array(
			'post_type' => 'eagle_places',
			'posts_per_page' => $settings['items'],
			'orderby' => $settings['order_by'],
			'order' => $settings['order'],
			'offset' =>  $settings['offset'],
		);

		$eb_places_qry = new \WP_Query( $eb_args );
		$eb_unique_token = wp_generate_password(5, false, false);

		$class = '';

		$desktop_cols = !empty( $settings['columns'] ) ? $settings['columns'] : 4;
        $tablet_cols = !empty( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : 3;
        $mobile_cols = !empty( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : 1;

		?>

		<?php if ( $settings['layout'] === 'carousel' ) {  ?>

			<script>
				jQuery(document).ready(function ($) {
					jQuery(function($) {

						var owl = $('#places-<?php echo esc_attr( $eb_unique_token ) ?>');
							owl.owlCarousel({
							loop: true,
							margin: <?php echo $settings['vertical_spacing']['size'] ?>,
							dots: false,
							nav: <?php echo $settings['navigation'] ? 'true' : 'false' ?>,
							navText: [
								"<i class='ion-ios-arrow-back'></i>",
								"<i class='ion-ios-arrow-forward'></i>"

							],
							responsive: {

								0: {
									items: <?php echo $mobile_cols ?>
								},

								768: {
									items: <?php echo $tablet_cols ?>
								},

								992: {
									items: <?php echo $desktop_cols ?>
								}

							}
						});

					});
				});
			</script>

			<?php

					$class .= 'owl-carousel';



				} elseif ( $settings['layout'] === 'normal' ) {

					$class = 'eb-g-lg-'.$desktop_cols.' '.'eb-g-md-'.$tablet_cols.' '.'eb-g-sm-'.$mobile_cols;

				} else {

					$class .= 'eb-g-2-1-1 eb-g-sm-1';
				}

			?>

		<div id="places-<?php echo esc_attr( $eb_unique_token ) ?>" class="<?php echo esc_attr( $class. ' eb-places' ) ?>">

		<?php

			// Start Places Loop
			if ( $eb_places_qry->have_posts() ) : while ($eb_places_qry->have_posts()) : $eb_places_qry->the_post();

					$eb_place_id = get_the_ID();
					$eb_place_title = get_the_title();
					$eb_place_url = get_permalink();
					$eb_place_img_url = get_the_post_thumbnail_url('', 'eagle_booking_image_size_720_470');

					/**
					* Include place item
					*/
					include "place-item.php";

				endwhile;

			endif;

		?>

		</div>

	<?php

	}

}
