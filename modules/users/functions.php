<?php
date_default_timezone_set( "Asia/Kolkata" );
// returns an array of wordpress users//

function filter_two_roles( $user ) {

    echo $user->roles[ 0 ];
    $roles = array( 'administrator', 'rewards_manager' );

    return in_array( $user->roles[ 0 ], $roles );
}

function get_skyi_users( $args = array() ) {


    $defaults = array(

        'orderby' => 'ID',
        'order'   => 'ASC',
        'offset'  => 0,
        'number'  => 40
    );

    $args = wp_parse_args( $args, $defaults );

    $argsa = array( 'role' => 'administrator' );
    $a     = get_users( $argsa );

    $argsb = array( 'role' => 'rewards_manager' );
    $b     = get_users( $argsb );

    $argsc = array( 'role' => 'product_manager' );
    $c     = get_users( $argsc );

    $users = array_merge( $a, $b, $c );


    foreach ( (array) $users as $value ) {

        $user_array[ ] = get_skyi_user( $value->ID );

    }

    return $user_array;

}

//fetch user role based on User Id.
function get_user_role( $user_ID = 0 ) {

    $user_ID = (int) $user_ID;

    if ( $user_ID === 0 ) {
        $user_ID = get_current_user_id();
    }

    // GET USER ROLE

    $user = new WP_User( $user_ID );
   
    $user_role= $user->roles[0];


    return $user->roles[ 0 ];
}

//return user details based on user id///
function get_skyi_user( $user_ID = 0 ) {

    $user_ID = (int) $user_ID;

    if ( $user_ID === 0 ) {
        $user_ID = get_current_user_id();
    }

    $single_user = get_userdata( $user_ID );

    $date_time  = explode( ' ', $single_user->user_registered );
    $date_value = date( "M d,Y", strtotime( $date_time[ 0 ] ) );
    $suspended_status = get_user_suspended_status($user_ID);
    $checked = "";
    if($suspended_status == 'true')
    {
        $checked = 'checked';
    }
    $user_info = array(

        'ID'              => $single_user->ID,
        'display_name'    => $single_user->display_name,
        'role'            => get_user_role( $single_user->ID ),
        'user_registered' => $date_value . " " . $date_time[ 1 ],
        'user_email'      => $single_user->user_email,
        'user_phone'      => $single_user->user_email,
        'checked'         => $checked

    );

    return $user_info;

}

//fething data nd storing it in the database///

function create_skyi_user( $args ) {

    $user_id = wp_insert_user( array(

        'ID'              => $args[ 'ID' ],
        'user_login'      => $args[ 'user_login' ],
        'display_name'    => $args[ 'display_name' ],
        'role'            => sanitize_key( $args[ 'role' ] ),
        'user_email'      => $args[ 'user_email' ],
        'user_registered' => $args[ 'user_registered' ]
       

    ) );
    
    $hash_value = md5($args[ 'user_email' ]);

    update_user_meta($user_id, 'hash', $hash_value);
    if($args[ 'user_pass' ] != "")
    {
    wp_set_password( $args[ 'user_pass' ], $user_id );
    }
    if($args[ 'ID' ] != "")
    {
    update_user_meta($user_id, 'suspended_user', $args['suspend']);
    }
    return $user_id;

}
