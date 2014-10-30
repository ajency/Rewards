<?php
/**
 * retrieves a list of customers
 * @global type $wpdb
 *
 * @param type  $user_login
 *
 * @return array of customers
 */
function get_customers( $user_login ) {

    global $wpdb;

    $referrals_table = $wpdb->prefix . "referrals";
    $customers_table = $wpdb->prefix . "customer";
    $single          = TRUE;

    $user_id = get_users( array(
        "meta_key"   => "hash",
        "meta_value" => $user_login,
        "fields"     => "ID"
    ) );


    $hash = get_user_meta( $user_id[ 0 ], 'hash', $single );

    if ( $hash == $user_login ) {

        $referral_array = array();

        $referrlas = $wpdb->get_results( "select * from $referrals_table where user_id=" . $user_id[ 0 ] );
        $counter   = 0;


        $points_count = $wpdb->get_var( "select sum(points) from $customers_table
                                    inner join  $referrals_table on $customers_table.referral_id =  $referrals_table.ID
                                     where user_id=" . $user_id[ 0 ] . " group by user_id" );
        if ( $points_count == "" ) {
            $points_count = 0;
        }
         $ref_count = 0;
        foreach ( (array) $referrlas as $value ) {

            $referrlas_data = $wpdb->get_row( "select * from $customers_table where referral_id=" . $value->ID );

            if ( $referrlas_data ) {
                $date = $referrlas_data->date_of_purchase;
                $term_meta = get_option('expiry_date');
                $date_expire   = date( 'Y-m-d', strtotime( '+'.$term_meta.' months', strtotime( $date ) ) );
                $date_import   = $referrlas_data->date_of_import;
                $date_purcahse = $referrlas_data->date_of_purchase;
                $points        = $referrlas_data->points;
                $ref_count =  $ref_count + 1;

            } else {
                $date = "--";
                //$date_expire = strtotime("+6 month", $date);
                $date_expire   = "--";
                $date_import   = "--";
                $date_purcahse = "--";
                $points        = 0;

               

            }
            $referral_array[ ] = array(
                'srno'             => $counter + 1,
                'referral_id'      => $value->id,
                'name'             => $value->name,
                'user_email'       => $value->email,
                'phone'            => $value->phone,
                'date_of_import'   => $date_import,
                'date_of_purchase' => $date_purcahse,
                'purchase_value'   => $referrlas_data->purchase_value,
                'date_of_expire'   => $date_expire,
                'points'           => $points,
                'sum_of_points'    => $points_count,
                'ref_count'        => $ref_count


            );

            $counter = $counter + 1;

        }
        
        if($referrlas==null){
                $referral_array= array(
                'srno'             => '--',
                'referral_id'      => '--',
                'name'             => '--',
                'user_email'       => '--',
                'phone'            => '--',
                'date_of_import'   => '--',
                'date_of_purchase' => '--',
                'purchase_value'   => '--',
                'date_of_expire'   =>'--',
                'points'           => '--',
                'sum_of_points'    => '0',
                'ref_count'        => '0'


            );
        }
        return $referral_array;

    } else {
        

        return $referral_array;
    }
}