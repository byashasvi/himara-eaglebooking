<?php
/* --------------------------------------------------------------------------
 * @ EB Admin
 * @ Sync Calendars [Admin]
 * @ Since  1.3.6
 * @ Author: Eagle Themes
 * @ Developer: Jomin Muskaj
---------------------------------------------------------------------------*/

// Exit if accessed directly
defined('ABSPATH') || exit;

class EB_ADMIN_SYNC_CALENDARS {

    public function __construct() {

        // Actions
        add_action( 'admin_menu', array( $this, 'add_admin_sub_page' ) );
        add_action( 'init', array( $this, 'add_calendar_feed') );
        add_action( 'wp_ajax_admin_create_url', array( $this, 'save_url') );
        add_action( 'wp_ajax_admin_delete_url', array( $this, 'delete_url') );

        // Manually Sync on AJAX call
        add_action( 'wp_ajax_admin_sync_ical', array( $this, 'manually_sync_ics') );

        // Enable auto-syncing and set the interval time
        if ( eb_get_option( 'auto_sync_calendars' ) == true ) {
            add_action( 'eb_import_ics_event',  array( $this, 'import_ics')  );

            if ( ! wp_next_scheduled( 'eb_import_ics_event' ) ) wp_schedule_single_event( time() + eb_get_option( 'sync_calendars_interval' ), 'eb_import_ics_event' );
        }
    }

   /**
   * Create the submenu
   */
    public function add_admin_sub_page(){
        $current_page = add_submenu_page(
            'eb_bookings',
            __('Sync Calendars', 'eagle-booking'),
            __('Sync Calendars <small>New</small>', 'eagle-booking'),
            'edit_pages',
            'eb_sync_calendars',
            array( $this, 'render' )
        );

        // Load the JS only on this page
        add_action( 'load-' . $current_page, array( $this, 'load_admin_js') );
    }

    /**
     * Load Admin JS
     */
    public function load_admin_js(){

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts') );
    }

    /**
     * Enqueue the required scripts
     */
     public function enqueue_scripts() {

        wp_enqueue_script( 'eb-admin-ical', EB_URL .'assets/js/admin/ical.js', array( 'jquery' ), EB_VERSION, true );

        wp_localize_script( 'eb-admin-ical', 'ical', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('nonce')
        ));
    }

    /**
     * Create 'eb_calendar' feed
     */
    public function add_calendar_feed(){

        add_feed('eb', array( $this, 'export_ics') );
    }

    /**
     * Save Import URL
     * Save Import URL into the DB for each room
     */
    public function save_url() {

        if( isset( $_POST['url'] ) ) {

            $ical_url_nonce = sanitize_text_field( $_POST['nonce'] );
            $ical_url = sanitize_url( $_POST['url'] );
            $ical_room_id = sanitize_text_field( $_POST['ical_room_id'] );

            // Check nonce
            if ( !wp_verify_nonce($ical_url_nonce, 'nonce') ) {

                $return_data['status'] = 'failed';
                $return_data['mssg'] = __('Invalid Nonce', 'eagle-booking');

            // If everything is ok let's proceed
            } else {

                // Current Entries
                $current_entries = get_option( 'eb_ical_urls' );

                if (  empty( $current_entries ) ) {

                    // Set first id to 1
                    $entry_id = 1;

                } else {

                    // Get the last entry
                    $last_array = end( $current_entries );

                    // Get the id of the latest entry
                    $last_id = $last_array['id'];

                    // Get the last id + 1
                    $entry_id = ++$last_id;

                }

                $new_entries = array(
                    'id'      => $entry_id,
                    'url'     => $ical_url,
                    'room_id' => $ical_room_id
                );

                // First time (doesn't exist yet)
                if ( empty( $current_entries)  ){

                    update_option( 'eb_ical_urls', array( $new_entries ) );

                // Update
                } else {

                    $merged_options = array_merge ( $current_entries , array ( $new_entries ) );

                    //Update Option
                    update_option( 'eb_ical_urls', $merged_options );

                }

                $return_data['status'] = 'success';
                $return_data['mssg'] = __('New URL Added Successfully', 'eagle-booking');

            }

        } else {

            $return_data['status'] = 'failed';
            $return_data['mssg'] = __('No URL', 'eagle-booking');

        }

      // Return all data to json
      wp_send_json($return_data);
      wp_die();

    }

  /**
   * Delete Entry [AJAX Request]f
  */
  public function delete_url() {

    // Check if Ajax response and get Ajax variables
    if ( !empty($_POST['url_id']) ) {

        $entry_nonce = sanitize_text_field( $_POST['nonce'] );
        $url_id = sanitize_text_field( $_POST['url_id'] );

        // Check nonce
        if ( !wp_verify_nonce($entry_nonce, 'nonce') ) {

          $return_data['status'] = 'failed';
          $return_data['mssg'] = __('Invalid Nonce', 'eagle-booking');

        // If everything is ok let's proceed to the deletion
        } else {

            // Existing Entries (urls)
            $data = get_option('eb_ical_urls');

            // Loop the array to find the specific entry
            foreach( $data as $key => $row ) {

                if( $row['id'] == $url_id ){

                    // Dlete the array
                    unset( $data[$key] );

                    // Stop the loop
                    break;

                }
            }

            update_option('eb_ical_urls', $data);

            $return_data['status'] = 'success';
            $return_data['mssg'] = __('Entry Deleted Successfully ', 'eagle-booking');

        }

      } else {

        $return_data['status'] = 'failed';
        $return_data['mssg'] = __('No ID', 'eagle-booking');

      }

      // Return all data to json
      wp_send_json($return_data);
      wp_die();

  }


