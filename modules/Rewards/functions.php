<?php

function get_rewards() {
    global $post;
    global $wpdb;
    $rewards_array = array();
    $referrals_table = $wpdb->prefix . "referrals";
    $customers_table = $wpdb->prefix . "customer";
    $redemption_table      = $wpdb->prefix . "redemption";
    $redemption_meta_table = $wpdb->prefix . "redemption_meta";
    $option_sort = get_terms('Options');
    
    foreach ( $option_sort as $Option ) {
     
           $term_meta = get_option( 'taxonomy' . $Option->term_id );
           $split_array = $term_meta;
           $opt_array_min[ $Option->slug] = $split_array;
           
           
     }
     
     asort($opt_array_min);
     
     
    $single = true;
    $user_id = get_users(array(
        "meta_key" => "hash",
        "meta_value" => $_REQUEST['username'],
        "fields" => "ID"
    ));


    $hash = get_user_meta($user_id[0], 'hash', $single);

    if ($hash == $_REQUEST['username']) {

        $referral_array = array();

        $referrlas = $wpdb->get_results("select * from $referrals_table where user_id=" . $user_id[0]);
        $counter = 0;
        $points_count = $wpdb->get_var("select sum(points) from $customers_table
inner join  $referrals_table on $customers_table.referral_id =  $referrals_table.ID
where user_id = " . $user_id[0] . "");
    }
    if($points_count=="")
    {
        $points_count = 0;
    }
    foreach($opt_array_min as $Options=>$value) {
        $product_details = array();
     
     $val = array('post_type' => 'Products',
        'tax_query' => array(
            array(
                'taxonomy' => 'Options',
                'field' => 'slug',
                'terms' => $Options,
            ),
        ),
     );
    $loop = new WP_Query($val);
        //$loop = new WP_Query(array('Options' => $Options));
        $template = "";
        while ($loop->have_posts()) : $loop->the_post();

            $product = get_post($post->ID);
            if (has_post_thumbnail($post->ID)) {

                $post_thumbnail_id = get_post_thumbnail_id($post->ID);
                $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
            } else {
                $image_url = "";
            }

            $product_details[] = array(
                'product_name' => $product->post_title,
                'product_price' => get_post_meta($post->ID, 'product_price'),
                'product_details' => $product->post_content,
                'product_img' => $post_thumbnail_url
                    
            );


        endwhile;
       
         $term_id = get_term_by( 'slug', $Options, 'Options');
       
    
        $term_meta = get_option( 'taxonomy' . $term_id->term_id );
        $split_term = $term_meta;
        
        if($points_count>=$split_term && $split_term != 0)
        {
            $disabled = "";
            $class = "";
        }
        else
        {
            $disabled = "disabled";
            $class = "disable-radio";
        }
        $archive = get_option("taxonomy_archive" . $term_id->term_id);
         $status ="";
    $satus_show = $wpdb->get_row( "select * from $redemption_table where userid  = " . $user_id[0] . " order by UNIX_TIMESTAMP(date) desc limit 1" );
    if ( $satus_show != null ) {

       
       
        $redemption_satus_show = $wpdb->get_row( "select * from $redemption_meta_table where redemption_id =" .
            $satus_show->id . " order by UNIX_TIMESTAMP(date) desc limit 1" );
        $status = $redemption_satus_show->status;
        
        $initaited_history = $wpdb->get_row( "select DATE(date)as `date` from $redemption_meta_table where redemption_id =" .
            $satus_show->id . "
                 and status='Initiated'  order by UNIX_TIMESTAMP(date) desc limit 1 " );
        
         $currentuser = get_userdata( $satus_show->initiated_by );
    }
   // $term = get_term_by('name',$redemption_satus_show->optionid,'Options');
    if($archive == 0)
    {
        $rewards_array[] = array(
            'option' => $term_id->name,
            'ID' => $term_id->term_id,
            'product_details' => $product_details,
            'sum_of_points' => $points_count,
            'disabled'      => $disabled,
            'classname'         => $class,
            'option_desc'   =>$term_id->description,
            'min'           =>$split_term,
            'max'           =>$split_term,
            'checked'      => '',    
            'status'       => $status,
            'selected'      => ''
            
        );
    }
    
        
    }


    return $rewards_array;
}

function save_redemption($username, $optionid) {

    
    global $wpdb;
    
    $redemption_table = $wpdb->prefix . "redemption";
    $redemption_meta_table = $wpdb->prefix . "redemption_meta";
    $single = true;
    
    $user_id = get_users(array(
        "meta_key" => "hash",
        "meta_value" => $username,
        "fields" => "ID"
    ));
    
    $program_member = get_userdata( $user_id[0] );
    
    $wpdb->insert($redemption_table, array('userid' => $user_id[0], 'initiated_by' => $user_id[0],
           'date' => date('Y-m-d H:i:s')));
    
   $wpdb->insert($redemption_meta_table, array('redemption_id' => $wpdb->insert_id, 'optionid' => $optionid,
           'status' => 'Awaiting Rewards Manager Input','date' => date('Y-m-d H:i:s')));
    
   $redemption_info = array('display_name' => $program_member->display_name,'date'=>date('Y-m-d H:i:s'));
    
  return $redemption_info;
}

function get_points($ID){
  
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
    $status ="";
    $satus_show = $wpdb->get_row( "select * from $redemption_table where userid  = " . $ID . " order by UNIX_TIMESTAMP(date) desc limit 1" );
    if ( $satus_show != null ) {

       
       
        $redemption_satus_show = $wpdb->get_row( "select * from $redemption_meta_table where redemption_id =" .
            $satus_show->id . " order by UNIX_TIMESTAMP(date) desc limit 1" );
        $status = $redemption_satus_show->status;
        
        $initaited_history = $wpdb->get_row( "select DATE(date)as `date` from $redemption_meta_table where redemption_id =" .
            $satus_show->id . "
                 and status='Initiated'  order by UNIX_TIMESTAMP(date) desc limit 1 " );
        
         $currentuser = get_userdata( $satus_show->initiated_by );
            $user = get_userdata( $ID );
         $option_val = $redemption_satus_show->optionid;
         if($status == "Redemption Not initiated"){
             
             $option_val = "";
         }
    }
   // $term = get_term_by('name',$redemption_satus_show->optionid,'Options');
    $arr = array('points'=>$points_count,'status'=>$status,'initiatedby'=>$currentuser->display_name,
        'date'=>$initaited_history->date,'option'=>$option_val,'display_name'=>$user->display_name);
    return $arr;
}