<?php

function skyi_scripts() {
    wp_enqueue_script( 'customjs', site_template_directory_uri() . '/js/custom.js', array(), '', true );
    wp_enqueue_script( 'bpopupjs', site_template_directory_uri() . '/js/jquery.bpopup.min.js', array(), '', true );
    wp_enqueue_script( 'classie', site_template_directory_uri() . '/js/classie.js', array(), '', true );
    wp_enqueue_style( 'customcss', site_template_directory_uri() . '/css/custom.css');
   wp_localize_script(  "customjs", "SITEURL", site_url() );
   wp_localize_script(  "customjs", "AJAXURL", admin_url( "admin-ajax.php" ) );
}
add_action( 'wp_enqueue_scripts', 'skyi_scripts' );

function site_template_directory_uri() {
    return site_url('wp-content/themes/skyifirst');
}

add_action( 'admin_enqueue_scripts', 'load_admin_style' );
    function load_admin_style() {
        if ( class_exists( 'woocommerce' ) ) {
        wp_dequeue_style( 'select2' );
        wp_deregister_style( 'select2' );

        wp_dequeue_script( 'select2');
        wp_deregister_script('select2');

    }
         wp_enqueue_script( 'jqueryjs', site_template_directory_uri() . '/js/jquery.js', array(), '', true );
    wp_enqueue_script( 'custom-adminjs', site_template_directory_uri() . '/js/custom-admin.js', array(), '', true );
    
        wp_enqueue_style( 'admin_css', site_template_directory_uri() . '/css/custom-admin-style.css', false, '1.0.0' );
        wp_enqueue_script( 'bpopupjs', site_template_directory_uri() . '/js/jquery.bpopup.min.js', array(), '', true );
        
    wp_localize_script(  "bpopupjs", "SITEURL", site_url() );
   wp_localize_script(  "bpopupjs", "AJAXURL", admin_url( "admin-ajax.php" ) );
}

/**
 * Open a preview e-mail.
 *
 * @return null
**/

function previewEmail() {

    if (is_admin()) {
        $default_path = WC()->plugin_path() . '/templates/';

        $files = scandir($default_path . 'emails');
        $exclude = array( '.', '..', 'email-header.php', 'email-footer.php','plain' );
        $list = array_diff($files,$exclude);
        ?><form method="get" action="<?php echo site_url(); ?>/wp-admin/admin-ajax.php">
<input type="hidden" name="order" value="593">
<input type="hidden" name="action" value="previewemail">
        <select name="file">
        <?php
        foreach( $list as $item ){ ?>
            <option value="<?php echo $item; ?>"><?php echo str_replace('.php', '', $item); ?></option>
        <?php } ?>
        </select><input type="submit" value="Go"></form><?php
        global $order;
        $order = new WC_Order($_GET['order']);
        wc_get_template( 'emails/email-header.php', array( 'order' => $order ) );


        wc_get_template( 'emails/'.$_GET['file'], array( 'order' => $order ) );
        wc_get_template( 'emails/email-footer.php', array( 'order' => $order ) );

    }
    return null;
}

add_action('wp_ajax_previewemail', 'previewEmail');

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
 // $checkout_url = site_url().'/application';
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
      $rand = getRandomCode(10);
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
        wp_redirect( site_url().'/thank-you/' ); exit; // or whatever url you want
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

		$fields['billing']['billing_address_2']['placeholder'] = 'street address etc';
		$fields['billing']['billing_first_name']['placeholder'] = 'John';
		$fields['billing']['billing_last_name']['placeholder'] = 'Doe';
		$fields['billing']['billing_email']['placeholder'] = 'john@example.com';
		$fields['billing']['billing_email-2']['placeholder'] = 'john@example.com';
		$fields['billing']['billing_phone']['placeholder'] = '9123456780';
        $fields['billing']['billing_address_1']['label'] = 'Address';
        $fields['billing']['billing_phone']['label'] = 'Mobile';
        $fields['billing']['billing_phone']['type'] = 'text';
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
    $new_columns['broker_name'] = 'Partner';
    $new_columns['cheque_no'] = 'Cheque No';

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
                     
                      $unit_type = strtoupper($term['item_meta']['pa_unit_type'][0]);
                     $unit_type = strtoupper($term['item_meta']['unit_type'][0]);
                     echo $unit_type;
                    

                        }
                  } else {
                    _e( 'Unable get the producten', 'woocommerce' );
                          }
                break;

        case 'status' :
             print_r($the_order->get_status());

            break;

        case 'broker_name' :
            $customer_name = get_post_meta( $the_order->id, 'sale_person_name', true ) != "" ? get_post_meta( $the_order->id, 'sale_person_name', true ) : '--';
            $customer_last_name = get_post_meta( $the_order->id, 'sale_person_last_name', true ) != "" ? get_post_meta( $the_order->id, 'sale_person_last_name', true ) : '--';
            echo  $customer_name.' '.$customer_last_name;

            break;

        case 'ordertitle' :
                        $order = new WC_Order($the_order->id);
                        $billing_first_name = $order->billing_first_name;
            $billing_last_name = $order->billing_last_name;
            $billing_email = $order->billing_email;
            echo '<a href="'.esc_url( $the_order->get_view_order_url() ).'">#'.$the_order->get_order_number().'</a>

            by '.$billing_first_name.' '.$billing_last_name.'<br/>'.$billing_email.'';



            break;

        case 'cheque_no' :
            $cheque_no = get_post_meta( $the_order->id, 'cheque_no', true ) != "" ? get_post_meta( $the_order->id, 'cheque_no', true ) : '--';
            echo  $cheque_no;

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
    $customer_name = get_post_meta( $post->ID, 'sale_person_name', true ) != "" ? get_post_meta( $post->ID, 'sale_person_name', true ) : 'Not present';
    $customer_last_name = get_post_meta( $post->ID, 'sale_person_last_name', true ) != "" ? get_post_meta( $post->ID, 'sale_person_last_name', true ) : 'Not present';
    echo '<p><strong style="display: block;">'.__('Partner Name').':</strong>'.$customer_name.' '.$customer_last_name.'</p>';
    $customer_email = get_post_meta( $post->ID, 'sale_person_email', true ) != "" ? get_post_meta( $post->ID, 'sale_person_email', true ) : 'Not present';
    echo '<p><strong style="display: block;">'.__('Partner Phone').':</strong>'.$customer_email.'</p>';
    $customer_phone = get_post_meta( $post->ID, 'sale_person_phone', true ) != "" ? get_post_meta( $post->ID, 'sale_person_phone', true ) : 'Not present';
    echo '<p><strong style="display: block;">'.__('Partner Email').':</strong>'.$customer_phone.'</p>';
    $customer_company = get_post_meta( $post->ID, 'sale_person_company', true ) != "" ? get_post_meta( $post->ID, 'sale_person_company', true ) : 'Not present';
    echo '<p><strong style="display: block;">'.__('Partner Company').':</strong>'.$customer_company.'</p>';




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
    $payment = get_post_meta( $post->ID, '_payment_method', true );

    echo '<br/><label for="myplugin_cheque_bank">';
    _e( 'Bank', 'myplugin_textdomain' );
    echo '</label> ';
    echo '<br/><input type="text" id="myplugin_cheque_bank" name="myplugin_cheque_bank" value="' . esc_attr( $value ) . '" size="25" />';
    echo '<br/><input type="hidden" name="payment_mode" id="payment_mode" value="'.$payment.'" / >';

