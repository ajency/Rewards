<?php

function parseCSV( $filepath ) {

    // read the csv file
    $csv = new Coseva\CSV( $filepath );

    // parse the csv
    $csv->parse();

    //Convert parsed csv data to a json string
    $csvJson = $csv->toJSON();

    return $csvJson;
}

function get_CSV_Content( $csvJson ) {

    global $wpdb;
    $customer  = $wpdb->prefix . "customer";
    $referrals = $wpdb->prefix . "referrals";

    $csvData = json_decode( $csvJson );
    $i       = 0;

    //Counter variables to keep track
    $totalCsvRecords   = count( $csvData ); //total records in CSV
    $customerDuplicate = 0;
    $customerAdded     = 0;
    $referralsAdded    = 0;

    //While there is an entry in the CSV data
    while ( $i < count( $csvData ) ) {
        //Take the email_id as $csvEmailId from the ith row
        $csvName           = $csvData[ $i ][ 0 ];
        $csvEmailId        = $csvData[ $i ][ 1 ];
        $csvPhone          = $csvData[ $i ][ 2 ];
        $csvDateOfPurchase = $csvData[ $i ][ 3 ];
        $csvPurchaseValue  = $csvData[ $i ][ 4 ];
        $dateOfImport      = date( "Y-m-d" ); //Current date
        $referralPoints    = getRefererralPoints( $csvPurchaseValue ); //Referral points based on value


        /* Loop through all rows of customer table and check if $csvEmailId is present */

        //Query the customer table to see if $csvEmailId is present
		if($csvEmailId!="")
		{
			$selectQuery = $wpdb->get_row( "select * from $customer where email_id like '%" . $csvEmailId . "%'" );
			//$result = $dbconn->query($selectQuery);
			// Number of rows found.
			$emailIdFound = $selectQuery->email_id;
            $csvPhoneNO = $csvPhone;
            $csvPhoneNO = str_replace(" ", "", $csvPhoneNO);
		}
		else{
            $csvPhoneArr = explode(' ',$csvPhone);
            if($csvPhoneArr.length == 0)
            {
                if(strpos($csvPhone,'+')=== false)
                {
                    $csvPhoneNO = '+91 '.$csvPhone;
                }
                else
                {
                    $csvPhoneNO = $csvPhone;
                }
            }
            if(strpos($csvPhoneArr[0],'+')=== false)
            {
               $csvPhoneNO = '+91 '.$csvPhoneArr[0];
            }
            else
            {
                $csvPhoneNO =  $csvPhoneArr[1] ;
            }
            $info = $wpdb->get_results( "SELECT *  from $customer ");
            foreach ( (array) $info as $value ) {

                if(strpos($value->phone,'+')=== false)
                {
                    $value->phone = '+91 '.$value->phone;
                }
                $value->phone = str_replace(" ", "", $value->phone);
                $wpdb->update( "$customer" , array(phone => $value->phone),array(id => $value->id));

            }
            $csvPhoneNO = str_replace(" ", "", $csvPhoneNO);
			$selectQuery = $wpdb->get_row( "select * from $customer where phone like '%".$csvPhoneNO."%'" );
			//$result = $dbconn->query($selectQuery);
			// Number of rows found.
			$emailIdFound = $selectQuery->phone;
		
		}

        //If $csvEmailId found in customer table
        if ( $selectQuery != null ) {
            //increment duplicate counter
            $customerDuplicate++;
        } else {
            //Insert into customer table

            $wpdb->insert( $customer, array(
                    'email_id'         => $csvEmailId,
                    'phone'            => $csvPhoneNO,
                    'date_of_import'   => $dateOfImport,
                    'date_of_purchase' => $csvDateOfPurchase,
                    'purchase_value'   => $csvPurchaseValue,
                    'points'           => $referralPoints
                )
            );


            if ( $wpdb->insert_id )
                $customerAdded++;
            else
                die( mysql_error() );

            //Also check if the email_id is present in referrals table
            //Query the database
			if($csvEmailId!="")
			{
				$queryReferrals = $wpdb->get_row( "select * from $referrals where email like '%" . $csvEmailId . "%'" );
                $csvPhoneNO = $csvPhone;
			}
			else
			{
                $csvPhoneArr = explode(' ',$csvPhone);
                if($csvPhoneArr.length == 0)
            {
                if(strpos($csvPhone,'+')=== false)
                {
                    $csvPhoneNO = '+91 '.$csvPhone;
                }
                else
                {
                    $csvPhoneNO = $csvPhone;
                }
            }
            if(strpos($csvPhoneArr[0],'+')=== false)
            {
                $csvPhoneNO = '+91 '.$csvPhoneArr[0];
            }
            else
            {
                $csvPhoneNO =  $csvPhoneArr[1] ;
            }
            $info = $wpdb->get_results( "SELECT *  from $referrals ");
            foreach ( (array) $info as $value ) {
                if(strpos($value->phone,'+') === false)
                {
                    $value->phone = '+91 '.$value->phone;
                }
                $value->phone = str_replace(" ", "", $value->phone);
                $wpdb->update( "$referrals" , array(phone => $value->phone),array(ID => $value->ID));

            }
             $csvPhoneNO = str_replace(" ", "", $csvPhoneNO);
				$queryReferrals = $wpdb->get_row( "select * from $referrals where phone like '%" . $csvPhoneNO . "%'" );
			}
			
            //$resultReferrals = $dbconn->query($queryReferrals);
            //$rowReferrals = $resultReferrals->fetch_assoc();
            // Number of rows found.
            //$refEmailIdFound = $resultReferrals->num_rows;
            $referaal_id = $queryReferrals->ID;
            $user_id     = $queryReferrals->user_id;
            $single      = TRUE;
            //If $csvEmailId is also found in referrals table, update the customer table with the referral table details
            if ( $queryReferrals != null ) {

                if($csvEmailId!="")
				{
					$updateQuery = $wpdb->update(
						$customer, array(
						'referral_id' => $referaal_id // string
					), array( 'email_id' => $csvEmailId ) );
				}
				else
				{
						$updateQuery = $wpdb->update(
						$customer, array(
						'referral_id' => $referaal_id // string
					), array( 'phone' => $csvPhoneNO ) );
					
				}
                if ( $updateQuery ) {
                    $referralsAdded++;
                  
                    //Check if $rowReferrals['ID'] is present is usermeta if present update usermeta table else insert new
                    //$querySearchID = "select * from {$wpdb->prefix}usermeta where user_id =" . $user_id;
                    // = $wpdb->get_row($querySearchID);
                    $resultSearchID = get_user_meta( $user_id, 'customer', $single );

                    if ( $resultSearchID == "" ) {
                        //update row in usermeta
                        update_user_meta( $user_id, 'customer', 'true' );
                    } else {
                        //insert row in usermeta
                        add_user_meta( $user_id, 'customer', 'true' );
                    }
                    send_mail_program_member( $referaal_id);
                } else
                    die( mysql_error() );
            }
        }
        //Increment while counter 
        $i++;
    }
    $updateQuery  = $wpdb->get_row( "select * from $customer ORDER BY date_of_import DESC limit 1" );
    $date         = $updateQuery->date_of_import;
    $result_array = array( $totalCsvRecords, $customerDuplicate, $customerAdded, $referralsAdded, $date );

    return $result_array;
}

