<?php
namespace EB_ELEMENTOR_PLUGIN\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/* --------------------------------------------------------------------------
* Eagle Booking Elementor Search Widget
* Author: Eagle Themes (Jomin Muskaj)
* Since: 1.0.0
---------------------------------------------------------------------------*/
class EB_SEARCH_FORMS extends Widget_Base {

	/* Retrieve the widget name. */
	public function get_name() {
		return 'eb_search_form';
	}

	/* Retrieve the widget title. */
	public function get_title() {
		return __( 'EB Search Form', 'eagle-booking' );
	}

	/* Retrieve the widget icon. */
	public function get_icon() {
		return 'eicon-site-search';
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

		// Style Tab
		$this->start_controls_section(
			'section_style',
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
				'default' => 'horizontal',
				'options' => [
					'horizontal'  => __( 'Horizontal', 'eagle-booking' ),
					'vertical'  => __( 'Vertical', 'eagle-booking' ),
					// 'popup'  => __( 'Popup', 'eagle-booking' ),
				],
			]
		);

		// Form Label
		$this->add_control(
			'branch',
			[
				'label' => __( 'Branch Selector', 'eagle-booking' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'eagle-booking' ),
				'label_off' => __( 'Hide', 'eagle-booking' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'bg_color', [
				'label' => __( 'Background Color', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eb-search-form' => 'background: {{VALUE}}'
				],
			]
		);

		$this->add_responsive_control(
			'margin',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Margin', 'eagle-booking' ),
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eb-search-form' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'padding',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Padding', 'eagle-booking' ),
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '30',
					'right' => '30',
					'bottom' => '30',
					'left' => '30',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .eb-search-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .eb-search-form',
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
					'{{WRAPPER}} .eb-search-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => __( 'Box Shadow', 'eagle-booking' ),
				'selector' => '{{WRAPPER}} .eb-search-form',
			]
		);

		$this->end_controls_section();

