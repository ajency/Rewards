<?php

function dashboard_info(){
    global $wpdb;
    $referrals_table = $wpdb->prefix . "referrals";
    $customers_table = $wpdb->prefix . "customer";
    $redemption_table      = $wpdb->prefix . "redemption";
    $redemption_meta_table = $wpdb->prefix . "redemption_meta";
    $users_table = "wp_users";
   
    $ref_count = $wpdb->get_var("select count(*) from $referrals_table");
    
    $args_num = array(
        'role'    => 'Programmember',
        'orderby' => 'ID',
        'order'   => 'ASC'


    );

    $users_num = get_users( $args_num );
  
   $date = date('Y-m-d');
    $olddate = strtotime ( '-7 day' , strtotime ( $date ) ) ;
    $olddate = date ( 'Y-m-d' , $olddate );
    
    $program_count = 0;
    foreach ($users_num as $value) {
        $date_time = explode(' ',$value->user_registered);
     
      
        if($date_time[0] >= $olddate && $date_time[0] <= $date)
        
            $program_count = $program_count + 1;
    }

    $pgm_count_last_week = $wpdb->get_results("select * from $users_table  where date(user_registered)
             >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
             and date(date_time) < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY ");
     
     $pgm_count_last_week = count($pgm_count_last_week);
     
     $pgm_count_previous_day = $wpdb->get_results("select * from $users_table  where date(user_registered)
             BETWEEN CURDATE() - INTERVAL 1 DAY AND CURDATE() ");
     
     $pgm_count_previous_day = count($pgm_count_previous_day);
    
     $ref_count_last_week = $wpdb->get_results("select * from $referrals_table  where date(date_time)
             >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
             and date(date_time) < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY ");
     
     $ref_count_last_week = count($ref_count_last_week);
     
     $ref_count_previous_day = $wpdb->get_results("select * from $referrals_table  where date(date_time)
             BETWEEN CURDATE() - INTERVAL 1 DAY AND CURDATE() ");
     
     $ref_count_previous_day = count($ref_count_previous_day);
     
     $converted_count = $wpdb->get_var("select distinct(count(c.referral_id)) from wp_customer as c
             Inner JOIN wp_referrals r on r.ID = c.referral_id
                where c.referral_id != 0");
    $program_member_count = $wpdb->get_var("select distinct(count(r.user_id)) from $customers_table as c
             Inner JOIN $referrals_table r on r.ID = c.referral_id");
    $points_count = $wpdb->get_var("select sum(points) from $customers_table as c
             Inner JOIN $referrals_table r on r.ID = c.referral_id");
    
    
    
    $redem_count = $wpdb->get_var("select count(*) from $redemption_table as r
             Inner JOIN $redemption_meta_table m on m.redemption_id = r.id where m.status='Inititated'
            and ( m.status!='Approved' Or m.status!='Confirmed' Or m.status!='Closed' Or m.status!='Redemption Not Initiated')");
     
    $redem_count_last_week = $wpdb->get_var("select count(*) from $redemption_meta_table  where date(date)
             >= curdate() - INTERVAL DAYOFWEEK(curdate())+6 DAY
             and date(date) < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY and status='Confirmed'");
    
    $redem_count_yesterday = $wpdb->get_var("select count(*) from $redemption_meta_table  where date(date)
             BETWEEN CURDATE() - INTERVAL 1 DAY AND CURDATE()  and status='Confirmed'");
     $dahboard_array = array(
       'program_count'               =>   $program_count,
       'program_count_last_week'     =>   $pgm_count_last_week,
       'program_count_previous_day'  =>   $pgm_count_previous_day,
       'ref_count'                   =>   $ref_count,
       'ref_last_week_count'         =>   $ref_count_last_week,
       'ref_previous_day_count'      =>   $ref_count_previous_day,
       'conversion_count'            =>   $converted_count,
       'points'                      =>   $points_count,
       'redem_count'                 =>   $redem_count,
       'redem_last_week'             =>   $redem_count_last_week,
       'redem_yesterday'             =>   $redem_count_yesterday,
       'program_member_count'        =>   $program_member_count
         
     );
     
     
     return $dahboard_array;
}
