<?php

require_once 'send_mail.php';
global $wpdb;

$comm_table = $wpdb->prefix . "comm_module";
$comm_meta_table = $wpdb->prefix . "module_meta";

$info = $wpdb->get_results( "SELECT *  from $comm_table where status='To be send'" );


foreach ( (array) $info as $value ) {


    $info_comm              = $wpdb->get_results( "SELECT *  from $comm_meta_table where comm_module_id=" . $value->id . "" );

    $accept_reject_referral = array();
    foreach ( (array) $info_comm as $value_arr ) {
        $accept_reject_referral[ ] = $value_arr->id;
    }

   $accept_reject_referral2 = implode( ",", $accept_reject_referral );

    call_comm_module_referrals( $value->email_type, $value->recipients, $accept_reject_referral2, $value->id );

}

/* retrieve data to send mail */

function call_comm_module_referrals( $email_type, $recipeint, $data, $comm_id ) {
// echo $email_type."-".$recipeint."--".$comm_id;

    //var_dump($recipeint);

    global $wpdb;
    $referrals_table = $wpdb->prefix . "referrals";

    $comm_meta_table = $wpdb->prefix . "module_meta";
    switch ( $email_type ) {
        case "Program_Member_Type":

            $data_array = explode( ',', $data );

            $comm_table = $wpdb->prefix . "comm_module";

        $user_data = get_user_by('email',$recipeint);

        //var_dump($user_data);
            //exit();
            //exit();
            $text      = '    <style type="text/css">

        /* Resets: see reset.css for details */
        .ReadMsgBody { width: 100%; background-color: #ebebeb;}
        .ExternalClass {width: 100%; background-color: #ebebeb;}
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
        body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
        body {margin:0; padding:0;}
        table {border-spacing:0;}
        table td {border-collapse:collapse;font-size: 13px;padding: 4px 5px;}
        .yshortcuts a {border-bottom: none !important;}


        /* Constrain email width for small screens */
        @media screen and (max-width: 600px) {
            table[class="container"] {
                width: 95% !important;
            }
        }

        /* Give content more room on mobile */
        @media screen and (max-width: 480px) {
            td[class="container-padding"] {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }
        }


        /* Styles for forcing columns to rows */
        @media only screen and (max-width : 600px) {

            /* force container columns to (horizontal) blocks */
            td[class="force-col"] {
                display: block;
                padding-right: 0 !important;
            }
            table[class="col-3"] {
                /* unset table align="left/right" */
                float: none !important;
                width: 100% !important;

                /* change left/right padding and margins to top/bottom ones */
                margin-bottom: 12px;
                padding-bottom: 12px;
                border-bottom: 1px solid #eee;
            }

            /* remove bottom border for last column/row */
            table[id="last-col-3"] {
                border-bottom: none !important;
                margin-bottom: 0;
            }

            /* align images right and shrink them a bit */
            img[class="col-3-img"] {
                float: right;
                margin-left: 6px;
                max-width: 130px;
            }
        }
    </style>
            <table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ebebeb">
        <tbody>
        <tr>
          <td style="background-color: #ebebeb;" align="center" valign="top" bgcolor="#ebebeb"><!-- 600px container (white background) -->
            <br>
			<table class="container" border="0" width="600" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td align="center">
                    <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><img src="'.site_url().'/wp-content/themes/skyi/img/skyi-logo-1.png" alt="Skyi" /></div>
                  </td>
                </tr>
                <tr>
                  <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: arial; color: #333;" align="left" bgcolor="#ffffff"><br /> <!-- ### BEGIN CONTENT ### --> <br /> Hi <b style="font-weight: bold; font-size: 15px; line-height: 24px; color: #f28428;">'.$user_data->display_name.'</b>,<br /><br /> Thank you for introducing us to your friends / family. You are a Program Member on the SKYi Rewards Program. <br /><br />  Here are your recently added referrals:<br /><br>
                    <table style="border:1px solid #ccc; padding: 5px; width:100%;" class="email_table">
                      <tbody>';


                     foreach ( $data_array as $key => $value ) {

                         $data_info = $wpdb->get_row( "SELECT *  from $comm_meta_table where id=" . $value . "" );
                         
                       
                            
                             
                             
                        


                         if ( $data_info->key == 'referral_accepted_referrals' ) {

                             $data_string = explode( ',', $data_info->value );
                             foreach ( $data_string as $key => $value_string ) {


//echo "SELECT *  from $referrals_table where email='" . $data_string[ $key ] . "'";
                                 $referral_info = $wpdb->get_row( "SELECT *  from $referrals_table where email='" . $data_string[ $key ] . "'" );
if($referral_info->phone == 0 )
                                 {
                                     $phone_val = '--';
                                 }
 else {
     $phone_val = $referral_info->phone;
 }



                    $text.='   <tr>
                                  <td>Name:</td>
                                  <td>'.$referral_info->name .'</td>
                                </tr>
                                <tr>
                                  <td>Email:</td>
                                  <td>'.$referral_info->email.'</td>
                                </tr>
                                <tr>
                                  <td>Contact No.:</td>
                                  <td>'.$phone_val.'</td>
                                </tr>
                                <tr>
                                  <td>City:</td>
                                  <td>'.$referral_info->city .'</td>
                                </tr>
                                <tr>
                                  <td style="border-bottom:1px solid #ccc;">Status:*</td>
                                  <td style="border-bottom:1px solid #ccc;">'.$referral_info->status.'</td>
                                </tr>';
                             }//end foreach ( $data_string as $key => $value_string ) {
                         }
                         if ( $data_info->key == 'referral_rejected_referrals' ) {

                             $data_string = explode( '|', $data_info->value );
                             $email_string = explode(',',$data_string[0]);
                             $name_string = explode(',',$data_string[1]);
                             $city_string = explode(',',$data_string[2]);
                             $phone_string = explode(',',$data_string[3]);
                             foreach ( $email_string as $key => $value_string ) {

                                 if($phone_string[$key]=="")
                                 {
                                     $phone = '--';
                                 }
 else {
     $phone = $phone_string[$key];
 }



                    $text.='   <tr>
                                  <td>Name:</td>
                                  <td>'.$name_string[$key] .'</td>
                                </tr>
                                <tr>
                                  <td>Email:</td>
                                  <td>'.$value_string.'</td>
                                </tr>
                                <tr>
                                  <td>Contact No.:</td>
                                  <td>'.$phone.'</td>
                                </tr>
                                <tr>
                                  <td>City:</td>
                                  <td>'.$city_string[$key] .'</td>
                                </tr>
                                <tr>
                                  <td style="border-bottom:1px solid #ccc;">Status:*</td>
                                  <td style="border-bottom:1px solid #ccc;">Present in the System</td>
                                </tr>';
                             }//end foreach ( $data_string as $key => $value_string ) {
                         }
                         //end if ( $data_info->key == 'referral_accepted_referrals' ) {
                     }//foreach ( $data_array as $key => $value ) {

            $text.=' </tbody>
                    </table>
                    <br><i>*New Referral. Thank you for providing referral details. </i><br>
					<i>*Present in the system: We already have the contact details of your referral. Points, if any, will not add to your total. </i>
                    <br><br>
        We will get in touch with your referrals over the next few days, and we’ll keep you posted on their interest in SKYi properties. If any of them make a purchase with us, you will be the first to know! <br />
                    <h3>The Rewards Program: How it works</h3>
        <b>You refer, you get rewarded - it\'s that simple!</b> <br /> <br /> Each referral that results in a booking with SKYi properties will entitle you to points in proportion to the sale value of the property. <br />
                    <h3>About Skyi Properties</h3>
        The SKYi homes development caters to 3 segments of the residential market - Ultra Luxury, Luxury and Premium. The product offering involves a wide range of products including condominiums, duplexes, row houses and apartments of varying sizes. <br /><br /> SKYi is credited with introducing the revolutionary concept of ihome development in the residential segment. Our projects are environment friendly by way of intelligent designs and sensitive approach to development. <br /><br /> SKYi has successfully launched numerous residential projects and is in the process of marking its presence across various locations in Pune. <br />
                    <h4>Following are some of our projects</h4>
                    <ol>
                      <li>Iris Bavdhan, an 80 apartments project spread over 2 acres;</li>
                      <li>5 Baner, luxurious apartments with state of the art amenities;</li>
                      <li>Iris Baner, 106 apartments spread over 3 acres;</li>
                      <li>Aquila, 18 luxurious townhouses to the upcoming Songbirds, a sustainable state of the art township spread over 42 acres in Bhugaon Hills of Pune.</li>
                    </ol>
        By adhering to stringent quality norms, our focus in on providing people with a better and fulfilling living experience. <br /> If you have any further enquiries feel free to contact us on <b>+91 20 6790 6790</b> or email us at <a href="mailto:sales@skyi.com">sales@skyi.com</a> <br /><br /> Regards,<br /> Program Manager,<br /> SKYi Rewards Program</td>
                </tr>
                <tr>
                  <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 11px; line-height: 20px; font-family: arial; color: #9c9c9c; font-style: italic;" align="left" bgcolor="#ffffff"><br /><br /> You received this email because you\'re a registered Skyi user. We occasionally send system alerts with account information, planned outages, system improvements, and important customer-service updates. We\'ll keep them brief and useful. Promise.<br /><b> ©2013 skyi. All Rights Reserved.</b></td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#ffffff">
                    <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><br /> <br /> <img src="'.site_url().'/wp-content/themes/skyi/img/skyi-logo-1.png" alt="SKYi" /></div>
                  </td>
                  <td>  </td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#ffffff">
                    <div style="text-shadow: white 0 1px 0px; background-repeat: no-repeat; margin: 10px 0; padding-top: 7px; color: #777777; font: 12px/18px Helvetica, sans-serif;"><a style="color: #777777; text-decoration: underline;" href="#">SKYi Website</a>  · </div>
                  </td>
                </tr>
              </tbody>
            </table>
			<br>
            <!--/600px container --></td>
        </tr>
      </tbody>
    </table>';


            //$subject = "You are now a part of Skyi Rewards Program";
           // $subject = "Skyi - Thanks for adding Referrals";
            $subject = "Thank You For Your Referrals.";

           send_mail( $subject, $text, $recipeint, $comm_id );





            break;



        case "Referral_Type" :
            global $wpdb;
            $referrals_table = $wpdb->prefix . "referrals";
            $recipient_array = explode( ',', $recipeint );
             $data_array = explode( ',', $data );
            $data_info       = $wpdb->get_row( "SELECT *  from $comm_meta_table where id=" . $data_array[ 0 ] . "" );

            //get referal name
            
             $user_data = get_user_by('email',$data_info->value);
            //$subject         = "Welcome to Skyi Properties";
            //$subject         = "Introducing Skyi Properties";
            $subject         = $user_data->display_name." Asked Us To Get In Touch With You";

            foreach ( $recipient_array as $key => $value ) {

               
                
                $qry_referral_name = "SELECT name FROM ".$referrals_table." WHERE email = '".$value."'";
                $res_referral_name = $wpdb->get_results($qry_referral_name,ARRAY_A);


                $text = '<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ebebeb">
                          <tbody>
                            <tr>
                              <td style="background-color: #ebebeb;" align="center" valign="top" bgcolor="#ebebeb"><!-- 600px container (white background) --> <br />
                                <table class="container" border="0" width="600" cellspacing="0" cellpadding="0">
                                  <tbody>
                                    <tr>
                                      <td align="center">
                                        <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><img src="'.site_url().'/wp-content/themes/skyi/img/skyi-logo-1.png" alt="Skyi" /></div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: arial; color: #333;" align="left" bgcolor="#ffffff"><br /> <!-- ### BEGIN CONTENT ### --> <br /> Hi <b style="font-weight: bold; font-size: 15px; line-height: 24px; color: #f28428;">'.$res_referral_name[0]['name'].'</b>,<br /><br /> <strong>'. $user_data->display_name .'</strong> provided us with your contact details and suggested we get in touch with you about the latest projects at SKYi Properties. And we will most happily oblige! <br />
                                        <h4>Introducing SKYi Properties</h4>
                                        SKYi has defined the very essence of fine living in Pune. The SKYi homes development caters to 3 segments of the residential market - Ultra Luxury, Luxury and Premium. The product offering involves a wide range of products including condominiums, duplexes, row houses and apartments of varying sizes. <br /> <br /> SKYi is credited with introducing the revolutionary concept of ihome development in the residential segment. Our projects are environment friendly by way of intelligent designs and sensitive approach to development. <br />
                                        <h4>Following are some of our projects</h4>
                                        <ul>
                                          <li>Iris Bavdhan, an 80 apartments project spread over 2 acres;</li>
                                          <li>5 Baner, luxurious apartments with state of the art amenities;</li>
                                          <li>Iris Baner, 106 apartments spread over 3 acres;</li>
                                          <li>Aquila, 18 luxurious townhouses to the upcoming Songbirds, a sustainable state of the art township spread over 42 acres in Bhugaon Hills of Pune.</li>
                                        </ul>
                                        For more details, visit <a style="color: #f28428; text-decoration: none; font-size: 14px; cursor: pointer;" href="http://www.skyi.com/">skyi.com.</a> <br /> <br /> If you are looking to purchase a property in Pune, we suggest you allow us to walk you through our projects. Of course, an in-person meeting at our project site will be great. Our executive will call you on to set up a convenient time. <br /><br /> Alternatively, you could call us on <b>+91 20 6790 6790</b> or email us at <a style="color: #f28428; text-decoration: none; font-size: 14px; cursor: pointer;" href="mailto:sales@skyi.com">sales@skyi.com</a> and let us know a time convenient to you. <br /><br /> We look forward to meeting you soon. <br /><br /> Thanking you,<br /> Program Member,<br /> SKYi Rewards Program</td>
                                    </tr>
                                    <tr>
                                      <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 11px; line-height: 20px; font-family: arial; color: #9c9c9c; font-style: italic;" align="left" bgcolor="#ffffff"><br /><br /> You received this email because you\'re a registered Skyi user. We occasionally send system alerts with account information, planned outages, system improvements, and important customer-service updates. We\'ll keep them brief and useful. Promise.<br /><b> &copy; 2013 skyi. All Rights Reserved.</b> </td>
                                    </tr>
                                    <tr>
                                      <td align="center" bgcolor="#ffffff">
                                        <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><br /> <br /> <img src="'.site_url().'/wp-content/themes/skyi/img/skyi-logo-1.png" alt="SKYi" /></div>
                                      </td>
                                      <td>  </td>
                                    </tr>
                                    <tr>
                                      <td align="center" bgcolor="#ffffff">
                                        <div style="text-shadow: white 0 1px 0px; background-repeat: no-repeat; margin: 10px 0; padding-top: 7px; color: #777777; font: 12px/18px Helvetica, sans-serif;"><a style="color: #777777; text-decoration: underline;" href="#">SKYi Website</a>.</div>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                                <br /> <!--/600px container --></td>
                            </tr>
                          </tbody>
                        </table>';


                send_mail( $subject, $text, $value, $comm_id );
            }
            break;
            
      
    }
}


?>
