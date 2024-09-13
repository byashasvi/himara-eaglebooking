/*================================================
* Plugin Name: Eagle Booking
* Version: 1.1.6
* Author Name: Jomin Muskaj (Eagle-Themes)
* Author URI: eagle-themes.com
=================================================*/

(function ($) {
  "use strict";

  /* Document is Raedy */
  $(document).ready(function () {

    // =============================================
    // DATERANGEPICKER
    // =============================================
    var eb_calendar_min_date = new Date();
    var eb_calendar_max_date = moment(eb_calendar_min_date).add(eb_js_settings.eb_calendar_availability_period, 'M').endOf('month');
    var eagle_booking_date_format = eb_js_settings.eagle_booking_date_format.toUpperCase();

    var eb_signle_room = false;

    // Check if calendar is on single room
    if ( $('form').hasClass('room-booking-form') ) {

      eb_signle_room = true;

    }

    $(".eb-datepicker").each(function () {

      var calendar = $(this);

      $(calendar).daterangepicker({
          autoUpdateInput: false,
          autoApply: true,
          alwaysShowCalendars: true,
          linkedCalendars: true,

          isInvalidDate: function(date) {

            if ( typeof eb_booked_dates!== 'undefined' && eb_booked_dates != '' ) {

              return !!(eb_booked_dates.indexOf(date.format('YYYY/MM/DD')) > 0);

            }

           },

          minDate: eb_calendar_min_date,
          maxDate: eb_calendar_max_date,
          locale: {
            format: eagle_booking_date_format,
            separator: " → ",
            "daysOfWeek": [
              eb_js_settings.eb_calendar_sunday,
              eb_js_settings.eb_calendar_monday,
              eb_js_settings.eb_calendar_tuesday,
              eb_js_settings.eb_calendar_wednesday,
              eb_js_settings.eb_calendar_thursday,
              eb_js_settings.eb_calendar_friday,
              eb_js_settings.eb_calendar_saturday,
            ],
            "monthNames": [
              eb_js_settings.eb_calendar_january,
              eb_js_settings.eb_calendar_february,
              eb_js_settings.eb_calendar_march,
              eb_js_settings.eb_calendar_april,
              eb_js_settings.eb_calendar_may,
              eb_js_settings.eb_calendar_june,
              eb_js_settings.eb_calendar_july,
              eb_js_settings.eb_calendar_august,
              eb_js_settings.eb_calendar_september,
              eb_js_settings.eb_calendar_october,
              eb_js_settings.eb_calendar_november,
              eb_js_settings.eb_calendar_december,
            ],
            "firstDay": 1
          }
        }),

        $(calendar).on("apply.daterangepicker", function () {

          // Displayd Format
          var checkin = $(calendar).data('daterangepicker').startDate.format(eagle_booking_date_format);
          var checkout = $(calendar).data('daterangepicker').endDate.format(eagle_booking_date_format);

          // Display Date
          $(this).val(checkin + " " + " " + " → " + " " + " " + checkout);

          // Add value to hidden inouts
          $('.eb_checkin').val(checkin);
          $('.eb_checkout').val(checkout);

          // Update Booking Filters only for the search page (filters)
          if ($("div").hasClass("search-filters")) {
            eb_search_filters();
          }

          if ($("div").hasClass("search-filters") || $("div").hasClass("calendar")) {
            eb_get_nights(calendar);
          }

          // Disable all booked & blocked room on the signle room calendar
          if ( eb_signle_room == true ) {

            var i, eb_booked_date;

            // Loop all booked dates until the condition
            for( i = 0; i < eb_booked_dates.length; i++ ) {

              eb_booked_date = moment(eb_booked_dates[i]).format('YYYY/MM/DD');

              var checkin_new = $(calendar).data('daterangepicker').startDate.format('YYYY-MM-DD');
              var checkout_new = $(calendar).data('daterangepicker').endDate.format('YYYY-MM-DD');

              if ( moment(eb_booked_date).isBetween(checkin_new, checkout_new) ) {

                $(this).data('daterangepicker').setStartDate(checkout);
                $(this).val("").focus();

                // Break loop on the first match
                break;

              }

            }

          }

        })

    })


    // =============================================
    // CALCULATE NIGHTS NUMBER
    // =============================================
    function eb_get_nights( calendar ) {

      var eagle_booking_checkin = $(calendar).parent().find('.eb_checkin').val();
      var eagle_booking_checkout = $(calendar).parent().find('.eb_checkout').val();

      var eagle_booking_start_date = moment(eagle_booking_checkin, eb_js_settings.eagle_booking_date_format.toUpperCase()).format('YYYY-MM-DD');;
      var eagle_booking_end_date = moment(eagle_booking_checkout, eb_js_settings.eagle_booking_date_format.toUpperCase()).format('YYYY-MM-DD');;

      var booking_nights = (new Date(eagle_booking_end_date)) - (new Date(eagle_booking_start_date));
      var eagle_booking_nights_number = booking_nights / (1000 * 60 * 60 * 24);
      if (eagle_booking_nights_number < 0) {
        var eagle_booking_nights_number = '0';
      }

      return eagle_booking_nights_number;

    }

    // =============================================
    // GUESTS SELECT
    // =============================================
    $('.eb-guestspicker .guestspicker').on('click', function (event) {
      $('.eb-guestspicker').toggleClass('active');
      event.preventDefault();
    });
    $(window).click(function () {
      $('.eb-guestspicker').removeClass('active');
    });
    $('.eb-guestspicker').on('click', function (event) {
      event.stopPropagation();
    });

    function guestsSum() {
      var arr = $('.booking-guests');
      var guests = 0;
      for (var i = 0; i < arr.length; i++) {
        if (parseInt(arr[i].value, 10))
          guests += parseInt(arr[i].value, 10);
      }
      if (guests > 0) {
        var cardQty = document.querySelector(".gueststotal");
        cardQty.innerHTML = guests;
      }

      // Add the new value to geust input
      $("#eagle_booking_guests").val(guests);

    }

    guestsSum();

    $(function () {
      $(".plus, .minus").on("click", function () {
        var button = $(this);
        var oldValue = button.parent().find("input").val();
        var min_value = button.parent().find("input").attr("min");

        if (button.hasClass('plus')) {
          var newVal = parseFloat(oldValue) + 1;
        } else {

          if (oldValue > min_value) {
            var newVal = parseFloat(oldValue) - 1;
          } else {
            newVal = min_value;
          }

        }

        button.parent().find("input").val(newVal);

        guestsSum();

        if ($('form').hasClass('booking-search-form')) {
          eagle_booking_filters();
        }

      });

    });

    /*----------------------------------------------------*/
    /* Bookings Filters
    /*----------------------------------------------------*/
      // bind change event to select
      $('.eb_bookings_filter').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;

      });

    /*----------------------------------------------------*/
    /* Bookings Calendar AJAX
    /*----------------------------------------------------*/
    function eb_calendar_room_availability() {

      // handler to the ajax request
      var eb_ajax_calendar_room_availability_xhr = null;

      $('.eb-room-booked').on('mouseenter', function(event) {

        // Remove any previous active
        $('.eb-room-booked').removeClass("open");

        var popover = $('#eb-room-availability-popup');
        var eb_loader = '<div id="eb-loader"></div>';

        popover.append(eb_loader);

        $('#eb-calendar-title').hide();
        $('#eb-calendar-title-loading').show();

        // Empty any previous results
        $("#eb-room-availability-popup #content").empty();
        $("#eb-calendar-date").empty();
        $("#eb-calendar-room-title").empty();

        // Popover Position
        var pos = $(this).position();
        var date_width = $(this).outerWidth();
        var calendar_width = $('.eb-calendar-view').outerWidth();
        var popover_width = $('#eb-room-availability-popup').outerWidth();

        // Display popover in the left side
        if ( (calendar_width - pos.left) < popover_width + 50  ) {

          var popover_pos = pos.left - popover_width;
          popover.removeClass('right');
          popover.addClass('left');

        // Display popover in the right side
        } else {

          var popover_pos = pos.left + date_width;
          popover.removeClass('left');
          popover.addClass('right');

        }

        popover.css({
          position: "absolute",
          top: pos.top + "px",
          left: (popover_pos) + "px",

         }).show();


        var eb_date = $(this).data("date");
        var eb_displayed_date = $(this).data("displayed-date");
        var eb_room_id = $(this).data("room-id");
        var eb_room_title = $(this).data("room-title");

          // if there is a previous ajax request, then abort it
          if( eb_ajax_calendar_room_availability_xhr != null ) {
            eb_ajax_calendar_room_availability_xhr.abort();
            eb_ajax_calendar_room_availability_xhr = null;
          }

          // Start the AJAX request
          eb_ajax_calendar_room_availability_xhr = $.ajax({

            url: eb_admin_ajax.eb_admin_calendar_ajax,
            method: 'GET',
            dataType: 'json',
            data: {
              action: 'eb_admin_calendar_action',
              eb_date: eb_date,
              eb_room_id: eb_room_id,
              eb_calendar_nonce: eb_admin_ajax.eb_admin_ajax_nonce,
            },

            // Success
            success: function (eb_calendar_room_availability_data) {

              // Appened new results
              $("#eb-room-availability-popup #content").append(eb_calendar_room_availability_data.output);

              $("#eb-room-availability-popup #content #bookings").append(eb_calendar_room_availability_data.bookings);

              $('#eb-calendar-title-loading').hide();
              $('#eb-calendar-title').show();
              $('#eb-calendar-date').text(eb_displayed_date);
              $('#eb-calendar-room-title').text(eb_room_title);

            },

            error: function (eb_ajax_calendar_room_availability_xhr, textStatus, errorThrown) {
              // Console mssg - debug purpose
              console.log(errorThrown);

            },

            complete: function () {

              // Remove loader
              $('#eb-loader').remove();

            },

          });

      });

    /*----------------------------------------------------*/
    /* Booking Calendar POPOVER
    /*----------------------------------------------------*/
    $('.eb-room-booked').on('click', function(event) {

      $(this).addClass("open").siblings().removeClass("open");

    });

    $('.eb-room-booked').on('mouseleave', function(event) {

      if ( !$(this).hasClass('open') ) {

        $('#eb-room-availability-popup').hide();

      }

    });

    $('body').on('click', function(event) {

      if ( !$(event.target).closest('.eb-room-booked, #eb-room-availability-popup').length ) {

        $('#eb-room-availability-popup').hide();

      }

    });

  }

  eb_calendar_room_availability();

    /*----------------------------------------------------*/
    /* Media Upload
    /*----------------------------------------------------*/
    function media_upload(button_class) {

      $('body').on('click', button_class, function (e) {

        var upload_file_box = $(this);

        // If the media frame already exists, reopen it.
        if (frame) {
            frame.open();
            return;
        }

        // Create a new media frame
        var frame = wp.media({
            library: {
                type: 'image'
            },
            multiple: false
        });

        frame.on('select', function () {

            // Get media attachment details from the frame state
            var attachment = frame.state().get('selection').first().toJSON();

            upload_file_box.parent().find('.eb-upload-file-url').val(attachment.url);
            upload_file_box.find('.eb-upload-file-remove').css('display', 'block');
            upload_file_box.find('.eb-upload-file-text').css('display', 'none');
            upload_file_box.find('.eb-upload-file-preview').attr('src', attachment.url).css('display', 'block');

        });

        frame.open();
        return false;
    });

  }

  media_upload('.eb-upload-file');

  // Remove File
  $('body').on('click', ".eb-upload-file-remove", function (e) {

    var upload_file_remove = $(this);
    upload_file_remove.css('display', 'none');
    upload_file_remove.parent().find('.eb-upload-file-text').css('display', 'block');
    upload_file_remove.parent().find('.eb-upload-file-url').val("");
    upload_file_remove.parent().find('.eb-upload-file-preview').attr('src', "").css('display', 'none');

    preventDefault(e);

  });


  // Clear the form after the submit
  $('#submit').click(function () {


    var upload_file_submit_button = $(this);

    // Look for a div WordPress produces for an invalid form element
    if ( !$('#addtag .form-invalid').length ) {

        upload_file_submit_button.parent().parent().find('.eb-upload-file-preview').attr('src', "").css('display', 'none');

    }

  });


});


})(jQuery);
