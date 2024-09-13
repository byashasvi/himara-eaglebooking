<?php
namespace EB_ELEMENTOR_PLUGIN\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/* --------------------------------------------------------------------------
* Elementor rooms
* Author: Eagle Themes
* Since: 1.0.0
---------------------------------------------------------------------------*/
class EB_ROOMS extends Widget_Base {

	/* Retrieve the widget name. */
	public function get_name() {
		return 'eb_rooms';
	}

	/* Retrieve the widget title. */
	public function get_title() {
		return __( 'EB Rooms', 'eagle-booking' );
	}

	/* Retrieve the widget icon. */
	public function get_icon() {
		return 'eicon-apps';
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
				'label' => __( 'Settings', 'eagle-booking' ),
			]
		);

		// Layout
		$this->add_control(
			'layout',
			[
				'label' => __( 'Style', 'eagle-booking' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal'  => __( 'Normal', 'eagle-booking' ),
					'grid'  => __( 'Grid', 'eagle-booking' ),
					'carousel'  => __( 'Carousel', 'eagle-booking' ),
					// 'list'  => __( 'List', 'eagle-booking' ),
				],
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

				'condition' => [
					'layout!' => 'grid',
				],
			]

		);

		// Items to Display
		$this->add_control(
			'items',
			[
				'label' => __( 'Items to Display', 'eagle-booking' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '10',
				'condition' => [
					'layout!' => 'grid',
				],
			]
		);

		// Branches
		$this->add_control(
			'branch_id',
			[
				'label' => __( 'Branch', 'eagle-booking' ),
				'type' => Controls_Manager::SELECT,
				'default' => '0',
				'options' => eb_sort_by_branch()
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

	}

	/* Render */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$desktop_cols = !empty( $settings['columns'] ) ? $settings['columns'] : 4;
        $tablet_cols = !empty( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : 3;
        $mobile_cols = !empty( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : 1;


		$items = $settings['items'];

		if ( $settings['layout'] === 'grid' ) $items = 3;

		// rooms
		$eagle_query_args = array(
			'post_type' => 'eagle_rooms',
			'posts_per_page' => $items,
			'orderby' => $settings['order_by'],
			'order' => $settings['order'],
			'offset' =>  $settings['offset'],

		);

		/**
		* Sort by branch
		*/
		if ( isset($settings['branch_id']) && !empty( ($settings['branch_id']) ) && $settings['branch_id'] != '' && $settings['branch_id'] != '0'  ) {

			$eagle_query_args['tax_query'][] = array(
			'taxonomy' => 'eagle_branch',
			'field' => 'term_id',
			'terms' => $settings['branch_id'],
			);
		}

		$eb_rooms_qry = new \WP_Query($eagle_query_args);
		$eb_unique_token = wp_generate_password(5, false, false);

		$class = '';
		$image_size = '';

	?>

	<?php if ( $settings['layout'] === 'carousel' ) { ?>

		<script>
			jQuery(document).ready(function ($) {
				jQuery(function($) {

					var owl = $('#rooms-<?php echo esc_attr( $eb_unique_token ) ?>');
						owl.owlCarousel({
						loop: <?php echo $settings['navigation'] ? 'true' : 'false' ?>,
						margin: 30,
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

			$class .= 'owl-carousel testimonials-owl';
			$image_size = 'eagle_booking_image_size_370_485';

		} elseif ( $settings['layout'] === 'normal' ) {

			$class = 'eb-g-lg-'.$desktop_cols.' '.'eb-g-md-'.$tablet_cols.' '.'eb-g-sm-'.$mobile_cols;
			$image_size = 'eagle_booking_image_size_370_485';

		} elseif (  $settings['layout'] === 'grid' ) {

			$class = 'eb-g-2-1-1 eb-g-sm-1';
			$image_size = 'eagle_booking_image_size_720_470';
		}

		?>
		<div id="<?php echo esc_attr( 'rooms-'.$eb_unique_token ) ?>" class="<?php echo esc_attr( $class ) ?> eb-rooms">

	<?php

		$eb_counter = 0;

		// Loop
		if ( $eb_rooms_qry->have_posts()) : while ( $eb_rooms_qry->have_posts() ) : $eb_rooms_qry->the_post();

			// Grid Style
			if ( ( $settings['layout'] === 'grid' ) && ( $eb_counter == 1 || $eb_counter == 2  ) ) $image_size = 'eagle_booking_image_size_370_485';

        	$eb_room_id = get_the_ID();
			$eb_room_title = get_the_title();
			$eb_room_url = get_permalink();
			$eb_room_img_url = get_the_post_thumbnail_url('', $image_size);

			/**
			* Include room item
			*/
			include('room-item.php');

			$eb_counter++;

	?>

	<?php endwhile; endif; ?>

		</div>

		<?php

	}

}
