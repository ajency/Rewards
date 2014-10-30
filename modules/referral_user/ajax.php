<?php

require_once 'functions.php';

add_action( 'wp_ajax_get-referrals', 'ajax_call_get_referrals' );

/* ajax call to fetch referrsl  */

function ajax_call_get_referrals() {

    global $user_ID;


    $referrals_array = get_referral( $user_ID );


    wp_send_json( $referrals_array );
}