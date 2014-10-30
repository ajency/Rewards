<?php

/* create a program member */

function create_program_member($args) {

    $user_id = wp_insert_user(array(
        'user_login' => $args['program_member_email'],
        'display_name' => $args['program_member_name'],
        'user_email' => $args['program_member_email'],
        'role' => 'Programmember'
            ));


    //add_user_meta($user_id, 'customer', $args['customer']);

    add_user_meta($user_id, 'contactno', $args['program_member_phone']);

    $hash_value = md5($args['program_member_email']);

    add_user_meta($user_id, 'hash', $hash_value);

    check_customer($args['program_member_email'],$args['program_member_phone'],$user_id);

    return $user_id;
}

/* check if referral exists based on email */

function referral_email_exists($parameter, $argument, $params, $args) {

    global $wpdb;

    $referrals_table = $wpdb->prefix . "referrals";
    $customer_table = $wpdb->prefix . "customer";
    $users_table = $wpdb->prefix . "users";
    $flag = 0;
    $ref_email = 0;
    $cus_email = 0;
    $user_email = 0;
    $user_phone = 0;
    //echo "select * from $referrals_table where " . $argument . "='" . $parameter . "'";
    $referral_email = $wpdb->get_row("select * from $referrals_table where " . $argument . "='" . $parameter . "'");
    if ($referral_email->email != "") {
        $ref_email = 1;
    }


    if (( $params != "" ) && ( $args != "" )) {
        //echo   "select * from $referrals_table where " . $args . "='" . $params . "'";
        $referral_phone = $wpdb->get_row("select * from $referrals_table where " . $args . "='" . $params . "'");
        //echo $referral_phone->phone;
        if ($referral_phone->phone != "") {
            $flag = 1;
        }
     
    }


    $flag1 = 0;
    // echo "select * from $customer_table where email_id='" . $parameter . "' and referral_id IS NOT NULL";
    $customer_email = $wpdb->get_row("select * from $customer_table where email_id='" . $parameter . "' and referral_id IS NOT NULL");
    if ($customer_email->email_id != "") {
        $cus_email = 1;
    }

    if (( $params != "" ) && ( $args != "" )) {
        // echo "select * from $customer_table where " . $args . "='" . $params . "' and referral_id IS NOT NULL";
        $customer_phone = $wpdb->get_row("select * from $customer_table where " . $args . "='" . $params . "' and referral_id IS NOT NULL");
        //echo $customer_phone->phone;
        if ($customer_phone->phone != "") {
            $flag1 = 1;
        }
    }
$phone ="";
        if(email_exists($parameter))
        {
            $user_email = 1;
        }
        if($params!="")
        {
        $phone = get_users('meta_value='.$params.'');
        if($phone!=null){
            
             $user_phone = 1;
            
        }
        }
    
        
        
        
    if (( ( $ref_email == 1 ) || ( $flag == 1 ) ) || ( ( $cus_email == 1 ) || ( $flag1 == 1 ) ) || (($user_email == 1) || ($user_phone==1))) {

        return TRUE;
    } else {

        return FALSE;
    }
}

/* create referral */

function create_referral($referrals) {

    global $wpdb;
    $referrals_table = $wpdb->prefix . "referrals";
    $flag = 0;
    foreach ((array) $referrals as $value) {


        $wpdb->insert($referrals_table, array('name' => $value['referral_name'], 'email' => $value['referral_email'],
            'city' => $value['referral_city'], 'phone' => $value['referral_phone'], 'user_id' => $value['program_memeber_id'],
            'status' => $value['status'], 'date_time' => date('Y-m-d H:i:s')));
        $flag = 1;
    }
    if ($flag == 1)
        return TRUE;
    else
        return FALSE;
}

/* get program member  email */

function get_program_member_user($email, $customer, $phone) {

    global $wpdb;
    $referrals_table = $wpdb->prefix . "users";

    $user_id = $wpdb->get_var("SELECT ID from $referrals_table where user_email='" . $email . "'");
    $single = TRUE;
    $customer = get_user_meta($user_id, 'customer', $single);
    /* if($customer==""){
      add_user_meta($user_id, 'customer', $customer);}
      else {
      update_user_meta($user_id, 'customer', $customer);
      } */

    $hash_value = md5($email);
    $hash = get_user_meta($user_id, 'hash', $single);
    if ($hash == "") {
        add_user_meta($user_id, 'hash', $hash_value);
    } else {
        update_user_meta($user_id, 'hash', $hash_value);
    }
    $contactno = get_user_meta($user_id, 'contactno', $single);
    if ($contactno == "") {
        add_user_meta($user_id, 'contactno', $phone);
    } else {
        update_user_meta($user_id, 'contactno', $phone);
    }
    check_customer($email,$phone,$user_id);

    return $user_id;
}

