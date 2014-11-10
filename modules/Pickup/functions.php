<?php

function get_pickup() {


    global $wpdb;
    $pickup_details  = array();
    $redemption_table = $wpdb->prefix . "redemption";
    $redemption_meta_table = $wpdb->prefix . "redemption_meta";
    $query = "SELECT * , MONTH( SUBSTRING_INDEX( confirm_date,  '|', 1 ) ) as month,
        MONTHNAME( SUBSTRING_INDEX( confirm_date,  '|', 1 ) ) as monthname,
        YEAR( SUBSTRING_INDEX( confirm_date,  '|', 1 ) ) as yearname
FROM  $redemption_meta_table
 where status='Confirmed' and confirm_date <> ''
    group  BY YEAR( SUBSTRING_INDEX( confirm_date,  '|', 1 ) ) ";

    $pick_result = $wpdb->get_results($query);

    foreach ($pick_result as $value) {

        $sub_query = "SELECT * , DAYOFMONTH( SUBSTRING_INDEX( confirm_date,  '|', 1 ) ) as dayofmonth, MONTHNAME( SUBSTRING_INDEX( confirm_date,  '|', 1 ) ) as monthname,MONTH( SUBSTRING_INDEX( confirm_date,  '|', 1 ) ) as month ,GROUP_CONCAT(r.initiated_by)  as initiated_by

FROM  $redemption_meta_table as m
INNER JOIN $redemption_table r on r.id = m.redemption_id
WHERE YEAR( SUBSTRING_INDEX( confirm_date,  '|', 1 ) ) = $value->yearname group by 
MONTH( SUBSTRING_INDEX( confirm_date,  '|', 1 ) ) order by MONTH( SUBSTRING_INDEX( confirm_date,  '|', 1 ) ) ";
         $sub_pick_result = $wpdb->get_results($sub_query);
         foreach ((array)$sub_pick_result as $sub_value) {

    $sub_query1 = "SELECT * , DAYOFMONTH( SUBSTRING_INDEX( confirm_date,  '|', 1 ) ) as dayofmonth, MONTH( SUBSTRING_INDEX( confirm_date,  '|', 1 ) ) as month ,GROUP_CONCAT(r.initiated_by)  as initiated_by

FROM  $redemption_meta_table as m
INNER JOIN $redemption_table r on r.id = m.redemption_id
WHERE MONTH( SUBSTRING_INDEX( confirm_date,  '|', 1 ) ) = $sub_value->month
group  by DAYOFMONTH( SUBSTRING_INDEX( confirm_date,  '|', 1 ) ) order by DAYOFMONTH( SUBSTRING_INDEX( confirm_date,  '|', 1 ) )";
             $date_details = array();
        $sub_pick_result1 = $wpdb->get_results($sub_query1);
         foreach ((array)$sub_pick_result1 as $sub_value1) {
             $user_array = array();
             $user_string = explode(',',$sub_value1->userid);
             for($i=0;$i<count($user_string);$i++){
                 
                 $user = get_userdata($user_string[$i]);  
                 $single = true;
                 $hash = get_user_meta($user->ID, 'hash', $single);
                 $user_array [] = array(
                     
                     'name'   => $user->display_name,
                     'hash'   => $hash,
                     'user_id'  =>$user->ID
                         );
                 
             }
             $ii = $sub_value1->dayofmonth;
            $j = $ii % 10;
         $k = $ii % 100;
    if ($j == 1 && $k != 11) {
        $date_val =  $ii."st";
    }
    else if ($j == 2 && $k != 12) {
        $date_val =  $ii."nd";
    }
    else if ($j == 3 && $k != 13) {
       $date_val = $ii."rd";
    }
    else
    {
   $date_val = $ii."th";
    }
    
        $date_details[] = array(
            
            'date_array'           => $date_val,
            'name_array'           => $user_array
            
        );
        
         }
         
         
         $pickup_details[] = array(
            
            'month'     => $sub_value->monthname,
            'date'          => $date_details,
            'year'          => $value->yearname
            
        );
    }
}
    
    return $pickup_details;
}