/*================================================
* Plugin Name: Eagle Booking
* Version: 1.3.3.6
* Author: Eagle Themes (Jomin Muskaj)
* Author URI: eagle-booking.com
=================================================*/

  /**
  * Functions that can be called by external files
  * Use jQuery instead of $
  */

  /**
  * Button Animation
  * Version: 1.0
  * Can be called externally
  */
  function eb_button_loading( btn_id, btn_action = '' ) {

    var btn =  jQuery( btn_id );

    if ( btn_action === 'hide' ) {

      btn.find('.eb-btn-loader').remove();
      btn.find('.eb-btn-text').show();
      btn.css('pointer-events','');
      btn.blur();

    } else {

      var eb_loader_dom = '<span class="eb-btn-loader"><span class="eb-spinner spinner1"></span><span class="eb-spinner spinner2"></span><span class="eb-spinner spinner3"></span><span class="eb-spinner spinner4"></span><span class="eb-spinner spinner5"></span></span>';

      btn.append( eb_loader_dom );
      btn.find('.eb-btn-text').hide();
      btn.find('i').hide();
      btn.css('pointer-events','none');

    }

    // Firefox fix: on "Go Back"
    jQuery(window).unload(function () { jQuery(window).unbind('unload'); });

  }

  /**
  * Fixed sidebar
  * Version: 1.0.1
  * Can be called externally
  */
  var adminbar = jQuery('#wpadminbar');
  var header = jQuery('header');
  var stickysidebar = jQuery('.sticky-sidebar');

  if (adminbar.length && adminbar.is(':visible')) {
    var adminsidebarfixed = adminbar.height();
  } else {
    var adminsidebarfixed = 0;
  }

  if (header.hasClass("fixed")) {
    var headersidebarfixed = header.height();
  } else {
    var headersidebarfixed = 10;
  }

  var sidebarfixed = adminsidebarfixed + headersidebarfixed;

  if (stickysidebar.length) {

    var sidebar = new StickySidebar('.sticky-sidebar', {
      topSpacing: sidebarfixed + 20,
      bottomSpacing: 0,
      containerSelector: '.eb-sticky-sidebar-container',
      minWidth: 991
    });

  }

  // Re-initialize fixed sidebar
  function eb_update_fixed_sidebar() {

      if ( stickysidebar.length ) {

        sidebar.updateSticky();

      }

  }