/* data saved for the mail purpose */

function insert_mail_info($referrals_accepted, $program_member, $referrals_rejected, $phone_aceepted, $phone_rejected, $name_rejected, $city_rejected) {


    global $wpdb;
    $comm_module_table = $wpdb->prefix . "comm_module";
    $comm_meta_table = $wpdb->prefix . "module_meta";

    $referral_accepted_tring = "";
    $referral_rejected_string = "";
    $referral_rejected_name_string = "";
    $referral_rejected_city_string = "";
    $referral_accepted_string_arr = array();
    $referral_rejected_string_arr = array();
    $referral_rejected_name_arr = array();
    $referral_rejected_city_arr = array();
    $referral_rejected_phone_arr = array();
   

    foreach ($referrals_accepted as $key => $value) {

        $referral_accepted_string_arr[] = $referrals_accepted[$key];
    }
    foreach ($referrals_rejected as $key => $value) {

        $referral_rejected_string_arr[] = $referrals_rejected[$key];
    }
    foreach ($name_rejected as $key => $value) {

        $referral_rejected_name_arr[] = $name_rejected[$key];
    }
    foreach ($city_rejected as $key => $value) {

        $referral_rejected_city_arr[] = $city_rejected[$key];
    }
    foreach ($phone_rejected as $key => $value) {

        $referral_rejected_phone_arr[] = $phone_rejected[$key];
    }
    $referral_accepted_tring = implode(',', $referral_accepted_string_arr);
    $referral_rejected_string = implode(',', $referral_rejected_string_arr);
    $referral_rejected_name_string = implode(',', $referral_rejected_name_arr);
    $referral_rejected_city_string = implode(',', $referral_rejected_city_arr);
    $referral_rejected_phone_string = implode(',', $referral_rejected_phone_arr);

    if (( count($referrals_accepted) > 0 ) || ( count($referrals_rejected) > 0 )) {
        $wpdb->insert($comm_module_table, array('email_type' => 'Program_Member_Type', 'recipients' => $program_member,
            'status' => 'To be send', 'priority' => 'Normal', 'date' => date('Y-m-d H:i:s')));
    }
    $insert = $wpdb->insert_id;
    if (count($referrals_accepted) > 0) {
        $wpdb->insert($comm_meta_table, array('comm_module_id' => $insert, 'key' => 'referral_accepted_referrals',
            'value' => $referral_accepted_tring));


        $wpdb->insert($comm_module_table, array('email_type' => 'Referral_Type', 'recipients' => $referral_accepted_tring,
            'status' => 'To be send', 'priority' => 'Normal', 'date' => date('Y-m-d H:i:s')));

        $wpdb->insert($comm_meta_table, array('comm_module_id' => $wpdb->insert_id, 'key' => 'referrer_data',
            'value' => $program_member));
    }

    if (count($referrals_rejected) > 0) {
        $wpdb->insert($comm_meta_table, array('comm_module_id' => $insert, 'key' => 'referral_rejected_referrals',
            'value' => $referral_rejected_string . '|' . $referral_rejected_name_string . '|' . $referral_rejected_city_string.'|'.$referral_rejected_phone_string));
    }

    # include 'comm_module.php';
}

function referral_email_exists_incustomer($parameter, $argument, $params, $args) {

    global $wpdb;

    $customer_table = $wpdb->prefix . "customer";
    $flag = 0;
    $referral_email = $wpdb->get_row("select * from $customer_table where " . $argument . "='" . $parameter . "' ");
    if (( $params != "" ) && ( $args != "" )) {
        $referral_phone = $wpdb->get_row("select * from $customer_table where " . $args . "='" . $params . "'");
        if ($referral_phone->phone == "") {
            $flag = 1;
        }
    }

    if (( $referral_email->email != "" ) && ( $flag == 0 )) {

        return TRUE;
    } else {

        return FALSE;
    }
}

function check_customer($email,$phone,$user_id){

    global $wpdb;

    $customer_table = $wpdb->prefix . "customer";
    $flag = 0;
    $referral_email = $wpdb->get_row("select * from $customer_table where email='" . $email . "'");

        $referral_phone = $wpdb->get_row("select * from $customer_table where phone='" . $phone . "'");
        if ($referral_phone->phone == "") {
            $flag = 1;
        }


    if (( $referral_email->email != "" ) || ( $flag == 0 )) {

        update_user_meta( $user_id, 'customer', 'true' );
    }
}