<?php

function skyi_scripts() {
    wp_enqueue_script( 'customjs', site_template_directory_uri() . '/js/custom.js', array(), '', true );
	wp_enqueue_script( 'classie', site_template_directory_uri() . '/js/classie.js', array(), '', true );
	wp_enqueue_style( 'customcss', site_template_directory_uri() . '/css/custom.css');
   wp_localize_script(  "customjs", "SITEURL", site_url() );
}
add_action( 'wp_enqueue_scripts', 'skyi_scripts' );

function site_template_directory_uri() {
    return site_url('wp-content/themes/skyifirst');
}

/* Code added by Surekha */
// remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
//
// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
//
// remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
//
// remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );

add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
function wcs_woo_remove_reviews_tab($tabs) {
	unset( $tabs['description'] ); // Remove the description tab
unset( $tabs['reviews'] ); // Remove the reviews tab
unset( $tabs['additional_information'] ); // Remove the additional information tab
 return $tabs;
}

function remove_loop_button(){
	// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title',5);
	// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price',10);
	// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt',20);
	// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart',30);
	// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta',40);
	// remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing',50);


}
add_action('init','remove_loop_button');
add_filter('add_to_cart_redirect', 'themeprefix_add_to_cart_redirect');
function themeprefix_add_to_cart_redirect() {
 global $woocommerce;
 $checkout_url = $woocommerce->cart->get_checkout_url();
 return $checkout_url;
}
//Add New Pay Button Text
add_filter( 'woocommerce_product_single_add_to_cart_text', 'themeprefix_cart_button_text' );

function themeprefix_cart_button_text() {
 return __( 'Buy', 'woocommerce' );
}
add_filter( 'wc_add_to_cart_message', 'custom_add_to_cart_message' );

function custom_add_to_cart_message() {

echo '<style>.woocommerce-message {display: none !important;}</style>';

}

add_action( 'woocommerce_thankyou', 'my_function' );
/*
 * Do something after WooCommerce sets an order on completed
 */
function my_function($order_id) {

	// order object (optional but handy)
	global $woocommerce;
	$order = new WC_Order();
  if ( $order->status != 'failed' ) {
			// $rand = 'FREEDOM'.$order_id;
      $original_string = 'kjlmnopqrst';
      $random_string = get_random_string($original_string, 6);
      $rand = md5(uniqid($order_id, true));
      // $rand = $random_string;
			$payment = get_post_meta($order_id, '_payment_method' ,true);
			if( $payment != 'cheque' ){
			update_post_meta($order_id,'coupon' ,$rand );
			}

			?>
			<script type="text/javascript">
			jQuery('form').clearForm()

			</script>

			<?php
      $sales_person_email = get_post_meta($order_id, 'sales_person_email' ,true);
      // if($sales_person_email!="")
      // {
      //   wp_redirect( site_url().'/partner_thankyou' );
      // }
      // else {
      //     wp_redirect( site_url().'customer_thankyou' );
      // }
	    wp_redirect( home_url() ); exit; // or whatever url you want
	   }



}


add_filter('add_commponents_filter','dba_add_communication_components',10,1);



function wc_remove_all_quantity_fields( $return, $product ) {
    return true;
}
add_filter( 'woocommerce_is_sold_individually', 'wc_remove_all_quantity_fields', 10, 2 );


// add_action( 'init', 'we_woocommerce_clear_cart_url' );
// function we_woocommerce_clear_cart_url() {
//
//
// }

add_filter( 'woocommerce_add_cart_item_data', 'wdm_empty_cart', 10,  3);
function wdm_empty_cart( $cart_item_data, $product_id, $variation_id )
{
    global $woocommerce;
    $woocommerce->cart->empty_cart();

    // Do nothing with the data and return
    return $cart_item_data;
}
add_filter('woocommerce_enable_order_notes_field', '__return_false');
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

