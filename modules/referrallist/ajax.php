<?php

require_once 'functions.php';

add_action( 'wp_ajax_get-referrallist', 'ajax_call_get_referrallist' );

add_action( 'wp_ajax_export_csv', 'ajax_call_export_csv' );

function ajax_call_get_referrallist() {

    $referrals = get_referrallist();

    wp_send_json( $referrals);
}

function ajax_call_export_csv(){
    
    
    $from_date = $_REQUEST['from_date'];
    
   $to_date = $_REQUEST['to_date'];
    
   
    $status1 = $_REQUEST['status1'];
    $status2 = $_REQUEST['status2'];
    $data = $_REQUEST['coll'];
    $new = "";
    $con = "";
   
    
    $args = array(
        'status1'   => $status1,
        'status2'   => $status2,
        'from_date' => $from_date,
        'to_date'   => $to_date,
        'data'      => $data
    );
    $csv_return = export_csv($args);
    
}