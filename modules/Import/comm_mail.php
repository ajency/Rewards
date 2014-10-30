<?php

function send_notification_email(){
    
        $subject = "Notification";
        $text = "Check";
        $to = "xavier@ajency.in";
        send_mail_import( $subject, $text, $to );
}

function send_reminder(){
    
        $subject = "Reminder to Initiate";
        $text = "Check";
        
        $to = "xavier@ajency.in";
        
        send_mail_import( $subject, $text, $to );
}

function send_confirmation(){
    
        $subject = "Confirmation";
        $text = "Check";
        //$to = $value->user_email;
        $to = "xavier@ajency.in";
        send_mail_import( $subject, $text, $to );
}

function send_rejection(){
    
        $subject = "Rejection";
        $text = "Check";
        //$to = $satus_show->initiated_by;
        $to = "xavier@ajency.in";
        send_mail_import( $subject, $text, $to );
}

function send_approval(){
    
        $subject = "Approval";
        $text = "Check";
        //$to = $satus_show->initiated_by;
        $to = "xavier@ajency.in";
        send_mail_import( $subject, $text, $to );
}

function conversion_email(){
    
        $subject   = "Conversion Email";
        $text      = "Congrats";
        //$recipeint = $sql_get_programmmember_user->email;
        $to = "xavier@ajency.in";
        send_mail_import( $subject, $text, $recipeint );
}

conversion_email();
//send_approval();
//send_rejection();
//send_confirmation();
//send_reminder();
//send_notification_email();