<?php
/**
 * The Template for displaying room availability
 *
 * This template can be overridden by copying it to yourtheme/eb-templates/single-room/availability.php.
 *
 * Author: Eagle Themes
 * Package: Eagle-Booking/Templates
 * Version: 1.1.5
 */

defined('ABSPATH') || exit;
?>

<?php   $eb_end_period = "+".eb_get_option('eb_calendar_availability_period'). " months" ?>
    
    
    <div id="bookingLotuSepMain">
        <div id="bookingLotuSep">
            <div class="elementor-widget-container">
    					<img loading="lazy" decoding="async" width="75" height="103" src="https://alipurapalace.com/wp-content/uploads/2024/05/LotusLeft-3.png" class="attachment-large size-large wp-image-4881" alt="" srcset="https://alipurapalace.com/wp-content/uploads/2024/05/LotusLeft-3.png 75w, https://alipurapalace.com/wp-content/uploads/2024/05/LotusLeft-3-58x80.png 58w" sizes="(max-width: 75px) 100vw, 75px">									
    		</div>
    		<div class="elementor-element elementor-element-103d834 e-flex e-con-boxed e-con e-child" data-id="103d834" data-element_type="container" id="seperatorBooking">
    					<div class="e-con-inner">
    					</div>
    		</div>			
            <div class="elementor-widget-container">
    			<img loading="lazy" decoding="async" width="77" height="103" src="https://alipurapalace.com/wp-content/uploads/2024/05/LotusRight-2.png" class="attachment-large size-large wp-image-4882" alt="" srcset="https://alipurapalace.com/wp-content/uploads/2024/05/LotusRight-2.png 77w, https://alipurapalace.com/wp-content/uploads/2024/05/LotusRight-2-60x80.png 60w" sizes="(max-width: 77px) 100vw, 77px">							
    		</div>	
        </div>
    </div>


  <div id="availDateSection">
      
      <h2 class="section-title"><?php echo esc_html__('Room Availability', 'eagle-booking') ?></h2>
      <div id="availability-calendar"></div>
    
      <ul class="availability-calendar-list-availability">
        <li>
          <span class="available"></span>
          <?php echo __('Available', 'eagle-booking') ?>
        </li>
        <li>
          <span class="not-available"></span>
          <?php echo __('Not Available', 'eagle-booking') ?>
        </li>
        <!-- <li>
          <span class="semi-available"></span>
          <?php echo __('Check Out Only', 'eagle-booking') ?>
        </li> -->
      </ul>
    
      <script>
        (function($) {
          "use strict";
          $(document).ready(function() {
    
            $("#availability-calendar").simpleCalendar({
              events: eb_booked_dates
            });
        });
        })(jQuery);
      </script>
  
      
  </div>
  