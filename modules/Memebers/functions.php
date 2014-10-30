<?php

/* code to return an array of program users */

function fetch_program_members($args = array(), $sort) {

    $defaults = array(
        'role' => 'Programmember',
        'orderby' => 'ID',
        'order' => 'ASC',
        'offset' => 0,
        'number' => 0
    );

    $args = wp_parse_args($args, $defaults);

    $users = get_users($args);

    foreach ((array) $users as $value) {

        $user_array[] = get_program_member($value->ID);
    }

    if ($sort != "") {

        usort($user_array, $sort);
    }



    return $user_array;
}


/* get a program member */

function get_program_member($user_ID = 0) {


    global $wpdb;
   
    $referrals_table = $wpdb->prefix . "referrals";
    $customer_table = $wpdb->prefix . "customer";
    $users_table = $wpdb->prefix . "users";
    $redemption_table = $wpdb->prefix . "redemption";
    $redemption_meta_table = $wpdb->prefix . "redemption_meta";
    $user_ID = (int) $user_ID;

    if ($user_ID === 0) {
        $user_ID = get_current_user_id();
    }

    $single_user = get_userdata($user_ID);

    $date_time = explode(' ', $single_user->user_registered);
    // $date_value = date("M d,Y", strtotime($date_time[0]));
    $date_value = $date_time[0];
    $single = TRUE;

    //$customer = get_user_meta( $user_ID, 'customer', $single );
    $hash = get_user_meta($user_ID, 'hash', $single);
    $phone = get_user_meta($user_ID, 'contactno', $single);

    $user_count = $wpdb->get_var("SELECT COUNT(*) FROM $referrals_table where user_id=" . $user_ID);

    $points = $wpdb->get_var("select sum(points) from $customer_table
    inner join  $referrals_table on $customer_table.referral_id =  $referrals_table.ID
    where user_id = " . $user_ID . "");

    if ($points != null) {
        $points_count = $points;
    } else {
        $points_count = (int) 0;
    }


    $purchased_ref_count = $wpdb->get_var("select count(*) from $customer_table
    inner join  $referrals_table on $customer_table.referral_id =  $referrals_table.ID
    where user_id = " . $user_ID . "");
    $rejected_status = 0;

    $satus_show = $wpdb->get_row("select * from $redemption_table where userid  = " . $user_ID . " order by UNIX_TIMESTAMP(date) desc limit 1");
    if ($satus_show != null) {



        $redemption_satus_show = $wpdb->get_row("select * ,DATE(date)as `date` from $redemption_meta_table where redemption_id =" .
                $satus_show->id . " order by UNIX_TIMESTAMP(date) desc limit 1");



        $redemption_status = $redemption_satus_show->status;
        $redemption_action = get_redemption_action($redemption_status);

       
        $confirmed_history = $wpdb->get_row("select DATE(date)as `date`,confirm_date from $redemption_meta_table where redemption_id =" .
                $satus_show->id . "
                 and status='Confirmed'  order by UNIX_TIMESTAMP(date) desc limit 1 ");
        $arr = explode('|', $confirmed_history->confirm_date);


        $approved_history = $wpdb->get_row("select DATE(date)as `date` from $redemption_meta_table where redemption_id =" .
                $satus_show->id . "
                 and status='Approved'  order by UNIX_TIMESTAMP(date) desc limit 1 ");

        $get_history = get_history($user_ID);
        $user = get_user_by( 'id', $satus_show->initiated_by );
    } else {
        $user = "";
        $rejected_status = 1;
        $redemption_status = "Redemption Not initiated";
        $redemption_action = array('action' => 'Send Reminder', 'sep' => "", 'action2' => "");
    }
    $single = true;
    $customer = get_user_meta($single_user->ID, 'customer', $single);

    if ($customer == 'true') {
        $cus_val = 'Yes';
    } else {
        $cus_val = 'No';
    }
    $option = get_options();
    $ref_under_dicussion = $user_count - $purchased_ref_count;
    $user_info = array(
        'ID' => $single_user->ID,
        'display_name' => $single_user->display_name,
        'role' => get_user_role($single_user->ID),
        'user_registered' => $date_value,
        'user_email' => $single_user->user_email,
        'referral_count' => $user_count,
        'customer' => $customer,
        'user_login' => $hash,
        'phone' => $phone,
        'points' => $points_count,
        'purchased_ref' => $purchased_ref_count,
        'ref_discussion' => $ref_under_dicussion,
        'status' => $redemption_status,
        'action' => $redemption_action['action'],
        'confirmed' => $confirmed_history->date,
        'redem_date' => $redemption_satus_show->date,
        'option' => $redemption_satus_show->optionid,
        'date_confirm' => $arr[0],
        'rejected_status' => $rejected_status,
        'user_role' => get_user_role(get_current_user_id()),
        'customer_val' => $cus_val,
        'history'       => $get_history,
        'user'          => $user->display_name
    );

    return $user_info;
}

function get_redemption_action($status) {


    if ($status == 'Approved' || $status == 'Redemption Not initiated' || $status == 'Rejected') {
        $action = 'Send Reminder';
    } elseif ($status == 'Initiated') {
        $action = 'Confirm';
    }

    $action = array('action' => $action);

    return $action;
}

function get_pm_model($userid) {

    $user = get_program_member($userid);

    return $user;
}

function get_history($user_ID){
    
     global $wpdb;
     $ini_arr = array();
     $redemption_table = $wpdb->prefix . "redemption";
     $redemption_meta_table = $wpdb->prefix . "redemption_meta";
    
    $initaited_history = $wpdb->get_results("SELECT status,DATE(m.date)as `date` FROM $redemption_table as r
        inner join $redemption_meta_table m on m.redemption_id  = r.id
        where userid = " . $user_ID . " order by DATE(m.date) desc ");

        if ($initaited_history != null) {

            foreach ((array) $initaited_history as $value) {
                
                if($value->status == 'Redemption Not initiated')
                {
                    $value->status = 'Rejected';
                }

                $ini_arr[] = array(
                    'history_status' => $value->status,
                    'history_date'  => $value->date
                        
                        );
            }
        }
        
        return $ini_arr;
}
