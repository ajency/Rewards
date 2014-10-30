<?php

function get_all_option_products($args) {

    global $post;
    $product_array = array();
    $products = new WP_Query($args);
    if ($products->have_posts()):
        while ($products->have_posts()):$products->the_post();
            $product = get_post($post->ID);
            if (has_post_thumbnail($post->ID)) {

                $post_thumbnail_id = get_post_thumbnail_id($post->ID);
                $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
            } else {
                $image_url = "";
            }
            $product_array[] = array(
                'ID' => $post->ID,
                'product_name' => $product->post_title,
                'product_details' => $product->post_content,
                'product_price' => get_post_meta($post->ID, 'product_price'),
                'product_img' => $post_thumbnail_url,
                'selected' => ''
            );

        endwhile;
    endif;

    return $product_array;
}

function create_option($args) {

    
    global $wpdb;
   
    $options_table = $wpdb->prefix . "options";
    $option = wp_insert_term(
            $args['option_name'], // the term
            'Options', // the taxonomy
            array(
        'description' => $args['option_desc'],
                'slug' => $args1['option_name']
            ));

   
    add_option("taxonomy" . $option['term_id'], $args['min_opt'] );
    add_option("taxonomy_archive" . $option['term_id'], $args['archive'] );

    global $user_ID;
    $args1 = array(
        'post_author' => $user_ID,
        'post_type' => 'Products'
    );
     $products = get_all_option_products($args1);

    $products1 = explode(',', $args['optionstring']);
    for ($i = 0; $i < count($products1); $i++) {
        wp_add_object_terms($products1[$i], $option['term_id'], 'Options');
    }
    $package = get_term_by('id', $option['term_id'],'Options');
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
        
        $template = "";
        $sum = 0;
        $term_meta = get_option('taxonomy' . $option['term_id']);

        $term_string =  $term_meta;
        
        while ($loop->have_posts()) : $loop->the_post();

            $product = get_post($post->ID);
          
            if (has_post_thumbnail($post->ID)) {

                $post_thumbnail_id = get_post_thumbnail_id($post->ID);
                $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
            } else {
                $image_url = "";
            }


            $product_details[] = array(
                'ID' => $product->ID,
                'product_name' => $product->post_title,
                'product_price' => get_post_meta($product->ID, 'product_price'),
                'product_details' => $product->post_content,
                'product_img' => $post_thumbnail_url,
                'selected' => 'checked'
            );
            
            $prod_arr[]  =  $product->ID;
            
            $price_val = get_post_meta($product->ID, 'product_price');
            $sum = $sum + (int)$price_val[0];
            foreach ($products as $key => $value) {

                if ($product->ID == $value['ID']) {
                    unset($products[$key]);
                }
            }
        endwhile;
        
         $actual = array_merge($product_details, $products);
         $min = get_option("minimum_percentage");
        $max = get_option("maximum_percentage");
        $range = get_points_range($args['min_opt'], $min, $max);
        
         $option = array(
        'ID' => $option['term_id'],
        'option_name' => $args['option_name'],
        'option_desc' => $args['option_desc'],
        'product_details' => $actual,
        'min_opt' => $args['min_opt'],
        'max_opt' => $args['max_opt'],
        'selected_arr' => $product_details,
        'min_range'  => $range['min'],
        'max_range' => $range['max'],
         'sum'      => $sum
    );
    return $option;
}

function get_options() {

    global $post;
    global $wpdb;

    $rewards_array = array();

    $Option = get_terms('Options', array(
 	'hide_empty' => 0));
   
    

    

    foreach ($Option as $Options) {
        $product_details = array();
       global $user_ID;
       $args = array(
        'post_author' => $user_ID,
        'post_type' => 'Products'
    );

        $products = get_all_option_products($args);
        $prod_arr = Array();
      $package = get_term_by('id', $Options->term_id,'Options');
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
       // $loop = new WP_Query(array('Options' => $Options->term_id));
        $template = "";
        $sum = 0;
        $term_meta = get_option('taxonomy' . $Options->term_id);
        $archive =  get_option("taxonomy_archive" . $Options->term_id);
    if($archive == 1)
    {
        $check = 'checked';
    }
    else
    {
        $check = "";
    }
        $term_string =  $term_meta;
        while ($loop->have_posts()) : $loop->the_post();

            $product = get_post($post->ID);
            if (has_post_thumbnail($post->ID)) {

                $post_thumbnail_id = get_post_thumbnail_id($post->ID);
                $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);
            } else {
                $image_url = "";
            }


            $product_details[] = array(
                'ID' => $post->ID,
                'product_name' => $product->post_title,
                'product_price' => get_post_meta($post->ID, 'product_price'),
                'product_details' => $product->post_content,
                'product_img' => $post_thumbnail_url,
                'selected' => 'checked'
            );
            
            $prod_arr[]  =  $post->ID;
            
            $price_val = get_post_meta($post->ID, 'product_price');
            $sum = $sum + (int)$price_val[0];
            foreach ($products as $key => $value) {

                if ($post->ID == $value['ID']) {
                    unset($products[$key]);
                }
            }
        endwhile;
        $prod_string = implode(',',$prod_arr);
        $actual = array_merge($product_details, $products);
        $min = get_option("minimum_percentage");
        $max = get_option("maximum_percentage");
        $range = get_points_range($term_string, $min, $max);
        $rewards_array[] = array(
            'ID' => $Options->term_id,
            'option_name' => $Options->name,
            'option_desc' => $Options->description,
            'product_details' => $actual,
            'opt_id' => $Options->term_id,
            'min_opt' => $term_string,
            'max_opt' => $term_string,
            'count' => count($product_details),
            'selected_arr' => $product_details,
            'min_range'  => $range['min'],
            'max_range' => $range['max'],
            'sum'      => $sum,
            'prod_array' => $prod_string,
            'check'       => $check
        );
    }

       
    return $rewards_array;
}

