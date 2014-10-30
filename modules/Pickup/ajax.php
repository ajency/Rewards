<?php

require_once 'functions.php';

add_action( 'wp_ajax_get-pickup', 'ajax_call_get_pickup' );


function ajax_call_get_pickup(){
    
    $pickup_details = get_pickup();
    
      wp_send_json( $pickup_details );
}