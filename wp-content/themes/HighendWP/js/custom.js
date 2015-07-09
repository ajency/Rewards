
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
      jQuery('form').clearForm()


    })
    jQuery('.single_add_to_cart_button').on('click' , function(e){
      e.preventDefault()
      jQuery('#variation_id').val(jQuery(e.currentTarget).val());
      jQuery('#product_id').val(jQuery(e.currentTarget).attr('data-product'));
        jQuery('#add-to-cart').val(jQuery(e.currentTarget).attr('data-product'));

        jQuery('#attribute_pa_unit_type').val(jQuery('#attributepa_unit_type'+jQuery(e.currentTarget).val()).val());
      jQuery('form#myForm').submit();
    })

    jQuery.fn.clearForm = function(){
      return this.each(function() {
        var type = this.type, tag = this.tagName.toLowerCase();
        if (tag == 'form')
          return jQuery(':input',this).clearForm();
        if (type == 'text' || type == 'password' || tag == 'textarea')
          this.value = '';
        else if (type == 'checkbox' || type == 'radio')
          this.checked = false;
        else if (tag == 'select')
          this.selectedIndex = -1;
      });

    };
      jQuery('form').clearForm()





}
