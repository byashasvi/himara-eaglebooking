<?php
namespace EB_ELEMENTOR_PLUGIN\Widgets;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/* --------------------------------------------------------------------------
* Branches Elementor Widget
* Author: Eagle Themes
* Since: 1.0.0
---------------------------------------------------------------------------*/
class EB_BRANCHES extends Widget_Base {

	/* Retrieve the widget name. */
	public function get_name() {
		return 'eb_branches';
	}

	/* Retrieve the widget title. */
	public function get_title() {
		return __( 'EB Branches', 'eagle-booking' );
	}

	/* Retrieve the widget icon. */
	public function get_icon() {
		return 'eicon-sitemap';
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

				'desktop_default' => '3',
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
				'default' => 'term_id',
				'options' => [
					'none'  => __( 'None', 'eagle-booking' ),
					'term_id'  => __( 'ID', 'eagle-booking' ),
					'name'  => __( 'Title', 'eagle-booking' ),
					'slug'  => __( 'Slug', 'eagle-booking' ),
					'term_group'  => __( 'Term Group', 'eagle-booking' ),
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
			'section_title',
			[
				'label' => __( 'Title', 'eagle-booking' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color', [
				'label' => __( 'Text Color', 'eagle-booking' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}}  .eb-branch-details .title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'eagle-booking' ),
				'selector' => '{{WRAPPER}}  .eb-branch-details .title',

			],

		);

		$this->end_controls_section();

	}

	/* Render */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$desktop_cols = !empty( $settings['columns'] ) ? $settings['columns'] : 3;
        $tablet_cols = !empty( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : 3;
        $mobile_cols = !empty( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : 1;

		$args = array(
            'taxonomy'    => 'eagle_branch',
            'hide_empty'  => false,
			'number'      => $settings['items'],
			'orderby'     => $settings['orderby'],
			'order'       => $settings['order'],
			'offset'      => $settings['offset']
        );

        $branches_qry = new \WP_Term_Query($args);
		$class = '';
		$class = 'eb-g-lg-'.$desktop_cols.' '.'eb-g-md-'.$tablet_cols.' '.'eb-g-sm-'.$mobile_cols;

	?>

	<div class="<?php echo esc_attr( $class ) ?> eb-braches">

	<?php

		if (!empty($branches_qry->terms)) {

			foreach ($branches_qry->terms as $eb_branch_term) {

			$eb_branch_id = $eb_branch_term->term_id;
			$eb_branch_name = get_term_field( 'name', $eb_branch_term );
			$eb_branch_logo = get_term_meta( $eb_branch_id, 'eb_branch_logo', true );
			$eb_branch_bg = get_term_meta( $eb_branch_id, 'eb_branch_bg', true );
			$eb_branch_address = get_term_meta( $eb_branch_id, 'eb_branch_address', true );
			$eb_branch_phone = get_term_meta( $eb_branch_id, 'eb_branch_phone', true );
			$eb_branch_email = get_term_meta( $eb_branch_id, 'eb_branch_email', true );
			$eb_branch_url = get_term_link($eb_branch_id);

		?>
			<div class="eb-branch-item">
				<a href="<?php echo esc_url( $eb_branch_url ) ?>">
					<figure style="background-image: url(<?php echo esc_url( $eb_branch_bg ) ?>); background-size: cover">
						<div class="eb-branch-details">
							<div class="eb-branch-details-inner ">
								<h4 class="title"><?php echo esc_html( $eb_branch_name ) ?></h4>
								<div class="eb-branch-location"><i class="icon-location-pin"></i> <?php echo $eb_branch_address ?></div>
							</div>
						</div>
					</figure>

				</a>

			</div>

		<?php } } ?>

	</div>

<?php

	}

}
