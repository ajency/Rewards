<?php

function get_inventory(){
    
  /*  $Option = get_terms('Options', array(
 	'hide_empty' => 0));
    $inventory_details = Array();
    $count = 0;
    foreach ($Option as $Options) {
        
       global $user_ID;
       global $wpdb;
       $redemption_table      = $wpdb->prefix . "redemption";
       $redemption_meta_table = $wpdb->prefix . "redemption_meta";
        
       $confirmed_Count = $wpdb->get_var( "select count(*) from $redemption_meta_table 
           where status='Confirmed' and optionid='".$Options->term_id."' group by optionid" );
       
       $initiated_Count = $wpdb->get_var( "select count(*) from $redemption_meta_table 
           where status='Initiated' and optionid='".$Options->term_id."' group by optionid" );
       
       $approved_Count = $wpdb->get_var( "select count(*) from $redemption_meta_table 
           where status='Approved' and optionid='".$Options->term_id."' group by optionid" );
       
       $closed_Count = $wpdb->get_var( "select count(*) from $redemption_meta_table 
           where status='Closed' and optionid='".$Options->term_id."' group by optionid" );
        
  
        $loop = new WP_Query(array('Options' => $Options->name));

        var_dump($Options->name);

        $template = "";
        $sum = 0;
        $term_meta = get_option('taxonomy' . $Options->term_id);
        $archive =  get_option("taxonomy_archive" . $Options->term_id);
    
        $term_string =  $term_meta;
        while ($loop->have_posts()) : $loop->the_post();

            $product = get_post($post->ID);
           
            
            $count = $count + 1 ;

            $inventory_details[] = array(
                'ID'                    => $count,
                'opt_id'                => $Options->term_id,
                'product_name'          => $product->post_title,
                'option_name'           => $Options->name,
                'Confirmed_count'       => $confirmed_Count,
                'Initiated_count'        => $initiated_Count,
                'Approved_count'        => $approved_Count,
                'Closed_Count'          => $closed_Count
            );
            
          
            
           
            
        endwhile;
      
        
        
    }
    */

    global $user_ID;
    global $wpdb;
    $count = 0;
    $inventory_details = array();
    $query = "SELECT redemption_data.optionid as optionid,options.name as package,
              object_id,post_title as product,
             SUM(confirm_status_count) as confirm_status_count,
             SUM(closed_status_count) as closed_status_count,
             SUM(initiated_status_count) as initiated_status_count,
             SUM(approved_status_count) as approved_status_count
              FROM
              (SELECT  optionid,
              SUM(CASE WHEN  status = 'Confirmed'  THEN 1 ELSE 0 END )AS confirm_status_count,
              SUM(CASE WHEN  status = 'Closed'  THEN 1 ELSE 0 END) AS closed_status_count,
              SUM(CASE WHEN  status = 'Initiated'  THEN 1 ELSE 0 END) AS initiated_status_count,
              SUM(CASE WHEN  status = 'Approved'  THEN 1 ELSE 0 END) AS approved_status_count
              FROM
              (SELECT redemption_meta.optionid,redemption_meta.status
              FROM " . $wpdb->prefix . "redemption_meta redemption_meta
              WHERE redemption_meta.id =
              (SELECT max(redemption_meta_distinct_latest.id) FROM " . $wpdb->prefix . "redemption_meta redemption_meta_distinct_latest
              WHERE redemption_meta_distinct_latest.redemption_id = redemption_meta.redemption_id ) and redemption_meta.status!='Redemption Not Initiated'
              GROUP BY    redemption_id)  AS redemtion_option_last_status
              GROUP BY optionid) AS redemption_data
              JOIN " . $wpdb->prefix . "term_relationships
              ON term_taxonomy_id = redemption_data.optionid
              JOIN " . $wpdb->prefix . "posts products on object_id = products.ID
              JOIN " . $wpdb->prefix . "terms options on optionid = options.term_id group by products.ID";


    $invetory_result = $wpdb->get_results($query);
 
    foreach($invetory_result as $invetory){
       
       $count = $count + 1 ;
       
       $inventory_details[] = array(
                'ID'                    => $count,
                'opt_id'                => $invetory->optionid,
                'product_name'          => $invetory->product,
                'option_name'           => $invetory->package,
                'Confirmed_count'       => $invetory->confirm_status_count,
                'Initiated_count'       => $invetory->initiated_status_count,
                'Approved_count'        => $invetory->approved_status_count,
                'Closed_Count'          => $invetory->closed_status_count
            );

    }
    return $inventory_details;
}


function get_inventory_package(){

     global $user_ID;
    global $wpdb;
    $count = 0;
    $inventory_details = array();
    $query = "SELECT redemption_data.optionid,
options.name as package,
              object_id,post_title as product,
            confirm_status as confirm_status_count,
             closed_status as closed_status_count,
             initiated_status as initiated_status_count,
             approved_status as approved_status_count
FROM
(SELECT  optionid,
SUM(CASE WHEN  status = 'Confirmed'  THEN 1 ELSE 0 END )AS confirm_status,
SUM(CASE WHEN  status = 'Closed'  THEN 1 ELSE 0 END) AS closed_status,
SUM(CASE WHEN  status = 'Initiated'  THEN 1 ELSE 0 END) AS initiated_status,
SUM(CASE WHEN  status = 'Approved'  THEN 1 ELSE 0 END) AS approved_status
FROM
(SELECT rm.optionid,rm.status
FROM " . $wpdb->prefix . "redemption_meta rm
WHERE rm.id =
(SELECT max(rm2.id) FROM " . $wpdb->prefix . "redemption_meta rm2
WHERE rm2.redemption_id = rm.redemption_id )
GROUP BY    redemption_id)  AS result
GROUP BY optionid) AS redemption_data
JOIN " . $wpdb->prefix . "term_relationships TR
ON term_taxonomy_id = redemption_data.optionid
JOIN " . $wpdb->prefix . "posts products on object_id = products.ID
JOIN " . $wpdb->prefix . "terms options on optionid = options.term_id";

    $invetory_result = $wpdb->get_results($query);

    foreach($invetory_result as $invetory){

        $count = $count + 1 ;

        $inventory_details[] = array(
            'ID'                    => $count,
            'opt_id'                => $invetory->optionid,
            'product_name'          => $invetory->product,
            'option_name'           => $invetory->package,
            'Confirmed_count'       => $invetory->confirm_status_count,
            'Initiated_count'       => $invetory->initiated_status_count,
            'Approved_count'        => $invetory->approved_status_count,
            'Closed_Count'          => $invetory->closed_status_count
        );

    }
    return $inventory_details;
}