function getRefererralPoints( $referralValue ) {

    $points = 0;

    if ( ( $referralValue >= 2500000 ) && ( $referralValue < 5000000 ) ) {
        $points = 1;
    } else if ( ( $referralValue >= 5000000 ) && ( $referralValue < 7500000 ) ) {
        $points = 2;
    } else if ( ( $referralValue >= 7500000 ) && ( $referralValue < 10000000 ) ) {
        $points = 3;
    } else if ( ( $referralValue >= 10000000 ) && ( $referralValue < 12500000 ) ) {
        $points = 4;
    } else if ( ( $referralValue >= 12500000 ) && ( $referralValue < 15000000 ) ) {
        $points = 5;
    } else if ( ( $referralValue >= 15000000 ) && ( $referralValue < 17500000 ) ) {
        $points = 6;
    } else if ( ( $referralValue >= 17500000 ) && ( $referralValue < 20000000 ) ) {
        $points = 7;
    } else if ( ( $referralValue >= 20000000 ) && ( $referralValue < 22500000 ) ) {
        $points = 8;
    } else if ( ( $referralValue >= 22500000 ) && ( $referralValue < 25000000 ) ) {
        $points = 9;
    } else if ( ( $referralValue >= 25000000 ) && ( $referralValue < 27500000 ) ) {
        $points = 10;
    } else if ( ( $referralValue >= 27500000 ) && ( $referralValue <= 30000000 ) ) {
        $points = 11;
    } else {
        $points = 0;
    }

    return $points;
}

