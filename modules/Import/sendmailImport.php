<?php


add_filter( 'wp_mail_content_type', 'set_html_content_type_import' );



/*send mail*/
function send_mail_import( $subject, $text, $to ) {

    
    wp_mail( $to, $subject, $text );

}

/*set email content*/
function set_html_content_type_import() {

    return 'text/html';
}
