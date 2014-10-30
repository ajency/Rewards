<?php
date_default_timezone_set( "Asia/Kolkata" );
require_once 'functions.php';
require_once 'send_mail.php';

//add_action('wp_ajax_nopriv_get_userdata', 'ajax_call_to_fetch_referral_users');

add_action( 'wp_ajax_get_userdata', 'ajax_call_to_fetch_referral_users' );

/**
 * ajax_call_to_fetch_referrals
 */
function ajax_call_to_fetch_referral_users() {

    $program_member_info      = array(
        'program_member_name'  => $_REQUEST[ 'program_member_name' ],
        'program_member_email' => $_REQUEST[ 'program_member_email' ],
        'program_member_phone' => $_REQUEST[ 'program_member_phone' ],
        'customer'             => $_REQUEST[ 'customer' ]
    );
    $referrals                = array();
    $referral_emails_accepted = array();
    $referral_emails_rejected = array();
    $referral_names_rejected  = array();
    $referral_cities_rejected = array();
    $referral_phone_accepted  = array();
    $referral_phone_rejected  = array();
    $referrals_rejected       = array();
    $referrals_accepted       = array();
    $parameter                = "";
    $args                     = "";
    $params                   = "";
    $argument                 = "";
    if ( !( email_exists( $_REQUEST[ 'program_member_email' ] ) ) ) {

        $program_user = create_program_member( $program_member_info );
        if ( $program_user ) {

            $num_ref = explode( ',', $_REQUEST[ 'num_ref' ] );
            for ( $ii = 0; $ii < count( $num_ref ); $ii++ ) {
                $i = $num_ref[ $ii ];

                if ( $_REQUEST[ 'hide' . $i ] == 0 ) {

                    if ( $_REQUEST[ 'referral_email' . $i ] != "" ) {
                        $parameter = $_REQUEST[ 'referral_email' . $i ];
                        $argument  = "email";

                    } else if ( $_REQUEST[ 'referral_phone' . $i ] != "" ) {
                        $params = $_REQUEST[ 'referral_phone' . $i ];
                        $args  = "phone";

                    }
                    if ( ( $_REQUEST[ 'referral_phone' . $i ] != "" ) && ( $_REQUEST[ 'referral_email' . $i ] != "" ) ) {
                        $parameter = $_REQUEST[ 'referral_email' . $i ];
                        $argument  = "email";
                        $params    = $_REQUEST[ 'referral_phone' . $i ];
                        $args      = "phone";

                    }
                    if ( !( referral_email_exists( $parameter, $argument, $params, $args ) ) ) {

                        $referrals[ ] = array(
                            'referral_name'      => $_REQUEST[ 'referral_name' . $i ],
                            'referral_email'     => $_REQUEST[ 'referral_email' . $i ],
                            'referral_phone'     => $_REQUEST[ 'referral_phone' . $i ],
                            'referral_city'      => $_REQUEST[ 'referral_city' . $i ],
                            'program_memeber_id' => $program_user,
                            'status'             => 'New Referral',

                        );
                        $referrals_accepted[ ] = array(
                            'referral_name'      => $_REQUEST[ 'referral_name' . $i ],
                            'referral_email'     => $_REQUEST[ 'referral_email' . $i ],
                            'referral_phone'     => $_REQUEST[ 'referral_phone' . $i ],
                            'referral_city'      => $_REQUEST[ 'referral_city' . $i ],
                            'program_memeber_id' => $program_user,
                            'status'             => 'New Referral',

                        );
                        if ( $_REQUEST[ 'referral_email' . $i ] != "" ) {
                            $referral_emails_accepted[ ] = $_REQUEST[ 'referral_email' . $i ];
                        } else if ( $_REQUEST[ 'referral_phone' . $i ] != "" ) {
                            $referral_phone_accepted[ ] = $_REQUEST[ 'referral_phone' . $i ];
                        }
                    } else {

                        $referrals_rejected[ ] = array(
                            'referral_name'      => $_REQUEST[ 'referral_name' . $i ],
                            'referral_email'     => $_REQUEST[ 'referral_email' . $i ],
                            'referral_phone'     => $_REQUEST[ 'referral_phone' . $i ],
                            'referral_city'      => $_REQUEST[ 'referral_city' . $i ],
                            'program_memeber_id' => $program_user,
                            'status'             => 'Present in the system',

                        );
                        
                            $referral_emails_rejected[ ] = $_REQUEST[ 'referral_email' . $i ];
                            $referral_names_rejected[ ]  = $_REQUEST[ 'referral_name' . $i ];
                            $referral_cities_rejected[ ] = $_REQUEST[ 'referral_city' . $i ];
                       
                            $referral_phone_rejected[ ] = $_REQUEST[ 'referral_phone' . $i ];
                        
                    }
                }
                 $referral_id = create_referral( $referrals );
                  $referrals                = array();
            }

           
            //send_mail_to_referrer($referrals);


            insert_mail_info( $referral_emails_accepted, $_REQUEST[ 'program_member_email' ], $referral_emails_rejected, $referral_phone_accepted, $referral_phone_rejected, $referral_names_rejected, $referral_cities_rejected );


            wp_send_json( array( 'code' => 'OK', 'data' => array( 'ID' => $program_user, 'accept' => $referrals_accepted, 'reject' => $referrals_rejected ) ) );
        }
    } else {
        $get_program_member_user_id = get_program_member_user( $_REQUEST[ 'program_member_email' ], $_REQUEST[ 'customer' ], $_REQUEST[ 'program_member_phone' ] );
        if ( $get_program_member_user_id ) {
            $num_ref = explode( ',', $_REQUEST[ 'num_ref' ] );
            for ( $ii = 0; $ii < count( $num_ref ); $ii++ ) {
                $i = $num_ref[ $ii ];
                if ( $_REQUEST[ 'hide' . $i ] == 0 ) {

                    if ( $_REQUEST[ 'referral_email' . $i ] != "" ) {
                        $parameter = $_REQUEST[ 'referral_email' . $i ];
                        $argument  = "email";

                    }
                    if ( $_REQUEST[ 'referral_phone' . $i ] != "" ) {
                        $params = $_REQUEST[ 'referral_phone' . $i ];
                        $args  = "phone";

                    }
                    if ( ( $_REQUEST[ 'referral_phone' . $i ] != "" ) && ( $_REQUEST[ 'referral_email' . $i ] != "" ) ) {
                        $parameter = $_REQUEST[ 'referral_email' . $i ];
                        $argument  = "email";
                        $params    = $_REQUEST[ 'referral_phone' . $i ];
                        $args      = "phone";

                    }
                    if ( !( referral_email_exists( $parameter, $argument, $params, $args ) ) ) {

                        $referrals[ ] = array(
                            'referral_name'      => $_REQUEST[ 'referral_name' . $i ],
                            'referral_email'     => $_REQUEST[ 'referral_email' . $i ],
                            'referral_phone'     => $_REQUEST[ 'referral_phone' . $i ],
                            'referral_city'      => $_REQUEST[ 'referral_city' . $i ],
                            'program_memeber_id' => $get_program_member_user_id,
                            'status'             => 'New Referral',

                        );
                        
                        $referrals_accepted[ ] = array(
                            'referral_name'      => $_REQUEST[ 'referral_name' . $i ],
                            'referral_email'     => $_REQUEST[ 'referral_email' . $i ],
                            'referral_phone'     => $_REQUEST[ 'referral_phone' . $i ],
                            'referral_city'      => $_REQUEST[ 'referral_city' . $i ],
                            'program_memeber_id' => $get_program_member_user_id,
                            'status'             => 'New Referral',

                        );
                        if ( $_REQUEST[ 'referral_email' . $i ] != "" ) {
                            $referral_emails_accepted[ ] = $_REQUEST[ 'referral_email' . $i ];
                        } else if ( $_REQUEST[ 'referral_phone' . $i ] != "" ) {
                            $referral_phone_accepted[ ] = $_REQUEST[ 'referral_phone' . $i ];
                        }
                    } else {

                        $referrals_rejected[ ] = array(
                            'referral_name'      => $_REQUEST[ 'referral_name' . $i ],
                            'referral_email'     => $_REQUEST[ 'referral_email' . $i ],
                            'referral_phone'     => $_REQUEST[ 'referral_phone' . $i ],
                            'referral_city'      => $_REQUEST[ 'referral_city' . $i ],
                            'program_memeber_id' => $get_program_member_user_id,
                            'status'             => 'Present in the system',

                        );
                        
                            $referral_emails_rejected[ ] = $_REQUEST[ 'referral_email' . $i ];
                            $referral_names_rejected[ ]  = $_REQUEST[ 'referral_name' . $i ];
                            $referral_cities_rejected[ ] = $_REQUEST[ 'referral_city' . $i ];
                     
                            $referral_phone_rejected[ ] = $_REQUEST[ 'referral_phone' . $i ];
                        
                    }
                }
                
                 $referral_id = create_referral( $referrals );
                 $referrals                = array();
            }

           


            insert_mail_info( $referral_emails_accepted, $_REQUEST[ 'program_member_email' ], $referral_emails_rejected, $referral_phone_accepted, $referral_phone_rejected, $referral_names_rejected, $referral_cities_rejected );

            wp_send_json( array( 'code' => 'OK', 'data' => array( 'ID' => $get_program_member_user_id, 'accept' => $referrals_accepted, 'reject' => $referrals_rejected ) ) );
        }
    }
}