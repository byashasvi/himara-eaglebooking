

/*================================================
* Plugin Name: Eagle Booking / Admin iCal [Beta]
* Version: 1.3.6
* Author: Eagle Themes (Jomin Muskaj)
* Author URI: eagle-booking.com
=================================================*/

(function ($) {

    "use strict";

    /* Document is Raedy Lets Start */
    $(document).ready(function () {

        /*----------------------------------------------------*/
        /*  New Entry Form
        /*----------------------------------------------------*/
        $(".eb-new-entry").on("click", function (event) {

            $(this).closest('.eb-entry-line').find('.eb-no-entry').hide();

            $(this).closest('.eb-entry-line').find(".eb_ical_new_url").parent().parent().show();

        })

        /*----------------------------------------------------*/
        /*  Cancel Edit
        /*----------------------------------------------------*/
        $('body').on('click', '.eb-cancel-action', function(event) {

            $(this).closest('.eb-entry-line').find(".eb_ical_new_url").parent().parent().hide();

            // Only if there is no any other entry
            $(this).closest('.eb-entry-line').find('.eb-no-entry').show();

        });

        /*----------------------------------------------------*/
        /*  Create Entry
        /*----------------------------------------------------*/
        $('.eb-create-entry').on('click', function(event) {

            // Check before submit
            var eb_form_has_error = false;

            // Get required fields
            var fields = {
                line: $(this).closest('.eb-entry-line').find('.eb_ical_new_line'),
                url: $(this).closest('.eb-entry-line').find('.eb_ical_new_url'),
                room_id: $(this).closest('.eb-entry-line').find('.eb_ical_new_url').data('room-id'),
            }

            // // Check if any required field is empty
            fields.url.each( function() {

                if( !this.value ) {
                    eb_form_has_error = true;
                    $(this).addClass("empty");
                }

            });

            // Let's send back to PHP
            if ( eb_form_has_error == false ) {

                // Handler to the ajax request
                var eb_create_entry  = null;

                // If there is a previous ajax request, then abort it
                if( eb_create_entry != null ) {
                    eb_create_entry.abort();
                    eb_create_entry = null;
                }

                // Set the data
                var data = {
                    action: 'admin_create_url',
                    nonce: ical.nonce,
                    url: fields.url.val(),
                    ical_room_id: fields.room_id,
                }

                eb_create_entry = $.ajax({
                    type: 'POST',
                    dataType: "json",
                    url: ical.ajaxurl,
                    data: data

                })

                // Always
                .always( function (response) {} )

                // Done
                .done( function (response) {

                     // Lets check the returned status
                     if ( response.status === 'success' ) {

                        var response_class = 'success';

                        // Remove "Add New Line"
                        fields.line.hide();

                        // Add the content of the new line
                        var new_line = $('<tr class="eb-url-line">Testjoni</tr>');

                        // $(new_line).insertAfter('.eb_ical_new_url').fadeIn();


                        $('<tr class="eb-url-line"><td class="eb-url-line" width="50%"><code class="eb-existing-entry"><a href="' + fields.url.val() + '" target="_blank">' + fields.url.val() + '</a></code></td><td class="eb-action-buttons"><span class="eb-delete-action" data-url-id="2"><i class="fas fa-times"></i></span></td></tr>').insertAfter(fields.line)

                        // alert(fields.url.val());



                     } else {

                        var response_class = 'failed';

                     }

                    // Show notification box & and remove it after 3s
                    var eb_notice = $('<div class="eb-notice eb-'+ response_class +'">'+ response.mssg +'</div>');

                    $(eb_notice).hide().appendTo("body").fadeIn(300);

                    // Remove Notice
                    setTimeout( function() {
                        $('.eb-notice').fadeOut(300);
                    }, 3000);


                } )

                // Fail
                .fail( function (response) { console.log('Request Failed');  })

            }

        });

        /*----------------------------------------------------*/
        /*  Delete Entry
        /*----------------------------------------------------*/
        $('.eb-delete-action').on('click', function(event) {

            // Get required fields
            var fields = {
                line: $(this).closest('.eb-entry-line'),
                url_id: $(this).closest('.eb-url-line').data('row-id'),
            }


            // Handler to the ajax request
            var eb_delete_entry  = null;

            // If there is a previous ajax request, then abort it
            if( eb_delete_entry != null ) {
                eb_delete_entry.abort();
                eb_delete_entry = null;
            }

            // Set the data
            var data = {
                action: 'admin_delete_url',
                nonce: ical.nonce,
                url_id: fields.url_id
            }

            eb_delete_entry = $.ajax({
                type: 'POST',
                dataType: "json",
                url: ical.ajaxurl,
                data: data

            })

            // Always
            .always( function (response) {} )

            // Done
            .done( function (response) {

                    // Lets check the returned status
                    if ( response.status === 'success' ) {

                    var response_class = 'success';


                    $('.eb-url-line[data-row-id="'+ fields.url_id +'"]').fadeOut(300);



                    } else {

                    var response_class = 'failed';

                    }

                // Show notification box & and remove it after 3s
                var eb_notice = $('<div class="eb-notice eb-'+ response_class +'">'+ response.mssg +'</div>');

                $(eb_notice).hide().appendTo("body").fadeIn(300);

                // Remove Notice
                setTimeout( function() {
                    $('.eb-notice').fadeOut(300);
                }, 3000);


            } )

            // Fail
            .fail( function (response) { console.log('Request Failed');  })

        });

        /*----------------------------------------------------*/
        /*  Sync Room
        /*----------------------------------------------------*/
        $('.eb-sync-action').on('click', function(event) {

            // rotate icon
            $(this).addClass('eb-rotate');

            $(this).removeAttr('data-eb-tooltip');

            // Get required fields
            var fields = {
                room_id: $(this).data('entry-id'),
            }

            // Handler to the ajax request
            var eb_sync_entry  = null;

            // If there is a previous ajax request, then abort it
            if( eb_sync_entry != null ) {
                eb_sync_entry.abort();
                eb_sync_entry = null;
            }

            // Set the data
            var data = {
                action: 'admin_sync_ical',
                nonce: ical.nonce,
                room_id: fields.room_id
            }

            eb_sync_entry = $.ajax({
                type: 'POST',
                dataType: "json",
                url: ical.ajaxurl,
                data: data

            })

            // Always
            .always( function (response) {

                console.log(response.logs);

            } )

            // Done
            .done( function (response) {


                // remove rotate icon

                $('.eb-edit-action').removeClass('eb-rotate');


                // Check if booking deleted successfully
                if ( response.status === 'success' ) {

                    var response_class = 'success';

                } else {

                    var response_class = 'error';

                }

                // Show notification box & and remove it after 3s
                var eb_notice = $('<div class="eb-notice eb-'+ response_class +'">'+ response.mssg +'</div>');

                $(eb_notice).hide().appendTo("body").fadeIn(300);

                // Remove Notice
                setTimeout( function() { $('.eb-notice').fadeOut(300);}, 3000);


            } )

            // Fail
            .fail( function (response) { console.log('Request Failed');  })

        });



    });

})(jQuery);
