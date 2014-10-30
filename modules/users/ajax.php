<?php

require_once 'functions.php';

add_action( 'wp_ajax_get-users', 'fetch_users' );
add_action( 'wp_ajax_create-user', 'ajax_call_create_skyi_user' );
add_action( 'wp_ajax_check_email', 'check_email_address' );
add_action( 'wp_ajax_update-user', 'ajax_call_create_skyi_user' );
add_action( 'wp_ajax_get_current_user', 'ajax_call_get_current_user' );
add_action( 'wp_ajax_logout_current_user', 'ajax_call_logout_current_user' );

//fetch list of users///
function fetch_users() {

    global $user_ID;

    // GET USER ROLE
    $user_role = get_user_role();

    //FETCH USERS
    $users = get_skyi_users();
    wp_send_json( $users );
}

//check whether email exists//
function check_email_address() {

    $user_email = $_REQUEST[ 'user_email' ];
    if ( email_exists( $user_email ) )
        wp_send_json( FALSE );
    else
        wp_send_json( TRUE );
}

//call to create a user//
function ajax_call_create_skyi_user() {

    $user_id = 0;
    if ( ( isset( $_REQUEST[ 'ID' ] ) ) && $_REQUEST[ 'ID' ] != "" ) {
        $user_id = $_REQUEST[ 'ID' ];
    }
    $user_array = array(
        'ID'              => $user_id,
        'user_login'      => $_REQUEST[ 'user_email' ],
        'display_name'    => $_REQUEST[ 'display_name' ],
        'role'            => $_REQUEST[ 'role' ],
        'user_email'      => $_REQUEST[ 'user_email' ],
        'user_pass'       => $_REQUEST[ 'password' ],
        'suspend'         => $_REQUEST[ 'suspend' ],
        'user_registered' => date( 'Y-m-d H:i:s' )
    );

        if($_REQUEST[ 'ID' ]== ""){
    if ( !email_exists( $_REQUEST[ 'user_email' ] ) ) {
        $user_created = create_skyi_user( $user_array );

        $user_reg = get_skyi_user( $user_created );

        wp_send_json( array( 'code' => 'OK', 'data' => array( 'ID' => $user_created, 'user_registered' => $user_reg[ 'user_registered' ] ) ) );
    } else {

        wp_send_json( array( 'code' => 'Error', 'data' => null ) );

    }
}
else
{
   $user_created = create_skyi_user( $user_array );

        $user_reg = get_skyi_user( $user_created );

        wp_send_json( array( 'code' => 'OK', 'data' => array( 'ID' => $user_created, 'user_registered' => $user_reg[ 'user_registered' ] ) ) );
  
}
}

/*get curent user*/
function ajax_call_get_current_user() {

    global $user_ID;

    $user_info  = get_skyi_user( $user_ID );
    $last_login = get_user_meta( $user_ID, 'last_login', TRUE );
    $date       = explode( ' ', $last_login );


    wp_send_json( array( 'code' => 'OK', 'data' => $user_info, 'date' => $last_login ) );
}

/*logout the user*/
function ajax_call_logout_current_user() {

    wp_logout();
    wp_send_json( array( 'code' => 'OK', 'data' => 'true' ) );

}