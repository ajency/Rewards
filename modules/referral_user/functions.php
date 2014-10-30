<?php

/* get referrals */

function get_referral( $user_id ) {

    global $wpdb;

    $referrals_table = $wpdb->prefix . "referrals";

    $list = $wpdb->get_results( "select * from $referrals_table" );

    foreach ( (array) $list as $value ) {

        $date_time  = explode( ' ', $value->date_time );
        $date_value = date( "M d,Y", strtotime( $date_time[ 0 ] ) );

        $customer_data = referral_exists_customer( $value->email );
        if ( $customer_data != 0 ) {
            $status = 'Converted';
        } else {

            $status = '';
        }
        $referral_array[ ] = array(
            'ID'      => $value->ID,
            'name'    => $value->name,
            'email'   => $value->email,
            'phone'   => $value->phone,
            'date'    => $date_value . " " . $date_time[ 1 ],
            'user_id' => $value->user_id,
            'points'  => $customer_data,
            'status'  => $status
        );
    }

    return $referral_array;
}

function referral_exists_customer( $email ) {

    global $wpdb;

    $customer_table = $wpdb->prefix . "customer";

    $list = $wpdb->get_row( "select * from $customer_table where email_id='" . $email . "'" );

    if ( $list != null ) {
        $points_value = $list->points;

        return $points_value;
    } else {

        $points_value = 0;

        return $points_value;
    }
}

