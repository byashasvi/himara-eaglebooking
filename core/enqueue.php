<?php
/* --------------------------------------------------------------------------
 * Enqueue Styles
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
function eb_enqueue_styles() {

    $styles = array(
        'daterangepicker' => 'daterangepicker.css',
        'rangeslider' => 'ion.rangeslider.min.css',
        'intlTelInput' => 'intlTelInput.min.css',
        'countrySelect' => 'countrySelect.min.css',
        'eb-swiper' => 'swiper.css',
        'owl-carousel' => 'owl.carousel.min.css',
        'magnific-popup' => 'magnific-popup.css',
        'eb-main' => 'eb.css',
        'eb-responsive' => 'eb-responsive.css',
    );

    // Enqueue all required CSS
    foreach ( $styles as $id => $style ) {
        wp_enqueue_style( $id, EB_URL .'assets/css/'. $style, false, EB_VERSION );
    }

    // Enqueue Icon Fonts
    wp_enqueue_style( 'fontawesome', EB_URL .'assets/fonts/css/fontawesome.min.css', false, EB_VERSION );
    wp_enqueue_style( 'flaticon', EB_URL. 'assets/fonts/flaticon/flaticon.css', false, EB_VERSION );
    wp_enqueue_style( 'ionicons', EB_URL. 'assets/fonts/css/ionicons.min.css', false, EB_VERSION );
    wp_enqueue_style( 'simpleicons', EB_URL. 'assets/fonts/css/simple-line-icons.css', false, EB_VERSION );
}

add_action( 'wp_enqueue_scripts', 'eb_enqueue_styles' );

/* --------------------------------------------------------------------------
 * Enqueue Scripts
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
function eb_enqueue_scripts() {

    // JS libraries
    $scripts = array(
        'sticky-sidebar' => 'sticky-sidebar.min.js',
        'moment' => 'moment.js',
        'cookies' => 'js.cookie.js',
        'daterangepicker' => 'daterangepicker.js',
        'rangeslider' => 'ion.rangeslider.min.js',
        'intlTelInput' => 'intlTelInput.min.js',
        'countrySelect' => 'countrySelect.min.js',
        'owl' => 'owl.carousel.min.js',
        'swiper' => 'swiper.js',
        'magnific-popup' => 'jquery.magnific-popup.min.js',
        'dragscroll' => 'dragscroll.min.js',
        'parallax' => 'parallax.min.js',
        'eb-main' => 'eb.js',
    );

    // Pre-Packed JS libraries
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-tabs');

    // Enque Js Files
    foreach ( $scripts as $id => $script ) {
        wp_enqueue_script($id, EB_URL .'assets/js/'. $script, array( 'jquery' ), EB_VERSION, true );
    }

    // Localize JS Settings
    wp_localize_script( 'eb-main', 'eb_js_settings', eb_get_js_settings() );

    // Localize AJAX in array
    wp_localize_script(

        'eb-main', 'eb_frontend_ajax',

        array(

            'eb_search_filters_ajax' => admin_url( 'admin-ajax.php' ),

            // Used for static Ajax requests
            'eb_ajax_nonce' => wp_create_nonce( 'eb_nonce' ),
        )

     );

}

add_action( 'wp_enqueue_scripts', 'eb_enqueue_scripts' );

/* --------------------------------------------------------------------------
 * Enqueue Admin Scripts
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
function eb_enqueue_admin_scripts() {

   wp_enqueue_script( 'moment-admin', EB_URL .'assets/js/moment.js', array( 'jquery' ), EB_VERSION, true );
   wp_enqueue_script( 'daterangepicker', EB_URL .'assets/js/daterangepicker.js', array( 'jquery' ), EB_VERSION, true );
   wp_enqueue_script( 'eb-admin-main', EB_URL .'assets/js/admin/eb-admin.js', array( 'jquery' ), EB_VERSION, true );

    // Localize JS Settings
    wp_localize_script( 'eb-admin-main', 'eb_js_settings', eb_get_js_settings() );

    // Localize AJAX in array
    wp_localize_script(

        'eb-admin-main', 'eb_admin_ajax',

        array(

            // Calendar Nonce
            'eb_admin_calendar_ajax' => admin_url( 'admin-ajax.php' ),

            // Remove delete booking
            'eb_admin_delete_booking_ajax' => admin_url( 'admin-ajax.php' ),

            // Used for static Ajax requests
            'eb_admin_ajax_nonce' => wp_create_nonce( 'eb_admin_nonce' ),
        )

     );
}

add_action( 'admin_enqueue_scripts', 'eb_enqueue_admin_scripts' );

/* --------------------------------------------------------------------------
 * Enqueue Admin Styles
 * @since  1.0.0
 ---------------------------------------------------------------------------*/
function eb_enqueue_admin_style() {

  wp_enqueue_style( 'eb-admin-style', plugin_dir_url( __DIR__ ). 'assets/css/admin/eb-admin.css', false, EB_VERSION );
  wp_enqueue_style( 'eb-admin-calendar', plugin_dir_url( __DIR__ ). 'assets/css/daterangepicker.css', false, EB_VERSION );
  wp_enqueue_style( 'eb-fontawesome', plugin_dir_url( __DIR__ ). 'assets/fonts/css/fontawesome.min.css', false, EB_VERSION );

}

add_action( 'admin_enqueue_scripts', 'eb_enqueue_admin_style' );
