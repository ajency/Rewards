<?php
require_once 'functions.php';


add_action( 'wp_ajax_get-menus', 'get_menus' );

//fetch menus//
function get_menus() {

    // GET USER ROLE
    $user_role = get_user_role();

    //FETCH MENU
    $menu = get_site_menu( $user_role );
    echo( wp_send_json( $menu ) );
    die;
}