?>
<script type="text/javascript">
flag_order = 0;
jQuery('.save_order ').on('click',function(e){
jQuery('.validation').remove();
 e.preventDefault();
 if(jQuery('#order_status').val() == 'wc-completed' && jQuery('#payment_mode').val() == 'cheque')
 {
     console.log(jQuery('#order_status').val())
     if(jQuery('#myplugin_cheque_no').val() == "")
     {
         jQuery('#myplugin_cheque_no').after("<div class='validation' style='color:red'>Enter Cheque No</div>");
         return false;
     }
     if(jQuery('#myplugin_cheque_bank').val() == "")
     {
         jQuery('#myplugin_cheque_bank').after("<div class='validation' style='color:red'>Enter Bank details</div>");
         return false;
     }
 }

 if(jQuery('#order_status').val() == 'wc-cancelled')
 {
     
     if(flag_order == 0 ||(flag_order ==1 && jQuery('#add_order_note').val()!=""))
     {
        jQuery('#add_order_note').after("<div class='validation' style='color:red'>Enter reason for cancellation</div>");
        jQuery('html, body').animate({
                            scrollTop: jQuery(document).height()
                          }, 'slow')
         return false;
     }
     
 }
 jQuery('form#post').submit();
})
jQuery(document).on('keyup', '#add_order_note',function(e){
    jQuery('.validation').remove();
    if(jQuery(e.target).val()!="")
        flag_order = 1;
    else
        flag_order = 0;
})
jQuery('#myplugin_cheque_no').on('keyup' , function(e){
        jQuery('.validation').remove();
      var phone = jQuery(e.target).val(),
      intRegex = /^[0-9 A-Z]*(?:\.\d{1,2})?$/;
      if((!intRegex.test(phone)))
      {
        jQuery(e.target).val("");
        jQuery(e.target).after("<div class='validation' style='color:red'>Please enter a valid cheque number</div>");
         return false;
      }
    })
</script>
<?php

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
      $random = getRandomCode(10);

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
        'class'         => array('my-field-class form-row-first'),
        'label'         => __('Cheque No'),
        'placeholder'   => __('1000000'),
        'required'      => false,
        ));

    woocommerce_form_field( 'confirm_cheque_no', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-last'),
        'label'         => __('Confirm Cheque No'),
        'placeholder'   => __('1000000'),
        'required'      => false,
        ));
    echo '<div class="clear"></div>';

    // woocommerce_form_field( 'booking_amount', array(
    //     'type'          => 'text',
    //     'class'         => array('my-field-class form-row-wide'),
    //     'label'         => __('Amount in Rs.'),
    //     'placeholder'   => __('1100'),
    //     'required'      => true,
    //     ));

    woocommerce_form_field( 'cheque_bank', array(
        'type'          => 'text',
        'class'         => array('my-field-class form-row-wide'),
        'label'         => __('Bank'),
        'placeholder'   => __('SBI'),
        'required'      => false,
        ));

    echo '<div class="clear"></div><div class="hb-separator" style="margin-top:0px;margin-top:40px;"></div></div>';

    echo '<div id="some_custom_checkout_field"><h4 class="step-intro">Partner/Sales person details</h4>';

      woocommerce_form_field( 'sale_person_name', array(
          'type'          => 'text',
          'class'         => array('my-field-class form-row-first'),
          'label'         => __('First Name'),
          'placeholder'   => __('Ram'),
          'required'      => false,
          ));

      woocommerce_form_field( 'sale_person_last_name', array(
          'type'          => 'text',
          'class'         => array('my-field-class form-row-last'),
          'label'         => __('Last Name'),
          'placeholder'   => __('Singh'),
          'required'      => false,
          ));

      woocommerce_form_field( 'sale_person_email', array(
          'type'          => 'text',
          'class'         => array('my-field-class form-row-first'),
          'label'         => __('Email'),
          'placeholder'   => __('ram@gmail.com'),
          'required'      => false,
          ));
      echo '<div class=" "></div>';

      woocommerce_form_field( 'sale_person_phone', array(
          'type'          => 'text',
          'class'         => array('my-field-class form-row-last'),
          'label'         => __('Phone'),
          'placeholder'   => __('9023560202'),
          'required'      => false,
          ));

      woocommerce_form_field( 'sale_person_company', array(
          'type'          => 'text',
          'class'         => array('my-field-class form-row-first'),
          'label'         => __('Company'),
          'placeholder'   => __('My Company Pvt. Ltd.'),
          'required'      => false,
          ));

      echo '<div class="clear"></div></div>';

}
add_action( 'woocommerce_checkout_update_order_meta', 'some_custom_checkout_field_update_order_meta' );