/**
 * Create .ics
 * Select only bookings that end date is after today
 */
public function export_ics() {

    // DB QUERY
    global $wpdb;

    // Query the rooms first
    $rooms = new WP_Query(
        array(
            'p' => $_REQUEST['id'],
            'post_type' => 'eagle_rooms',
        )
    );

    // Loop All Rooms
    if ( $rooms->have_posts() ) while ( $rooms->have_posts() ) : $rooms->the_post();

        // Let's create the .ics file for each room
        $room_id = get_the_ID();
        $room_title = get_the_title();
        $filename = urlencode( 'eb_room_'.$room_id.'.ics' );

        // Set the correct headers for this file
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=".$filename);
        header('Content-type: text/calendar; charset=utf-8');
        header("Pragma: 0");
        header("Expires: 0");

        $calendar = '';
        $calendar .= "BEGIN:VCALENDAR\r\n";
        $calendar .= "PRODID;X-RICAL-TZSOURCE=TZINFO:-//Eagle Booking//Calendar//EN\r\n";
        $calendar .= "CALSCALE:GREGORIAN\r\n";
        $calendar .= "METHOD:PUBLISH\r\n";
        $calendar .= "VERSION:2.0\r\n";

        // Get all the bookings of the room (end date after today)
        $eb_room_bookings = $wpdb->get_results(  "SELECT * FROM ".EAGLE_BOOKING_TABLE." WHERE id_post = $room_id " );

        foreach ( $eb_room_bookings as $eb_room_booking ) {

            $checkin = DateTime::createFromFormat("m/d/Y", $eb_room_booking->date_from)->format('Ymd\THis');
            $checkout = DateTime::createFromFormat("m/d/Y", $eb_room_booking->date_to)->format('Ymd\THis');
            $booking_id = $eb_room_booking->id;

            $eb_today = date("Y-m-d");
            $eb_end_date = DateTime::createFromFormat("m/d/Y", $eb_room_booking->date_to)->format('Y-m-d');

            // Export only active booking
            if ( $eb_end_date >= $eb_today ) {

                $calendar .= "BEGIN:VEVENT\r\n";
                $calendar .= "DTSTAMP:" . date("Ymd\THis\Z", time()) . "\r\n";
                $calendar .= "DTSTART;VALUE=DATE:".$checkin."\r\n";
                $calendar .= "DTEND;VALUE=DATE:".$checkout."\r\n";
                $calendar .= "UID:EB".$booking_id."\r\n";
                $calendar .= "DESCRIPTION:[EB] Resevation for ".$room_title."\r\n";
                $calendar .= "SUMMARY:[EB] Resevation by ".$eb_room_booking->user_first_name.' '.$eb_room_booking->user_last_name." for ".$room_title."\r\n";
                $calendar .= "LOCATION:".eb_room_branch($room_id)."\r\n";
                $calendar .= "END:VEVENT\r\n";

            }

        }

        $calendar .= "END:VCALENDAR";

    endwhile;

    echo $calendar;

}

