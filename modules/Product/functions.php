<?php

function create_product( $args ) {

    $data[ 'post_status' ]  = 'publish';
    $data[ 'post_title' ]   = $args[ 'post_title' ];
    $data[ 'post_content' ] = $args[ 'post_content' ];
    $data[ 'post_type' ]    = 'products';
    $post_id                = wp_insert_post( $data );

    add_post_meta( $post_id, 'product_price', $args[ 'post_price' ] );
    update_post_meta( $post_id, '_thumbnail_id', $args[ 'attachmentid' ] );

    $post_array = get_product_data( $post_id );

    return $post_array;
}

function get_all_products( $args ) {

    $product_array = array();
    $products      = new WP_Query( $args );
    if ( $products->have_posts() ):
        while ( $products->have_posts() ):$products->the_post();
            $product_array[ ] = get_product_data( get_the_ID() );
        endwhile;
    endif;

    return $product_array;
}

function get_product_data( $product_id ) {

    $product = get_post( $product_id );

    $thumbnail_id = get_post_thumbnail_id( $product->ID );
    $images       = wp_get_attachment_image_src( $thumbnail_id );
    $image        = is_array( $images ) && count( $images ) > 1 ? $images[ 0 ] : get_template_directory_uri() .
        '/img/placeholder.jpg';
    $product_data = array(
        'ID'                   => $product->ID,
        'product_name'         => $product->post_title,
        'product_details'      => $product->post_content,
        'product_price'        => get_post_meta( $product->ID, 'product_price' ),
        'product_image'        => $image,
        'product_thumbnail_id' => $thumbnail_id
    );

    return $product_data;
}

function store_image( $post_id, $url ) {


    $upload_dir = wp_upload_dir(); // Set upload folder


    $image_data = file_get_contents( $url ); // Get image data

    $filename = basename( $url ); // Create image file name
    // Check folder permission and define file location

    if ( wp_mkdir_p( $upload_dir[ 'path' ] ) ) {

        $file = $upload_dir[ 'path' ] . '/' . $filename;
    } else {

        $file = $upload_dir[ 'basedir' ] . '/' . $filename;
    }


    // Create the image  file on the server

    file_put_contents( $file, $image_data );


    // Check image file type

    $wp_filetype = wp_check_filetype( $filename, null );


    // Set attachment data

    $attachment = array(
        'post_mime_type' => $wp_filetype[ 'type' ],
        'post_title'     => sanitize_file_name( $filename ),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );


    // Create the attachment

    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );


    // Include image.php

    require_once( ABSPATH . 'wp-admin/includes/image.php' );


    // Define attachment metadata

    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );


    // Assign metadata to attachment

    wp_update_attachment_metadata( $attach_id, $attach_data );


    // And finally assign featured image to post

    set_post_thumbnail( $post_id, $attach_id );
}

function get_updated_product( $args ) {


    $my_post = array(
        'ID'           => $args[ 'post_author' ],
        'post_content' => $args[ 'post_content' ],
        'post_title'   => $args[ 'post_title' ]
    );

    $post_id = wp_update_post( $my_post );

    update_post_meta( $post_id, '_thumbnail_id', $args[ 'attachmentid' ] );
    update_post_meta( $post_id, 'product_price', $args[ 'post_price' ] );

    $post_array = get_product_data( $post_id );

    return $post_array;
}

function uploadImage( $url ) {


    $upload_dir = wp_upload_dir(); // Set upload folder

    $image_data = file_get_contents( $url ); // Get image data

    $filename = basename( $url ); // Create image file name
    // Check folder permission and define file location

    if ( wp_mkdir_p( $upload_dir[ 'path' ] ) ) {

        $file = $upload_dir[ 'path' ] . '/' . $filename;
    } else {

        $file = $upload_dir[ 'basedir' ] . '/' . $filename;
    }


    // Create the image  file on the server

    file_put_contents( $file, $image_data );


    // Check image file type

    $wp_filetype = wp_check_filetype( $filename, null );


    // Set attachment data

    $attachment = array(
        'post_mime_type' => $wp_filetype[ 'type' ],
        'post_title'     => sanitize_file_name( $filename ),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );


    // Create the attachment

    //$attach_id = wp_insert_attachment($attachment, $file, $post_id);


    // Include image.php

    //require_once(ABSPATH . 'wp-admin/includes/image.php');


    // Define attachment metadata

    //$attach_data = wp_generate_attachment_metadata($attach_id, $file);


    // Assign metadata to attachment

    //wp_update_attachment_metadata($attach_id, $attach_data);


    // And finally assign featured image to post

    //set_post_thumbnail($post_id, $attach_id);
    $image_array = array( 'attachid' => $attachment, 'file' => $file );

    return $image_array;
}