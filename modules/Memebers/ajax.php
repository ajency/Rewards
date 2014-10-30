<?php

require_once 'functions.php';

add_action( 'wp_ajax_get-members', 'ajax_call_get_program_members' );

add_action( 'wp_ajax_get_pm_model', 'ajax_call_get_pm_model' );

/* ajax call to fetch program members */

function ajax_call_get_program_members() {

    $user_role = get_user_role();

    if ( $_REQUEST[ 'page' ] != 0 ) {
        $offset = ( $_REQUEST[ 'page' ] * $_REQUEST[ 'size' ] ) + 1;
    } else {
        $offset = $_REQUEST[ 'page' ];
    }
    $sortlist  = $_REQUEST['sortlist'];
    $exp_array  = explode("=",$sortlist);
    $exp = explode('[',$exp_array[0]);
    $exp2 = explode(']',$exp[1]);

    $sort = "";
    
    if($exp2[0]==0 && $exp_array[1]==1){
       
        $order = 'ASC';
        $orderby = 'display_name';
    }
    elseif($exp2[0]==0 && $exp_array[1]==0){
        
        $order = 'DESC';
        $orderby = 'display_name';
    }
    if($exp2[0]==1 && $exp_array[1]==1){
        
        $order = 'ASC';
        $orderby = 'registered';
    }
    elseif($exp2[0]==1 && $exp_array[1]==0){
        
        $order = 'DESC';
        $orderby = 'registered';
    }
    if($exp2[0]==2 && $exp_array[1]==1){

        $sort = "referral_count_desc";
    }
    elseif($exp2[0]==2 && $exp_array[1]==0){

        $sort = "referral_count_asc";
    }
    if($exp2[0]==3 && $exp_array[1]==1){

        $sort = "points_desc";
    }
    elseif($exp2[0]==3 && $exp_array[1]==0){

        $sort = "points_asc";
    }
    if($exp2[0]==4 && $exp_array[1]==1){
        
        $sort = "cmp";
    }
    elseif($exp2[0]==4 && $exp_array[1]==0){
        
         $sort = "cmp1";
    }
    $args = array(
        
        'orderby' => $orderby,
        'order'   => $order,
        'offset'  => $offset,
        'number'  => $_REQUEST[ 'size' ]


    );

    $args_num = array(
        
        'orderby' => 'ID',
        'order'   => 'ASC'


    );

    $users_num = get_users( $args_num );

    $users = fetch_program_members( $args,$sort );

    //wp_send_json( array( 'total_rows' => count( $users_num ), 'data' => $users, 'role' => $user_role ) );
    wp_send_json($users);
}


function ajax_call_get_pm_model(){
    
    $userid = $_REQUEST['userid'];
    $user = get_pm_model($userid);
     wp_send_json($user);
}