public function icsToArray($paramUrl){

    $icsFile = file_get_contents($paramUrl);

    $icsData = explode("BEGIN:", $icsFile);

    foreach($icsData as $key => $value){
        $icsDatesMeta[$key] = explode("\n", $value);
    }

    foreach($icsDatesMeta as $key => $value){
        foreach($value as $subKey => $subValue){
            if($subValue != ""){
                if($key != 0 && $subKey == 0){
                    $icsDates[$key]["BEGIN"] = trim($subValue);
                }else{
                    $subValueArr = explode(":", $subValue, 2);
                    $icsDates[$key][$subValueArr[0]] = trim($subValueArr[1]);
                }
            }
        }
    }

    return $icsDates;
}


/**
 * Import .ics into DB
 * Check room availability first
 * The import process should run on AJAX call or on Cronjob
 */
public function import_ics() {

    // DB QUERY
    global $wpdb;

    // Lets loop all URLs - Retrive all .ics URLs.
    $eb_ics = get_option('eb_ical_urls');


    if ( $eb_ics ) {

        foreach ( $eb_ics as $key => $item ) {

            $eb_ics_url = $item['url'];
            $eb_ical_room_id = $item['room_id'];

            $eb_ics_data = $this->icsToArray($eb_ics_url);

            $eb_existing_bookings = array();

            $eb_bookings = $wpdb->get_results("SELECT * FROM ".EAGLE_BOOKING_TABLE." WHERE id_post = $eb_ical_room_id");

            // Add all returned results in array
            if ( !empty($eb_bookings) ) foreach ($eb_bookings as $eb_booking) {

                $eb_existing_bookings[] = $eb_booking->paypal_tx;
            }

            // Lets loop all events
            foreach( $eb_ics_data as $key => $icsEvent ){

                if( $icsEvent['BEGIN'] == "VEVENT") {

                    // Get event details
                    $event_start_date = isset( $icsEvent ['DTSTART;VALUE=DATE'] ) ? $icsEvent ['DTSTART;VALUE=DATE'] : $icsEvent ['DTSTART'];
                    $event_end_date = isset( $icsEvent ['DTEND;VALUE=DATE'] ) ? $icsEvent ['DTEND;VALUE=DATE'] : $icsEvent ['DTEND'];
                    $cal_id = isset( $icsEvent ['UID'] ) ? $icsEvent ['UID'] : $icsEvent ['UID'];

                    // Convert date format to system format Y/m/d
                    $checkin = DateTime::createFromFormat("Ymd", $event_start_date)->format('m/d/Y');
                    $checkout = DateTime::createFromFormat("Ymd", $event_end_date)->format('m/d/Y');

                    $eb_today = date("Y-m-d");
                    $eb_end_date = DateTime::createFromFormat("Ymd", $event_end_date)->format('Y-m-d');

                    // Import only active bookings and only if the booking does not already exists
                    if ( $eb_end_date >= $eb_today && !in_array( $cal_id, $eb_existing_bookings ) ) {


                         if ( eagle_booking_is_qnt_available( eb_room_availability( $eb_ical_room_id, $checkin, $checkout), $checkin, $checkout, $eb_ical_room_id ) == 1 ) {

                            // Enter the reservation into the db
                            $insert_booking = eb_insert_booking_into_db(
                                $eb_ical_room_id,
                                get_the_title($eb_ical_room_id),
                                date('H:m:s F j Y'),
                                $checkin,
                                $checkout,
                                '', // Guests
                                '', // Adults
                                '', // Children
                                '0', // Price
                                '0',
                                '',
                                '',
                                '',
                                '-', // Firstname
                                '-', // Lastname
                                '',
                                '0',
                                '',
                                ''.' '.'',
                                '',
                                '',
                                '',
                                '',
                                '',
                                'completed',
                                eb_currency(),
                                $cal_id,
                                'external',
                                'external'
                            );


                        } else {

                            echo "Conflict Detedcted";

                        }

                    }

                }

            }

        }

    }

}

