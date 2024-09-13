<?php
/**
 * The Template for displaying room info
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/single-room/info.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.
 */

defined('ABSPATH') || exit;


$eb_mtb_room_max_guests = get_post_meta(get_the_ID(), 'eagle_booking_mtb_room_maxguests', true);
$eb_mtb_room_max_adults = get_post_meta(get_the_ID(), 'eagle_booking_mtb_room_max_adults', true);
$eb_mtb_room_max_children = get_post_meta(get_the_ID(), 'eagle_booking_mtb_room_max_children', true);

$eb_mtb_room_min_booking_nights = get_post_meta(get_the_ID(), 'eagle_booking_mtb_room_min_booking_nights', true);
$eb_mtb_room_max_booking_nights = get_post_meta(get_the_ID(), 'eagle_booking_mtb_room_max_booking_nights', true);

if( empty( $eb_mtb_room_min_booking_nights ) ) $eb_mtb_room_min_booking_nights = 1;

$eb_mtb_room_size = get_post_meta(get_the_ID(), 'eagle_booking_mtb_room_size', true);
$eb_mtb_room_bed_type = get_post_meta(get_the_ID(), 'eagle_booking_mtb_room_bed_type', true);


?>

<div class="room-info">

    <div class="item">
      <i class="flaticon-child"></i>
      <div class="room-info-content">
        <div>
          <?php
          if (eb_get_option('eb_adults_children') == true) {

              echo __($eb_mtb_room_max_adults).' '.__('Adults', 'eagle-booking').' / ' .__($eb_mtb_room_max_children).' '.__('Children', 'eagle-booking');

          } else {

              echo __($eb_mtb_room_max_guests).' '.__('Guests', 'eagle-booking');

          }
          ?>
        </div>
      </div>
    </div>


    <div class="item">
      <i class="flaticon-bed"></i>
      <div class="room-info-content">
        <div>
        <?php echo esc_html( $eb_mtb_room_bed_type ) ?>
        </div>
      </div>
    </div>



    <div class="item">
      <i class="flaticon-map"></i>
      <div class="room-info-content">
        <div>
        <?php echo esc_html( $eb_mtb_room_size ) ?> <?php echo eb_get_option('eagle_booking_units_of_measure') ?>
        </div>
      </div>
    </div>

</div>