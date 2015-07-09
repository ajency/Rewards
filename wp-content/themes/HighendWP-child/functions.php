<?php

function skyi_scripts() {
	wp_enqueue_script( 'customjs', site_template_directory_uri() . '/js/custom.js', array(), '', true );
	wp_enqueue_style( 'customcss', site_template_directory_uri() . '/css/custom.css');
}
add_action( 'wp_enqueue_scripts', 'skyi_scripts' );

function site_template_directory_uri() {
    return site_url('wp-content/themes/HighendWP-child');
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
			$rand = 'FREEDOM'.$order_id;
			$payment = get_post_meta($order_id, '_payment_method' ,true);
			if( $payment != 'cheque' ){
			update_post_meta($order_id,'coupon' ,$rand );
			}

			?>
			<script type="text/javascript">
			jQuery('form').clearForm()

			</script>

			<?php
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
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    // unset($fields['billing']['billing_city']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
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
$wdm_address_fields = array('full_name','city','first_name','last_name'

				);

//global array only for extra fields
	$wdm_ext_fields = array('full_name');

add_filter( 'woocommerce_default_address_fields' , 'wdm_override_default_address_fields' );

     function wdm_override_default_address_fields( $address_fields ){

     $temp_fields = array();

     $address_fields['full_name'] = array(
    'label'     => __('Full Name', 'woocommerce'),
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
	"billing_full_name",
	"billing_email",
	"billing_email-2",
	"billing_phone",
	"billing_city",
	"billing_first_name",
	"billing_last_name"

    );
    foreach($order as $field)
    {
        $ordered_fields[$field] = $fields["billing"][$field];
    }

    $fields["billing"] = $ordered_fields;
    return $fields;
}
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_login_form', 10 );

add_action( 'woocommerce_checkout_order_review_details', 'woocommerce_order_review', 10 );
add_action( 'woocommerce_checkout_paymen_options', 'woocommerce_checkout_payment', 20 );