function custom_override_checkout_fields( $fields ) {
    // unset($fields['billing']['billing_first_name']);
    // unset($fields['billing']['billing_last_name']);
    unset($fields['billing']['billing_company']);
    // unset($fields['billing']['billing_address_1']);
    // unset($fields['billing']['billing_address_2']);
    // unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    // unset($fields['billing']['billing_country']);
    // unset($fields['billing']['billing_state']);
    // unset($fields['billing']['billing_phone']);
    unset($fields['order']['order_comments']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_company']);
    // unset($fields['billing']['billing_last_name']);
    // unset($fields['billing']['billing_email']);
    // unset($fields['billing']['billing_city']);
    return $fields;
}

function wc_custom_addresses_labels( $translated_text, $text, $domain )
{

    switch ( $translated_text )

    {
      	case 'Billing Details' : // Back-end
            $translated_text = __( 'Customer Details', 'woocommerce' );
            break;


    }
    return $translated_text;
}
add_filter( 'gettext', 'wc_custom_addresses_labels', 20, 3 );


$wdm_address_fields = array('address2','city','first_name','last_name','state','country' ,'address_1'

				);

//global array only for extra fields
	$wdm_ext_fields = array('address2');

add_filter( 'woocommerce_default_address_fields' , 'wdm_override_default_address_fields' );

     function wdm_override_default_address_fields( $address_fields ){

     $temp_fields = array();

     $address_fields['address2'] = array(
    'label'     => __('Addree 2', 'woocommerce'),
    'required'  => true,
    'class'     => array('form-row-wide'),
    'type'  => 'text',
     );

		// $address_fields['refund'] = array(
    // 'label'     => __('Refund', 'woocommerce'),
  	// 'class'     => array('form-row-wide'),
    // 'type'  => 'label',
    //  );



    global $wdm_address_fields;

    foreach($wdm_address_fields as $fky){
    $temp_fields[$fky] = $address_fields[$fky];
    }

    $address_fields = $temp_fields;

    return $address_fields;
}
add_filter("woocommerce_checkout_fields", "order_fields");

function order_fields($fields) {




$order = array(
    "billing_first_name",
	"billing_last_name",
    "billing_email",
	"billing_email-2",
    "billing_address_1",
    "billing_address_2",
    "billing_city",
    "billing_state",
	"billing_phone"

    );
    foreach($order as $field)
    {
        $ordered_fields[$field] = $fields["billing"][$field];
    }

    $fields["billing"] = $ordered_fields;
    $fields['billing']['billing_address_1']['placeholder'] = 'apartment,building ,floor etc';
		$fields['billing']['billing_address_2']['placeholder'] = 'street address, pincode etc';
		$fields['billing']['billing_first_name']['placeholder'] = 'John';
		$fields['billing']['billing_last_name']['placeholder'] = 'Doe';
		$fields['billing']['billing_email']['placeholder'] = 'john@example.com';
		$fields['billing']['billing_email-2']['placeholder'] = 'john@example.com';
		$fields['billing']['billing_phone']['placeholder'] = '+91 9123456780';
    $fields['billing']['billing_address_1']['label'] = 'Address';
		$fields['billing']['billing_phone']['label'] = 'Mobile';
    $fields['billing']['billing_state']['label'] = 'State';

    return $fields;
}
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );

add_action( 'woocommerce_checkout_order_review_details', 'woocommerce_order_review', 10 );
add_action( 'woocommerce_checkout_paymen_options', 'woocommerce_checkout_payment', 20 );

function kia_woocommerce_order_item_name( $name, $item ){

    $product_id = $item['product_id'];
    $tax = 'product_cat';

    $terms = wp_get_post_terms( $product_id, $tax, array( 'fields' => 'names' ) );

    if( $terms && ! is_wp_error( $terms )) {
        $taxonomy = get_taxonomy($tax);
        $name .= '<label>' . $taxonomy->label . ': </label>' . implode( ', ', $terms );
    }

    return $name;
}
add_filter( 'woocommerce_order_item_name', 'kia_woocommerce_order_item_name', 10, 2 );