function some_custom_checkout_field_update_order_meta( $order_id ) {
    if ( ! empty( $_POST['cheque_no'] ) ) {
        update_post_meta( $order_id, 'cheque_no', sanitize_text_field( $_POST['cheque_no'] ) );
    }
    if ( ! empty( $_POST['confirm_cheque_no'] ) ) {
        update_post_meta( $order_id, 'confirm_cheque_no', sanitize_text_field( $_POST['confirm_cheque_no'] ) );
    }
    // if ( ! empty( $_POST['booking_amount'] ) ) {
    //     update_post_meta( $order_id, 'booking_amount', sanitize_text_field( $_POST['booking_amount'] ) );
    // }
    if ( ! empty( $_POST['cheque_bank'] ) ) {
        update_post_meta( $order_id, 'cheque_bank', sanitize_text_field( $_POST['cheque_bank'] ) );
    }
    if ( ! empty( $_POST['sale_person_name'] ) ) {
        update_post_meta( $order_id, 'sale_person_name', sanitize_text_field( $_POST['sale_person_name'] ) );
    }
    if ( ! empty( $_POST['sale_person_last_name'] ) ) {
        update_post_meta( $order_id, 'sale_person_last_name', sanitize_text_field( $_POST['sale_person_last_name'] ) );
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
class payment extends WC_Gateway_Payu_In
{

    public function __construct(){
        parent::__construct();

    }
    public function payment_fields()
    {

        if ( $this->description ) { echo wpautop( wptexturize( $this->description ) ); }

        if($this->cc_method == 'yes' || $this->dc_method == 'yes' || $this->nb_method == 'yes' || $this->emi_method == 'yes' || $this->cod_method == 'yes') {
        ?>

        <fieldset>
            <ul class="form-row payu-options">
                <?php if($this->cc_method == 'yes') { ?><li><input type="radio" name="pg" value="CC" id="CC"><label for="CC">Credit Card</label></li><?php } ?>
                <?php if($this->dc_method == 'yes') { ?><li><input type="radio" name="pg" value="DC" id="DC"><label for="DC">Debit Card</label></li><?php } ?>
                <?php if($this->nb_method == 'yes') { ?><li><input type="radio" name="pg" value="NB" id="NB"><label for="NB">Net Banking</label></li><?php } ?>
                <?php if($this->emi_method == 'yes') { ?><li><input type="radio" name="pg" value="EMI" id="EMI"><label for="EMI">EMI</label></li><?php } ?>
                <?php if($this->cod_method == 'yes') { ?><li><input type="radio" name="pg" value="COD" id="COD"><label for="COD">COD</label></li><?php } ?>
                <li><img src="../wp-content/themes/skyifirst/images/payu-logo.png" alt="payu"/></li>
            </ul>
            <div class="clear"></div>
        </fieldset>

        <?php
        }
    }
}

function check_cheque_no(){

$chequeno = $_REQUEST['cheque_no'];

  $args = array(
  'post_type' => 'shop_order',
  'post_status' => 'publish',
  'meta_key' => '_customer_user',
  'posts_per_page' => '-1'
);
$my_query = new WP_Query($args);

$customer_orders = $my_query->posts;
$cheques = array();
foreach ($customer_orders as $customer_order) {
 $order = new WC_Order();

 $order->populate($customer_order);
 $orderdata = (array) $order;
 $cheque_no = get_post_meta($orderdata['id'],'cheque_no',true);
  if($cheque_no != "")
  array_push($cheques,$cheque_no);

 // $orderdata Array will have Information. for e.g Shippin firstname, Lastname, Address ... and MUCH more.... Just enjoy!
}

  if(in_array($chequeno,$cheques))
  {
    $output = 1;
  }
  else {
    $output = 0;
  }
  echo $output;
    die();

}

add_action('wp_ajax_check_cheque_no','check_cheque_no');

add_action( 'wp_enqueue_scripts', 'mgt_dequeue_stylesandscripts', 100 );

// add_action( 'admin_enqueue_scripts', 'mgt_dequeue_stylesandscripts', 100 );
function mgt_dequeue_stylesandscripts() {
    if ( class_exists( 'woocommerce' ) ) {
        wp_dequeue_style( 'select2' );
        wp_deregister_style( 'select2' );

        wp_dequeue_script( 'select2');
        wp_deregister_script('select2');

    }
}
function add_prodcut_variation(){

  global $woocommerce;
  // ob_start();

  //   $product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $_REQUEST['pid'] ) );
  //   $quantity          = empty( $_POST['quantity'] ) ? 1 : wc_stock_amount( $_REQUEST['qty'] );

  //   $variation_id      = isset( $_POST['variation_id'] ) ? absint( $_POST['vid'] ) : '';
  //   $variation         = ! empty( $_POST['variation'] ) ? (array) $_POST['variation'] : '';

  //   $passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

  //   if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation ) ) {

  //       do_action( 'woocommerce_ajax_added_to_cart', $product_id );

  //       if ( get_option( 'woocommerce_cart_redirect_after_add' ) == 'yes' ) {
  //           wc_add_to_cart_message( $product_id );
  //       }

  //       // Return fragments
  //       WC_AJAX::get_refreshed_fragments();

  //   } else {

  //       // If there was an error adding to the cart, redirect to the product page to show any errors
  //       $data = array(
  //           'error' => true,
  //           'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id )
  //       );

  //       wp_send_json( $data );

  //   }

  //   die();

  $quantity       = (isset($_REQUEST['qty'])) ? (int) $_REQUEST['qty'] : 1;
  $product_id     = (int) apply_filters('woocommerce_add_to_cart_product_id', $_REQUEST['pid']);
  $vid            = (int) apply_filters('woocommerce_add_to_cart_product_id', $_REQUEST['vid']);
  
  
  
  
  if ($vid > 0) $woocommerce->cart->add_to_cart( $product_id, $quantity, $vid,$_REQUEST['variation'],null);
  else $woocommerce->cart->add_to_cart( $product_id, $quantity );

  get_product_variantion();

 // $orderdata Array will have Information. for e.g Shippin firstname, Lastname, Address ... and MUCH more.... Just enjoy!
}

function get_product_variantion(){

      foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        // print_r($cart_item);
        // echo WC()->cart->get_cart_total();
        $unit_type = strtoupper($cart_item['variation']['unit_type']);
          $price = floatval( preg_replace( '#[^\d.]#', '', WC()->cart->get_cart_total() ) );;
    }

    $term = array('unit_type' =>  $unit_type,'price'=>$price );
    // print_r($term);
    // die();
    wp_send_json($term);
}
add_action('wp_ajax_add_prodcut_variation','add_prodcut_variation');

add_action('wp_ajax_nopriv_add_prodcut_variation','add_prodcut_variation');

add_action('wp_ajax_get_product_variantion','get_product_variantion');
add_action('wp_ajax_nopriv_get_product_variantion','get_product_variantion');

function wpg_add_fields($settings) {

  $settings['cheque_no'] = array(
                'name' => __( 'Cheque No', 'woocommerce-simply-order-export' ),
                'type' => 'checkbox',
                'desc' => __( 'Cheque No', 'woocommerce-simply-order-export' ),
                'id'   => 'wc_settings_tab_cheque_no'
              );

  $settings['cheque_bank'] = array(
                'name' => __( 'Cheque Bank', 'woocommerce-simply-order-export' ),
                'type' => 'checkbox',
                'desc' => __( 'Cheque Bank', 'woocommerce-simply-order-export' ),
                'id'   => 'wc_settings_tab_cheque_bank'
              );

  return $settings;

}

function csv_write( &$csv, $od, $fields ) {

  if( !empty( $fields['wc_settings_tab_cheque_no'] ) && $fields['wc_settings_tab_cheque_no'] === true ){
    $cheque_no = get_post_meta( $od->id, 'cheque_no', true );
    array_push( $csv, $cheque_no );
  }
  if( !empty( $fields['wc_settings_tab_cheque_bank'] ) && $fields['wc_settings_tab_cheque_bank'] === true ){
    $cheque_bank = get_post_meta( $od->id, 'cheque_bank', true );
    array_push( $csv, $cheque_bank );
  }

}
add_action('wpg_before_csv_write', 'csv_write', 10, 3);
add_filter('wc_settings_tab_order_export', 'wpg_add_fields');

function getRandomCode($length){
    // $characters = "AB0CD1CD2EF3GH4IJ5KL6MN7PQ8RS9TUOVWXYZ";
    // $su = strlen($an) - 1;
    // return substr($an, mt_rand(0, $su), 9);
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}

function register_menu() {
  add_menu_page( __( 'Generate winners' ), __( 'Generate winners' ),
    'manage_options', 'coupons_settings', 'set_coupons');
 add_submenu_page( 'coupons_settings', 'Winner list', 'Winner list',
    'manage_options', 'List-settings', 'show_list_coupons');
  

}
add_action('admin_menu', 'register_menu');

function show_list_coupons(){

    $_pf = new WC_Product_Factory();
    $new_product = $_pf->get_product(269);
    $variations = $new_product->get_available_variations();

    ?>
    <div class="winners row">
        <h3>Winners List</h3>
    <?php
    foreach ($variations as $key => $value) {

    ?>
    <div class="coupon-table">
        <h4>Winners - <span style="color: #4269B7;"><?php echo strtoupper(implode('/', $value['attributes']));?></span></h4>
    <table cellspacing="6" cellpadding="4" style="width:100%">
        
           
            
            <?php  
            $pool_val = get_option('pool_'.strtoupper(implode('/', $value['attributes'])));
            $pool = strtoupper(implode('/', $value['attributes']));
            if($pool_val)
            {
                
                 $pool_list = maybe_unserialize(get_option('coupons_'.$pool.'_1'));
                 if(count($pool_list)>0){
                    ?>
                <tr><th>Coupon</th><th>Name</th></tr>
                <?php
                 foreach ($pool_list as $key => $value) {
                    $order = new WC_Order($value['id']);
                    $billing_first_name = $order->billing_first_name;
                    $billing_last_name = $order->billing_last_name;
                    $billing_email = $order->billing_email;
                    $url = get_edit_post_link($value['id']);
                   
                    ?>
                        <tr><td><?php echo $value['coupon'];?></td><td><a href="<?php echo $url;?>"><?php echo $billing_first_name.$billing_last_name;?></a></td></tr>

                    <?php
                     # code...
                 }
             }
             else
             {
                ?>
                 <tr><td><b>No data found</b></td></tr>
                 <?php
             }
            }
           else
             {
                ?>
                 <tr><td><b>No data found</b></td></tr>
                 <?php
             }

        
            ?>

    </table>
    </div>
    <?php



    }

     ?>
    </div>


    <div class="row">
        <h3>Waiting list</h3>
    <?php

    foreach ($variations as $key => $value) {?>

    
    <?php
    $pool_val = get_option('pool_'.strtoupper(implode('/', $value['attributes'])));
    $pool = strtoupper(implode('/', $value['attributes']));
    for ($i=2; $i <= $pool_val; $i++) { 
        $pool_list = maybe_unserialize(get_option('coupons_'.$pool.'_'.$i));
        if(count($pool_list)>0){
        ?>

        
        <div class="coupon-table">
            <h4>Waiting List - <span style="color: #4269B7;"><?php echo (intval($i) - 1).'-'.$pool;?></span></h4>
        <table class="" cellspacing="6" cellpadding="4" style="width:100%">
           
       
           
           

         <tr><th>Coupon</th><th>Name</th></tr>
        <?php
                 foreach ($pool_list as $key => $value) {
                    $order = new WC_Order($value['id']);
                    $billing_first_name = $order->billing_first_name;
                    $billing_last_name = $order->billing_last_name;
                    $billing_email = $order->billing_email;
                    $url = get_edit_post_link($value['id']);
                   
                    ?>
                        <tr><td><?php echo $value['coupon'];?></td><td><a href="<?php echo $url;?>"><?php echo $billing_first_name.$billing_last_name;?></a></td></tr>

                    <?php
                     # code...
                 }

                    ?>

         </table>
     </div>
             <?php
             }
             
          
    }
    ?>

    <?php



    }
    ?>
   

    
    </div>
    <div class="row">
    <input type="button" name="send_winners" id="send_winners" value="Send emails to Winners" />
    <input type="button" name="send_non_winners" id="send_non_winners" value="Send emails to Non Winners" />
    <img id="loading" style="display:none" src="../wp-content/themes/skyifirst/images/loading.gif" />
</div>
    <br/><div id="show"></div>
    <script type="text/javascript">
        jQuery('#send_winners').on('click',function(){
            jQuery('#loading').show();
              jQuery('#show').empty()
            jQuery.ajax({
                type: 'POST',
                url: AJAXURL+'?action=send_emails_to_winners',
                success: function(response, textStatus, jqXHR){
                      // log a message to the console



                    if(jqXHR.status ==200){
                       
                        jQuery('#loading').hide();
                        jQuery('#show').text('Emails sent')

                    }
                    else
                    {
                        jQuery('#loading').hide();
                        jQuery('#show').text('some problem occurred')
                    }

                  }/*,
                dataType: 'JSON'*/
              });


        })

        jQuery('#send_non_winners').on('click',function(){
             jQuery('#loading').show();
            jQuery('#show').empty()
            jQuery.ajax({
                type: 'POST',
                url: AJAXURL+'?action=send_emails_to_non_winners',
                success: function(response, textStatus, jqXHR){
                      // log a message to the console
                       
                        if(jqXHR.status ==200){
                       
                        jQuery('#loading').hide();
                        jQuery('#show').text('Emails sent')

                    }
                    else
                    {
                        jQuery('#loading').hide();
                        jQuery('#show').text('some problem occurred')
                    }

                  }/*,
                dataType: 'JSON'*/
              });


        })


    </script>

    <?php


}
function set_coupons(){

$_pf = new WC_Product_Factory();
$new_product = $_pf->get_product(269);
$variations = $new_product->get_available_variations();

?>

<html>
<body class="show">
     <h3>Declare Winners</h3>
      <div class="generate">
     <div class="coupon">
        <label>No of Winners</label><span class="text-danger" style="color: red;">*</span>
        
<input type="text" name="count" id="count" value="" />
</div>
 <div class="coupon">
     <label>Select Pool</label><span class="text-danger" style="color: red;">*</span>
<select name="pool" id="pool">
    <option value=""></option>
    <?php
foreach ($variations as $key => $value) {

            ?>

               



                 <option value="<?php echo strtoupper(implode('/', $value['attributes']));?>"><?php echo strtoupper(implode('/', $value['attributes']));?>
                       </option>



            <?php
            }
?>
</select>
</div>
 <div class="coupon">
<input type="button" name="generate" id="generate" value="Generate" />
<img id="loading" src="<?php echo site_url();?>/wp-content/themes/skyifirst/images/loading.gif" style="display:none" />

</div>
</div>
<div class="clearfix"></div>
<h3>The winners in the Pool are as follows : </h3>
<h4 id="show" class="show"></h4>
</body>

</html>
<script type="text/javascript">
jQuery('#generate').on('click',function(){
        jQuery('.validation').remove();
        if(jQuery('#count').val()== "")
        {
            jQuery('#count').after("<div class='validation' style='color:red'>Enter the count</div>");
            return false;
        }
        if(jQuery('#pool').val()== "")
        {
            jQuery('#pool').after("<div class='validation' style='color:red'>Select pool</div>");
            return false;
        }
    jQuery('#loading').show();
    jQuery.ajax({
            type: 'POST',
            url: AJAXURL+'?action=generate_coupon',
            data: { 'count':  jQuery('#count').val(),'pool' : jQuery('#pool').val()},
            success: function(response, textStatus, jqXHR){
                  // log a message to the console
                  jQuery('#loading').hide();
                  if(jqXHR.status ==200){
                    
                    if(response.response.length !=0){
                    html = '<div class="generate_table"><table ><tr><td>Order ID</td><td>Coupon</td></tr>';

                    jQuery.each(response.response,function(index,value){
                        console.log(value)
                        html += '<tr><td>'+value.coupon+'</td></tr>';
                    })
                    html += '</table></div>';
                }
                else
                {
                      html = '<div class="generate_table">No data found</div>';
                }
                    jQuery('#show').html(html);

                  }
                  else {
                    
                    html = 'No data found';
                  }

              }/*,
            dataType: 'JSON'*/
          });

})
</script>

<?php

}

function generate($count,$pool){

    //exclude////
         $pool_val = get_option('pool_'.$pool);
         $coupon_ids = array();
         for ($i=1; $i <= $pool_val; $i++) { 
            
             $pool_list = maybe_unserialize(get_option('coupons_'.$pool.'_'.$i));
             
             foreach ($pool_list as $key => $value) {
                array_push($coupon_ids, intval($value['id']));
               
               
             }
         }
       $unique = array_unique($coupon_ids, SORT_NUMERIC);
       
    //exclude///

    $args = array(
      'post_type' => 'shop_order',
      'post_status' => 'publish',
      'posts_per_page ' => -1,
      'post__not_in' =>  $unique,
      'orderby'=>'rand'
    );
    $my_query = new WP_Query($args);
    $i = 0;
    $customer_orders = $my_query->posts;
    $posts = array();
    // print_r($customer_orders);
    foreach ($customer_orders as $customer_order) {
        $order = new WC_Order();
        $order->populate($customer_order);
        $orderdata = (array) $order;
        // print_r($orderdata);
        $terms = $order->get_items();
       if ( is_array( $terms ) ) {
            foreach($terms as $term)
                {
                 
                    $unit_type = strtoupper($term['item_meta']['pa_unit_type'][0]);
                    if($unit_type == "")
                        $unit_type = strtoupper($term['item_meta']['unit_type'][0]);
                    // echo $unit_type;
                }
        }
         
        if($orderdata['post_status'] == 'wc-completed' && $unit_type == $pool && $i <= $count)
        {
            $i++; 
            $coupon = get_post_meta($orderdata['id'],'coupon',true);
            // array_push($posts, $orderdata);
            $posts[] = array(
                'id' => $orderdata['id'],
                'coupon' => $coupon

                );
        }
    }

    //save it in the database
   
    if($pool_val)
        $curr_count  = intval(get_option('pool_'.$pool)) + 1 ; 
    else
        $curr_count = 1;
    $pool_key = 'pool_'.$pool;
    update_option($pool_key,$curr_count);
    $serialized_posts  = maybe_serialize($posts);
    // print_r($serialized_posts);
    $pool_list_key = 'coupons_'.$pool.'_'.$curr_count;
    update_option($pool_list_key,$serialized_posts);
    return $posts;

}

function generate_coupon(){

    $count = $_REQUEST['count'];
    $pool = $_REQUEST['pool'];

    $response = generate($count,$pool);
    wp_send_json(array('response' =>$response));
    die();
}

add_action('wp_ajax_generate_coupon','generate_coupon');

add_action( 'template_redirect', 'wc_custom_redirect_after_purchase' ); 
function wc_custom_redirect_after_purchase() {
    global $wp;
    
    if ( is_checkout() && ! empty( $wp->query_vars['order-received'] )  ) {
        wp_redirect( site_url().'/thank-you/' );
        wp_cache_flush();
        exit;
    }
}

function dba_add_communication_components($defined_comm_components){

    $defined_comm_components['draw_emails'] = array(
                'winner_email' => array('preference'=>1),
                'non-winner-email'  => array('preference'=>1)

        );

   

    return $defined_comm_components;
}
add_filter('add_commponents_filter','dba_add_communication_components',10,1);




function send_emails_to_winners(){

    global $aj_comm;

    $user_id = get_current_user_id();


    $args = array(
        'component'             => 'draw_emails',
        'communication_type'    => 'winner_email',
        'user_id'               => $user_id,
        'blog_id'               => get_current_blog_id()

        );
   

    $_pf = new WC_Product_Factory();
    $new_product = $_pf->get_product(269);
    $variations = $new_product->get_available_variations();

    foreach ($variations as $key => $value) {

   

    
            $pool_val = get_option('pool_'.strtoupper(implode('/', $value['attributes'])));
            $pool = strtoupper(implode('/', $value['attributes']));
            
            if($pool_val != false)
            {
                
                 $pool_list = maybe_unserialize(get_option('coupons_'.$pool.'_1'));
                
                 if(count($pool_list)>0){
                
                 foreach ($pool_list as $key => $value) {
                    $order = new WC_Order($value['id']);
                    $billing_first_name = $order->billing_first_name;
                    $billing_last_name = $order->billing_last_name;
                    $billing_email = $order->billing_email;
                    $url = get_edit_post_link($value['id']);

                    $meta = array(
                        'username'        => $billing_first_name.' '.$billing_last_name,
                        'product_name'    => $pool
                        


                    );

                    // print_r($meta);
                     $recipients_args = array(
                            array(
                                'type'        => 'email',
                                'value'       =>  $billing_email

                            )

                    );

                    $aj_comm->create_communication($args,$meta,$recipients_args);

                    $aj_comm->cron_process_communication_queue("draw_emails",'winner_email');

                   
                   
                 }
             }
            
             
            }
           

        


    }

   

    


    

   

    return true;
}



function send_emails_to_non_winners(){

    global $aj_comm;

    $user_id = get_current_user_id();


    $args = array(
        'component'             => 'draw_emails',
        'communication_type'    => 'winner_non_email',
        'user_id'               => $user_id,
        'blog_id'               => get_current_blog_id()

        );

    $_pf = new WC_Product_Factory();
    $new_product = $_pf->get_product(269);
    $variations = $new_product->get_available_variations();

    foreach ($variations as $key => $value) {?>

    
    <?php
    $pool_val = get_option('pool_'.strtoupper(implode('/', $value['attributes'])));
    $pool = strtoupper(implode('/', $value['attributes']));
    for ($i=2; $i <= $pool_val; $i++) { 
        $pool_list = maybe_unserialize(get_option('coupons_'.$pool.'_'.$i));
        
        if(count($pool_list)>0){

        
                 foreach ($pool_list as $key => $value) {
                    $order = new WC_Order($value['id']);
                    $billing_first_name = $order->billing_first_name;
                    $billing_last_name = $order->billing_last_name;
                    $billing_email = $order->billing_email;
                    $url = get_edit_post_link($value['id']);

                     $meta = array(
                        'username'        => $billing_first_name.' '.$billing_last_name,
                        'product_name'    => $pool
                        


                    );

                     $recipients_args = array(
                            array(
                                'type'        => 'email',
                                'value'       =>  $billing_email

                            )

                    );

                    $aj_comm->create_communication($args,$meta,$recipients_args);

                    $aj_comm->cron_process_communication_queue("draw_emails",'winner_non_email');

                   
                   
                 }
             }
             
             
    }
    


    }
}

add_action('wp_ajax_send_emails_to_winners','send_emails_to_winners');

add_action('wp_ajax_send_emails_to_non_winners','send_emails_to_non_winners');

add_filter( 'woocommerce_shop_order_search_fields', 'woocommerce_shop_order_search_order_total' );
 
 
 
function woocommerce_shop_order_search_order_total( $search_fields ) {
 
  $search_fields[] = 'billing_first_name';
  $search_fields[] = 'billing_last_name';
  $search_fields[] = 'cheque_no';
  $search_fields[] = 'attribute_unit-type';
 
  return $search_fields;
 
}



//apartment selector/////////


/**
 * apartmentselector functions file
 *
 * @package    WordPress
 * @subpackage apartmentselector
 * @since      apartmentselector 0.0.1
 */
//load the common file having commonly containing funtions
require_once (get_stylesheet_directory().'/functions/common.php');

//load the init file
require_once (get_stylesheet_directory().'/functions/init.php');

//load the functions for formidable plugin hooks
require_once (get_stylesheet_directory().'/functions/formidable.php');

//load the functions related to rooms
require_once (get_stylesheet_directory().'/functions/rooms.php');

//load the functions related to unit
require_once (get_stylesheet_directory().'/functions/unit.php');

//load the functions related to unit type
require_once (get_stylesheet_directory().'/functions/unit-type.php');

//load the functions related to building
require_once (get_stylesheet_directory().'/functions/building.php');

//load the functions related to apartment selector settings
require_once (get_stylesheet_directory().'/functions/settings.php');

//load the functions related to apartment selector payment plans
require_once (get_stylesheet_directory().'/functions/payment-plans.php');
//load the functions site_template_directory_uri to apartment selector users
require_once (get_stylesheet_directory().'/functions/users.php');

//load backend styles and scripts//
require_once (get_stylesheet_directory().'/functions/backend-scripts-styles.php');

//load all the classes//
require_once (get_stylesheet_directory().'/classes/autoload.php');

//load ajax call
require_once (get_stylesheet_directory().'/ajax-module.php');
//pdf generator library
require_once (get_stylesheet_directory().'/functions/tcpdf_include.php');

///added by Surekha
require_once (get_stylesheet_directory().'/apis/unit.api.php');

$bust = '?'.BUST; 

//formatted echo using pre tags can be used to echo out data for testing purpose

// function formatted_echo($data){

//     echo "<pre>";

//     print_r($data);

//     echo "</pre>";

// }

// function apartmentselector_theme_setup() {

//     // load language
//     load_theme_textdomain( 'apartmentselector', get_template_directory() . '/languages' );

//     // add theme support
//     add_theme_support( 'post-formats', array( 'image', 'quote', 'status', 'link' ) );
//     add_theme_support( 'post-thumbnails' );
//     add_theme_support( 'menus' );
//     add_theme_support( 'automatic-feed-links' );
//     add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//     // define you image sizes here
//     add_image_size( 'apartmentselector-full-width', 1038, 576, TRUE );

//     // This theme uses its own gallery styles.
//     add_filter( 'use_default_gallery_style', '__return_false' );

// }

// add_action( 'after_setup_theme', 'apartmentselector_theme_setup' );


// function apartmentselector_after_init() {

//     show_admin_bar( FALSE );
// }

// add_action( 'init', 'apartmentselector_after_init' );

// function get_data(){

//     $building = get_buildings();
//             $unit = get_units();
//             $unit_type = get_unit_types();
//             $buildingarray = array();
//             $unitarray = array();
//             $unittype = array();
//             $temparray = array();
//             $tempphasearray = array();
//             $unit_typetemparray = array();
//             $temparray1 = array();
//             foreach ($building as $value) {
//                 array_push($tempphasearray,intval($value['id']));
//                 if($value['phase'] == 26){
//                     array_push($buildingarray, $value);
//                     array_push($temparray, $value['id']);


//                 }

//                 # code...
//             }
            
//             foreach ($unit as $value) {
//                 if(in_array($value['building'], $temparray)){
//                     array_push($unitarray, $value);
                    

//                 }

//                 # code...
//             }
//     return array($buildingarray,$unitarray,$tempphasearray);
// }

// if ( is_development_environment() ) {
 
//     function apartmentselector_dev_enqueue_scripts() {

//     //check not to enqueue frontend scritps for backend
//         if(!check_backend_template()){
//             // TODO: handle with better logic to define patterns and folder names
//             $module = get_module_name();

//             $pattern     = 'scripts';
//             $folder_path = 'js/src';

//             if ( is_single_page_app( $module ) ) {
//                 $pattern     = 'spa';
//                 $folder_path = 'spa/src';
//             }

//             wp_enqueue_script( "requirejs",
//                 get_template_directory_uri() . "/js/src/bower_components/requirejs/require.js",
//                 array(),
//                 get_current_version(),
//                 TRUE );

//             wp_enqueue_script( "require-config",
//                 get_template_directory_uri() . "/{$folder_path}/require.config.js",
//                 array( "requirejs" ),
//                 get_current_version(),
//                 TRUE);



//             wp_enqueue_script( "$module-script",
//                 get_template_directory_uri() . "/{$folder_path}/{$module}.{$pattern}.js",
//                 array( "require-config" ) );
           

            

//             $data = get_data();
//             $buildings = $data[0];
//             $units = $data[1];
//             $phases = $data[2];
           
//             // localized variables
//             wp_localize_script( "requirejs", "SITEURL", site_url() );
//             wp_localize_script( "requirejs", "AJAXURL", admin_url( "admin-ajax.php" ) );
//             wp_localize_script(  "requirejs", "ajaxurl", admin_url( "admin-ajax.php" ) );
//             wp_localize_script( "requirejs", "UPLOADURL", admin_url( "async-upload.php" ) );
//             wp_localize_script( "requirejs", "_WPNONCE", wp_create_nonce( 'media-form' ) );
//             wp_localize_script( "requirejs", "BUILDINGS", $buildings );
//             wp_localize_script( "requirejs", "BUILDINGS_PHASES", $phases );
//             wp_localize_script( "requirejs", "UNITS", $units );
//             wp_localize_script( "requirejs", "STATUS", get_unit_status() );
//             wp_localize_script( "requirejs", "UNITTYPES", get_unit_types() );
//             wp_localize_script( "requirejs", "TERRACEOPTIONS", get_terrace_options() );
//             wp_localize_script( "requirejs", "UNITVARIANTS", get_unit_variants() );
//             wp_localize_script( "requirejs", "VIEWS", get_views() );
//             wp_localize_script( "requirejs", "FACINGS", get_facings() );
//             wp_localize_script( "requirejs", "PAYMENTPLANS", get_payment_plans() );
//             wp_localize_script( "requirejs", "MILESTONES", get_milestones() );
//             wp_localize_script( "requirejs", "SETTINGS", get_apratment_selector_settings() );
//             wp_localize_script( "requirejs", "USER", get_ap_current_user() );
//             wp_localize_script( "requirejs", "EMAILFORM", FrmEntriesController::show_form(27, $key = '', $title=false, $description=true  ));
 

//         }
//     }
 
//         add_action( 'wp_enqueue_scripts', 'apartmentselector_dev_enqueue_scripts' );
   

//     function apartmentselector_dev_enqueue_styles() {

//         $module = get_module_name();

//         wp_enqueue_style( "$module-style", get_template_directory_uri() . "/css/{$module}.styles.css".$bust, array(), "", "screen" );

//         wp_enqueue_style( "$module-print-style", get_template_directory_uri() . "/css/{$module}.print.css".$bust, array(), "", "print" );

//     } 
//         add_action( 'wp_enqueue_scripts', 'apartmentselector_dev_enqueue_styles' );
   
// }

// if (! is_development_environment() ) {

//     function apartmentselector_production_enqueue_script() {

//     //check not to enqueue frontend scritps for backend
//     if(!check_backend_template()){
//            $module = get_module_name();

//             if ( is_single_page_app( $module ) )

//                 $path = get_template_directory_uri() . "/production/{$module}.spa.min.js".$bust;
//             else
//                 $path = get_template_directory_uri() . "/production/{$module}.scripts.min.js".$bust;

//             wp_enqueue_script( "$module-script",
//                 $path,
//                 array(),
//                 get_current_version(),
//                 TRUE );

//             $data = get_data();
//             $buildings = $data[0];
//             $units = $data[1];
//             $phases = $data[2];
//             wp_localize_script(  "$module-script", "SITEURL", site_url() );
//             wp_localize_script(  "$module-script", "AJAXURL", admin_url( "admin-ajax.php" ) );
//             wp_localize_script(  "$module-script", "ajaxurl", admin_url( "admin-ajax.php" ) );
//             wp_localize_script(  "$module-script", "UPLOADURL", admin_url( "async-upload.php" ) );
//             wp_localize_script(  "$module-script", "_WPNONCE", wp_create_nonce( 'media-form' ) );
//             wp_localize_script( "$module-script", "BUILDINGS", $buildings );
//             wp_localize_script( "$module-script", "BUILDINGS_PHASES", $phases );
//             wp_localize_script( "$module-script", "UNITS", $units );
//             wp_localize_script( "$module-script", "STATUS", get_unit_status() );
//             wp_localize_script( "$module-script", "UNITTYPES", get_unit_types() );
//             wp_localize_script( "$module-script", "TERRACEOPTIONS", get_terrace_options() );
//             wp_localize_script( "$module-script", "UNITVARIANTS", get_unit_variants() );
//             wp_localize_script( "$module-script", "VIEWS", get_views() );
//             wp_localize_script( "$module-script", "FACINGS", get_facings() );
//             wp_localize_script( "$module-script", "PAYMENTPLANS", get_payment_plans() );
//             wp_localize_script( "$module-script", "MILESTONES", get_milestones() );
//             wp_localize_script( "$module-script", "SETTINGS", get_apratment_selector_settings() );
//             wp_localize_script( "$module-script", "USER", get_ap_current_user() );
//             wp_localize_script( "$module-script", "EMAILFORM", FrmEntriesController::show_form(27, $key = '', $title=false, $description=true  ));
//         }
//     }

//        add_action( 'wp_enqueue_scripts', 'apartmentselector_production_enqueue_script' );
  
    
//     function apartmentselector_production_enqueue_styles() {

//     //check not to enqueue frontend scritps for backend
//     if(!check_backend_template()){
//         $module = get_module_name();

//         wp_enqueue_style( "$module-style",
//             get_template_directory_uri() . "/production/{$module}.styles.min.css".$bust,
//             array(),
//             get_current_version(),
//             "screen" );

//         wp_enqueue_style( "$module-print-style",
//             get_template_directory_uri() . "/css/{$module}.print.css".$bust,
//             array(),
//             "",
//             "print" );

        
//         }

//     }
//         add_action( 'wp_enqueue_scripts', 'apartmentselector_production_enqueue_styles' );

// }


// function is_development_environment() {

//     if ( defined( 'ENV' ) && ENV === "production" )
//         return FALSE;

//     return TRUE;
// }


// function get_current_version() {

//     global $wp_version;

//     if ( defined( 'VERSION' ) )
//         return VERSION;

//     return $wp_version;

// }

// function is_single_page_app( $module_name ) {

//     // add slugs of SPA pages here
//     $spa_pages = array( 'apartment-selector','apartmentsselector','wishlist' ,'booking');

//     return in_array( $module_name, $spa_pages );

// }


// function get_module_name() {

//     $module = "";

//     // TODO: Handle with project specific logic here to define module names
//     if ( is_page() )
//         $module = sanitize_title( get_the_title() );
   

//     return $module;

// }


// function generate_pdf_data($unit_id,$tower_id,$wishlist){

//     // create new PDF document
//         $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//         // set document information
//         $pdf->SetCreator(PDF_CREATOR);
//         $pdf->SetAuthor('Nicola Asuni');
//         $pdf->SetTitle('TCPDF Example 001');
//         $pdf->SetSubject('TCPDF Tutorial');
//         $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
//         $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        

//         $pdf->AddPage();

       
    
//         $units_data = get_post($unit_id);
        

//         $unit_variant =   get_post_meta($units_data->ID, 'unit_variant', true);
        
//         $building =   get_post_meta($units_data->ID, 'building', true);

//         $apartment_views =   get_post_meta($units_data->ID, 'apartment_views', true);

//         $facings_data =   get_post_meta($units_data->ID, 'facing', true);

//         $floor = get_post_meta($units_data->ID, 'floor', true);

//         $unit_type = get_unit_type_by_unit_variant($unit_variant);

//         $unitytpes = get_unit_type_by_id($unit_type);
//         $views = "";
//         $facings = "";
//         if(count($apartment_views)>0 && $apartment_views != "" )
//             {
//             foreach($apartment_views as $value){

//                 $viewsdata = get_views($value);
                
//                 $views .= $viewsdata[0]['name'].'<br/>';

//             }
//         }
//         if(count($facings_data)>0 && $facings_data != "")
//             {
//             foreach($facings_data as $value){

//                 $facingsdata = get_facings($value);
               
//                 $facings .= $facingsdata[0]['name'].'<br/>';

//             }
//         }


    

//         $unitvariant = get_unit_variants($unit_variant);

//         $rangname = "";
//         $buildingmodel = get_building_by_id($building);
//         $image_attributes = wp_get_attachment_image_src( $buildingmodel['zoomedinimage']['id'] );
//         $zoomed_in_image = $image_attributes[0];
        
//         $attachment = get_attached_file($buildingmodel['zoomedinimage']['id']);
//         $floorriserange = $buildingmodel['floorriserange'];
//         foreach($floorriserange as $value){
            
//             $range = array();
//             $start = intval($value['start']);
//             $end = intval($value['end']);
//             $i = $start;
//             while($i<=$end){
//                 array_push($range,$i);
//                 $i++;


//             }
            
//             $rangname = "";
            
            
//             if(in_array($floor, $range)){
               
//                 if($value['name'] == 'medium')
//                     $rangname = 'mid';
//                 else
//                     $rangname = $value['name'];


                
//                 $rangname = $rangname."rise";

//             }


//         }
       
//         $result = ucfirst($rangname);
//         $html = "";
//         $image = '<div><img src="'.$attachment.'" /></div>';
//     // $pdf->writeHTML($image, true, 0, true, 0);
//     // $pdf->Image($zoomed_in_imag , 0, 0, 210, 2697, '', '', '', true, 150);

//     // $html .= "<span>Flat No. </span><span>".$units_data->post_name."</span><br/><span>".$buildingmodel['name']."
//     //         </span><br/><span>Floor Range: </span>".$result."<span>".$unitytpes->name;

//         $html .= '
                    
//                         <div class="col-sm-6 head">
//                             <h1>Flat No: <strong><span id="flatno">'.$units_data->post_name.'</span></strong></h1>
//                         </div>
//                         <div class="col-sm-6 head">
//                             <h1 id="towerno">'.$buildingmodel['name'].'</h1>
//                         </div>
                    
                    
//                         <div class="col-sm-6 head">
//                             <h2>Flat Type: <strong><span id="unittypename">'.$unitytpes->name.'</span></strong>(<span id="area">'.$unitvariant[0]['sellablearea'].'</span> sq. ft.)</h2>
//                         </div>
//                         <!--<div class="col-sm-6 head">
//                             <h2>Floor Range: <strong><span id="floorrise"></span></strong></h2>
//                         </div>-->';
    
    

                
//                 foreach($unitvariant[0]['roomsizes'] as $value){
                    
//                     $html .= '<div class="rooms">
//                                     <span>'.$value['room_type'].'</span>: '.$value['room_size'].' sq ft
//                                 </div>';


//                 }

//     $html .= '<span>Views :</span>'.$views;
//     $html .= '<span>Facings: </span>'.$facings;
//     // print_r($unitvariant);
    
    
//     $upload_dir = wp_upload_dir();
//     $destination_dir = $upload_dir['basedir'].'/2014/pdfuplaods';

//     if (!file_exists($destination_dir)){

//     mkdir($destination_dir);

//     }

//     $filename = "unitdetails".date('dmyhis');

//     $pdf->WriteHTML( $html );
//     $image = '<div><img src="'.$unitvariant[0]['url2dlayout_image'].'" /></div>';
//     $pdf->writeHTML($image, true, 0, true, 0);
//     $image = '<div><img src="'.$unitvariant[0]['url3dlayout_image'].'" /></div>';
//     $pdf->writeHTML($image, true, 0, true, 0);

    
//     $wishlistarray = explode(',', $wishlist);
    
//     foreach($wishlistarray as $value){

//         $wish = "";
        
//         $units_data = get_post($value);

//         $unit_variant =   get_post_meta($units_data->ID, 'unit_variant', true);
        
//         $building =   get_post_meta($units_data->ID, 'building', true);

//         $floor = get_post_meta($units_data->ID, 'floor', true);

//         $buildingmodel = get_building_by_id($building);

        
//         $unit_type = get_unit_type_by_unit_variant($unit_variant);

//         $unitytpes = get_unit_type_by_id($unit_type);

        

//         $unitvariant = get_unit_variants($unit_variant);

//         $floorriserange = $buildingmodel['floorriserange'];
//         foreach($floorriserange as $value){
            
//             $range = array();
//             $start = intval($value['start']);
//             $end = intval($value['end']);
//             $i = $start;
//             while($i<=$end){
//                 array_push($range, $i);
//                 $i++;


//             }
            
//             $rangname = "";

            
//             if(in_array($floor, $range)){
               
//                 if($value['name'] == 'medium')
//                     $rangname = 'mid';
//                 else
//                     $rangname = $value['name'];


                
//                 $rangname = $rangname."rise";

//             }


//         }
//         $result = ucfirst($rangname);
//         $apartment_views =   get_post_meta($units_data->ID, 'apartment_views', true);

//         $facings_data =   get_post_meta($units_data->ID, 'facing', true);

//         $views = "";
//         $facings = "";
//         if(count($apartment_views)>0 && $apartment_views != "" )
//             {
//             foreach($apartment_views as $value){

//                 $viewsdata = get_views($value);
                
//                 $views .= $viewsdata[0]['name'].'<br/>';

//             }
//         }
//         if(count($facings_data)>0 && $facings_data != "")
//             {
//             foreach($facings_data as $value){

//                 $facingsdata = get_facings($value);
               
//                 $facings .= $facingsdata[0]['name'].'<br/>';

//             }
//         }
//     $roomsizes = $unitvariant[0]['roomsizes'];
//     $roomTypeArr = array(68,71,72);
//     $roomsizearr = array();
//     $roomTest= "";
//     $mainArr =array();
//     foreach ($roomTypeArr as $key => $value) {

//         $roomTest .= $value['room_type'];
//         foreach ($roomsizes as $key => $value1) {
//             if($value1['room_type_id'] == $value){
//                 $roomTest .= $value1['room_type'].'-'.$value1['room_size'].'<br/>';
//             }
//             # code...
//         }
//         $roomTest .= '<br/>';
//         # code...
//     }

   
//         $image = "";
//         $wish .= '<h1>Flat No: <strong><span id="flatno">'.$units_data->post_name.'</span></strong></h1>
//         <h1 id="towerno">'.$buildingmodel['name'].'</h1>
//         <h2>Flat Type: <strong><span id="unittypename">'.$unitytpes->name.'</span></strong>(<span id="area">'.$unitvariant[0]['sellablearea'].'</span> sq. ft.)</h2>
//         <!--<h2>Floor Range: <strong><span id="floorrise"></span></strong></h2>-->
//         <h2>Floor: <strong><span id="floorrise">'.$floor.'</span></strong></h2>
//         <h2>Views: <strong><span id="floorrise">'.$views.'</span></strong></h2>
//         <h2>Facings: <strong><span id="floorrise">'.$facings.'</span></strong></h2>
//         <h2>Total Area: <strong><span id="floorrise">'.$unitvariant[0]['sellablearea'].'</span></strong></h2>
//         <h2>Carpet Area: <strong><span id="floorrise">'.$unitvariant[0]['carpetarea'].'</span></strong></h2>
//         <h2>Terrace Area: <strong><span id="floorrise">'.$unitvariant[0]['terracearea'].'</span></strong></h2>
//         <h2>Room Sizes: <strong><span id="floorrise">'.$roomTest.'</span></strong></h2>';

//         $pdf->WriteHTML( $wish );
//         $image = '<img src="'.$unitvariant[0]['url2dlayout_image'].'"  />';
//         $pdf->writeHTML($image, true, 0, true, 0);
//         $image = '<img src="'.$unitvariant[0]['url3dlayout_image'].'" />';
//         $pdf->writeHTML($image, true, 0, true, 0);
//         $image = '<img src="'.$buildingmodel['positioninproject']['image_url'].'"  />';
//         $pdf->writeHTML($image, true, 0, true, 0);
        
    



//     }
   



    
//     $output_link=$destination_dir.'/'.$filename.'.pdf';
    
   
//    $attachment = $pdf->Output($output_link, 'F');

//    return $output_link;
// }

// add_action('cron_schedule_session_removal', 'cron_check_seesion', 2,0);


