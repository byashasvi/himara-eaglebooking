// =============================================
// AJAX Filters
// Modified: 1.2.5
// Author: Eagle Themes
// The function eb_search_filters is globally accessible
// =============================================

( function ($) {

    "use strict";

    /* Document is Raedy */
    $(document).ready(function () {

        var calendar = $(".eb-datepicker");

        // handler to the ajax request
        var eb_ajax_filters_xhr = null;

        window.eb_search_filters = function ( paged = '') {

            // if there is a previous ajax request, then abort it
            if( eb_ajax_filters_xhr != null ) {
                eb_ajax_filters_xhr.abort();
                eb_ajax_filters_xhr = null;
            }

            // Get Dates from Daterangepicker
            var eagle_booking_date_format = eb_js_settings.eagle_booking_date_format.toUpperCase();
            var eagle_booking_checkin = $(calendar).data('daterangepicker').startDate.format(eagle_booking_date_format);
            var eagle_booking_checkout = $(calendar).data('daterangepicker').endDate.format(eagle_booking_date_format);
            var eb_search_results_alert = $('#eb-no-search-results');
            var eb_search_rooms_rooms_list = $(".eb-rooms");

            // Check if check-in and check-out have been set
            if (eagle_booking_checkin && eagle_booking_checkout) {

                // Remove prevous results
                $(".eb-rooms-list").remove();

                // Remove alert
                eb_search_results_alert.remove();

                // Get Values
                var eagle_booking_guests = $("#eagle_booking_guests").val();
                var eagle_booking_adults = $("#eagle_booking_adults").val();
                var eagle_booking_children = $("#eagle_booking_children").val();
                var eagle_booking_min_price = $("#eagle_booking_min_price").val();
                var eagle_booking_max_price = $("#eagle_booking_max_price").val();
                var eb_normal_services = $("#eb_normal_services").val();
                var eb_additional_services = $("#eb_additional_services").val();

                var eb_branch = $("#eb_branch").val();
                if ( eb_branch === undefined ) eb_branch = '';

                var eagle_booking_search_sorting_filter_meta_key = $("#eagle_booking_search_sorting .selected a").attr('data-meta-key');
                var eagle_booking_search_sorting_filter_order = $("#eagle_booking_search_sorting .selected a").attr('data-order');
                var view = $(".rooms-view .active").attr('data-view');

                var eagle_booking_paged = paged;

                // Defaults
                if ( typeof eagle_booking_search_sorting_filter_meta_key == 'undefined') eagle_booking_search_sorting_filter_meta_key = '';
                if ( typeof eagle_booking_search_sorting_filter_order == 'undefined') eagle_booking_search_sorting_filter_order = '';

                // Use diffrent loader based on selected view
                if ( view === 'grid-view' ) {

                    var eagle_booking_search_loader = $('<div class="eagle_booking_search_loader"><div class="wrapper-cell"><div class="image-line"></div><div class="text-cell"><div class="text-line title-line"></div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div></div><div class="price-cell"><div class="price-line"></div><div class="night-line"></div><div class="button-line"></div></div></div><div class="wrapper-cell"><div class="image-line"></div><div class="text-cell"><div class="text-line title-line"></div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div></div><div class="price-cell"><div class="price-line"></div><div class="night-line"></div><div class="button-line"></div></div></div><div class="wrapper-cell"><div class="image-line"></div><div class="text-cell"><div class="text-line title-line"></div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div></div><div class="price-cell"><div class="price-line"></div><div class="night-line"></div><div class="button-line"></div></div></div><div class="wrapper-cell"><div class="image-line"></div><div class="text-cell"><div class="text-line title-line"></div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div></div><div class="price-cell"><div class="price-line"></div><div class="night-line"></div><div class="button-line"></div></div></div><div class="wrapper-cell"><div class="image-line"></div><div class="text-cell"><div class="text-line title-line"></div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div></div><div class="price-cell"><div class="price-line"></div><div class="night-line"></div><div class="button-line"></div></div></div></div>');

                } else {

                    var eagle_booking_search_loader = $('<div class="eagle_booking_search_loader"><div class="wrapper-cell"><div class="image-line"></div><div class="text-cell"><div class="text-line title-line"></div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div></div><div class="price-cell"><div class="price-line"></div><div class="night-line"></div><div class="button-line"></div></div></div><div class="wrapper-cell"><div class="image-line"></div><div class="text-cell"><div class="text-line title-line"></div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div></div><div class="price-cell"><div class="price-line"></div><div class="night-line"></div><div class="button-line"></div></div></div><div class="wrapper-cell"><div class="image-line"></div><div class="text-cell"><div class="text-line title-line"></div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div></div><div class="price-cell"><div class="price-line"></div><div class="night-line"></div><div class="button-line"></div></div></div><div class="wrapper-cell"><div class="image-line"></div><div class="text-cell"><div class="text-line title-line"></div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div></div><div class="price-cell"><div class="price-line"></div><div class="night-line"></div><div class="button-line"></div></div></div><div class="wrapper-cell"><div class="image-line"></div><div class="text-cell"><div class="text-line title-line"></div><div class="text-line"></div><div class="text-line"></div><div class="text-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div><div class="service-line"></div></div><div class="price-cell"><div class="price-line"></div><div class="night-line"></div><div class="button-line"></div></div></div></div>');

                }

                // Check if there is already a loader
                if ( !$('.eagle_booking_search_loader').length ) {
                    eb_search_rooms_rooms_list.append(eagle_booking_search_loader);
                }

                eb_update_fixed_sidebar();

                // Start the AJAX request
                eb_ajax_filters_xhr = $.ajax({
                url: eb_frontend_ajax.eb_search_filters_ajax,
                method: 'GET',
                data: {
                    action: 'eb_search_filters_action',
                    eb_search_filters_nonce: eb_frontend_ajax.eb_ajax_nonce,
                    eagle_booking_paged: eagle_booking_paged,
                    eagle_booking_checkin: eagle_booking_checkin,
                    eagle_booking_checkout: eagle_booking_checkout,
                    eagle_booking_guests: eagle_booking_guests,
                    eagle_booking_adults: eagle_booking_adults,
                    eagle_booking_children: eagle_booking_children,
                    eagle_booking_min_price: eagle_booking_min_price,
                    eagle_booking_max_price: eagle_booking_max_price,
                    eb_normal_services: eb_normal_services,
                    eb_additional_services: eb_additional_services,
                    eb_branch_id: eb_branch,

                    eagle_booking_search_sorting_filter_meta_key: eagle_booking_search_sorting_filter_meta_key,
                    eagle_booking_search_sorting_filter_order: eagle_booking_search_sorting_filter_order,
                    view: view,
                },

                // Success
                success: function (eagle_booking_filters_result) {

                    // Remove alert
                    eb_search_results_alert.remove();

                    // Append new results
                    $(".eb-rooms").append(eagle_booking_filters_result);

                    // Re-intialize popover
                    if ($.fn.popover) {
                    $('[data-toggle="popover"]').popover({
                        html: true,
                        offset: '0 10px'
                    });
                    }

                    // Remove Loader
                    $('.eagle_booking_search_loader').remove();

                    // Scroll to top of the page
                    $('html').animate({
                    scrollTop: $('body').offset().top
                    }, 300);
                },

                error: function (eb_ajax_filters_xhr, textStatus, errorThrown) {

                    // Console mssg - debug purpose
                    console.log(errorThrown);

                },

                complete: function () {

                    // After request complited update results number
                    var eagle_booking_results_qnt = $('#eagle_booking_results_qnt').val();
                    $("#results-number").text(eagle_booking_results_qnt);

                    eb_update_fixed_sidebar();

                }

                });

            } else {

                // Open Calendar if check-in & checkout have not been set
                //$('#eagle_booking_datepicker').click();

            }

        }


        // =============================================
        // Price Filter
        // =============================================
        var eb_price_range = $("#eagle_booking_slider_range");
        var eb_currency_position = eb_js_settings.eb_currency_position;

        if ( eb_currency_position === 'after' ) {

        var eb_prefix = '';
        var eb_postfix = eb_js_settings.eb_currency;

        } else {

        var eb_prefix = eb_js_settings.eb_currency;
        var eb_postfix = '';

        }

        eb_price_range.ionRangeSlider({
        type: "double",
        skin: "round",
        grid: true,
        min: eb_js_settings.eagle_booking_price_range_min,
        max: eb_js_settings.eagle_booking_price_range_max,
        from: eb_js_settings.eagle_booking_price_range_default_min,
        to: eb_js_settings.eagle_booking_price_range_default_max,
        prefix: eb_prefix,
        postfix: eb_postfix,
        onFinish: function (data) {
            $('#eagle_booking_min_price').val(data.from);
            $('#eagle_booking_max_price').val(data.to);
            eb_search_filters();

        },

        onUpdate: function (data) {
            disable: true
        }
        });

        // =============================================
        // Services Filter
        // =============================================
        $(".eb_normal_service").change(function () {

            if ($(this).is(":checked")) {

                var eb_normal_service_value = $(this).val();
                var eb_normal_service_previous_value = $("#eb_normal_services").val();
                $("#eb_normal_services").val(eb_normal_service_value + eb_normal_service_previous_value);
                eb_search_filters();

            } else {

                var eb_normal_service_value = $(this).val();
                var eb_normal_service_previous_value = $("#eb_normal_services").val();
                var eb_normal_services = eb_normal_service_previous_value.replace(eb_normal_service_value, "");

                $("#eb_normal_services").val(eb_normal_services);
                eb_search_filters();
            }
        });


        // =============================================
        // Additional Services Filter
        // =============================================
        $(".eb_checkbox_additional_service").change(function () {

            if ($(this).is(":checked")) {

                var eb_additional_service_value = $(this).val();
                var eb_additional_service_previous_value = $("#eb_additional_services").val();
                $("#eb_additional_services").val(eb_additional_service_value + eb_additional_service_previous_value );
                eb_search_filters();

            } else {

                var eb_additional_service_value = $(this).val();
                var eb_additional_service_previous_value = $("#eb_additional_services").val();
                var eb_additional_services = eb_additional_service_previous_value.replace(eb_additional_service_value, "");
                $("#eb_additional_services").val(eb_additional_services);
                eb_search_filters();
            }

        });

        // =============================================
        // Branches Filter
        // =============================================
        $('.eb-branch-filter').on('click', function() {

            // Remove all previous checked except the current one
            $('.eb-branch-filter').not(this).removeClass('selected');
            $('.eb-branch-filter').children('input[type="checkbox"]').not(this).prop('checked', false);

            if ( $(this).hasClass('selected') ) {

            $(this).removeClass('selected');
            $(this).children('input[type="checkbox"]').prop('checked', false);

            } else {

            $(this).addClass('selected');
            $(this).children('input[type="checkbox"]').prop('checked', true);

            }

            var checkbox = $(this).children('input[type="checkbox"]');
            var branch_id  = $("#eb_branch");

            var eb_branch_value = checkbox.val();

            if ((checkbox).is(":checked")) {

            // Set value
            branch_id.val(eb_branch_value );

            } else {

            $(this).removeClass('selected');

            // Clear value
            branch_id.val('');

            }

            // Refresh results
            eb_search_filters();

        });

        // =============================================
        // Open Calendar on select dates button & scroll
        // =============================================
        $(document).on('click', '.select-booking-dates-notice', function() {

            // Current Height from top
            var docViewTop = $(window).scrollTop();
            // Search form height from top
            var elemTop = $('#search_form').offset().top;

            if( docViewTop > elemTop ) {

            $('html').animate({
                scrollTop: $('body').offset().top
            }, 300);

            // Open Calendar Afrwe srolling to top (with delay)
            setTimeout(function () {
                $(calendar).focus();
            }, 300);

            } else {

            // Open Calendar Afrwe srolling to top (with no delay)
                $(calendar).focus();

            }

        })

        // =============================================
        // Sort By
        // =============================================
        $("#eagle_booking_search_sorting li").on("click", function () {

            $('#eagle_booking_search_sorting li').removeClass("selected");

            $(this).addClass("selected");

            $('#eagle_booking_active_sorting').text($(this).text());

            eb_search_filters();

        });

        // =============================================
        // View
        // =============================================
        $(".rooms-view .view-btn").on("click", function () {

            $('.rooms-view .view-btn').removeClass('active');
            $(this).addClass('active');

            if ( $(this).hasClass('grid-btn') ) {

                $('.eb-rooms').addClass("grid-view");
                $('.eb-rooms').removeClass ("list-view");

            } else {

                $('.eb-rooms').removeClass ("grid-view");
                $('.eb-rooms').addClass ("list-view");

            }

        });


        // =============================================
        // Search Page Pagination
        // =============================================
        $(document).on('click', '.pagination-button', function() {
            var eb_pagination = $(this).attr('data-pagination');
            eb_search_filters(eb_pagination);
        })


    });

})(jQuery);