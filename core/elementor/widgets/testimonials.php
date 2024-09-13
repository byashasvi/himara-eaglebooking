<?php
namespace EB_ELEMENTOR_PLUGIN\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/* --------------------------------------------------------------------------
* Testimonials Elementor Widget
* Author: Eagle Themes
* Since: 1.0.0
---------------------------------------------------------------------------*/
class EB_REVIEWS extends Widget_Base {

	/* Retrieve the widget name. */
	public function get_name() {
		return 'eb_reviews';
	}

	/* Retrieve the widget title. */
	public function get_title() {
		return __( 'EB Reviews', 'eagle-booking' );
	}

	/* Retrieve the widget icon. */
	public function get_icon() {
		return 'eicon-review';
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
	protected function register_controls()  {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Settings', 'eagle-booking' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Layout
		$this->add_control(
			'layout',
			[
				'label' => __( 'Layout', 'eagle-booking' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => [
					'grid'  => __( 'Grid', 'eagle-booking' ),
					'carousel'  => __( 'Carousel', 'eagle-booking' ),
				],
			]
		);


		// Items to Display
		$this->add_control(
			'items',
			[
				'label' => __( 'Items to Display', 'eagle-booking' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '8',
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
			'return_value' => true,
			'default' => true,
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

	$this->add_control(
		'bg_color', [
			'label' => __( 'Background Color', 'eagle-booking' ),
			'type' => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .item .testimonial-item' => 'background: {{VALUE}}'
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
			'selector' => '{{WRAPPER}} .item .testimonial-item',
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
				'{{WRAPPER}} .item .testimonial-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

	$this->add_group_control(
		\Elementor\Group_Control_Box_Shadow::get_type(),
		[
			'name' => 'box_shadow',
			'label' => esc_html__( 'Box Shadow', 'eagle-booking' ),
			'selector' => '.item .testimonial-item',
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

		$eb_query_args = array(
			'post_type' => 'eagle_reviews',
			'posts_per_page' =>  $settings['items'],
			'orderby' => $settings['orderby'],
			'order' => $settings['order'],
			'offset' => $settings['offset']
		);

		$eb_review_qry = new \WP_Query($eb_query_args);
		$eb_unique_token = wp_generate_password(5, false, false);

		$class = '';

	?>

	<?php if ( $settings['layout'] === 'carousel' ) { ?>

	<script>
		jQuery(document).ready(function ($) {
			jQuery(function($) {

				var owl = $('#testimonials-<?php echo esc_attr( $eb_unique_token ) ?>');
					owl.owlCarousel({
					loop: true,
					margin: 30,
					dots: <?php echo $settings['navigation'] ? 'true' : 'false' ?>,
					nav: false,
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

	<?php if ( $settings['navigation'] != true ) : ?>

		<style>.testimonials .testimonials-owl { padding-left: 0  }</style>

	<?php endif ?>

    <?php

		$class .= 'owl-carousel testimonials-owl';

	} else {

		$class = 'eb-g-lg-'.$desktop_cols.' '.'eb-g-md-'.$tablet_cols.' '.'eb-g-sm-'.$mobile_cols;

	}

	?>

	<div class="testimonials">

		<div id="<?php echo esc_attr( 'testimonials-'.$eb_unique_token ) ?>" class="<?php echo esc_attr( $class ) ?>">
			<?php

			if ($eb_review_qry->have_posts()): while ($eb_review_qry->have_posts()) : $eb_review_qry->the_post();

				$eb_review_author_name = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_author', true );
				$eb_review_avatar_file_id = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_image_id', true );
				$eb_review_avatar =  wp_get_attachment_image_url( $eb_review_avatar_file_id);
				$eb_review_author_location = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_author_location', true );
				$eb_review_rating = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_rating', true );
				$eb_review_quote = get_post_meta(get_the_ID(), 'eagle_booking_mtb_review_quote', true );

				?>

				<div class="item">
					<div class="testimonial-item">
						<div class="author-img">
							<img alt="<?php echo esc_html( $eb_review_author_name ) ?>" class="img-fluid" src="<?php echo esc_url( $eb_review_avatar ) ?>">
						</div>
						<div class="author">
							<h4 class="name"><?php echo esc_html( $eb_review_author_name ) ?></h4>
							<div class="location"><?php echo esc_html( $eb_review_author_location ) ?></div>
						</div>
						<div class="rating">
						<?php

							for( $x = 1; $x <= $eb_review_rating; $x++ ) {

								echo '<i class="fa fa-star voted" aria-hidden="true"></i>';
							}

							if ( strpos( $eb_review_rating,'.' ) ) {

								echo '<i class="fa fa-star" aria-hidden="true"></i>';

								$x++;
							}

							while ( $x <= 5 ) {

								echo '<i class="fa fa-star" aria-hidden="true"></i>';

								$x++;
							}

						?>
						</div>
						<p><?php echo esc_html( $eb_review_quote ) ?></p>


					</div>
				</div>

			<?php endwhile; endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>

<?php

	}

}
