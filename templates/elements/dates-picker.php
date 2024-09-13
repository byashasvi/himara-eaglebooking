<?php
   /**
    * The Template for the dates picker
    *
    * This template can be overridden by copying it to yourtheme/eb-templates/elements/dates-picker.php.
    *
    * Author: Eagle Themes
    * Package: Eagle-Booking/Templates
    * Version: 1.1.5
    */

   defined('ABSPATH') || exit;

?>
<div class="eb-field-group">
   <label><?php echo __('Check In/Out','eagle-booking') ?></label>
   <input type="text" class="eb-datepicker eb-field" placeholder="<?php echo esc_html__('Check In', 'eagle-booking') ?> &nbsp;&nbsp;→&nbsp;&nbsp; <?php echo esc_html__('Check Out', 'eagle-booking') ?>" value="<?php echo $eagle_booking_dates ?>" autocomplete="off" readonly>
   <input type="hidden" class="eb_checkin"  name="<?php echo $eagle_booking_checkin_param ?>">
   <input type="hidden" class="eb_checkout"  name="<?php echo $eagle_booking_checkout_param ?>">
</div>

<?php $eb_end_period = "+".eb_get_option('eb_calendar_availability_period'). " months" ?>
