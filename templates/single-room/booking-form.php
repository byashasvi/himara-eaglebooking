<?php
/**
* The Template for the calendar
*
* This template can be overridden by copying it to yourtheme/eb-templates/single-room/booking-form.php.
*
* Author: Eagle Themes
* Package: Eagle-Booking/Templates
* Version: 1.1.6
*/

defined('ABSPATH') || exit;
?>

<div class="eb-widget eb-widget-border calendar">
  <h2 class="title"><?php echo __('Book Your Room','eagle-booking') ?></h2>
  <div class="inner">
    <form id="room-booking-form" action="<?php echo $eagle_booking_action ?>" class="room-booking-form" method="<?php echo $eagle_booking_action_method ?>" target="<?php echo esc_attr( $eagle_booking_target ) ?>">

        <?php include eb_load_template('elements/custom-parameters.php') ?>

        <input type="hidden" name="eb_room_id" value="<?php echo get_the_ID() ?>" />
        <input type="hidden" name="eb_single_room" value="1">

        <?php if (eb_get_option('booking_type') == 'custom' ) : ?>
        <input type="hidden" name="<?php echo esc_html( $eagle_booking_room_param ) ?>" value="<?php echo esc_html( $eagle_booking_room_external_id ) ?>" >
        <?php endif ?>

          <?php

            /**
             * Include Date Picker
            */
            include eb_load_template('elements/dates-picker.php');

            /**
             * Include Guests Picker
            */
            include eb_load_template('elements/guests-picker.php');

          ?>
        
          <div id="priceOnForm">
            <span>Price:</span> <div><span>INR. 1,500 / per night</span> <p>(Price before taxes)</p></div>
          </div>
        
          <?php
              $eb_meta_box_room_custom_link = get_post_meta( get_the_ID(), 'eagle_booking_room_custom_link', true );
              if ( empty($eb_meta_box_room_custom_link) ) { ?>

                <button id="eb_search_form" name="submit" class="btn eb-btn mt30" type="submit">
                  <span class="eb-btn-text"><?php echo __('Check Availability','eagle-booking') ?></span>
                </button>
                
                <div id="divAvailableDate">
                    <span>
                        <a href="#availDateSection">
                            <p>See All Available Dates</p><img decoding="async" id="availableDateIcon" src="https://alipurapalace.com/wp-content/uploads/2024/05/arrow.png">
                        </a>
                    </span>
                </div>
                
          <?php } else { ?>
                <a target="_blank" class="btn eb-btn" href="<?php echo $eb_meta_box_room_custom_link ?>"><?php echo __('Book Now','eagle-booking') ?></a>
          <?php } ?>

    </form>
  </div>
</div>