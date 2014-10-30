<?php


add_filter( 'wp_mail_content_type', 'set_html_content_type' );


/*send mail*/
function send_mail( $subject, $text, $to, $comm_id ) {

    global $wpdb;
    $comm_table = $wpdb->prefix."comm_module" ;
    $headers = 'From: SKYi Rewards Program <rewards@skyi.com>' . "\r\n";
    $wpdb->update(
        $comm_table,
        array(
            'status' => 'sent' // string

        ),
        array( 'id' => $comm_id ),

        array('%s'),

        array('%d')

    );
    
    //$to = "xavier@ajency.in";
    add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
    wp_mail( $to, $subject, $text, $headers );
}

/*set email content*/
function set_html_content_type() {

    return 'text/html';
}
