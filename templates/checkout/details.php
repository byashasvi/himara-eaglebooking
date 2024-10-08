<?php
   /**
    * The Template for the checkout booking details
    *
    * This template can be overridden by copying it to yourtheme/eb-templates/checkout/details.php.
    *
    * Author: Eagle Themes
    * Package: Eagle-Booking/Templates
    * Version: 1.1.6
    */

   defined('ABSPATH') || exit;

  /**
  * Include Stepline
  */
  if ( eb_get_option('eb_stepline' ) == true ) include eb_load_template('elements/stepline.php');

?>


<div class="checkout-details eb-g-3">

    <h4 class="title"><?php echo esc_html__('Booking Details','eagle-booking') ?></h4>

    <div class="checkout-details-inner">

      <div><strong><?php echo esc_html__('Full Name','eagle-booking') ?>:</strong> <?php echo $eagle_booking_form_name .' '.$eagle_booking_form_surname ?></div>

      <div><strong><?php echo esc_html__('Email','eagle-booking') ?>:</strong> <?php echo $eagle_booking_form_email ?></div>

      <div><strong><?php echo esc_html__('Phone','eagle-booking') ?>:</strong> <?php echo $eagle_booking_form_phone ?></div>

      <?php if ( eb_get_option('eb_booking_form_fields')['address'] == true && !empty( $eagle_booking_form_address.$eagle_booking_form_zip.$eagle_booking_form_city.$eagle_booking_form_country ) ) : ?>
          <div><strong><?php echo esc_html__('Address','eagle-booking') ?>:</strong> <?php echo $eagle_booking_form_address .', '.$eagle_booking_form_zip .', '.$eagle_booking_form_city .', '.$eagle_booking_form_country ?></div>
      <?php endif ?>

      <div><strong><?php echo esc_html__('Room','eagle-booking') ?>:</strong> <?php echo $eagle_booking_room_title ?></div>

      <?php if ( eb_room_branch( $eagle_booking_room_id ) ) : ?>
          <div><strong><?php echo esc_html__('Branch','eagle-booking') ?>:</strong> <?php echo eb_room_branch( $eagle_booking_room_id )  ?></div>
      <?php endif ?>

      <div><strong><?php echo esc_html__('Check In/Out','eagle-booking') ?>:</strong> <?php echo eagle_booking_displayd_date_format($eagle_booking_form_date_from) ?><?php eb_checkin_checkout_time('checkin') ?>  &nbsp; → &nbsp;  <?php echo eagle_booking_displayd_date_format($eagle_booking_form_date_to) ?><?php eb_checkin_checkout_time('checkout') ?></div>

      <div><strong><?php echo esc_html__('Guests','eagle-booking') ?>:</strong>
        <?php if ( eb_get_option('eb_adults_children') == true ) : ?>
          <?php echo $eagle_booking_form_adults . ' ' .esc_html__('Adults', 'eagle-booking'). ', ' . $eagle_booking_form_children . ' ' .esc_html__('Children', 'eagle-booking') ?>
        <?php else : ?>
          <?php echo $eagle_booking_form_guests ?>
        <?php endif ?>
      </div>

      <?php if ( eb_get_option('eb_booking_form_fields')['arrival'] == true && $eagle_booking_form_arrival != '') : ?>
          <div><strong><?php echo esc_html__('Arrival','eagle-booking') ?> :</strong> <?php echo $eagle_booking_form_arrival ?></div>
      <?php endif ?>

      <?php if (!empty($eagle_booking_form_services)) : ?>
        <div class="checkout-details-services"><strong><?php echo esc_html__('Additional Services','eagle-booking') ?>:</strong>
          <?php
          if ( !empty($eagle_booking_form_services) ) :
          $eagle_booking_services_array = explode(',', $eagle_booking_form_services );
          for ($eagle_booking_services_array_i = 0; $eagle_booking_services_array_i < count($eagle_booking_services_array)-1; $eagle_booking_services_array_i++) :

              $eagle_booking_service_id = $eagle_booking_services_array[$eagle_booking_services_array_i];
              $eagle_booking_service_name = get_the_title($eagle_booking_service_id);

              echo $eagle_booking_service_name;
              if (next($eagle_booking_services_array )) :
                  echo ', ';
              endif;

          endfor;
          endif;
          ?>
        </div>
      <?php endif ?>

      <?php if ( !empty($eagle_booking_form_requests) ) : ?>
        <div><strong><?php echo esc_html__('Requests','eagle-booking') ?>:</strong> <?php echo $eagle_booking_form_requests ?></div>
      <?php endif ?>

      <?php if ( eb_get_option('show_price') == true ) : ?>

        <div>
          <strong><?php echo esc_html__('Total Price','eagle-booking') ?>:</strong>
          <?php echo eb_price( $eagle_booking_form_final_price ) ?>
        </div>

      <?php endif  ?>

    <?php if ( eb_get_option('eagle_booking_deposit_amount') < 100 ) : ?>
      <div>
        <strong><?php echo esc_html__('Deposit Amount','eagle-booking') ?>:</strong>
        <?php if ( eb_currency_position() == 'before' ) : ?>
        <?php echo eb_currency()?><?php eb_formatted_price($eagle_booking_deposit_amount) ?>
        <?php else : ?>
        <?php eb_formatted_price($eagle_booking_deposit_amount) ?><?php echo eb_currency()?>
        <?php endif ?>
      </div>
    <?php endif ?>

  </div>

</div>