function send_mail_program_member( $referaal_id) {

    global $wpdb;
    $customer  = $wpdb->prefix . "customer";
    $referrals = $wpdb->prefix . "referrals";
    
        $comm_module_table = $wpdb->prefix . "comm_module";
        $comm_meta_table = $wpdb->prefix . "module_meta";
   
    $sql_get_programmmember_user = $wpdb->get_row( "select * from $referrals where ID = " . $referaal_id );
    if ( $sql_get_programmmember_user != null ) {
       
        $recipeint = $sql_get_programmmember_user->user_id;
        $wpdb->insert($comm_module_table, array('email_type' => 'Conversion_type', 'recipients' =>$recipeint,
            'status' => 'To be send', 'priority' => 'Normal', 'date' => date('Y-m-d H:i:s')));
        $wpdb->insert($comm_meta_table, array('comm_module_id' => $wpdb->insert_id, 'key' => 'add_info',
            'value' => $referaal_id));
      
    }
}

function get_CSV_Content_Ref($csvJson){
    
     global $wpdb;
    $customer  = $wpdb->prefix . "customer";
    $referrals = $wpdb->prefix . "referrals";

    $csvData = json_decode( $csvJson );
    $i       = 0;

    //Counter variables to keep track
    $totalCsvRecords   = count( $csvData ); //total records in CSV
    $customerDuplicate = 0;
    $customerAdded     = 0;
    $referralsAdded    = 0;
    $refCount = 0;
    $refduplicateCount = 0;
    $cusduplicateCount = 0;
    $programduplicateCount = 0;
    //While there is an entry in the CSV data
    while ( $i < count( $csvData ) ) {
        //Take the email_id as $csvEmailId from the ith row
        $csvdate            = $csvData[ $i ][ 1 ];
        $csvName            = $csvData[ $i ][ 2 ];
        $csvPhone           = $csvData[ $i ][ 3 ];
        $csvEmailId         = $csvData[ $i ][ 4 ];
        $csvSource          = $csvData[ $i ][ 6 ];
         
       $flag = 0;
        $flag1 = 0;
         $flag2 = 0;
       $u = 0;

        if($csvEmailId == "")
        {

            $csvEmailId = 'null';
        }
        if($csvPhone == "")
        {
            $csvPhone = 'null';
        }

	$queryReferralEmail = $wpdb->get_row( "select * from $referrals where email = '" . $csvEmailId . "'" );
        if($queryReferralEmail!=null)
        {
            $flag = 1;
            $u  = 1;
            $refduplicateCount++;
        }

                        if($flag==0)
                        {

                            $csvPhoneArr = explode(' ',$csvPhone);
                            if($csvPhoneArr.length == 0)
            {
                if(strpos($csvPhone,'+')=== false)
                {
                    $csvPhoneNO = '+91 '.$csvPhone;
                }
                else
                {
                    $csvPhoneNO = $csvPhone;
                }
            }
            if(strpos($csvPhoneArr[0],'+')=== false)
            {
                $csvPhoneNO = '+91 '.$csvPhoneArr[0];
            }
            else
            {
                $csvPhoneNO =  $csvPhoneArr[1] ;
            }
            $info = $wpdb->get_results( "SELECT *  from $referrals ");
            foreach ( (array) $info as $value ) {

                if(strpos($value->phone,'+')=== false)
                {
                    $value->phone = '+91 '.$value->phone;
                }
                $value->phone = str_replace(" ", "", $value->phone);
                $wpdb->update( "$referrals" , array(phone => $value->phone),array(ID => $value->ID));

            }
            $csvPhoneNO = str_replace(" ", "", $csvPhoneNO);
	$queryReferralPhone = $wpdb->get_row( "select * from $referrals where phone = '" . $csvPhoneNO . "'" );
	if($queryReferralPhone!=null)
        {
            $flag = 1;
            $u  = 1;
             $refduplicateCount++;
        }
                        }

        $queryCustomerEmail = $wpdb->get_row( "select * from $customer where email_id = '" . $csvEmailId . "'" );
        if($queryCustomerEmail!=null)
        {
            $flag1 = 1;
            $u  = 1;
             $cusduplicateCount++;
        }

 if($flag1==0) {

     $csvPhoneArr = explode(' ',$csvPhone);
     if($csvPhoneArr.length == 0)
            {
                if(strpos($csvPhone,'+')=== false)
                {
                    $csvPhoneNO = '+91 '.$csvPhone;
                }
                else
                {
                    $csvPhoneNO = $csvPhone;
                }
            }
            if(strpos($csvPhoneArr[0],'+')=== false)
            {
                $csvPhoneNO = '+91 '.$csvPhoneArr[0];
            }
            else
            {
                $csvPhoneNO =  $csvPhoneArr[1] ;
            }
            $info = $wpdb->get_results( "SELECT *  from $customer ");
            foreach ( (array) $info as $value ) {

                if(strpos($value->phone,'+')=== false)
                {
                    $value->phone = '+91 '.$value->phone;
                }
                $value->phone = str_replace(" ", "", $value->phone);
                $wpdb->update( "$customer" , array(phone => $value->phone),array(id => $value->id));

            }
            $csvPhoneNO = str_replace(" ", "", $csvPhoneNO);
	$queryCustomerPhone = $wpdb->get_row( "select * from $customer where phone = '" . $csvPhoneNO . "'" );
	if($queryCustomerPhone!=null)
        {
            $flag1 = 1;
            $u  = 1;
             $cusduplicateCount++;
        }
 }
        $phone ="";

        if(email_exists($csvEmailId))
        {
            $flag2 = 1;
            $u  = 1;
             $programduplicateCount++;
        }

 if($flag2==0) {
        if($csvPhone!="")
        {
            $csvPhoneArr = explode(' ',$csvPhone);
            if(strpos($csvPhoneArr[0],'+')=== false)
            {
                $csvPhoneNO = '+91 '.$csvPhoneArr[0];
            }
            else
            {
                $csvPhoneNO =  $csvPhoneArr[1] ;
            }
        $phone = get_users('meta_value='.$csvPhoneNO.'');
        if($phone!=null){

             $flag2 = 1;
             $u  = 1;
             $programduplicateCount++;

        }
        }
 }
        if($u==0)
        {

            if($csvEmailId == "null")
            {

                $csvEmailId = '';
            }
            if($csvPhone == "null")
            {
                $csvPhone = '';
            }
            $refCount++;
            $csvdatestr = explode(' ',$csvdate);
            $csvformattedate = explode('/',$csvdatestr[0]);

            $csvdatenew = $csvformattedate[2].'-'.$csvformattedate[1].'-'.$csvformattedate[0].' '.$csvdatestr[1];

            $user = get_users( 'role='.$csvSource );

            if(count($user)>0)
            {
            $wpdb->insert($referrals, array('name' => $csvName, 'email' => $csvEmailId,
            'city' => '', 'phone' => $csvPhoneNO, 'user_id' => $user[0]->ID ,
                'status'=>'New referral','date_time'=>$csvdatenew));
            }
        else {

            $user_id = wp_insert_user(array(
        'user_login' => $csvSource,
        'display_name' => $csvSource,
        'user_email' => $csvSource,
        'role' => $csvSource
            ));
            $hash_value = md5($csvSource);

    update_user_meta($user_id, 'hash', $hash_value);
            $wpdb->insert($referrals, array('name' => $csvName, 'email' => $csvEmailId,
             'phone' => $csvPhoneNO, 'user_id' => $user_id ,
                'status'=>'New referral','date_time'=>$csvdatenew));
        }
        }
        $i++;
    }
    
   return array(count( $csvData ),$refCount,$refduplicateCount,$cusduplicateCount,$programduplicateCount);

 
}