add_filter( 'manage_edit-shop_order_columns', 'MY_COLUMNS_FUNCTION' );
function MY_COLUMNS_FUNCTION($columns){
    $new_columns = (is_array($columns)) ? $columns : array();
    unset( $new_columns['order_actions'] );
    unset( $new_columns['shipping_address'] );
    unset( $new_columns['customer_message'] );
    unset( $new_columns['order_notes'] );
    unset( $new_columns['order_items'] );
    unset( $new_columns['order_title'] );
    $new_columns['order_date'] = 'Booking Date';
    $new_columns['order_total'] = 'Amount';

    //edit this for you column(s)
    //all of your columns will be added before the actions column
    $new_columns['ordertitle'] = 'Bookings';
    $new_columns['order_product'] = 'Product';
    $new_columns['order_date'] = 'Booking Date';
    $new_columns['order_total'] = 'Amount';
    $new_columns['status'] = 'Status';

    //stop editing



    $new_columns['order_actions'] = $columns['order_actions'];
    return $new_columns;
}
add_action( 'manage_shop_order_posts_custom_column', 'MY_COLUMNS_VALUES_FUNCTION', 2 );

function MY_COLUMNS_VALUES_FUNCTION($column){
    global $post, $woocommerce, $the_order,$product;


    switch ( $column ) {

        case 'order_product' :
            $terms = $the_order->get_items();
           if ( is_array( $terms ) ) {
                 	foreach($terms as $term)
    		             {

                  		echo $term['item_meta']['pa_unit_type'][0];
                  		}
                  } else {
                  	_e( 'Unable get the producten', 'woocommerce' );
    		              }
                break;

        case 'status' :
             print_r($the_order->get_status());

            break;

        case 'ordertitle' :
						$order = new WC_Order($the_order->id);
						$billing_first_name = $order->billing_first_name;
            $billing_last_name = $order->billing_last_name;
            $billing_email = $order->billing_email;
            echo '<a href="'.esc_url( $the_order->get_view_order_url() ).'">#'.$the_order->get_order_number().'</a>

            by '.$billing_first_name.' '.$billing_last_name.'<br/>'.$billing_email.'';



            break;

    }
    //stop editing
}

add_action( 'woocommerce_admin_order_data_after_billing_address', 'woo_display_order_username', 10, 1 );

function woo_display_order_username( $order ){

    global $post;

		$order = new WC_Order($order->id);
		$billing_first_name = $order->billing_first_name;
		$billing_last_name = $order->billing_last_name;
		$billing_email = $order->billing_email;
    echo '<p><strong style="display: block;">'.__('Customer Username').':</strong> <a href="user-edit.php?user_id=' . $customer_user . '">' .$billing_first_name .' '.$billing_last_name. '</a></p>';
		echo '<p><strong style="display: block;">'.__('Customer Email Address').':</strong> <a href="user-edit.php?user_id=' . $customer_user . '">' .$billing_email. '</a></p>';


		$customer_coupon = get_post_meta( $post->ID, 'coupon', true ) != "" ? get_post_meta( $post->ID, 'coupon', true ) : 'Not generated';
    echo '<p><strong style="display: block;">'.__('Customer Coupon').':</strong>'.$customer_coupon.'</p>';
		$customer_chequeno = get_post_meta( $post->ID, 'cheque_no', true ) != "" ? get_post_meta( $post->ID, 'cheque_no', true ) : 'Not present';
    echo '<p><strong style="display: block;">'.__('Cheque No').':</strong>'.$customer_chequeno.'</p>';
		$customer_cheque_bank = get_post_meta( $post->ID, 'cheque_bank', true ) != "" ? get_post_meta( $post->ID, 'cheque_bank', true ) : 'Not present';
    echo '<p><strong style="display: block;">'.__('Bank').':</strong>'.$customer_cheque_bank.'</p>';
}


