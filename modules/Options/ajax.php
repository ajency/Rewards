<?php

require_once 'functions.php';

add_action( 'wp_ajax_get-optionAdd', 'ajax_call_get_optionAdd' );

add_action( 'wp_ajax_create-option', 'ajax_call_create_option' );

add_action( 'wp_ajax_get-option', 'ajax_call_get_option' );

add_action( 'wp_ajax_update-option', 'ajax_call_update_option' );

add_action( 'wp_ajax_save_expiry', 'ajax_call_save_expiry' );


add_action( 'wp_ajax_get-option-list', 'ajax_call_get_option_list' );




add_action( 'wp_ajax_get_date', 'ajax_call_get_date' );

add_action( 'wp_ajax_get_points_range', 'ajax_call_get_points_range' );



function ajax_call_get_optionAdd() {

    global $user_ID;
    $args = array(

        'post_author' => $user_ID,
        'post_type'   => 'Products',
        'posts_per_page' => -1
    );

    $products = get_all_option_products( $args );
    wp_send_json( $products );
}

function ajax_call_create_option() {

    global $user_ID;
    $args = array(

        'post_author'   => $user_ID,
        'post_type'     => 'Products',
        'option_name'   => $_REQUEST[ 'option_name' ],
        'option_desc'   => $_REQUEST[ 'option_desc' ],
        'optiont_price' => $_REQUEST[ 'optiont_price' ],
        'optionstring'  => $_REQUEST[ 'optionstring' ],
        'optionstring1'  => $_REQUEST[ 'optionstring1' ],
        'min_opt'       => $_REQUEST[ 'min_opt' ],
        'max_opt'       => $_REQUEST[ 'max_opt' ],
        'archive'       => $_REQUEST[ 'archiveval' ]
    );

    $option = create_option( $args );
    wp_send_json( $option );

}

function ajax_call_get_option() {

    $option_array = get_options();
    wp_send_json( $option_array );

}

function ajax_call_update_option() {

    global $user_ID;
    $args = array(
        'ID'            => $_REQUEST[ 'ID' ],
        'post_author'   => $user_ID,
        'post_type'     => 'Products',
        'option_name'   => $_REQUEST[ 'option_name' ],
        'option_desc'   => $_REQUEST[ 'option_desc' ],
        'optiont_price' => $_REQUEST[ 'optiont_price' ],
        'optionstring'  => $_REQUEST[ 'optionstring' ],
        'optionstring1' => $_REQUEST[ 'optionstring1' ],
        'min_opt'       => $_REQUEST[ 'min_opt' ],
        'max_opt'       => $_REQUEST[ 'max_opt' ],
        'archive'       => $_REQUEST[ 'archiveval' ]
    );

    $option = update_option_taxonomy( $args );
    wp_send_json( $option );

}


function ajax_call_save_expiry(){
    
    $expiry_date  = $_REQUEST['expiry_date'];
    $min = $_REQUEST['min_per'];
    $max = $_REQUEST['max_per'];
    $expiry_data = set_expiry_date($expiry_date,$min,$max);
    
     wp_send_json( $expiry_data );
            
}

function ajax_call_get_date(){
    
    $date_period = get_expiry_date();
    
     wp_send_json( $date_period );
}

function ajax_call_get_points_range(){
    
    $points = $_REQUEST['min_opt'];
    $min =  get_option("minimum_percentage");
    $max =  get_option("maximum_percentage");
    $points_range = get_points_range($points,$min,$max);
    wp_send_json( $points_range );
}

function ajax_call_get_option_list(){

    $options  = get_options();

    wp_send_json( $options );
}