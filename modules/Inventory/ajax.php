<?php

require_once 'functions.php';

add_action( 'wp_ajax_get-inventory', 'ajax_call_get_inventory' );

add_action( 'wp_ajax_get-inventory_package', 'ajax_call_get_inventory_package' );


function ajax_call_get_inventory(){
    
    $inventory = get_inventory();
    
     wp_send_json( $inventory );
}


function ajax_call_get_inventory_package(){

    $inventory = get_inventory_package();

    wp_send_json( $inventory );

}