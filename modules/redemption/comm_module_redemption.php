<?php

function send_mail_redemption() {

    global $wpdb;

    $comm_table = $wpdb->prefix . "comm_module";
    $comm_meta_table = $wpdb->prefix . "module_meta";

    $info = $wpdb->get_results("SELECT *  from $comm_table where status='To be send' ");

    //call_comm_module_redemption( $info->email_type, $info->recipients,$info->id );

    foreach ((array) $info as $value) {


        $info_comm = $wpdb->get_results("SELECT *  from $comm_meta_table where comm_module_id=" . $value->id . "");
        $accept_reject_referral = '';
        foreach ((array) $info_comm as $value_arr) {
            $accept_reject_referral = $value_arr->value;
        }



        call_comm_module_redemption($value->email_type, $value->recipients, $value->id, $accept_reject_referral);
    }
}

function call_comm_module_redemption($email_type, $recipeint, $comm_id, $data) {

    global $wpdb;
    $referrals_table = $wpdb->prefix . "referrals";

    $comm_meta_table = $wpdb->prefix . "module_meta";


    switch ($email_type) {
        case "Send_Reminder":

            $to = $recipeint;
            global $wpdb;
          
            $data_arr = explode(',', $data);
        
            
          
            $referrals_table = $wpdb->prefix . "referrals";
            $customers_table = $wpdb->prefix . "customer";

            $user_data = get_user_by('email', $to);

            $user_hash = get_user_meta($user_data->ID, 'hash', true);

            $points_count = $wpdb->get_var("select sum(points) from $customers_table
                                    inner join  $referrals_table on $customers_table.referral_id =  $referrals_table.ID
                                     where user_id=" . $user_data->ID . " group by user_id");

            $ref_count = $wpdb->get_var("select count(*) from $customers_table
                                    inner join  $referrals_table on $customers_table.referral_id =  $referrals_table.ID
                                     where user_id=" . $user_data->ID . " group by user_id");

            $subject = "Your Reward Awaits You. Get It Now.";
            $text = '<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="initial-scale=1.0">    <!-- So that mobile webkit will display zoomed in -->
    <meta name="format-detection" content="telephone=no"> <!-- disable auto telephone linking in iOS -->
  </head>
  <body style="margin:0; padding:10px 0;" bgcolor="#ebebeb" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <p>&nbsp;</p>
    <!-- 100% wrapper (grey background) -->
    <table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ebebeb">
      <tbody>
        <tr>
          <td style="background-color: #ebebeb;" align="center" valign="top" bgcolor="#ebebeb"><!-- 600px container (white background) -->
            <br>
			<table class="container" border="0" width="600" cellspacing="0" cellpadding="0">
              <tbody><div class="clearfix"></div>
            <ol class="m-l-5 m-t-20 m-b-10 user_step_list"><tr>
                  <td align="center">
                    <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="Skyi" /></div>
                  </td>
                </tr>
                <tr>
                  <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: arial; color: #333;" align="left" bgcolor="#ffffff"><br /> <!-- ### BEGIN CONTENT ### --> <br /> Dear <b style="font-weight: bold; font-size: 15px; line-height: 24px; color: #f28428;">' . $user_data->display_name . '</b>,<br /><br /> We are thrilled to let you know that (' . $ref_count . ') of your referrals have made a purchase with SKYi Properties. You now have a total of (' . $points_count . ') points on the SKYi Referral Program. Thank you for spreading the word about us! <br />
                   <h3>There are some exciting reward options available, and you could redeem your points for gifts like:</h3>';
                 for ($q = 0; $q < count($data_arr); $q++) {
                     
                     $k  = $q + 1; 
                      $term_id = get_term_by( 'id', $data_arr[$q], 'Options');
                      //$loop = new WP_Query(array('Options' => $term_id->name));
                     $val = array('post_type' => 'Products',
                         'tax_query' => array(
                             array(
                                 'taxonomy' => 'Options',
                                 'field' => 'slug',
                                 'terms' => $term_id->slug,
                             ),
                         ),
                     );
                     $loop = new WP_Query($val);
     $product_details = Array();
        while ($loop->have_posts()) : $loop->the_post();

            $product = get_post($post->ID);
          
            $product_details[] =  $product->post_title;
           
        endwhile;
       
        $product_string = implode(',',$product_details);
                  $text .= '<h4 style="font-size: 14px; margin-bottom: 5px; margin-top: 0;">'.$k.'. '.$term_id->name.'</h4>
                      <p style="font-size: 13px; margin-bottom: 5px; margin-top: 0;">'.$term_id->description.'</p>
                          <p style="font-size: 13px; margin-bottom: 10px; margin-top: 0;">This package includes: ('.$product_string.')</p>
					<br>';
                  
                 }
               
                   $text .=' Follow these simple steps:<ol>
                    <li>Go to : <a href="' . site_url() . '/customer/#user/' . $user_hash . '/' . $user_data->ID . '">Link Here</a></li>
                    <li>Click the \'Initiate Redemption\' button in Step 1.</li>
                    <li>In Step 2, select your reward options from the list available to you. Do click the \'Initiate Redemption\' button again after making a selection. <em>Please note: Reward options available to you is based on your total points.</em></li>
                    </ol>Once we receive your reward request, we will send you a confirmatory email in a few days. You will need to come to our office in Pune to collect your reward any time, one month after you receive our confirmation. <br /><br /> Regards,<br /> Rewards Manager,<br /> SKYi Referral Program</td>
                </tr>
                <tr>
                  <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 11px; line-height: 20px; font-family: arial; color: #9c9c9c; font-style: italic;" align="left" bgcolor="#ffffff"><br /><br /> You received this email because you\'re a registered Skyi user. We occasionally send system alerts with account information, planned outages, system improvements, and important customer-service updates. We\'ll keep them brief and useful. Promise.<br /><b> ©2013 skyi. All Rights Reserved.</b></td>
                </tr>
                <tr>
                  <td align="center" bgcolor="#ffffff">
                    <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><br /> <br /> <img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="SKYi" /></div>
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
    </table>
    <!--/100% wrapper-->
    <p>&nbsp;</p>
  </body>
</html>';


            send_mail($subject, $text, $to, $comm_id);

            break;

        case "Rejected_type":

            $to = $recipeint;

            $user_data = get_userdata($to);

            $to = $user_data->user_email;

            $user_hash = get_user_meta($user_data->ID, 'hash', true);


            // $subject = "Skyi - Your Redemption was Rejected";
            $subject = "Sorry! Your Reward Request Was Rejected.";

            //option name - approved
            $qry_get_option_name = "SELECT redmp_meta.optionid FROM " . $wpdb->prefix . "redemption redmp
                                        LEFT JOIN
                                        " . $wpdb->prefix . "redemption_meta redmp_meta

                                        on redmp.id = redmp_meta.redemption_id
                                            WHERE redmp_meta.status = 'Rejected'
                                            AND redmp.userid = " . $recipeint;

            $res_get_option_name = $wpdb->get_var($qry_get_option_name);


            $text = '<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ebebeb">
                          <tbody>
                            <tr>
                              <td style="background-color: #ebebeb;" align="center" valign="top" bgcolor="#ebebeb"><!-- 600px container (white background) -->
                                <br>
                                <table class="container" border="0" width="600" cellspacing="0" cellpadding="0">
                                  <tbody>
                                    <tr>
                                      <td align="center">
                                        <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="Skyi" /></div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: arial; color: #333;" align="left" bgcolor="#ffffff"><br /> <!-- ### BEGIN CONTENT ### --> <br /> Dear <b style="font-weight: bold; font-size: 15px; line-height: 24px; color: #f28428;">' . $user_data->display_name . '</b>,<br /><br /> We are sorry to inform you that your redemption request has failed. It could be for one of the following reasons: <br />
                                        <ul>
                                          <li>The reward option you selected is out of stock</li>
                                          <li>Changes to the program policy</li>
                                        </ul>
                                        <h4>You can initiate redemption once again, by following the same process as before:</h4>
                                        <ol>
                                          <li>Go to : <a style="color: #f28428; text-decoration: none; font-size: 14px; cursor: pointer;" href="' . site_url() . '/customer/#user/' . $user_hash . '/' . $user_data->ID . '">Link Here</a></li>
                                          <li>Click the \'Initiate Redemption\' button in Step 1.</li>
                                          <li>In Step 2, select your reward options from the list available to you. Do click the \'Initiate Redemption\' button again after making a selection. <em>Please note: Reward options available to you is based on your total points.</em></li>
                                        </ol>Once we receive your reward request, we will send you a confirmatory email in a few days. You will need to come to our office in Pune to collect your reward any time, one month after you receive our confirmation. <br /><br /> Regards,<br /> Rewards Manager,<br /> SKYi Referral Program</td>
                                    </tr>
                                    <tr>
                                      <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 11px; line-height: 20px; font-family: arial; color: #9c9c9c; font-style: italic;" align="left" bgcolor="#ffffff"><br /><br /> You received this email because you\'re a registered Skyi user. We occasionally send system alerts with account information, planned outages, system improvements, and important customer-service updates. We\'ll keep them brief and useful. Promise.<br /><b> &copy;2013 skyi. All Rights Reserved.</b> </td>
                                    </tr>
                                    <tr>
                                      <td align="center" bgcolor="#ffffff">
                                        <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><br /> <br /> <img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="SKYi" /></div>
                                      </td>
                                      <td>  </td>
                                    </tr>
                                    <tr>
                                      <td align="center" bgcolor="#ffffff">
                                        <div style="text-shadow: white 0 1px 0px; background-repeat: no-repeat; margin: 10px 0; padding-top: 7px; color: #777777; font: 12px/18px Helvetica, sans-serif;"><a style="color: #777777; text-decoration: underline;" href="#">SKYi Website</a> . </div>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                                <br>
                                <!--/600px container --></td>
                            </tr>
                          </tbody>
                        </table>';


            send_mail($subject, $text, $to, $comm_id);


            break;





        case "Approved_type":

            $to = $recipeint;



            $user_data = get_userdata($to);

            $to = $user_data->user_email;

            $user_hash = get_user_meta($user_data->ID, 'hash', true);


            //$subject = "Skyi - Your Redemption has been Approved.";

            $subject = "Your Reward Request Approved. Next Steps Here.";

            //option name - approved
            $qry_get_option_name = "SELECT redmp_meta.optionid FROM " . $wpdb->prefix . "redemption redmp
                                        LEFT JOIN
                                        " . $wpdb->prefix . "redemption_meta redmp_meta

                                        on redmp.id = redmp_meta.redemption_id
                                            WHERE redmp_meta.status = 'Approved'
                                            AND redmp.userid = " . $recipeint;

            $res_get_option_name = $wpdb->get_var($qry_get_option_name);
            $package = get_term_by('id',  $res_get_option_name,'Options');

            $text = '<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ebebeb">
                      <tbody>
                        <tr>
                          <td style="background-color: #ebebeb;" align="center" valign="top" bgcolor="#ebebeb"><!-- 600px container (white background) -->
                            <br>
                            <table class="container" border="0" width="600" cellspacing="0" cellpadding="0">
                              <tbody>
                                <tr>
                                  <td align="center">
                                    <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="Skyi" /></div>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: arial; color: #333;" align="left" bgcolor="#ffffff"><br /> <!-- ### BEGIN CONTENT ### --> <br /> Dear <b style="font-weight: bold; font-size: 15px; line-height: 24px; color: #f28428;">' . $user_data->display_name . '</b>,<br /><br /> We\'re indeed happy to inform you that your request to redeem your points has been approved. <strong>You have chosen to receive ' . $package->name . '.</strong> <br />
                                    <ul>
                                      <li>Go to : <a style="color: #f28428; text-decoration: none; font-size: 14px; cursor: pointer;" href="' . site_url() . '/customer/#user/' . $user_hash . '/' . $user_data->ID . '">(link here)</a></li>
                                      <li>Please select a convenient date and time to collect your reward from our office (address below) and click the \'Confirm\' button in Step 3. <br /><i>Please note: As per our rules, you can select a date one month after your request was approved in our system. </i></li>
                                    </ul>
                                    <b>Our office address is:</b> <br /> 1, Kanchan Lane <br /> Law College Road, <br /> Near Krishna Dining Hall, <br /> Pune - 411004.  <br /><br /> Regards,<br /> Rewards Manager,<br /> SKYi Referral Program</td>
                                </tr>
                                <tr>
                                  <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 11px; line-height: 20px; font-family: arial; color: #9c9c9c; font-style: italic;" align="left" bgcolor="#ffffff"><br /><br /> You received this email because you\'re a registered Skyi user. We occasionally send system alerts with account information, planned outages, system improvements, and important customer-service updates. We\'ll keep them brief and useful. Promise.<br /><b> &copy; 2013 skyi. All Rights Reserved.</b> </td>
                                </tr>
                                <tr>
                                  <td align="center" bgcolor="#ffffff">
                                    <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><br /> <br /> <img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="SKYi" /></div>
                                  </td>
                                  <td>  </td>
                                </tr>
                                <tr>
                                  <td align="center" bgcolor="#ffffff">
                                    <div style="text-shadow: white 0 1px 0px; background-repeat: no-repeat; margin: 10px 0; padding-top: 7px; color: #777777; font: 12px/18px Helvetica, sans-serif;"><a style="color: #777777; text-decoration: underline;" href="#">SKYi Website</a> . </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <br>
                            <!--/600px container --></td>
                        </tr>
                      </tbody>
                    </table>
                    <!--/100% wrapper-->
                    <p><br /> </p>
                  </body>
                </table>';

            send_mail($subject, $text, $to, $comm_id);


            break;










        case "Initiated_type":

            $to = $recipeint;



            $user_data = get_user_by('email', $to);

            $user_hash = get_user_meta($user_data->ID, 'hash', true);


            //option name - approved


            $qry_get_option_name_pm = "SELECT cm_md_mta.value as pm, redmp_mta.optionid  as  option_value  FROM " . $wpdb->prefix . "module_meta cm_md_mta
                                                JOIN " . $wpdb->prefix . "redemption redmp
                                                on cm_md_mta.value =  redmp.userid
                                                JOIN " . $wpdb->prefix . "redemption_meta redmp_mta
                                                on  redmp.id = redmp_mta.redemption_id


                                    WHERE comm_module_id = " . $comm_id . " AND cm_md_mta.key = 'add_info'

                                    And redmp_mta.status = 'Initiated' ";




            $res_get_option_name_pm = $wpdb->get_results($qry_get_option_name_pm, ARRAY_A);

            $pm_id = $res_get_option_name_pm[0]['pm'];
            $option_value = $res_get_option_name_pm[0]['option_value'];
            $package = get_term_by('id',  $option_value,'Options');

            $pm_data = get_userdata($pm_id);

            $referrals_table = $wpdb->prefix . "referrals";
            $customers_table = $wpdb->prefix . "customer";

            $points_count = $wpdb->get_var("select sum(points) from $customers_table
                                    inner join  $referrals_table on $customers_table.referral_id =  $referrals_table.ID
                                     where user_id=" . $pm_id . " group by user_id");




            $subject = $pm_data->display_name . " has initiated Redemption of Points";


            $text = '<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ebebeb">
                      <tbody>
                        <tr>
                          <td style="background-color: #ebebeb;" align="center" valign="top" bgcolor="#ebebeb"><br /> <!-- 600px container (white background) -->
                            <table class="container" border="0" width="600" cellspacing="0" cellpadding="0">
                              <tbody>
                                <tr>
                                  <td align="center">
                                    <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="Skyi" /></div>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: arial; color: #333;" align="left" bgcolor="#ffffff"><br /> <!-- ### BEGIN CONTENT ### --> <br /> Hello <span style="font-size: 15px; line-height: 24px; color: #f28428;">' . $user_data->display_name . '</span>,<br /><br /> Program Member <strong>' . $pm_data->display_name . '</strong> has just initiated redemption of points. <br /><br /> Total points : <b>' . $points_count . '</b><br /> Option Selected : <b>' . $package->name . '</b><br /> <br /> Request awaiting your input. </td>
                                </tr>
                                <tr>
                                  <td align="center" bgcolor="#ffffff">
                                    <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><br /> <br /> <img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="SKYi" /></div>
                                  </td>
                                  <td>  </td>
                                </tr>
                                <tr>
                                  <td align="center" bgcolor="#ffffff">
                                    <div style="text-shadow: white 0 1px 0px; background-repeat: no-repeat; margin: 10px 0; padding-top: 7px; color: #777777; font: 12px/18px Helvetica, sans-serif;"><a style="color: #777777; text-decoration: underline;" href="#">SKYi Website</a>. </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <br /> <!--/600px container --></td>
                        </tr>
                      </tbody>
                    </table>';

            send_mail($subject, $text, $to, $comm_id);



            break;





        case "Reminder_PM_type":

            $to = $recipeint;


            $user_data = get_userdata($to);

            $to = $user_data->user_email;

            $user_hash = get_user_meta($user_data->ID, 'hash', true);


            //$subject = "Skyi - Reminder to Collect your Reward";
            $subject = "Reminder To Collect Your Reward";

            //option name - approved
            $qry_get_option_name = "SELECT redmp_meta.optionid as option_value, redmp_meta.confirm_date as confirm_date  FROM " . $wpdb->prefix . "redemption redmp
                                        LEFT JOIN
                                        " . $wpdb->prefix . "redemption_meta redmp_meta

                                        on redmp.id = redmp_meta.redemption_id
                                            WHERE redmp_meta.status = 'Confirmed'
                                            AND redmp.userid = " . $recipeint;

            $res_get_option_name = $wpdb->get_results($qry_get_option_name, ARRAY_A);

            $option_value = $res_get_option_name[0]['option_value'];
            $package = get_term_by('id',  $option_value,'Options');

            $confirm_date_time = explode("|", $res_get_option_name[0]['confirm_date']);
            $confirm_date = $confirm_date_time[0];
            $confirm_time = $confirm_date_time[1];





            $text = '<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ebebeb">
                          <tbody>
                            <tr>
                              <td style="background-color: #ebebeb;" align="center" valign="top" bgcolor="#ebebeb"><br /> <!-- 600px container (white background) -->
                                <table class="container" border="0" width="600" cellspacing="0" cellpadding="0">
                                  <tbody>
                                    <tr>
                                      <td align="center">
                                        <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="Skyi" /></div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: arial; color: #333;" align="left" bgcolor="#ffffff"><br /> <!-- ### BEGIN CONTENT ### --> <br /> Hello <b style="font-weight: bold; font-size: 15px; line-height: 24px; color: #f28428;">' . $user_data->display_name . '</b>,<br /><br /> A gentle reminder to let you know that your reward <b>' . $package->name . '</b> is ready and waiting. We hope to see you at our office on <b>' . $confirm_date . '</b> at <b>' . $confirm_time . '</b>. <br /><br /> Regards,<br /> Rewards Manager,<br /> SKYi Rewards Program</td>
                                    </tr>
                                    <tr>
                                      <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 11px; line-height: 20px; font-family: arial; color: #9c9c9c; font-style: italic;" align="left" bgcolor="#ffffff"><br /><br /> You received this email because you\'re a registered Skyi user. We occasionally send system alerts with account information, planned outages, system improvements, and important customer-service updates. We\'ll keep them brief and useful. Promise.<br /><b> &copy;2013 skyi. All Rights Reserved.</b> </td>
                                    </tr>
                                    <tr>
                                      <td align="center" bgcolor="#ffffff">
                                        <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><br /> <br /> <img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="SKYi" /></div>
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

            send_mail($subject, $text, $to, $comm_id);



            break;





        case "Reminder_RM_type":

            $to = $recipeint;



            $user_data = get_user_by('email', $to);

            $user_hash = get_user_meta($user_data->ID, 'hash', true);


            //option name - approved


            $qry_get_option_name_pm_dt = "SELECT cm_md_mta.value as pm, redmp_mta.optionid  as  option_value, redmp_mta.confirm_date  as  confirm_date  FROM " . $wpdb->prefix . "module_meta cm_md_mta
                                                JOIN " . $wpdb->prefix . "redemption redmp
                                                on cm_md_mta.value =  redmp.userid
                                                JOIN " . $wpdb->prefix . "redemption_meta redmp_mta
                                                on  redmp.id = redmp_mta.redemption_id


                                    WHERE comm_module_id = " . $comm_id . " AND cm_md_mta.key = 'add_info'

                                    And redmp_mta.status = 'Confirmed' ";



            $res_get_option_name_pm_dt = $wpdb->get_results($qry_get_option_name_pm_dt, ARRAY_A);

            $pm_id = $res_get_option_name_pm_dt[0]['pm'];
            $option_value = $res_get_option_name_pm_dt[0]['option_value'];
            $package = get_term_by('id',  $option_value,'Options');

            $confirm_date_time = explode("|", $res_get_option_name_pm_dt[0]['confirm_date']);
            $confirm_date = $confirm_date_time[0];
            $confirm_time = $confirm_date_time[1];


            $pm_data = get_userdata($pm_id);

            $referrals_table = $wpdb->prefix . "referrals";
            $customers_table = $wpdb->prefix . "customer";

            $points_count = $wpdb->get_var("select sum(points) from $customers_table
                                    inner join  $referrals_table on $customers_table.referral_id =  $referrals_table.ID
                                     where user_id=" . $pm_id . " group by user_id");




            //$subject = "Skyi - Reminder for Dispatch of ".$pm_data->display_name."'s Reward";
            $subject = "Reminder: " . $pm_data->display_name . " To Collect Reward Soon";


            $text = '<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ebebeb">
                      <tbody>
                        <tr>
                          <td style="background-color: #ebebeb;" align="center" valign="top" bgcolor="#ebebeb"><br /> <!-- 600px container (white background) -->
                            <table class="container" border="0" width="600" cellspacing="0" cellpadding="0">
                              <tbody>
                                <tr>
                                  <td align="center">
                                    <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="Skyi" /></div>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: arial; color: #333;" align="left" bgcolor="#ffffff"><br /> <!-- ### BEGIN CONTENT ### --> <br /> Hello <span style="font-size: 15px; line-height: 24px; color: #f28428;">' . $user_data->display_name . '</span>,<br /><br /> A gentle reminder to let you know that Program Member <b>' . $pm_data->display_name . '</b> will be coming to collect the reward <b>' . $package->name . '</b> on <b>' . $confirm_date . '</b> at <b>' . $confirm_time . '</b>. <br /><br /> Yes, we\'ve already sent ' . $pm_data->display_name . ' a reminder! :) </td>
                                </tr>
                                <tr>
                                  <td align="center" bgcolor="#ffffff">
                                    <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><br /> <br /> <img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="SKYi" /></div>
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

            send_mail($subject, $text, $to, $comm_id);



            break;




        case "Send_closure_PM":

            $to = $recipeint;


            $user_data = get_user_by('email', $to);


            $user_hash = get_user_meta($user_data->ID, 'hash', true);


            $subject = "Your Reward Request Is Closed";

            //option name - approved
            $qry_get_option_name = "SELECT redmp_meta.optionid as option_value, redmp_meta.date as deliver_date  FROM " . $wpdb->prefix . "redemption redmp
                                        LEFT JOIN
                                        " . $wpdb->prefix . "redemption_meta redmp_meta

                                        on redmp.id = redmp_meta.redemption_id
                                            WHERE redmp_meta.status = 'Closed'
                                            AND redmp.userid = " . $user_data->ID;

            $res_get_option_name = $wpdb->get_results($qry_get_option_name, ARRAY_A);

            $option_value = $res_get_option_name[0]['option_value'];
            $package = get_term_by('id',  $option_value,'Options');

            $deliver_date_time = explode(" ", $res_get_option_name[0]['deliver_date']);
            $deliver_date = $deliver_date_time[0];
            $deliver_time = $deliver_date_time[1];





            $text = '<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ebebeb">
                      <tbody>
                        <tr>
                          <td style="background-color: #ebebeb;" align="center" valign="top" bgcolor="#ebebeb"><br /> <!-- 600px container (white background) -->
                            <table class="container" border="0" width="600" cellspacing="0" cellpadding="0">
                              <tbody>
                                <tr>
                                  <td align="center">
                                    <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="Skyi" /></div>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: arial; color: #333;" align="left" bgcolor="#ffffff"><br /> <!-- ### BEGIN CONTENT ### --> <br /> Hello <b style="font-weight: bold; font-size: 15px; line-height: 24px; color: #f28428;">' . $user_data->display_name . '</b>,<br /><br /> We are happy to confirm that you have successfully redeemed your points. <br /><br /> Thank you for collecting your reward <b>' . $package->name . '</b> on <b>' . $deliver_date . '</b>. <br /><br /> We\'d like to take this opportunity to thank you for your valuable time and effort in participating in the Rewards Program. <br /><br /> Thank you again,<br /> Team at SKYi Rewards Program</td>
                                </tr>
                                <tr>
                                  <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 11px; line-height: 20px; font-family: arial; color: #9c9c9c; font-style: italic;" align="left" bgcolor="#ffffff"><br /><br /> You received this email because you\'re a registered Skyi user. We occasionally send system alerts with account information, planned outages, system improvements, and important customer-service updates. We\'ll keep them brief and useful. Promise.<br /><b> ©2013 skyi. All Rights Reserved.</b> </td>
                                </tr>
                                <tr>
                                  <td align="center" bgcolor="#ffffff">
                                    <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><br /> <br /> <img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="SKYi" /></div>
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

            send_mail($subject, $text, $to, $comm_id);


            break;







        case "Send_closure_RM":

            $to = $recipeint;



            $user_data = get_user_by('email', $to);

            $user_hash = get_user_meta($user_data->ID, 'hash', true);


            //option name - approved


            $qry_get_option_name_pm_dt = "SELECT cm_md_mta.value as pm, redmp_mta.optionid  as  option_value, redmp_mta.date  as  deliver_date  FROM " . $wpdb->prefix . "module_meta cm_md_mta
                                                JOIN " . $wpdb->prefix . "redemption redmp
                                                on cm_md_mta.value =  redmp.userid
                                                JOIN " . $wpdb->prefix . "redemption_meta redmp_mta
                                                on  redmp.id = redmp_mta.redemption_id


                                    WHERE comm_module_id = " . $comm_id . " AND cm_md_mta.key = 'add_info'

                                    And redmp_mta.status = 'Closed' ";



            $res_get_option_name_pm_dt = $wpdb->get_results($qry_get_option_name_pm_dt, ARRAY_A);

            $pm_id = $res_get_option_name_pm_dt[0]['pm'];
            $option_value = $res_get_option_name_pm_dt[0]['option_value'];
            $package = get_term_by('id',  $option_value,'Options');

            $deliver_date_time = explode(" ", $res_get_option_name_pm_dt[0]['deliver_date']);
            $deliver_date = $deliver_date_time[0];
            $deliver_time = $deliver_date_time[1];


            $pm_data = get_userdata($pm_id);

            $referrals_table = $wpdb->prefix . "referrals";
            $customers_table = $wpdb->prefix . "customer";

            $points_count = $wpdb->get_var("select sum(points) from $customers_table
                                    inner join  $referrals_table on $customers_table.referral_id =  $referrals_table.ID
                                     where user_id=" . $pm_id . " group by user_id");




            $subject = "Redemption Process Completed For " . $pm_data->display_name;


            $text = ' <table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ebebeb">
                          <tbody>
                            <tr>
                              <td style="background-color: #ebebeb;" align="center" valign="top" bgcolor="#ebebeb"><!-- 600px container (white background) --> <br />
                                <table class="container" border="0" width="600" cellspacing="0" cellpadding="0">
                                  <tbody>
                                    <tr>
                                      <td align="center">
                                        <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="Skyi" /></div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: arial; color: #333;" align="left" bgcolor="#ffffff"><br /> <!-- ### BEGIN CONTENT ### --> <br /> Hello <span style="font-size: 15px; line-height: 24px; color: #f28428;">' . $user_data->display_name . '</span>,<br /><br /> The redemption process is complete for the following Program Member. <br /><br /> Program Member : <b>' . $pm_data->display_name . '</b><br /> Option : <b>' . $package->name . '</b><br /> Delivered On : <b>' . $deliver_date . '</b></td>
                                    </tr>
                                    <tr>
                                      <td align="center" bgcolor="#ffffff">
                                        <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><br /> <br /> <img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="SKYi" /></div>
                                      </td>
                                      <td>  </td>
                                    </tr>
                                    <tr>
                                      <td align="center" bgcolor="#ffffff">
                                        <div style="text-shadow: white 0 1px 0px; background-repeat: no-repeat; margin: 10px 0; padding-top: 7px; color: #777777; font: 12px/18px Helvetica, sans-serif;"><a style="color: #777777; text-decoration: underline;" href="#">SKYi Website</a>. </div>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                                <br /> <!--/600px container --></td>
                            </tr>
                          </tbody>
                        </table>';

            send_mail($subject, $text, $to, $comm_id);





            break;




        case "Conversion_type":

            $to = $recipeint;



            $user_data = get_userdata($to);

            $user_hash = get_user_meta($user_data->ID, 'hash', true);
            $referrals_table = $wpdb->prefix . "referrals";
            $customers_table = $wpdb->prefix . "customer";


            $to = $user_data->user_email;
            //option name - approved


            $qry_get_option_referral = "SELECT  reftbl.name as referral_name, reftbl.ID as referral_id,email 
                                            FROM " . $wpdb->prefix . "module_meta cm_md_mta
                                                LEFT JOIN " . $referrals_table . " reftbl on

                                                    cm_md_mta.value = reftbl.ID

                                                WHERE comm_module_id = " . $comm_id . "
                                                    AND cm_md_mta.key = 'add_info'  ";


            $referral_data = $wpdb->get_results($qry_get_option_referral, ARRAY_A);


            $referral_id = $referral_data[0]['referral_id'];
            $referral_name = $referral_data[0]['referral_name'];
            $referral_email = $referral_data[0]['email'];
            if($referral_name == "")
            {
                $name_val = $referral_email;
            }
            else
            {
                 $name_val = $referral_name;
            }



            $points_count = $wpdb->get_var("select sum(points) from $customers_table
                                    inner join  $referrals_table on $customers_table.referral_id =  $referrals_table.ID
                                     where user_id=" . $recipeint . " group by user_id");



            //get referral points

            $referral_points = " SELECT points FROM " . $customers_table . "
                                WHERE referral_id = " . $referral_id;

            $referral_points = $wpdb->get_var($referral_points);



            $subject = "Your Referral Is Now A Skyi Customer!";


            $text = '<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ebebeb">
                          <tbody>
                            <tr>
                              <td style="background-color: #ebebeb;" align="center" valign="top" bgcolor="#ebebeb"><!-- 600px container (white background) -->
                                <br>
                                <table class="container" border="0" width="600" cellspacing="0" cellpadding="0">
                                  <tbody>
                                    <tr>
                                      <td align="center">
                                        <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="Skyi" /></div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: arial; color: #333;" align="left" bgcolor="#ffffff"><br /> <!-- ### BEGIN CONTENT ### --> <br /> Hi <b style="font-weight: bold; font-size: 15px; line-height: 24px; color: #f28428;">' . $user_data->display_name . '</b>,<br /><br /> We have fantastic news to share! <strong>' . $name_val . '</strong> has joined our list of valued clients. Thank you for the introduction! <br />
                                        <h4>As Program Member on the SKYi Rewards Program, your points tally is:</h4>
                                        Points for the above referral : <b>' . $referral_points . '</b><br /> Total points : <b>' . $points_count . '</b> <br /> <br /> For more details, go to : <a style="color: #f28428; text-decoration: none; font-size: 14px; cursor: pointer;"   href= "' . site_url() . '/customer/#user/' . $user_hash . '/' . $user_data->ID . '" >(link)</a> <br /><br /> If you have any further enquiries feel free to contact us on <b>+91 20 6790 6790</b> or email us at <a style="color: #f28428; text-decoration: none; font-size: 14px; cursor: pointer;" href="mailto:sales@skyi.com">sales@skyi.com</a> <br /><br /> Regards,<br /> Program Manager,<br /> SKYi Rewards Program</td>
                                    </tr>
                                    <tr>
                                      <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 11px; line-height: 20px; font-family: arial; color: #9c9c9c; font-style: italic;" align="left" bgcolor="#ffffff"><br /><br /> You received this email because you\'re a registered Skyi user. We occasionally send system alerts with account information, planned outages, system improvements, and important customer-service updates. We\'ll keep them brief and useful. Promise.<br /><b> ©2013 skyi. All Rights Reserved.</b> </td>
                                    </tr>
                                    <tr>
                                      <td align="center" bgcolor="#ffffff">
                                        <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><br /> <br /> <img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="SKYi" /></div>
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

            send_mail($subject, $text, $to, $comm_id);




            break;




        case "Confirmed_PM_type":

            $to = $recipeint;


            $user_data = get_userdata($to);


            $user_hash = get_user_meta($user_data->ID, 'hash', true);

            $to = $user_data->user_email;

            $subject = "You Have Confirmed To Collect Your Reward.";

            //option name - approved
            $qry_get_option_name_dt = "SELECT redmp_meta.optionid as option_value, redmp_meta.confirm_date as confirm_date
                                        FROM " . $wpdb->prefix . "redemption redmp
                                            LEFT JOIN
                                        " . $wpdb->prefix . "redemption_meta redmp_meta

                                        on redmp.id = redmp_meta.redemption_id
                                            WHERE redmp_meta.status = 'Confirmed'
                                            AND redmp.userid = " . $user_data->ID;

            $res_get_option_name_dt = $wpdb->get_results($qry_get_option_name_dt, ARRAY_A);

            $option_value = $res_get_option_name_dt[0]['option_value'];
            $package = get_term_by('id',  $option_value,'Options');

            $confirm_date_time = explode("|", $res_get_option_name_dt[0]['confirm_date']);



            $confirm_date = $confirm_date_time[0];
            $confirm_time = $confirm_date_time[1];





            $text = '<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ebebeb">
                      <tbody>
                        <tr>
                          <td style="background-color: #ebebeb;" align="center" valign="top" bgcolor="#ebebeb"><br /> <!-- 600px container (white background) -->
                            <table class="container" border="0" width="600" cellspacing="0" cellpadding="0">
                              <tbody>
                                <tr>
                                  <td align="center">
                                    <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="Skyi" /></div>
                                  </td>
                                </tr>
                                <tr>
                                  <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: arial; color: #333;" align="left" bgcolor="#ffffff"><br /> <!-- ### BEGIN CONTENT ### --> <br /> Dear <span style="font-size: 15px; line-height: 24px; color: #f28428;">' . $user_data->display_name . '</span>,
                                  <br><br>
                                  You have confirmed to come to receive your reward <b>' . $package->name . '</b> on <b>' . $confirm_date . '</b> at <b>' . $confirm_time . '</b>.
                                  <br><br>
                                  <b>Our office address is:</b> <br /> 1, Kanchan Lane <br /> Law College Road, <br /> Near Krishna Dining Hall, <br /> Pune - 411004.  <br /><br />We look forward to meeting you soon.<br /><br /> Regards,<br /> Rewards Manager,<br /> SKYi Referral Program
                                  </td>
                                </tr>
                                <tr>
                                  <td align="center" bgcolor="#ffffff">
                                    <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><br /> <br /> <img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="SKYi" /></div>
                                  </td>
                                  <td>  </td>
                                </tr>
                                <tr>
                                  <td align="center" bgcolor="#ffffff">
                                    <div style="text-shadow: white 0 1px 0px; background-repeat: no-repeat; margin: 10px 0; padding-top: 7px; color: #777777; font: 12px/18px Helvetica, sans-serif;"><a style="color: #777777; text-decoration: underline;" href="#">SKYi Website</a>. </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <br /> <!--/600px container --></td>
                        </tr>
                      </tbody>
                    </table>';



            send_mail($subject, $text, $to, $comm_id);


            break;








        case "Confirmed_type":

            $to = $recipeint;



            $user_data = get_user_by('email', $to);

            $user_hash = get_user_meta($user_data->ID, 'hash', true);


            //option name - approved


            $qry_get_option_name_pm_dt = "SELECT cm_md_mta.value as pm, redmp_mta.optionid  as  option_value,
                                                redmp_mta.confirm_date  as  confirm_date

                                            FROM " . $wpdb->prefix . "module_meta cm_md_mta
                                                JOIN " . $wpdb->prefix . "redemption redmp
                                                    on cm_md_mta.value =  redmp.userid

                                                JOIN " . $wpdb->prefix . "redemption_meta redmp_mta
                                                    on  redmp.id = redmp_mta.redemption_id

                                            WHERE comm_module_id = " . $comm_id . " AND cm_md_mta.key = 'add_info'
                                                And redmp_mta.status = 'Confirmed' ";



            $res_get_option_name_pm_dt = $wpdb->get_results($qry_get_option_name_pm_dt, ARRAY_A);

            $pm_id = $res_get_option_name_pm_dt[0]['pm'];

            $option_value = $res_get_option_name_pm_dt[0]['option_value'];
            $package = get_term_by('id',  $option_value,'Options');

            $confirm_date_time = explode("|", $res_get_option_name_pm_dt[0]['confirm_date']);
            $confirm_date = $confirm_date_time[0];
            $confirm_time = $confirm_date_time[1];


            $pm_data = get_userdata($pm_id);

            /* $referrals_table = $wpdb->prefix . "referrals";
              $customers_table = $wpdb->prefix . "customer";

              $points_count = $wpdb->get_var( "select sum(points) from $customers_table
              inner join  $referrals_table on $customers_table.referral_id =  $referrals_table.ID
              where user_id=" . $pm_id . " group by user_id" );
             */



            $subject = "Confirmation from " . $pm_data->display_name;


            $text = '<table border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#ebebeb">
                          <tbody>
                            <tr>
                              <td style="background-color: #ebebeb;" align="center" valign="top" bgcolor="#ebebeb"><br /> <!-- 600px container (white background) -->
                                <table class="container" border="0" width="600" cellspacing="0" cellpadding="0">
                                  <tbody>
                                    <tr>
                                      <td align="center">
                                        <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="Skyi" /></div>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td class="container-padding" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 13px; line-height: 20px; font-family: arial; color: #333;" align="left" bgcolor="#ffffff"><br /> <!-- ### BEGIN CONTENT ### --> <br /> Dear <span style="font-size: 15px; line-height: 24px; color: #f28428;">' . $user_data->display_name . '</span>,
                                      <br><br>
                                          <b>' . $pm_data->display_name . '</b> has confirmed to come to and collect the reward <b>' . $package->name . '</b> on <b>' . $confirm_date . '</b> at <b>' . $confirm_time . '</b>.
                                      <br><br>
                                      <b>Our office address is:</b> <br /> 1, Kanchan Lane <br /> Law College Road, <br /> Near Krishna Dining Hall, <br /> Pune - 411004.  <br /><br />We look forward to meeting you soon.<br /><br /> Regards,<br /> Rewards Manager,<br /> SKYi Rewards Program
                                      </td>
                                    </tr>
                                    <tr>
                                      <td align="center" bgcolor="#ffffff">
                                        <div class="header" style="margin-bottom: 10px; color: #b8b8b8;"><br /> <br /> <img src="' . site_url() . '/wp-content/themes/Rewards/img/skyi-logo-1.png" alt="SKYi" /></div>
                                      </td>
                                      <td>  </td>
                                    </tr>
                                    <tr>
                                      <td align="center" bgcolor="#ffffff">
                                        <div style="text-shadow: white 0 1px 0px; background-repeat: no-repeat; margin: 10px 0; padding-top: 7px; color: #777777; font: 12px/18px Helvetica, sans-serif;"><a style="color: #777777; text-decoration: underline;" href="#">SKYi Website</a> .</div>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                                <br /> <!--/600px container --></td>
                            </tr>
                          </tbody>
                        </table>';

            send_mail($subject, $text, $to, $comm_id);


            break;
    }
}