(function ($) {

  "use strict";

  /* Document is Raedy */
  $(document).ready(function () {

    // =============================================
    // PAYMENT TABS
    // =============================================
    var checkout_tabs = $(".checkout-payment-tabs");
    if (checkout_tabs.length) {
      checkout_tabs.tabs();
    }

    // =============================================
    // ROOM SERVICES ON HOVER
    // =============================================
    $(".room-item .room-image").on({
      mouseenter: function () {
        $(this).parent().find('.room-services').addClass('active');
      },
    });

    $(".room-item").on({
      mouseleave: function () {
        $(this).parent().find('.room-services').removeClass('active');
      }
    });


    // =============================================
    // Magnific Popup - Room Details Page Slider
    // =============================================
    $('.eb-image-gallery').magnificPopup({
      delegate: '.swiper-slide:not(.swiper-slide-duplicate) a',
      type: 'image',
      fixedContentPos: true,
      gallery: {
        enabled: true,
        preload: [0,1],
        navigateByImgClick: true,
        tPrev: eb_js_settings.eb_magnific_previous,
        tNext: eb_js_settings.eb_magnific_next,
        tCounter: '%curr%' + ' ' + eb_js_settings.eb_magnific_counter + ' ' + '%total%'

      },
      removalDelay: 300,
      mainClass: 'mfp-fade',
      retina: {
        ratio: 1,
        replaceSrc: function(item, ratio) {
          return item.src.replace(/\.\w+$/, function(m) {
            return '@2x' + m;
          });
        }
      },

      tClose: eb_js_settings.eb_magnific_close,
      tLoading: eb_js_settings.eb_magnific_loading,

    });

    // =============================================
    // Room Details Page Slider
    // =============================================
    var eb_room_slider_autplay = eb_js_settings.eb_room_slider_autoplay;
    var eb_room_slider_loop = eb_js_settings.eb_room_slider_loop;

    if ( eb_room_slider_autplay == 1 ) {
      eb_room_slider_autplay = true;
    } else {
      eb_room_slider_autplay = false;
    }

    if ( eb_room_slider_loop == 1 ) {
      eb_room_slider_loop = true;
    } else {
      eb_room_slider_loop = false;
    }

    if ( $('#eb-room-slider-thumbs').length ) {

      var thumbsSlider = new Swiper('#eb-room-slider-thumbs', {
        spaceBetween: 15,
        slidesPerView: 6,
        loop: eb_room_slider_loop,
        freeMode: false,
        loopedSlides: 5,
        breakpoints: {
          360: {
            slidesPerView: 3,
            spaceBetween: 10
          },

          480: {
            slidesPerView: 4,
            spaceBetween: 10
          },

          640: {
            slidesPerView: 5,
            spaceBetween: 10
          }
        },
        watchSlidesVisibility: false,
        watchSlidesProgress: false
      });

    }

    if ( $('#eb-room-slider').length ) {

      var mainSlider = new Swiper('#eb-room-slider', {
        spaceBetween: 15,
        loop: true,
        preloadImages: false,
        loopedSlides: 5,
        navigation: {
          nextEl: '.swiper-next',
          prevEl: '.swiper-prev',
        },
        thumbs: {
          swiper: thumbsSlider,
        },

        autoplay: eb_room_slider_autplay,

      });

    }

    // Check if exist first
    if ( $('#eb-room-full-slider').length ) {

      $('.eb-room-page').addClass('full-slider-is-used');

      var fullslider = new Swiper('#eb-room-full-slider', {
        spaceBetween: 20,
        grabCursor: true,
        slidesPerView: 4,
        centeredSlides: true,
        loop: true,
        preloadImages: false,
        loopedSlides: 5,
        breakpoints: {
          360: {
            slidesPerView: 1,
            spaceBetween: 10
          },

          480: {
            slidesPerView: 1,
            spaceBetween: 10
          },

          992: {
            slidesPerView: 2,
            spaceBetween: 10
          }
        },
        navigation: {
          nextEl: '.swiper-next',
          prevEl: '.swiper-prev',
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },

        autoplay: eb_room_slider_autplay,

        on: {
          init: function () {

            // // Update sticky sidebar
            // if (stickysidebar.length) {
            //   sidebar.updateSticky();
            // }

            eb_update_fixed_sidebar();

          }
        },


      });
    }

    // ============================================================================================
    // VALIDATE HOMEPAGE & ROMM PAGE FORM / CHANGE THE OUTPUT FORMAT BASED ON THE BOOKING SYSTEM
    // ============================================================================================
    $("#room-booking-form, #search-form").on('submit', function (e) {

      var calendar = $(this).find(".eb-datepicker");

      if ( calendar.val() === '') {

        e.preventDefault();
        calendar.click();

      } else {

        var button = $(this).find('#eb_search_form');

        eb_button_loading(button);

        var eb_booking_type = eb_js_settings.eb_booking_type;
        var eb_custom_date_format = eb_js_settings.eb_custom_date_format;
        var eb_date_format = eb_js_settings.eagle_booking_date_format.toUpperCase();
        var eb_output_checkin = $(this).find('.eb_checkin').val();
        var eb_output_checkout = $(this).find('.eb_checkout').val();

        if (eb_booking_type === 'builtin') {

          // Single Room
          if ( $('form').hasClass('room-booking-form') ) {

            var eb_output_format = 'MM/DD/YYYY';

          // Search Form
          } else {

            var eb_output_format = 'MM-DD-YYYY';

          }

        } else if (eb_booking_type === 'booking') {

          var eb_output_format = 'YYYY-MM-DD';

        } else if (eb_booking_type === 'airbnb') {

          var eb_output_format = 'YYYY-MM-DD';

        } else if (eb_booking_type === 'tripadvisor') {

          var eb_output_format = 'MM-DD-YYYY';

        } else if (eb_booking_type === 'custom') {

          var eb_output_format = eb_custom_date_format;

        }

        var eb_output_checkin_formated = moment(eb_output_checkin, eb_date_format).format(eb_output_format);
        var eb_output_checkout_formated = moment(eb_output_checkout, eb_date_format).format(eb_output_format);

        $(this).find('.eb_checkin').val(eb_output_checkin_formated);
        $(this).find('.eb_checkout').val(eb_output_checkout_formated);

      }

    })

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

      var calendar = $(this),
          search_form = calendar.parent().parent().parent().parent().parent().parent().find('.eb-search-form'),
          position =  calendar.offset(),
          bottom_space = window.innerHeight - position.top,
          screen_width = $(window).width();


      if ( bottom_space > 500 || screen_width < 767 || $('.eb-search-form').hasClass('drops-down')  ) {

        var drops = 'down';

        $(this).parent().parent().find('.eb-guestspicker-content, .eb-select-list').addClass('dropdown');

      } else {

        var drops = 'up';

        $(this).parent().parent().find('.eb-guestspicker-content, .eb-select-list').addClass('up');

      }

      // For slideup form
      if ( search_form.hasClass('eb-slide-search-form') ) var drops = 'up';

      // If sidebar (eb-left-sidebar) open calendar left else open right
      if ( $('.eb-sidebar').hasClass('eb-right-sidebar') ) {

        var opens = 'left';

      } else {

        var opens = 'right';
      }

      $(calendar).daterangepicker({

          autoUpdateInput: false,
          autoApply: true,
          opens: opens,
          alwaysShowCalendars: true,
          linkedCalendars: true,
          drops: drops,

          isInvalidDate: function(date) {

            if ( typeof eb_booked_dates !== 'undefined' && eb_booked_dates != '' ) {


              for( var i = 0; i <= eb_booked_dates.length; i++ ){

                if (date.format('YYYY/MM/DD') == eb_booked_dates[i]){

                  return true;

                }

              }

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

        }),

        // Live Booking Nights
        $(calendar).on("show.daterangepicker", function () {

          var live_checkin = $(this).next('.eb_checkin').val();
          var live_checkout = $(this).next('.eb_checkout').val();

          if ( live_checkin != '' && typeof live_checkin !== 'undefined' && live_checkout != '' && typeof live_checkout !== 'undefined'  ) {
            var eagle_booking_nights_div = $('<div class="booking-nights">' + live_checkin + '&nbsp;' + ' → ' + '&nbsp' + live_checkout + ' (' + eb_get_nights(calendar) + ' ' + eb_js_settings.eb_booking_nights + ')</div>');
            $(".booking-nights").remove();
            $(".daterangepicker").append(eagle_booking_nights_div);
          }

          $(document).on('mouseenter', '.start-date', function () {
            live_checkin = $(this).attr('data-date');
            live_checkin = moment(live_checkin, 'MM/DD/YYYY').format(eb_js_settings.eagle_booking_date_format.toUpperCase());
            $('.eb_checkin').val(live_checkin)
          })

          $(document).on('mouseenter', '.in-range', function () {
            live_checkout = $(this).attr('data-date');
            live_checkout = moment(live_checkout, 'MM/DD/YYYY').format(eb_js_settings.eagle_booking_date_format.toUpperCase());
            $('.eb_checkout').val(live_checkout)
          })

          $(document).on('mouseenter', '.start-date, .in-range', function () {

            live_checkout = $(this).attr('data-date');
            live_checkout = moment(live_checkout, 'MM/DD/YYYY').format(eb_js_settings.eagle_booking_date_format.toUpperCase());

            var eagle_booking_nights_div = $('<div class="booking-nights">' + live_checkin + '&nbsp;' + ' → ' + '&nbsp' + live_checkout + ' (' + eb_get_nights(calendar) + ' ' + eb_js_settings.eb_booking_nights + ')</div>');
            $(".booking-nights").remove();
            $(".daterangepicker").append(eagle_booking_nights_div);
          })

        });

    })

    // Close Full Screen Calendar
    var calendar_close = $('<span class="eb-close-calendar"><i class="icon-close"></i></span>');

    $('.daterangepicker').prepend(calendar_close);

    $( '.eb-close-calendar' ).on('click', function (event) {

      $(this).closest('.daterangepicker').find('.cancelBtn').click();

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
    // Guests Picker
    // =============================================
    $('.eb-guestspicker').on('click', function (event) {

      $(this).addClass('active');

      $(this).find('.eb-select-list').removeClass('active');

      event.preventDefault();

      // Close brach selector
      $('.eb-select-list').removeClass('active');

    });

    // Close Guest Picker
    $(window).click(function () {
      $('.eb-guestspicker').removeClass('active');
    });

    $('.eb-guestspicker').on('click', function (event) {
      event.stopPropagation();
    });

    function guestsSum( current ) {

      var arr = $(current).closest('.eb-guestspicker').find('.booking-guests');

      var guests = 0;

      for (var i = 0; i < arr.length; i++) {
        if (parseInt(arr[i].value, 10))
          guests += parseInt(arr[i].value, 10);
      }

      if ( guests > 0 ) {

         $(current).closest('.eb-guestspicker').find('.gueststotal').text(guests);

      }

    }

    function guestsPicker() {

      $(".eb-guestspicker .plus, .eb-guestspicker .minus").on("click", function (event) {

        // Get the max value from data-max
        var oldValue = $(this).parent().find("input").val();

        var max_value = parseFloat($(this).parent().find("input").data('max'));
        var min_value = parseFloat($(this).parent().find("input").data('min'));

        if ( $(this).hasClass('plus') && max_value > 0 ) {

          if (oldValue < max_value) {

            var newVal = parseFloat(oldValue) + 1;

          } else {

            newVal = oldValue;

          }

        } else {

          if (oldValue > min_value) {
            var newVal = parseFloat(oldValue) - 1;
          } else {
            newVal = min_value;
          }

        }

        $(this).parent().find("input").val(newVal);

        // Get guests sum
        guestsSum( $(this) );

        // Search Page
        if ( $('form').hasClass('booking-search-form') ) {

          // Refresh filters
          eb_search_filters();
        }

      });

    }

    // Execute
    guestsPicker();

    // =============================================
    // Styled Radio Box
    // =============================================
    $('.eb-radio-box').on('click', function() {

      // Remove any previous selected option & reset the previous checked radiobox
      $('.eb-radio-box').removeClass('selected');
      $('.eb-radio-box').find('input').prop('checked', false);

      // Add selected class to this & check it
      $(this).addClass('selected');
      $(this).find('input').prop('checked', true);

    });

    // =============================================
    // Branches Selector
    // =============================================
    $('.eb-select').on('click', function (event) {

      $(this).find('.eb-select-list').toggleClass('active');
      $('.eb-search-form').find('.eb-field').removeClass('active');

      event.stopPropagation();

    });

    $(window).click(function () {
        $('.eb-select-list').removeClass('active');
    });

    $('.eb-select-list li').on('click', function (event) {

        // Remove any previous
        $('.eb-select-list li').removeClass('selected');
        $(this).toggleClass('selected');

        var selected_branch = $('.eb-select-list li.selected').text();
        var selected_branch_id = $('.eb-select-list li.selected').data('branch-id');

        $(this).parent().parent().find('#branch_text').text(selected_branch);
        $(this).parent().parent().find('#eb_branch').val( selected_branch_id );

    });

    // =============================================
    // EB Dropdown
    // =============================================
    $('.eb-dropdown-toggle').on('click', function(event) {
      event.stopPropagation();
      $(this).next('.eb-dropdown-menu').toggleClass('open');
    });

    $(window).click(function() {
      $('.eb-dropdown-menu').removeClass('open');
    });

    // =============================================
    // Button Loading Effect on search page
    // =============================================
    $('body').on('click', '.eb-proceed-btn', function(event) {
      eb_button_loading(this);
    });

    // EB Forms
    /* Add 'active' class on keydown
    ------------------------------------- */
    function checkForInput(element) {

      var label = $(element).siblings('label');
      if ( $(element).val().length > 0  ) {

        label.addClass('input-has-value');

      } else {

        label.removeClass('input-has-value');

      }

    }

    // The lines below are executed on page load
    $('.eb-form-col input, #eb_guest_phone').each(function() {
      checkForInput(this);
    });

    $('.eb-form-col input, #eb_guest_phone').on('change keydown focus', function() {
      checkForInput(this);
    });

    // =============================================
    // Room Breakpoint
    // =============================================
    $(document).on('click', '.toggle-room-breakpoint', function () {

      $(this).closest('.room-list-item').addClass('open');
      $(this).closest('.room-list-item').find('.room-quick-details').toggleClass('open');

      $(this).closest('.room-list-item').find('.room-quick-details').toggleClass(function(){
          return $(this).is('.slideup, .slidedown') ? 'slideup slidedown' : 'slideup';
        })

      $(this).toggleClass('open');
      $(this).find('i').toggleClass('fa-angle-down fa-angle-up');
    });

    // =============================================
    // SlideUp Search Form
    // =============================================
    if ( eb_js_settings.eb_slide_up_search_form == true ) {

      $('.eb-slide-search-form').find('.eb-guestspicker-content').addClass('up');

      var amountScrolled = 1200;
      var slide_form_btn = $('.eb-popup-search-form-btn');
      var slide_form = $('.eb-slide-search-form');
      var slide_form_text = slide_form_btn.find('.btn-text');

      $(window).on('scroll', function() {

        var scroll = $(window).scrollTop() + $(window).height();
        var anchorPoint = $("footer").offset().top;

        if ( $(window).scrollTop() > amountScrolled && scroll < anchorPoint ) {

          // If open on scroll, or on mobile (< 768 px ), is enabled then show the close button/icon
          if ( eb_js_settings.eb_slide_up_search_form_style === 'onscroll' ) {

            // Show the form after amountscrolled
            slide_form.addClass('open');

          // If open on click is enabled then don't show the form and show the open button/icon
          } else {

            slide_form_btn.addClass('active');
            // show the open button
            slide_form_text.css('display','block');
          }

        } else {

          slide_form_btn.removeClass('active');

          slide_form.removeClass('open');

          // on form slide down reset btn
          slide_form_btn.find('i').toggleClass('icon-close icon-calendar');

          slide_form_text.css('display','none');

        }

      });

      $('.eb-popup-search-form-btn').on('click', '', function () {

        $(this).toggleClass('open');
        var btn = $(this).find('i');

        btn.toggleClass('icon-calendar icon-close');

        $('.eb-slide-search-form').toggleClass('open');

      });

    } else {

      // console.log('the slide up search form is not enabled');

    }

  });

  // =============================================
  // Rooms
  // =============================================
  function eb_room_info() {

    $(".room-item").each(function () {

      var room_width = $(this).width();

      if ( room_width < 350 ) {

        $(this).addClass('small-item');

      } else {

        $(this).removeClass('small-item');

      }

    })

  }

  eb_room_info();

  $(window).resize(function() {

    eb_room_info();

  })

  // =============================================
  // Availability Calendar
  // =============================================
  var pluginName = "simpleCalendar",
    defaults = {
      days: [
        eb_js_settings.eb_calendar_sunday,
        eb_js_settings.eb_calendar_monday,
        eb_js_settings.eb_calendar_tuesday,
        eb_js_settings.eb_calendar_wednesday,
        eb_js_settings.eb_calendar_thursday,
        eb_js_settings.eb_calendar_friday,
        eb_js_settings.eb_calendar_saturday,
      ],
      months: [
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
      minDate: "YYYY/MM/DD",
      maxDate: "YYYY/MM/DD",
      insertEvent: true,
      displayEvent: true,
      fixedStartDay: true,
      events: [],
      insertCallback: function () {}
    };

  // The actual plugin constructor
  function Plugin(element, options) {
    this.element = element;
    this.settings = $.extend({}, defaults, options);
    this._defaults = defaults;
    this._name = pluginName;
    this.currentDate = new Date();
    this.events = options.events;
    this.init();
  }

  // Avoid Plugin.prototype conflicts
  $.extend(Plugin.prototype, {
    init: function () {
      var container = $(this.element);
      var todayDate = this.currentDate;
      var events = this.events;
      var calendar = $('<div class="availability-calendar"></div>');
      var header = $('<div class="availability-calendar-header">' +
        '<span class="btn-prev"><i class="fa fa-chevron-left" aria-hidden="true"></i></span>' +
        '<span class="month"></span>' +
        '<span class="btn-next"><i class="fa fa-chevron-right" aria-hidden="true"></i></span>' +
        '</div class="availability-calendar-header">');

      this.updateHeader(todayDate, header);
      calendar.append(header);
      this.buildCalendar(todayDate, calendar);
      container.append(calendar);
      this.bindEvents();
    },

    // Update the current month & year header
    updateHeader: function (date, header) {
      header.find('.month').html(this.settings.months[date.getMonth()] + ' ' + date.getFullYear());
    },

    //Build calendar of a month from date
    buildCalendar: function (fromDate, calendar) {
      var plugin = this;

      calendar.find('table').remove();

      var body = $('<table class="calendar"></table>');
      var thead = $('<thead></thead>');
      var tbody = $('<tbody></tbody>');

      //Header day in a week ( (1 to 8) % 7 to start the week by monday)
      for (var i = 1; i <= this.settings.days.length; i++) {
        thead.append($('<td class="day-name">' + this.settings.days[i % 7].substring(0, 3) + '</td>'));
      }

      //setting current year and month
      var y = fromDate.getFullYear(),
        m = fromDate.getMonth();

      //first day of the month
      var firstDay = new Date(y, m, 1);
      //If not monday set to previous monday
      while (firstDay.getDay() != 1) {
        firstDay.setDate(firstDay.getDate() - 1);
      }
      //last day of the month
      var lastDay = new Date(y, m + 1, 0);
      //If not sunday set to next sunday
      while (lastDay.getDay() != 0) {
        lastDay.setDate(lastDay.getDate() + 1);
      }

      for (var day = firstDay; day <= lastDay; day.setDate(day.getDate())) {
        var tr = $('<tr></tr>');
        //For each row
        for (var i = 0; i < 7; i++) {

            // var td = $('<td><span class="day">' + day.getDate() + '<span class="room-price">12$</span>' + '</span></td>');
            var td = $('<td><span class="day"><span class="number">' + day.getDate() + '</span></span></td>');
          //if today is this day

          var ymd = day.getFullYear() + '-' + day.getMonth() + '-' + day.getDay();
          var ymd = this.formatToYYYYMMDD(day);
          //  console.log(ymd);

          if ($.inArray(this.formatToYYYYMMDD(day), plugin.events) !== -1) {

            //  console.log('found');
            td.find(".day").addClass("event");

          }

          // if ( $.inArray( this.formatToYYYYMMDD(day), plugin.events ) == 0) {

          //   td.find(".day").addClass("semi-available");

          // }

          //if day is previous day
          if (day < (new Date())) {
            td.find(".day").addClass("wrong-day");
          }

          if (day.toDateString() === (new Date).toDateString()) {
            td.find(".day").addClass("today");
            td.find(".day").removeClass("wrong-day");
          }
          //if day is not in this month
          if (day.getMonth() != fromDate.getMonth()) {
            td.find(".day").addClass("wrong-month");
          }

          //Binding day event
          td.on('click', function (e) {
          });

          tr.append(td);
          day.setDate(day.getDate() + 1);
        }
        tbody.append(tr);
      }

      body.append(thead);
      body.append(tbody);

      var eventContainer = $('<div class="event-container"></div>');

      calendar.append(body);
      calendar.append(eventContainer);
    },

    // Init global events listeners
    bindEvents: function () {
      var eb_end_period = eb_js_settings.eb_calendar_availability_period;
      var plugin = this;
      var container = $(this.element);
      var counter = '';
      var startMoth = plugin.currentDate.getMonth();
      var endMonth = startMoth + (eb_end_period - 0);
      var currentMonth = startMoth;


      // Click previous month
      container.find('.btn-prev').on('click', function () {
        if (currentMonth > startMoth) {
          plugin.currentDate.setMonth(plugin.currentDate.getMonth() - 1);
          plugin.buildCalendar(plugin.currentDate, container.find('.availability-calendar'));
          plugin.updateHeader(plugin.currentDate, container.find('.availability-calendar .availability-calendar-header'));

          currentMonth--;
        }

      });

      // Click next month
      container.find('.btn-next').on('click', function () {
        if (currentMonth < endMonth) {
          plugin.currentDate.setMonth(plugin.currentDate.getMonth() + 1);
          plugin.buildCalendar(plugin.currentDate, container.find('.availability-calendar'));
          plugin.updateHeader(plugin.currentDate, container.find('.availability-calendar .availability-calendar-header'));

          currentMonth++;

        }

      });

    },

    formatToYYYYMMDD: function (date) {
      var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

      if (month.length < 2) month = '0' + month;
      if (day.length < 2) day = '0' + day;

      return [year, month, day].join('/');
    }

  });

  // preventing against multiple instantiations
  $.fn[pluginName] = function (options) {
    return this.each(function () {
      if (!$.data(this, "plugin_" + pluginName)) {
        $.data(this, "plugin_" + pluginName, new Plugin(this, options));
      }
    });
  };

})(jQuery);