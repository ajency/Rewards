<?php

require_once 'functions.php';

if ( is_user_logged_in() ) {

    add_action( 'wp_ajax_get-shippingdetails', 'ajax_call_get_shippingdetails' );

add_action( 'wp_ajax_final_redemption', 'ajax_call_final_redemption' );


add_action( 'wp_ajax_get_shippping_points', 'ajax_call_get_shippping_points' );

}
else
{
add_action( 'wp_ajax_nopriv_get-shippingdetails', 'ajax_call_get_shippingdetails' );

add_action( 'wp_ajax_nopriv_final_redemption', 'ajax_call_final_redemption' );


add_action( 'wp_ajax_nopriv_get_shippping_points', 'ajax_call_get_shippping_points' );
}

function ajax_call_get_shippingdetails() {

    $username = $_REQUEST[ 'username' ];
    $option   = $_REQUEST[ 'option' ];

    $shipping_data = get_shippingdetails( $username, $option );

    wp_send_json( $shipping_data );

}

function ajax_call_final_redemption() {

    $username        = $_REQUEST[ 'username' ];
    $option          = $_REQUEST[ 'option' ];
    $redemption_user = get_redemption_user( $username, $option );

    wp_send_json( $redemption_user );

}

function ajax_call_get_shippping_points(){
    
     $username        = $_REQUEST[ 'username' ];
     $option        = $_REQUEST[ 'option' ];
    
     $points = get_shipping_points( $username,$option);
    
     
      wp_send_json( $points );
}
