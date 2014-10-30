<?php

require_once 'functions.php';

if (is_user_logged_in()) {

add_action( 'wp_ajax_get-customers', 'ajax_call_get_customers' );
} else  {
add_action('wp_ajax_nopriv_get-customers', 'ajax_call_get_customers');
}

/* function call to get a list of customers */

function ajax_call_get_customers() {

    $user_login = $_REQUEST[ 'username' ];


    $user_details = get_customers( $user_login );


    wp_send_json( $user_details );
}