<?php

require_once 'functions.php';

add_action( 'wp_ajax_show_dashboard', 'ajax_call_show_dashboard' );


function ajax_call_show_dashboard(){
    
    $dashboard_info = dashboard_info();
    
    wp_send_json( $dashboard_info );
}