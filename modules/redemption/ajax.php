<?php

require_once 'functions.php';
require_once 'comm_module_redemption.php';
//send_mail_redemption();

if ( is_user_logged_in() ) {

add_action( 'wp_ajax_get-redemption', 'ajax_call_get_redemption' );

add_action( 'wp_ajax_set-redemption', 'ajax_call_redemption' );

add_action( 'wp_ajax_set-rejected-redemption', 'ajax_call_set_rejected_redemption' );

add_action( 'wp_ajax_final_save_details', 'ajax_call_final_save_details' );

add_action( 'wp_ajax_set-notinitiated-email', 'ajax_call_set_notinitiated_email' );

add_action( 'wp_ajax_set-closure-email', 'ajax_call_set_closure_email' );
}
else
{
 add_action( 'wp_ajax_nopriv_get-redemption', 'ajax_call_get_redemption' );

add_action( 'wp_ajax_nopriv_set-redemption', 'ajax_call_redemption' );

add_action( 'wp_ajax_nopriv_set-rejected-redemption', 'ajax_call_set_rejected_redemption' );

add_action( 'wp_ajax_nopriv_final_save_details', 'ajax_call_final_save_details' );

add_action( 'wp_ajax_nopriv_set-notinitiated-email', 'ajax_call_set_notinitiated_email' );

add_action( 'wp_ajax_nopriv_set-closure-email', 'ajax_call_set_closure_email' );
}

function ajax_call_get_redemption() {

    $response = get_redemption();

    wp_send_json( $response );
}

function ajax_call_redemption() {

    $option   = $_REQUEST[ 'option' ];
    $username = $_REQUEST[ 'username' ];
     $shipping = $_REQUEST[ 'shipping' ];

    $redemption = set_redemption( $option, $username ,$shipping);

    wp_send_json( $redemption );
}

function ajax_call_set_rejected_redemption() {

    $option   = $_REQUEST[ 'option' ];
    $username = $_REQUEST[ 'username' ];

    $redemption = set_rejected_redemption( $option, $username );

   wp_send_json( $redemption );

}

function ajax_call_final_save_details() {

    $option   = $_REQUEST[ 'option' ];
    $username = $_REQUEST[ 'username' ];
    $date = $_REQUEST[ 'date' ];
    $time = $_REQUEST[ 'time' ];
    $address = $_REQUEST[ 'address' ];

    $redemption = set_final_redemption( $option, $username,$date,$time ,$address);

    wp_send_json( $redemption );
}

function ajax_call_set_notinitiated_email(){
    
    
    $ID = $_REQUEST[ 'ID' ];
    
    $str = $_REQUEST[ 'str' ];
    
    $send_initiate_remin = send_initiate_reminder($ID,$str);
    
}


function ajax_call_set_closure_email(){
    
    $ID = $_REQUEST[ 'ID' ];
    
    $send_initiate_remin = set_closure_email($ID);
}


