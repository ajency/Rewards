<?php

function get_shippingdetails( $user_login, $option ) {

    $user_id     = get_users( array(
        "meta_key"   => "hash",
        "meta_value" => $user_login,
        "fields"     => "ID"
    ) );
    $single      = TRUE;
    $single_user = get_userdata( $user_id[ 0 ] );
    global $user_ID;
    global $wpdb;
    if ( is_user_logged_in() ) {


        $current_user = $user_ID;
    } else {
        $userid = get_users( array(
            "meta_key"   => "hash",
            "meta_value" => $username,
            "fields"     => "ID"
        ) );

        $current_user = $userid[ 0 ];
    }

    $currentuser = get_userdata( $current_user );
    $phone       = get_user_meta( $user_id[ 0 ], 'contactno', $single );
    global $wpdb;
    $shipping_array        = array();
    $redemption_table      = $wpdb->prefix . "redemption";
    $redemption_meta_table = $wpdb->prefix . "redemption_meta";
    $customers_table       = $wpdb->prefix . "customer";
    $referrals_table       = $wpdb->prefix . "referrals";
    $points_count          = $wpdb->get_var( "select sum(points) from $customers_table
inner join  $referrals_table on $customers_table.referral_id =  $referrals_table.ID
where user_id = " . $user_id[ 0 ] . "" );
    if ( $points_count == null ) {
        $points_count = 0;
    }

    $option_show = $wpdb->get_row( "select * from $redemption_table where userid  = " . $user_id[ 0 ] . " order by UNIX_TIMESTAMP(date) desc limit 1" );
    if ( $option_show != null ) {
       
        $redemption_option_show = $wpdb->get_row( "select DATE(date)as `date`,status,optionid from $redemption_meta_table where redemption_id =" . $option_show->id . "
             order by UNIX_TIMESTAMP(date) desc limit 1" );

        if ( $redemption_option_show != null ) {
            $redemption_date = $redemption_option_show->date;
            $redemption_status = $redemption_option_show->status;
            $option1          = $redemption_option_show->optionid;
        } else {
            $redemption_date = 0;
            $redemption_status = 'Redemption Not initiated';
            $option1          = "";
        }
    } else {
        $redemption_date = 0;
        $redemption_status = "Redemption Not initiated";
            $option1          = "";
    }


    $loop     = new WP_Query( array( 'Options' => $option ) );
    $template = "";
    while ( $loop->have_posts() ) : $loop->the_post();

        $product = get_post( $post->ID );
        if ( has_post_thumbnail( $post->ID ) ) {

            $post_thumbnail_id  = get_post_thumbnail_id( $post->ID );
            $post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
        } else {
            $image_url = "";
        }

        $product_details[ ] = array(
            'product_name'    => $product->post_title,
            'product_price'   => get_post_meta( $post->ID, 'product_price' ),
            'product_details' => $product->post_content,
            'product_img'     => $post_thumbnail_url
        );


    endwhile;
    $shipping_array[ ] = array(
        'option'          => $option,
        'ID'              => $option,
        'product_details' => $product_details,
        'sum_of_points'   => $points_count,
        'display_name'    => $single_user->display_name,
        'user_email'      => $single_user->user_email,
        'phone'           => $phone,
        'date'            => $redemption_date,
        'initiatedby'     => $currentuser->display_name,
        'status'          => $redemption_status

    );

    return $shipping_array;
}

function get_redemption_user( $username, $option ) {

    global $user_ID;
    global $wpdb;
    $comm_table = $wpdb->prefix . "comm_module";
$comm_meta_table = $wpdb->prefix . "module_meta";
    if ( is_user_logged_in() ) {

        $user_id      = get_users( array(
            "meta_key"   => "hash",
            "meta_value" => $username,
            "fields"     => "ID"
        ) );
        $user         = $user_id[ 0 ];
        $current_user = $user_ID;
    } else {
        $user_id      = get_users( array(
            "meta_key"   => "hash",
            "meta_value" => $username,
            "fields"     => "ID"
        ) );
        $user         = $user_id[ 0 ];
        $current_user = $user_id[ 0 ];
    }

    $single_user = get_userdata( $current_user );


    $redemption_table      = $wpdb->prefix . "redemption";
    $redemption_meta_table = $wpdb->prefix . "redemption_meta";
    $satus_show            = $wpdb->get_row( "select * from $redemption_table where userid  = " . $user . "" );

   

    $wpdb->insert( $redemption_table, array( 'userid' => $user, 'initiated_by' => $current_user,
                                             'date'   => date( 'Y-m-d H:i:s' ) ) );


   $insert =  $wpdb->insert( $redemption_meta_table, array( 'redemption_id' => $wpdb->insert_id, 'optionid' => $option,
                                                  'status'        => 'Initiated', 'date' => date( 'Y-m-d H:i:s' ) ) );

    $users = array(
        'display_name' => $single_user->display_name,
        'date'         => date( 'Y-m-d' )

    );
    
     $argsa = array( 'role' => 'administrator' );
    $a     = get_users( $argsa );

    $argsb = array( 'role' => 'rewards_manager' );
    $b     = get_users( $argsb );
    
    $users_data = array_merge( $a, $b);

    if($insert!=null)
    {
    foreach ( (array) $users_data as $value ) {
        
       
       
       $wpdb->insert($comm_table, array('email_type' => 'Initiated_type', 'recipients' => $value->user_email,
            'status' => 'To be send', 'priority' => 'Normal', 'date' => date('Y-m-d H:i:s')));
      
       $wpdb->insert($comm_meta_table, array('comm_module_id' => $wpdb->insert_id, 'key' => 'add_info',
            'value' => $user));

    }
    }
    return $users;
}


function get_shipping_points($ID,$option){
    
   
    global $wpdb;
    $rewards_array = array();
    $referrals_table = $wpdb->prefix . "referrals";
    $customers_table = $wpdb->prefix . "customer";
    $redemption_table      = $wpdb->prefix . "redemption";
    $redemption_meta_table = $wpdb->prefix . "redemption_meta";
    $points_count = $wpdb->get_var("select sum(points) from $customers_table
    inner join  $referrals_table on $customers_table.referral_id =  $referrals_table.ID
    where user_id = " . $ID . "");
    
    if($points_count=="")
    {
        $points_count = 0;
    }
    
   
     $satus_show = $wpdb->get_row( "select * from $redemption_table where userid  = " . $ID . " order by UNIX_TIMESTAMP(date) desc limit 1" );
    if ( $satus_show != null ) {
        
        $currentuser = get_userdata( $satus_show->initiated_by );
        
        $rejected_history = $wpdb->get_row( "select * from $redemption_meta_table where redemption_id =" .
            $satus_show->id . "
                 order by UNIX_TIMESTAMP(date) desc limit 1 " );
        
       $initaited_history = $wpdb->get_row( "select DATE(date)as `date` from $redemption_meta_table where redemption_id =" .
            $satus_show->id . "
                 and status='Initiated'  order by UNIX_TIMESTAMP(date) desc limit 1 " );
       
        
   
        if($rejected_history==null)
        {
            $count = 0;
            $date_approve = "0d";
        }
        else if($rejected_history->status == "Redemption Not initiated" )
        {
            $count = 0;
           $date_approve = "0d";
        }
        else if($rejected_history->status == "Initiated"){
     
                 $count = 1;
                 $date_approve = "0d";
        }
        else if($rejected_history->status == "Approved")
        {
            $count = 2;
            $date_confirm   = date( 'Y-m-d', strtotime( '+1 month', strtotime( $rejected_history->date ) ) );
            $date_approve = $date_confirm;
        }
        else if($rejected_history->status == "Confirmed")
        {
            $count = 3;
            $date_approve = "0d";

        }
        else if($rejected_history->status == "closed")
        {
            $count = 4;
            $date_approve = "0d";

        }
        
    }
    
 else {
        $count =0;
        $date_approve = "0d";
         
 
    }

    if($option == 'undefined')
    {
        $package = get_term_by('id', $rejected_history->optionid,'Options');
     $val = array('post_type' => 'Products',
        'tax_query' => array(
            array(
                'taxonomy' => 'Options',
                'field' => 'slug',
                'terms' => $package->slug,
            ),
        ),
     );
    $loop = new WP_Query($val);
      
      $option_val = $rejected_history->optionid;
    }
    else
    {
        $package = get_term_by('id', $option,'Options');
     $val = array('post_type' => 'Products',
        'tax_query' => array(
            array(
                'taxonomy' => 'Options',
                'field' => 'slug',
                'terms' => $package->slug,
            ),
        ),
     );
    $loop = new WP_Query($val);
      
      $option_val = $option;
    }
     $template = "";
    while ( $loop->have_posts() ) : $loop->the_post();

        $product = get_post( $post->ID );
        
        
        $template[] = $product->post_title;

        


    endwhile;


    $single = true;
      $address = get_user_meta($ID, 'address', $single);



    
    $package = get_term_by('id',  $option_val,'Options');
 
    $point_array = array('points'=>$points_count,'option'=>$count,'status'=>$rejected_history->status,
        'initiatedby'=>$currentuser->display_name,'date'=>$initaited_history->date,
        'approved_date'=>$date_approve,'confirm_date'=>$rejected_history->confirm_date,

        'optionid'=>$option_val,'option_name'=>$package->name,'product'=>$template,'shipping'=>$rejected_history->shipping,'address'=>$address);



    
    return $point_array;
    
}