    	// New Section [Title]
		$this->start_controls_section(
			'title_section',
			[
				'label' => __( 'Title', 'eagle-booking' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_availability',
			[
				'raw' => '<strong>' . esc_html__( 'Please note!', 'eagle-booking' ) . '</strong> ' . esc_html__( 'Title is available only for the horizontal search form', 'eagle-booking' ),
				'type' => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
				'render_type' => 'ui',
				'condition' => [
					'layout!' => 'vertical',
				],
			]
		);

		$this->add_control(
			'title_text', [
				'label' => __( 'Title', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Book Your Stay' , 'eagle-booking' ),
				'condition' => ['layout' => 'vertical'],

			]
		);

		$this->add_control(
			'title_align',
			[
				'label' => esc_html__( 'Alignment', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'eagle-booking' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'eagle-booking' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'eagle-booking' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'selectors' => [
					'{{WRAPPER}} .eb-search-form .form-title' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color', [
				'label' => __( 'Text Color', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eb-search-form .form-title' => 'color: {{VALUE}}'
				],
				'condition' => ['layout' => 'vertical'],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Title Typography', 'eagle-booking' ),
				'selector' => '{{WRAPPER}}  .eb-search-form .form-title',
				'condition' => ['layout' => 'vertical'],
			],

		);

		$this->add_responsive_control(
			'title_padding',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Padding', 'eagle-booking' ),
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eb-search-form .form-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => ['layout' => 'vertical'],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Margin', 'eagle-booking' ),
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '0',
					'right' => '15',
					'bottom' => '30',
					'left' => '15',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .eb-search-form .form-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'title_border',
				'label' => esc_html__( 'Border', 'eagle-booking' ),
				'selector' => '{{WRAPPER}} .eb-search-form .form-title',
				'condition' => ['layout' => 'vertical'],
			]
		);

		$this->end_controls_section();

    	// New Section [Fields]
		$this->start_controls_section(
			'fields_section',
			[
				'label' => __( 'Fields', 'eagle-booking' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'field_margin',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Margin', 'eagle-booking' ),
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .eb-search-form .eb-field-group' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'field_padding',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Padding', 'eagle-booking' ),
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '0',
					'left' => '0',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .eb-search-form .eb-field-group .eb-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Form Label
		$this->add_control(
			'label',
			[
				'label' => __( 'Labels', 'eagle-booking' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'eagle-booking' ),
				'label_off' => __( 'Hide', 'eagle-booking' ),
				'return_value' => 'block',
				'default' => false,
				'selectors' => [
					'{{WRAPPER}} .eb-field-group label' => 'display: {{VALUE}};'
				],
			]
		);

		$this->add_control(
			'label_color', [
				'label' => __( 'Label Color', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition' => ['label' => 'block'],
				'selectors' => [
					'{{WRAPPER}} .eb-field-group > label' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => __( 'Label Typography', 'eagle-booking' ),
				'selector' => '{{WRAPPER}} .eb-field-group label',
				'condition' => ['label' => 'block'],
			],

		);

		$this->add_control(
			'field_color', [
				'label' => __( 'Field Color', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eb-field-group ::-webkit-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eb-field-group .guestspicker' => 'color: {{VALUE}};',
					'{{WRAPPER}} .eb-field-group .eb-field' => 'color: {{VALUE}};'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'field_typography',
				'label' => __( 'Field Typography', 'eagle-booking' ),
				'selector' => '{{WRAPPER}}  .eb-field-group .eb-field',

			],

		);

		$this->add_control(
			'field_bg_color', [
				'label' => __( 'Background Color', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eb-search-form .eb-field' => 'background: {{VALUE}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'field_border',
				'label' => esc_html__( 'Border', 'eagle-booking' ),
				'selector' => '{{WRAPPER}} .eb-search-form .eb-field',
			]
		);

		$this->add_responsive_control(
			'field_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'eagle-booking' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => '1',
					'right' => '1',
					'bottom' => '1',
					'left' => '1',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .eb-search-form .eb-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

    	// New Section [Button]
		$this->start_controls_section(
			'button_section',
			[
				'label' => __( 'Button', 'eagle-booking' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Buton Text
		$this->add_control(
			'button_text', [
				'label' => __( 'Button Text', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Book Your Room' , 'eagle-booking' ),
				// 'condition' => ['layout' => 'popup'],
			]
		);

		$this->start_controls_tabs(
			'style_tabs'
		);

		$this->start_controls_tab(
			'style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'eagle-booking' ),
			]
		);

		$this->add_control(
			'button_color', [
				'label' => __( 'Text Color', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eb-btn-search-form' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'button_bg_color', [
				'label' => __( 'Background Color', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#19a1f7',
				'selectors' => [
					'{{WRAPPER}} .eb-btn-search-form' => 'background: {{VALUE}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
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
						'default' => '#19a1f7',
					],
				],

				'selector' => '{{WRAPPER}} .eb-btn-search-form',

			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'eagle-booking' ),
			]
		);

		$this->add_control(
			'button_color_hover', [
				'label' => __( 'Text Color Hover', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .eb-btn-search-form:hover' => 'color: {{VALUE}}'
				],
			]
		);

		$this->add_control(
			'button_bg_color_hover', [
				'label' => __( 'Background Color Hover', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#19a1f7',
				'selectors' => [
					'{{WRAPPER}} .eb-btn-search-form:hover' => 'background: {{VALUE}}'
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'button_border_hover',
				'label' => esc_html__( 'Border Hover', 'eagle-booking' ),
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
						'default' => '#19a1f7',
					],
				],

				'selector' => '{{WRAPPER}} .eb-btn-search-form:hover',

			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => __( 'Typography', 'eagle-booking' ),
				'selector' => '{{WRAPPER}}  .eb-btn-search-form',
				'condition!' => ['layout' => 'popup'],
			],

		);

		$this->add_responsive_control(
			'button_padding',
			[
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'label' => esc_html__( 'Padding', 'eagle-booking' ),
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eb-btn-search-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'eagle-booking' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .eb-btn-search-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	/* Render */
	protected function render() {

		// Include form parameters
		include EB_PATH . '/core/admin/form-parameters.php';

		$settings = $this->get_settings_for_display();
	?>

	<?php if ( $settings['layout'] === 'horizontal' ) : ?>

	<div class="eb-search-form eb-horizontal-search-form eb-elementor">
		<form id="search-form" action="<?php echo $eagle_booking_action ?>" method="GET" target="<?php echo esc_attr( $eagle_booking_target ) ?>">
			<div class="eb-form-fields">

				<?php

					/**
					 * Include Custom Parameters
					*/
					include eb_load_template('elements/custom-parameters.php');

					/**
					 * Include Dates Picker
					*/
					include eb_load_template('elements/dates-picker.php');

					/**
					 * Include Guests Picker
					*/
					include eb_load_template('elements/guests-picker.php');

					/**
					 * Include Branch Selector
					*/
					if ( $settings['branch'] == true ) include eb_load_template('elements/branch-selector.php');

				?>

				<div class="eb-field-button">
					<button id="eb_search_form" class="btn eb-btn-search-form" type="submit" >
						<span class="eb-btn-text"><?php echo $settings['button_text'] ?></span>
					</button>
				</div>

			</div>
		</form>
	</div>

	<?php elseif ( $settings['layout'] === 'vertical' ) : ?>

	<div class="eb-search-form eb-vertical-search-form eb-elementor">
		<h3 class="form-title"><?php echo $settings['title_text'] ?></h3>
		<form id="search-form" action="<?php echo $eagle_booking_action ?>" method="get" target="<?php echo esc_attr( $eagle_booking_target ) ?>">

			<?php

				/**
				 * Include Custom Parameters
				*/
				include eb_load_template('elements/custom-parameters.php');

				/**
				 * Include Dates Picker
				*/
				include eb_load_template('elements/dates-picker.php');

				/**
				 * Include Guests Picker
				*/
				include eb_load_template('elements/guests-picker.php');

				/**
				 * Include Branch Selector
				*/
				if ( $settings['branch'] == true ) include eb_load_template('elements/branch-selector.php');

			?>

			<div class="eb-field-button">
				<button id="eb_search_form" class="btn eb-btn-search-form" type="submit" >
					<span class="eb-btn-text"><?php echo $settings['button_text'] ?></span>
				</button>
			</div>

		</form>
	</div>

	<?php else : ?>

		<button id="eb-popup-search-form" class="eb-btn eb-popup-search-form-btn booking-form-toggle"><?php echo $settings['button_text'] ?><i class="fa fa-calendar" aria-hidden="true"></i></button>

	<?php endif ?>

<?php

	}

}
