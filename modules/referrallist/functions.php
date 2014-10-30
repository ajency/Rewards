<?php

function get_referrallist() {

    global $wpdb;
    $referrallist    = array();
    $referrals_table = $wpdb->prefix . "referrals";
    $users_table     = $wpdb->prefix . "users";
     $customers_table = $wpdb->prefix . "customer";

    $referral_list = $wpdb->get_results( "select * from $referrals_table" );
    $oldest_Date = $wpdb->get_row( "select  DATE(date_time) as olddate from wp_referrals where DATE(date_time) <> '0000-00-00' order by DATE(date_time)  ASC limit 1");
    $current_Date = date('Y-m-d');
    foreach ( (array) $referral_list as $value ) {

        $program_member = get_userdata( $value->user_id );
        
        $referrlas_data = $wpdb->get_row( "select * from $customers_table where referral_id=" . $value->ID );
        
        if($referrlas_data!=null){
            
            $status = 'Converted';
            $date  = $referrlas_data->date_of_import;
        }
        else {
        $status = $value->status;
         $date = "";
        }
        $exact_date = explode(' ',$value->date_time);
        
        
        $referrallist[ ] = array(

            'ID'           => $value->ID,
            'display_name' => $value->name,
            'date'         => $value->date_time,
            'program_name' => $program_member->display_name,
            'status'       => $status,
            'date_import'  => $date,
            'datevalue'    => $exact_date[0],
            'old'          =>$oldest_Date->olddate,
            'current'      =>$current_Date
        );
    }
    $new_Array = array('id'=>1,'collection'=>$referrallist,'old'=>$oldest_Date->olddate,'current'=>$current_Date);
    
    return $referrallist ;
}

function export_csv($args){
    
    global $wpdb;
  
    $from_date = $args['from_date'];
    $to_date = $args['to_date'];
    
  if( ($from_date!="") && ($to_date!="")){
      
      $condition = " where date(date_time) between
            '$from_date' and '$to_date'"; 
  }
  if( ($from_date!="") && ($to_date=="")){
      
      $condition = "  where  date(date_time) >= '$from_date' "; 
  }
 if( ($from_date=="") && ($to_date!="")){
      
      $condition = " where date(date_time) <= '$to_date' "; 
  }
     
    
    $referrallist    = array();
    $referrals_table = $wpdb->prefix . "referrals";
    $users_table     = $wpdb->prefix . "users";
    $customers_table = $wpdb->prefix . "customer";

    $referral_list = $wpdb->get_results( "select * from $referrals_table $condition" );
     foreach ( (array) $referral_list as $value ) {
         $single = true;
        $program_member = get_userdata( $value->user_id );
        $user_phone    = get_user_meta( $value->user_id, 'contactno', $single );
        $referrlas_data = $wpdb->get_row( "select * from $customers_table where referral_id=" . $value->ID );
         $exact_date = explode(' ',$value->date_time);
        if($referrlas_data!=null && $args['status2'] == 'true'){
            
            $status = 'Converted';
            $date  = $referrlas_data->date_of_import;
            $referrallist[ ] = array(

           
            'display_name' => $value->name,
            'email'        => $value->email,
            'phone'        => $value->phone,
            'program_name' => $program_member->display_name,
            'user_email'   => $program_member->user_email,
            'user_phone'   => $user_phone,
            'status'       => $status,
            'date'         => $value->date_time
           
        );
        }
         if(($referrlas_data == null) &&  ($args['status1']) == 'true') {
       $status = $value->status;
         $date = "";
         $referrallist[ ] = array(

           
            'display_name' => $value->name,
            'email'        => $value->email,
            'phone'        => $value->phone,
            'program_name' => $program_member->display_name,
            'user_email'   => $program_member->user_email,
            'user_phone'   => $user_phone,
            'status'       => $status,
            'date'         => $value->date_time
           
        );
        }
       
        
    }
    
   
    
    $output = "";
   
  $heading = array("Name","Email","Phone","Program Member Name","Program Member Email","Program Member Phone",
      "Date Added on","Status");

for ($i = 0; $i < count($heading); $i++) {

$output .= '"'.$heading[$i].'",';
}
$output .="\n";
    foreach ($referrallist as $value) {
        
    $output.=$value['display_name'].",".$value['email'].",".$value['phone'].",".$value['program_name'].
        ",".$value['user_email'].",".$value['user_phone'].",".$value['date'].",".$value['status'];

//$output .='"'.$value['display_name'].'","'.$value['email'].'","'.$value['phone'].'","'.$value['program_name'].'",
    //"'.$value['user_email'].'","'.$value['user_phone'].'","'.$value['status'].'","'.$value['date'].'"';

$output .="\n";
}

// Download the file

$filename = "myFile".strtotime('now').".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

echo $output;
exit;
}


