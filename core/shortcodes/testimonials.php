<?php
/*---------------------------------------------------------------------------------
* Eagle Booking Testimonials/Reviews Shortcode
* Since: 1.3.5
* Author: Eagle Themes
* Shortcode: [eb_testimonials]
* Parameters: items, columns, columns_tablet, columns_mobile, navigation, order, order_by, layout = carousel | normal
-----------------------------------------------------------------------------------*/
if( !function_exists('eb_testimonials') ) {

    function eb_testimonials( $atts, $content = null ) {

        extract( shortcode_atts ( array(

            'items' => '',
            'columns' => '',
            'columns_tablet' => '',
            'columns_mobile' => '',
            'offset' => '',
            'orderby' => '',
            'order' => '',
            'layout' => '',
            'navigation' => '',


        ), $atts));

        ob_start();

		$eb_query_args = array(
			'post_type' => 'eagle_reviews',
			'posts_per_page' =>  $items,
			'orderby' => $orderby,
			'order' => $order,
			'offset' => $offset
		);

		$eb_review_qry = new \WP_Query($eb_query_args);
		$eb_unique_token = wp_generate_password(5, false, false);

		$class = '';

        $desktop_cols = !empty( $columns ) ? $columns : 4;
        $tablet_cols = !empty( $columns_tablet ) ? $columns_tablet : 3;
        $mobile_cols = !empty( $columns_mobile ) ? $columns_mobile : 1;


        if ( $layout === 'carousel' ) { ?>

            <script>
                jQuery(document).ready(function ($) {
                    jQuery(function($) {

                        var owl = $('#testimonials-<?php echo esc_attr( $eb_unique_token ) ?>');
                            owl.owlCarousel({
                            loop: true,
                            margin: 30,
                            dots: <?php echo $navigation ? 'true' : 'false' ?>,
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

            <?php endwhile; endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        </div>

        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }

    add_shortcode('eb_testimonials', 'eb_testimonials');
}