/**
 * Sync Calendars Manually [AJAX Request]
 * Read all .ics files
 */
public function manually_sync_ics() {

    // DB QUERY
    global $wpdb;

    $return_data['logs'] = '';

    // Check if Ajax response and get Ajax variables
    if ( !empty($_POST['room_id']) ) {

        $entry_nonce = sanitize_text_field( $_POST['nonce'] );
        $requested_room_id = sanitize_text_field( $_POST['room_id'] );

        // Check nonce
        if ( !wp_verify_nonce($entry_nonce, 'nonce') ) {

          $return_data['status'] = 'failed';
          $return_data['mssg'] = __('Invalid Nonce', 'eagle-booking');

        // If everything is ok let's proceed to the deletion
        } else {

            // Get all URLs
            $eb_ics = get_option('eb_ical_urls');

            if ( $eb_ics ) {

                $url_exist = false;

                foreach ( $eb_ics as $key => $item ) {

                    $eb_ics_url = $item['url'];
                    $eb_ical_room_id = $item['room_id'];
                    $eb_room_title = get_the_title($eb_ical_room_id);

                    // Get only the URLs of the specific room
                    if ( $eb_ical_room_id === $requested_room_id ) {

                        $url_exist = true;

                        $return_data['logs'] .= "Checking the URL ".$eb_ics_url;

                        $eb_ics_data = $this->icsToArray($eb_ics_url);

                        // Check if the mentioned reservation has been already inserted before
                        $eb_existing_bookings = array();
                        $eb_bookings = $wpdb->get_results("SELECT * FROM ".EAGLE_BOOKING_TABLE." WHERE id_post = $eb_ical_room_id");
                        // Add all returned results in array
                        if ( !empty($eb_bookings) ) foreach ($eb_bookings as $eb_booking) {
                            $eb_existing_bookings[] = $eb_booking->paypal_tx;
                        }

                        if ( !empty( $eb_ics_data ) ) {

                            // Lets loop all events
                            foreach( $eb_ics_data as $key => $icsEvent ){

                                if( $icsEvent['BEGIN'] == "VEVENT") {

                                    // Get event details
                                    $event_start_date = isset( $icsEvent ['DTSTART;VALUE=DATE'] ) ? $icsEvent ['DTSTART;VALUE=DATE'] : $icsEvent ['DTSTART'];
                                    $event_end_date = isset( $icsEvent ['DTEND;VALUE=DATE'] ) ? $icsEvent ['DTEND;VALUE=DATE'] : $icsEvent ['DTEND'];
                                    $cal_id = isset( $icsEvent ['UID'] ) ? $icsEvent ['UID'] : $icsEvent ['UID'];

                                    // Convert date format to system format Y/m/d
                                    $checkin = DateTime::createFromFormat("Ymd", $event_start_date)->format('m/d/Y');
                                    $checkout = DateTime::createFromFormat("Ymd", $event_end_date)->format('m/d/Y');

                                    $eb_today = date("Y-m-d");
                                    $eb_end_date = DateTime::createFromFormat("Ymd", $event_end_date)->format('Y-m-d');

                                    // Import only active bookings and only if the booking does not already exists
                                    if ( $eb_end_date >= $eb_today && !in_array( $cal_id, $eb_existing_bookings ) ) {

                                        if ( eagle_booking_is_qnt_available( eb_room_availability( $eb_ical_room_id, $checkin, $checkout), $checkin, $checkout, $eb_ical_room_id ) == 1 ) {

                                            // Enter the reservation into the db
                                            $insert_booking = eb_insert_booking_into_db(
                                                $eb_ical_room_id,
                                                get_the_title($eb_ical_room_id),
                                                date('H:m:s F j Y'),
                                                $checkin,
                                                $checkout,
                                                '', // Guests
                                                '', // Adults
                                                '', // Children
                                                '0', // Price
                                                '0',
                                                '',
                                                '',
                                                '',
                                                '-', // Firstname
                                                '-', // Lastname
                                                '',
                                                '0',
                                                '',
                                                ''.' '.'',
                                                '',
                                                '',
                                                '',
                                                '',
                                                '',
                                                'completed',
                                                eb_currency(),
                                                $cal_id,
                                                'external',
                                                'external'
                                            );

                                            if ( $insert_booking == true ) {

                                                $return_data['status'] = 'success';
                                                $return_data['mssg'] =  __('Bookings imported successfully', 'eagle-booking');

                                            } else {

                                                $return_data['mssg'] =  __('Something went wrong', 'eagle-booking');

                                            }


                                        } else {

                                            $return_data['status'] = 'failed';
                                            $return_data['mssg'] =  __('Conflict detected', 'eagle-booking');
                                            $return_data['logs'] .= "The entry ".$cal_id. "was added succesfully";

                                        }

                                    } else {

                                        $return_data['status'] = 'failed';
                                        $return_data['mssg'] =  __('No new booking detected for the', 'eagle-booking').' '.$eb_room_title;

                                    }

                                } else {

                                    $return_data['status'] = 'failed';
                                    $return_data['mssg'] =  __('No valid event detected', 'eagle-booking');

                                }

                            }

                        }

                    }

                }

                // check if any URL founded after the loop completed
                if ( $url_exist == false ) {

                    $return_data['status'] = 'failed';
                    $return_data['mssg'] =  __('No URL found for the', 'eagle-booking').' '.$eb_room_title;
                }


            } else {

                $return_data['status'] = 'failed';
                $return_data['mssg'] =  __('No URL found for the', 'eagle-booking').' '.$eb_room_title;
            }

        }


    } else {

    $return_data['status'] = 'failed';
    $return_data['mssg'] = __('No ID', 'eagle-booking');

    }

    // Return all data to json
    wp_send_json($return_data);
    wp_die();

}

  /**
  * On Load Retrive Rooms
  */
  public function entries() {

    // echo '<pre>'; print_r($entries); echo '</pre>';

    $html = '';

    $args = array(
        'post_type' => 'eagle_rooms',
        'posts_per_page' => -1
    );

    $the_query = new WP_Query( $args );

    while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

        <?php
            // Defaults
            $eb_room_title = get_the_title();
            $eb_room_id = get_the_ID();
            $eb_room_url = get_edit_post_link( $eb_room_id );
            $eb_room_qnt = get_post_meta( $eb_room_id, 'eagle_booking_mtb_room_quantity', true );
            $eb_existing_urls = get_option('eb_ical_urls');
            $feed_url = get_feed_link('eb').'?id='.$eb_room_id.'.ics';
            $eagle_booking_image_id = get_post_thumbnail_id($eb_room_id);
            $eagle_booking_image_attributes = wp_get_attachment_image_src( $eagle_booking_image_id, 'thumbnail' );
            $eagle_booking_room_img_src = $eagle_booking_image_attributes[0];
            $html .= "<tr class='eb-entry-line' data-entry-id='$eb_room_id' data-cat='$eb_room_id'>";
            $html .= "<td class=''> <div style='display: flex'>  <a href=".get_edit_post_link( $eb_room_id )." target='_blank'> <img width='35' src=".$eagle_booking_room_img_src." style='border-radius: 2px; display: block'> </a>  <a href=".get_edit_post_link( $eb_room_id )." target='_blank'><h2 class='room-title'>$eb_room_title</h2></a></div></td>";
            $html .= "<td class=''><code><a href=".$feed_url." target='_blank'>".$feed_url."</a></code></td>";
            $html .= "<td class='eb-import-url'>";
            $html .= "<table>";

            // Check if the rooms has already import URL
            if (  $eb_existing_urls  ) {

                foreach ( $eb_existing_urls as $key => $item ) {

                    $eb_displayed_url = substr($item['url'], 0, 30).'...'.substr($item['url'], -30);

                    // Display only the URLs of the specific room
                    if ( $item['room_id'] == $eb_room_id ) {

                        $html .= "<tr class='eb-url-line' data-row-id='".$item['id']."'>";
                        $html .= "<td style='width: 70%'><code class='eb-existing-entry'><a href=".$item['url']." target='_blank'>".$eb_displayed_url."</a></code></td>";
                        $html .= "<td class='eb-action-buttons'><span class='eb-delete-action' data-url-id='".$item['id']."'><i class='far fa-trash-alt'></i></span></td>";
                        $html .= "</tr>";
                    }

                }


            } else {

                $html .= "<span class='eb-no-entry'> ";
                $html .= __('No URL Yet', 'eagle-booking');
                $html .= "</span>";

            }

            $html .= "<tr class='eb_ical_new_line' style='display: none'>";
            $html .= "<td style='width: 50%'><input type='text' class='eb_ical_new_url' data-room-id='".$eb_room_id."' placeholder='URL'></td>";
            $html .= "<td><span class='eb-action-buttons'><span class='eb-edit-action eb-create-entry'><i class='fas fa-check'></i></span><span class='eb-cancel-action'><i class='fas fa-times'></i></span></span></td>";
            $html .= "</tr>";
            $html .= "</table>";
            $html .= "</td>";
            $html .= "<td class='eb-action-buttons'>";
            $html .= "<span class='eb-edit-action eb-new-entry' data-entry-id='$eb_room_id' data-eb-tooltip='".__('Add new external calendar', 'eagle-booking')."'><i class='fas fa-plus'></i></span>";
            $html .= "<span class='eb-edit-action eb-sync-action' data-entry-id='$eb_room_id' data-eb-tooltip='".__('Import all external calendars of this room', 'eagle-booking')."'><i class='fas fa-sync'></i></span>";
            // $html .= "<span class='eb-edit-action eb-log-action' data-entry-id='$eb_room_id'><i class='far fa-file-alt'></i></span>";
            $html .= "</td>";
            $html .= "</tr>";

    endwhile;

    return $html;

  }

   /**
   * Render Output
   */
    public function render() {

        ?>

        <div class="eb-admin eb-wrapper">
            <div class="eb-admin-dashboard">

                <?php

                /**
                 * Include the EB admin header
                 *
                 * @since 1.3.2
                 */
                include EB_PATH.''."core/admin/bookings/elements/admin-header.php";

                ?>

                <div class="eb-admin-title">
                     <h1 class="wp-heading-inline"><?php echo __('Sync Calendars', 'eagle-booking') ?><!--<span class="heading-label"> <?php echo  __('Beta', 'eagle-booking') ?></span> --></h1>
                </div>

                <div class="eb-admin-dashboard-inner">

                    <form method="POST" action="">

                        <!-- Taxes -->
                        <div class="eb-admin-list-group eb-admin-taxes-fees" data-cat="eb_taxes">

                            <table class="widefat striped">

                                <thead>
                                    <tr>
                                        <th class="row-title" width="20%"><?php echo __('Room', 'eagle-booking') ?></th>
                                        <th class="row-title" width="30%"><span><?php echo __('Export URL', 'eagle-booking') ?></span></th>
                                        <th class="row-title" width="40%"><span><?php echo __('External Calendars', 'eagle-booking') ?></span></th>
                                        <th class="row-title" width="10%"><?php echo __('Actions', 'eagle-booking') ?></th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php

                                    /**
                                     * Print Existing Entries
                                    */
                                    echo $this->entries();

                                    ?>

                                </tbody>

                            </table>

                        </div>


                    </form>

                </div>

            </div>

        </div>
    <?php

    }

}

// Run only if Sync Calendars option is enabled
if ( eb_get_option('sync_calendars') == true ) new EB_ADMIN_SYNC_CALENDARS();
