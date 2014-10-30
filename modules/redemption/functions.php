<?php

function get_redemption() {

    global $user_ID;

    $defaults = array(
        'role'    => 'Programmember',
        'orderby' => 'ID',
        'order'   => 'ASC',
        'offset'  => 0,
        'number'  => 0
    );

    $args = wp_parse_args( $args, $defaults );

    $users = get_users( $args );

    foreach ( (array) $users as $value ) {

        $arr = get_skyi_user_redemption( $value->ID );
        if(count($arr)!=0){
        $user_array[ ] = get_skyi_user_redemption( $value->ID );
        }

    }

    return $user_array;

}

function get_skyi_user_redemption( $user_ID = 0 ) {

    global $wpdb;
    $redemption_table      = $wpdb->prefix . "redemption";
    $redemption_meta_table = $wpdb->prefix . "redemption_meta";

    $user_ID = (int) $user_ID;

    if ( $user_ID === 0 ) {
        $user_ID = get_current_user_id();
    }

    $single_user = get_userdata( $user_ID );

    $date_time  = explode( ' ', $single_user->user_registered );
    $date_value = date( "M d,Y", strtotime( $date_time[ 0 ] ) );

    $satus_show = $wpdb->get_row( "select * from $redemption_table where userid  = " . $user_ID . " order by UNIX_TIMESTAMP(date) desc limit 1" );

           if ( $satus_show != null ) {
            $redemption_satus_show = $wpdb->get_row( "select * from $redemption_meta_table where
            redemption_id =" . $satus_show->id . " and status!='Redemption Not Initiated' order by UNIX_TIMESTAMP(date) desc limit 1" );

       
     
    $user_info = array(

        'ID'              => $single_user->ID,
        'display_name'    => $single_user->display_name,
        'role'            => get_user_role( $single_user->ID ),
        'user_registered' => $date_value . " " . $date_time[ 1 ],
        'user_email'      => $single_user->user_email,
        'user_phone'      => $single_user->user_email,
        'status'          => $redemption_satus_show->status,
        'date'            => $redemption_satus_show->date

    );
}
    return $user_info;

}

function set_redemption( $option, $username,$shipping ) {

    $userid = get_users( array(
        "meta_key"   => "hash",
        "meta_value" => $username,
        "fields"     => "ID"
    ) );

    global $wpdb;
    $redemption_table      = $wpdb->prefix . "redemption";
    $redemption_meta_table = $wpdb->prefix . "redemption_meta";
  
        $comm_module_table = $wpdb->prefix . "comm_module";
        $comm_meta_table = $wpdb->prefix . "module_meta";
         $satus_show            = $wpdb->get_row( "select * from $redemption_table where userid 
        = " . $userid[ 0 ] . " order by UNIX_TIMESTAMP(date) desc limit 1" );
        if ( $satus_show != null ) {

        $redemption_satus_show = $wpdb->insert( $redemption_meta_table, array( 'redemption_id' => $satus_show->id, 'optionid' => $option,
                                                                               'status'        => 'Approved', 'date' => date( 'Y-m-d H:i:s' ),'shipping'=>$shipping ) );

         }
    $currentuser = get_userdata( $satus_show->initiated_by );
   
    $get_history = get_history($userid[ 0 ]);
    $user = get_user_by( 'id', $satus_show->initiated_by );
    $approved_history = $wpdb->get_row( "select DATE(date)as `date` from $redemption_meta_table where redemption_id =" .
    $satus_show->id . " and status='Approved'  order by UNIX_TIMESTAMP(date) desc limit 1 " );
    $confirmed_array = array('action'=>'Send Reminder','status'=>'Approved',
    'initiated'=>$get_history,'approved'=>$approved_history->date,'user'=>$user->display_name);
    
   if($redemption_satus_show!=null){
        
       
        $wpdb->insert($comm_module_table, array('email_type' => 'Approved_type', 'recipients' => $satus_show->userid,
        'status' => 'To be send', 'priority' => 'Normal', 'date' => date('Y-m-d H:i:s')));
       
       
    }
    return $confirmed_array;
}

function set_rejected_redemption( $option, $username ) {

    $userid = get_users( array(
        "meta_key"   => "hash",
        "meta_value" => $username,
        "fields"     => "ID"
    ) );

    global $wpdb;
    $redemption_table      = $wpdb->prefix . "redemption";
    $redemption_meta_table = $wpdb->prefix . "redemption_meta";
    $comm_module_table = $wpdb->prefix . "comm_module";
    $comm_meta_table = $wpdb->prefix . "module_meta";
    $satus_show            = $wpdb->get_row( "select * from $redemption_table where 
        userid  = " . $userid[ 0 ] . " order by UNIX_TIMESTAMP(date) desc limit 1" );
    if ( $satus_show != null ) {

        $redemption_satus_show = $wpdb->insert( $redemption_meta_table, array( 'redemption_id' => $satus_show->id, 'optionid' => $option,
                                                                               'status'        => 'Redemption Not initiated', 'date' => date( 'Y-m-d H:i:s' ) ) );

    }

     $get_history = get_history($userid[ 0 ]);
    $user = get_user_by( 'id', $satus_show->initiated_by );
    $rejected_array = array('action'=>'Send Reminder','status'=>'Redemption Not initiated',
        'initiated'=>$get_history,'user'=>$user->display_name);
    
    if ($redemption_satus_show != null) {


        $wpdb->insert($comm_module_table, array('email_type' => 'Rejected_type', 'recipients' => $satus_show->userid,
            'status' => 'To be send', 'priority' => 'Normal', 'date' => date('Y-m-d H:i:s')));
      
    }
  
    return $rejected_array;

}

function set_final_redemption( $option, $username ,$date,$time,$address) {
    
       
        

    $userid = get_users( array(
        "meta_key"   => "hash",
        "meta_value" => $username,
        "fields"     => "ID"
    ) );

    global $wpdb;
    $redemption_table      = $wpdb->prefix . "redemption";
    $redemption_meta_table = $wpdb->prefix . "redemption_meta";
    $comm_module_table = $wpdb->prefix . "comm_module";
    $comm_meta_table = $wpdb->prefix . "module_meta";
    $satus_show            = $wpdb->get_row( "select * from $redemption_table where userid  
        = " . $userid[ 0 ] . " order by date desc limit 1" );
    if($date!="")
    {
        $confirmdate = $date."|".$time;
    }
    if($address!="")
    {
        add_user_meta($userid[ 0 ], 'address', $address);
    }
    if ( $satus_show != null ) {

             $initaited_history = $wpdb->get_row( "select * from $redemption_meta_table where redemption_id =" .
            $satus_show->id . "
                 and status='Initiated' || status='Approved'  order by UNIX_TIMESTAMP(date) desc limit 1 " );
             
             
       $redemption_satus_show = $wpdb->insert( $redemption_meta_table, array( 'redemption_id' => $satus_show->id, 'optionid' => $initaited_history->optionid,
                                                                               'status'        => 'Confirmed', 'date' => date('Y-m-d H:i:s'),'confirm_date'=> $confirmdate ) );

    }
    $argsa = array( 'role' => 'administrator' );
    $a     = get_users( $argsa );

    $argsb = array( 'role' => 'rewards_manager' );
    $b     = get_users( $argsb );
    
    $users_data = array_merge( $a, $b);

    if($redemption_satus_show!=null)
    {
    foreach ( (array) $users_data as $value ) {
        
        
        $wpdb->insert($comm_module_table, array('email_type' => 'Confirmed_type', 'recipients' => $value->user_email,
            'status' => 'To be send', 'priority' => 'Normal', 'date' => date('Y-m-d H:i:s')));
      $wpdb->insert($comm_meta_table, array('comm_module_id' => $wpdb->insert_id, 'key' => 'add_info',
            'value' => $userid[ 0 ]));

    }
     $wpdb->insert($comm_module_table, array('email_type' => 'Confirmed_PM_type', 'recipients' => $userid[ 0 ],
            'status' => 'To be send', 'priority' => 'Normal', 'date' => date('Y-m-d H:i:s')));
   //$date1  = explode('|',$redemption_satus_show->confirm_date);
    
    $newdate = strtotime ( '-2 day' , strtotime ( $date ) ) ;
    $newdate = date ( 'Y-m-d' , $newdate );
    $wpdb->insert($comm_module_table, array('email_type' => 'Reminder_PM_type', 'recipients' => $satus_show->userid,
            'status' => 'To be send', 'priority' => 'Normal', 'date' => $newdate." ".date('H:i:s')));
    }
    foreach((array) $b as $val){
        
        $wpdb->insert($comm_module_table, array('email_type' => 'Reminder_RM_type', 'recipients' => $val->user_email,
            'status' => 'To be send', 'priority' => 'Normal', 'date' => date('Y-m-d H:i:s')));
        $wpdb->insert($comm_meta_table, array('comm_module_id' => $wpdb->insert_id, 'key' => 'add_info',
            'value' => $userid[ 0 ]));
    }
    $arr = array('date'=>$date,'time'=>$time,'address'=>$address);
    return $arr;

}

function send_initiate_reminder($ID,$str){
    
        global $wpdb;
        $comm_module_table = $wpdb->prefix . "comm_module";
        $comm_meta_table = $wpdb->prefix . "module_meta";
        
        $user = get_user_by( 'id', $ID );
        
        //$to = $user->user_email;
        
        $wpdb->insert($comm_module_table, array('email_type' => 'Send_Reminder', 'recipients' => $user->user_email,
            'status' => 'To be send', 'priority' => 'Normal', 'date' => date('Y-m-d H:i:s')));
       
     $wpdb->insert($comm_meta_table, array('comm_module_id' => $wpdb->insert_id, 'key' => 'packages',
            'value' => $str));

}


function set_closure_email($ID){
    
        global $wpdb;
        $redemption_table      = $wpdb->prefix . "redemption";
        $redemption_meta_table = $wpdb->prefix . "redemption_meta";
        $comm_module_table = $wpdb->prefix . "comm_module";
        $comm_meta_table = $wpdb->prefix . "module_meta";
        
        $user = get_user_by( 'id', $ID );
        
        $satus_show            = $wpdb->get_row( "select * from $redemption_table where userid  
        = " . $ID . " order by date desc limit 1" );
    if ( $satus_show != null ) {

             $initaited_history = $wpdb->get_row( "select * from $redemption_meta_table where redemption_id =" .
                $satus_show->id . "
                 and status='Confirmed'  order by UNIX_TIMESTAMP(date) desc limit 1 " );
             
             
       $redemption_satus_show = $wpdb->insert( $redemption_meta_table, array( 'redemption_id' => $satus_show->id, 'optionid' => $initaited_history->optionid,
                                                                               'status'        => 'closed', 'date' => date('Y-m-d H:i:s') ) );

    }
       
        $wpdb->insert($comm_module_table, array('email_type' => 'Send_closure_PM', 'recipients' => $user->user_email,
            'status' => 'To be send', 'priority' => 'Normal', 'date' => date('Y-m-d H:i:s')));
        
        $argsb = array( 'role' => 'rewards_manager' );
        $b     = get_users( $argsb );
        
        foreach ( (array) $b as $value ) {
        
        
         $wpdb->insert($comm_module_table, array('email_type' => 'Send_closure_RM', 'recipients' => $value->user_email,
            'status' => 'To be send', 'priority' => 'Normal', 'date' => date('Y-m-d H:i:s')));

            $wpdb->insert($comm_meta_table, array('comm_module_id' => $wpdb->insert_id, 'key' => 'add_info',
                'value' =>$ID));
      

    }
       
    }


