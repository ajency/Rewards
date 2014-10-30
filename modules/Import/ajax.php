<?php

require_once 'functions.php';
require_once 'CSV.php';
require_once 'sendmailImport.php';


add_action( 'wp_ajax_upload_CSV', 'ajax_call_uploadCSV' );

add_action( 'wp_ajax_upload_Ref_CSV', 'ajax_call_upload_Ref_CSV' );




function ajax_call_uploadCSV() {

    if ( isset( $_FILES[ "file" ] ) ) {

        $csvJson = parseCSV( $_FILES[ 'file' ][ 'tmp_name' ] );

        $csvjsondecode = get_CSV_Content( $csvJson );

    }
    wp_send_json( $csvjsondecode );
}

function ajax_call_upload_Ref_CSV(){
    
    if ( isset( $_FILES[ "file" ] ) ) {

        $csvJson = parseCSV( $_FILES[ 'file' ][ 'tmp_name' ] );

        $csvjsondecode = get_CSV_Content_Ref( $csvJson );

    }
    wp_send_json( $csvjsondecode );
    
}
  

    