function update_option_taxonomy($args1) {

    global $wpdb;
    $options_table = $wpdb->prefix . "options";
    $updated_taxo = wp_update_term($args1['ID'], // the term
            'Options', // the taxonomy
            array(
                'name' => $args1['option_name'],
        'description' => $args1['option_desc']
            ));


    update_option("taxonomy" . $updated_taxo['term_id'], $args1['min_opt']);
    update_option("taxonomy_archive" . $updated_taxo['term_id'], $args1['archive'] );
    $archive = get_option("taxonomy_archive" . $updated_taxo['term_id']);
    if($archive == 1)
    {
        $check = 'checked';
    }
    else
    {
        $check = "";
    }

    $products = explode(',', $args1['optionstring1']);
    for ($i = 0; $i < count($products); $i++) {
       
        wp_remove_object_terms($products[$i], $updated_taxo['term_id'], 'Options');
    }
   
    $products_arr_check = explode(',', $args1['optionstring']);
    for ($j = 0; $j < count($products_arr_check); $j++) {
        wp_add_object_terms($products_arr_check[$j], $updated_taxo['term_id'], 'Options');
    }
    global $post;
    global $wpdb;

    $rewards_array = array();

    //$Option = get_terms('Options');
    global $user_ID;
    $args = array(
        'post_author' => $user_ID,
        'post_type' => 'Products'
    );
   
    $products = get_all_option_products($args);

    $product_details = array();
     $package = get_term_by('id', $updated_taxo['term_id'],'Options');
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
            'ID' => $product->ID,
            'product_name' => $product->post_title,
            'product_price' => get_post_meta($post->ID, 'product_price'),
            'product_details' => $product->post_content,
            'product_img' => $post_thumbnail_url,
            'selected' => 'checked'
        );

        
            $price_val = get_post_meta($product->ID, 'product_price');
            $sum = $sum + (int)$price_val[0];
            foreach ($products as $key => $value) {

                if ($product->ID == $value['ID']) {
                    unset($products[$key]);
                }
            }
    endwhile;

    $actual = array_merge($product_details, $products);
        $min = get_option("minimum_percentage");
        $max = get_option("maximum_percentage");
        $range = get_points_range( $args1['min_opt'], $min, $max);

    $option = array(
        'ID' => $updated_taxo['term_id'],
        'option_name' => $args1['option_name'],
        'option_desc' => $args1['option_desc'],
        'product_details' => $actual,
        'min_opt' => $args1['min_opt'],
        'max_opt' => $args1['max_opt'],
        'selected_arr' => $product_details,
        'min_range'  => $range['min'],
        'max_range' => $range['max'],
         'sum'      => $sum,
        'check'    => $check
    );

    return $option;
}

function set_expiry_date($date, $min, $max) {

    $res = update_option("expiry_date", $date);
    $min = $min / 100;
    $max = $max / 100;
    $min = update_option("minimum_percentage", $min);
    $max = update_option("maximum_percentage", $max);
}

function get_expiry_date() {

    $date_period = get_option("expiry_date");
    $min = get_option("minimum_percentage");
    $max = get_option("maximum_percentage");
    $min = $min * 100;
    $max = $max * 100;
    return array('date' => $date_period, 'min' => $min, 'max' => $max);
}

function get_points_range($points_val, $min, $max) {

    $min_val = 0;
    $max_val = 0;
    if($points_val!=0 || $points_val!="")
    {
    $min_range = 2500000 * (int) $points_val;
    $max_range = (int) $min_range + 2500000;

    $avg = (($min_range + $max_range ) / 2);
    $min_val = $avg * $min;
    $max_val = $avg * $max;
    }
    
    $points_arr = array('min' => $min_val, 'max' => $max_val);


    

    return $points_arr;
}