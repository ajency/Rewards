<?php

require_once 'functions.php';


if ( is_user_logged_in() ) {

    add_action( 'wp_ajax_get-rewards', 'ajax_call_get_rewards' );

    add_action( 'wp_ajax_save_redemption', 'ajax_call_save_redemption' );
    
    add_action( 'wp_ajax_get_points', 'ajax_call_get_points' );
} else {


    add_action( 'wp_ajax_nopriv_get-rewards', 'ajax_call_get_rewards' );

    add_action( 'wp_ajax_nopriv_save_redemption', 'ajax_call_save_redemption' );
    
    add_action( 'wp_ajax_nopriv_get_points', 'ajax_call_get_points' );
}


function ajax_call_get_rewards() {


    $rewards = get_rewards();

    wp_send_json( $rewards );

}

function ajax_call_save_redemption() {

    $username = $_REQUEST[ 'username' ];
    $optionid = $_REQUEST[ 'optionid' ];

    $save_option = save_redemption( $username, $optionid );

    wp_send_json( $save_option );
}

function ajax_call_get_points(){
    
    $username = $_REQUEST[ 'username' ];
    
    $points = get_points($username);
    
    wp_send_json( $points );
}