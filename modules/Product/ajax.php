<?php

require_once 'functions.php';

add_action( 'wp_ajax_get-products', 'ajax_call_fetch_products' );

add_action( 'wp_ajax_create-product', 'ajax_call_create_product' );

add_action( 'wp_ajax_update-product', 'ajax_call_update_product' );

add_action( 'wp_ajax_upload_image', 'ajax_call_upload_image' );

add_action( 'wp_ajax_upload_edited_image', 'ajax_call_upload_edited_image' );


function ajax_call_create_product() {


    $args = array(
        'post_title'   => $_REQUEST[ 'product_name' ],
        'post_content' => $_REQUEST[ 'product_details' ],
        'post_price'   => $_REQUEST[ 'product_price' ],
        'attachmentid' => $_REQUEST[ 'attachmentid' ],
        'post_type'    => 'Products'
    );

    $product = create_product( $args );

    wp_send_json( array( 'code' => 'OK', 'data' => $product ) );

}

function ajax_call_fetch_products() {

    global $user_ID;
    $args = array(

        'post_author' => $user_ID,
        'post_type'   => 'Products'
    );

    $products = get_all_products( $args );
    wp_send_json( $products );
}

function ajax_call_update_product() {

    $args = array(
        'post_author'  => $_REQUEST[ 'ID' ],
        'post_title'   => $_REQUEST[ 'product_name' ],
        'post_content' => $_REQUEST[ 'product_details' ],
        'post_price'   => $_REQUEST[ 'product_price' ],
        'attachmentid' => $_REQUEST[ 'attachmentid' ]
    );

    $updated_product = get_updated_product( $args );
    wp_send_json( array( 'code' => 'OK', 'data' => $updated_product ) );
}

function ajax_call_upload_image() {

    if ( isset( $_FILES[ "product_img" ] ) ) {

        $imagepath = $_FILES[ 'product_img' ][ 'tmp_name' ];

        $attachmentid = uploadImage( $imagepath );

    }
    wp_send_json( $attachmentid );
}

function ajax_call_upload_edited_image() {

    if ( isset( $_FILES[ "productimg" ] ) ) {

        $imagepath = $_FILES[ 'productimg' ][ 'tmp_name' ];

        $attachmentid = uploadImage( $imagepath );

    }
    wp_send_json( $attachmentid );
}