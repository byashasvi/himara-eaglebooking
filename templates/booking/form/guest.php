<?php
   /**
    * The Template for the guest form
    *
    * This template can be overridden by copying it to yourtheme/eb-templates/booking/form/coupon.php.
    *
    * Author: Eagle Themes
    * Package: Eagle-Booking/Templates
    * Version: 1.0
    */

   defined('ABSPATH') || exit;
?>

<div class="eb-tab-content guest" data-tab="guest">
    <div class="eb-g-lg-2 eb-g-md-1">

        <div class="eb-form-col">
            <input type="text" id="eb_guest_first_name" class="eb-field">
            <label><?php echo __('First Name','eagle-booking') ?></label>
        </div>

        <div class="eb-form-col">
            <input type="text" id="eb_guest_last_name" class="eb-field">
            <label><?php echo __('Last Name','eagle-booking') ?></label>
        </div>

        <div class="eb-form-col">
            <input type="email" id="eb_guest_email" class="eb-field">
            <label><?php echo __('Email','eagle-booking') ?></label>
        </div>


        <input type="tel" id="eb_guest_phone" class="eb_user_phone_field eb-field" placeholder="<?php echo __('Phone','eagle-booking') ?> *">

        <?php if ( eb_get_option('eb_booking_form_fields')['address'] == true ) : ?>
            <div class="eb-form-col">
                <input type="text" id="eb_guest_address" class="eb-field">
                <label><?php echo __('Address','eagle-booking') ?></label>
            </div>
        <?php endif ?>

        <?php if ( eb_get_option('eb_booking_form_fields')['city'] == true ) : ?>
            <div class="eb-form-col">
                <input type="text" id="eb_guest_city" class="eb-field">
                <label><?php echo __('City','eagle-booking') ?></label>
            </div>
        <?php endif ?>

        <?php if ( eb_get_option('eb_booking_form_fields')['country'] == true ) : ?>
            <div class="eb-form-col">
                <input type="text" id="eb_guest_country" class="eb-field">
                <label><?php echo __('Country','eagle-booking') ?></label>
            </div>
        <?php endif ?>

        <?php if ( eb_get_option('eb_booking_form_fields')['zip'] == true ) : ?>
            <div class="eb-form-col">
                <input type="text" id="eb_guest_zip" class="eb-field">
                <label><?php echo __('ZIP','eagle-booking') ?></label>
            </div>
        <?php endif ?>
    </div>
</div>