add_action( 'add_meta_boxes', 'add_meta_boxes' );

function add_meta_boxes()
{
    add_meta_box(
        'woocommerce-order-my-custom',
        __( 'Cheque Details' ),
        'order_my_custom',
        'shop_order',
        'side',
        'default'
    );

}
function order_my_custom($post)
{

	wp_nonce_field( 'myplugin_save_meta_box_data', 'myplugin_meta_box_nonce' );


	$value = get_post_meta( $post->ID, 'cheque_no', true );

	echo '<label for="myplugin_cheque_no">';
	_e( 'Cheque No', 'myplugin_textdomain' );
	echo '</label> ';
	echo '<input type="text" id="myplugin_cheque_no" name="myplugin_cheque_no" value="' . esc_attr( $value ) . '" size="25" />';

	$value = get_post_meta( $post->ID, 'cheque_bank', true );

	echo '<br/><label for="myplugin_cheque_bank">';
	_e( 'Bank', 'myplugin_textdomain' );
	echo '</label> ';
	echo '<br/><input type="text" id="myplugin_cheque_bank" name="myplugin_cheque_bank" value="' . esc_attr( $value ) . '" size="25" />';



}

function myplugin_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'myplugin_save_meta_box_data' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.
	if ( ! isset( $_POST['myplugin_cheque_no'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['myplugin_cheque_no'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'cheque_no', $my_data );


	// Make sure that it is set.
	if ( ! isset( $_POST['myplugin_cheque_bank'] ) ) {
		return;
	}

	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['myplugin_cheque_bank'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'cheque_bank', $my_data );

  order_complete_function($post_id);
}
add_action( 'save_post', 'myplugin_save_meta_box_data' );


add_action( 'woocommerce_order_status_completed ', 'order_complete_function' );
/*
 * Do something after WooCommerce sets an order on completed
 */
function order_complete_function($order_id) {


	// order object (optional but handy)
	$order = new WC_Order( $order_id );

	$cheque_no = get_post_meta( $order_id, 'cheque_no', true );

	$cheque_bank = get_post_meta( $order_id, 'cheque_bank', true );


	$_payment_method = get_post_meta( $order_id, '_payment_method', true );

	$coupon = get_post_meta( $order_id, 'coupon', true );




	if($order->status == 'completed' && $cheque_no != "" && $cheque_bank != "" && $_payment_method == 'cheque' && $coupon =="")
	{
			// $random = 'FREEDOM'.$order_id;
      $original_string = 'abcdefghi';
      $random_string = get_random_string($original_string, 6);
      // $random = $random_string;
      $random = md5(uniqid($order_id, true));

		 update_post_meta( $order_id, 'coupon', $random );
		 add_filter( 'woocommerce_email_actions', 'so_27112461_woocommerce_email_actions' );

	}

}

function so_27112461_woocommerce_email_actions( $actions){

	$actions[] = 'woocommerce_order_status_completed';
    return $actions;
}
// add_action( 'woocommerce_checkout_after_customer_details', 'some_custom_checkout_field' );

function some_custom_checkout_field( $checkout ) {
	echo '<div id="some_custom_checkout_field">';

    woocommerce_form_field( 'cheque_no', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Cheque No'),
        'placeholder'   => __('no validation and database cross check'),
        'required'      => true,
        ));

    woocommerce_form_field( 'confirm_cheque_no', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Confirm Cheque No'),
        'placeholder'   => __('no validation and database cross check'),
        'required'      => true,
        ));

    woocommerce_form_field( 'booking_amount', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Amount in Rs.'),
        'placeholder'   => __('1100'),
        'required'      => true,
        ));

    woocommerce_form_field( 'cheque_bank', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Bank'),
        'placeholder'   => __('bank,branch name'),
        'required'      => true,
        ));

    echo '</div>';

    echo '<div id="some_custom_checkout_field"><h2>Partner/Sales person details</h2>';

      woocommerce_form_field( 'sale_person_name', array(
          'type'          => 'text',
          'class'         => array('my-field-class form-row-wide'),
          'label'         => __('Name'),
          'placeholder'   => __('first name last name'),
          'required'      => true,
          ));

      woocommerce_form_field( 'sale_person_email', array(
          'type'          => 'text',
          'class'         => array('my-field-class form-row-wide'),
          'label'         => __('Email'),
          'placeholder'   => __('email'),
          'required'      => true,
          ));

      woocommerce_form_field( 'sale_person_phone', array(
          'type'          => 'text',
          'class'         => array('my-field-class form-row-wide'),
          'label'         => __('Phone'),
          'placeholder'   => __('phone'),
          'required'      => true,
          ));

      woocommerce_form_field( 'sale_person_company', array(
          'type'          => 'text',
          'class'         => array('my-field-class form-row-wide'),
          'label'         => __('Company'),
          'placeholder'   => __('example.pvt.ltd/NA'),
          'required'      => true,
          ));

      echo '</div>';

}
add_action( 'woocommerce_checkout_update_order_meta', 'some_custom_checkout_field_update_order_meta' );

