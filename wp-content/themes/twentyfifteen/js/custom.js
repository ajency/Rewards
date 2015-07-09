
window.onload = function(){
    jQuery('.woocommerce-message').hide()
    jQuery('#customer_next').on('click',function(e){

      jQuery('#customer_details').show()

    })
    jQuery('#payment_next').on('click',function(e){

      jQuery('#payment_options').show()

    })
    jQuery('#customer_back').on('click',function(e){

      jQuery('#customer_details').hide()
      jQuery('#payment_options').hide()
      jQuery('form[name="checkout"]').trigger('reset')


    })
    jQuery('.single_add_to_cart_button').on('click' , function(e){
      e.preventDefault()
      jQuery('#variation_id').val(jQuery(e.currentTarget).val());
      jQuery('#product_id').val(jQuery(e.currentTarget).attr('data-product'));
        jQuery('#add-to-cart').val(jQuery(e.currentTarget).attr('data-product'));

        jQuery('#attribute_pa_unit_type').val(jQuery('#attributepa_unit_type'+jQuery(e.currentTarget).val()).val());
      jQuery('form#myForm').submit();
    })

}