function some_custom_checkout_field_update_order_meta( $order_id ) {
    if ( ! empty( $_POST['cheque_no'] ) ) {
        update_post_meta( $order_id, 'cheque_no', sanitize_text_field( $_POST['cheque_no'] ) );
    }
    if ( ! empty( $_POST['confirm_cheque_no'] ) ) {
        update_post_meta( $order_id, 'confirm_cheque_no', sanitize_text_field( $_POST['confirm_cheque_no'] ) );
    }
    if ( ! empty( $_POST['booking_amount'] ) ) {
        update_post_meta( $order_id, 'booking_amount', sanitize_text_field( $_POST['booking_amount'] ) );
    }
    if ( ! empty( $_POST['cheque_bank'] ) ) {
        update_post_meta( $order_id, 'cheque_bank', sanitize_text_field( $_POST['cheque_bank'] ) );
    }
    if ( ! empty( $_POST['sale_person_name'] ) ) {
        update_post_meta( $order_id, 'sale_person_name', sanitize_text_field( $_POST['sale_person_name'] ) );
    }
    if ( ! empty( $_POST['sale_person_email'] ) ) {
        update_post_meta( $order_id, 'sale_person_email', sanitize_text_field( $_POST['sale_person_email'] ) );
    }
    if ( ! empty( $_POST['sale_person_phone'] ) ) {
        update_post_meta( $order_id, 'sale_person_phone', sanitize_text_field( $_POST['sale_person_phone'] ) );
    }
    if ( ! empty( $_POST['sale_person_company'] ) ) {
        update_post_meta( $order_id, 'sale_person_company', sanitize_text_field( $_POST['sale_person_company'] ) );
    }


}

// add_filter( 'default_checkout_state', 'change_default_checkout_state' );
// function change_default_checkout_state() {
//   return 'MH'; // state code
// }
function get_random_string($valid_chars, $length)
{
    // start with an empty random string
    $random_string = "";

    // count the number of chars in the valid chars string so we know how many choices we have
    $num_valid_chars = strlen($valid_chars);

    // repeat the steps until we've created a string of the right length
    for ($i = 0; $i < $length; $i++)
    {
        // pick a random number from 1 up to the number of valid chars
        $random_pick = mt_rand(1, $num_valid_chars);

        // take the random character out of the string of valid chars
        // subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
        $random_char = $valid_chars[$random_pick-1];

        // add the randomly-chosen char onto the end of our string so far
        $random_string .= $random_char;
    }

    // return our finished random string
    return $random_string;
}
/* Add to the functions.php file of your theme */
add_filter( 'woocommerce_order_button_text', 'woo_custom_order_button_text' );

function woo_custom_order_button_text() {
    return __( 'Submit', 'woocommerce' );
}
