
window.onload = function(){
    jQuery('.woocommerce-message').hide()

    // jQuery('#customer_next').on('click',function(e){

    //   jQuery('#customer_details').show()

    // })

    jQuery('#customer_next').click(function() {
      jQuery('.accordion-group.one').removeClass('open');
      jQuery('.accordion-group.two').addClass('open viewed');
    });

    jQuery('.one.viewed > .acc-title').click(function() {
      jQuery('.accordion-group').removeClass('open');
      jQuery('.accordion-group.one').addClass('open');
    });


    // jQuery('#payment_next').on('click',function(e){

    //   jQuery('#payment_options').show()

    // })

    jQuery('#payment_next').click(function() {
      // if(jQuery('#billing_first_name').val() == "")
      // {
      //   alert('Please enter First name');
      //   return false;
      // }
      // if(jQuery('#billing_last_name').val() == "")
      // {
      //   alert('Please enter Last name');
      //   return false;
      // }
      // if(jQuery('#billing_email').val() == "")
      // {
      //   alert('Please enter Email Address');
      //   return false;
      // }
      // if(jQuery('#billing_email-2').val() == "")
      // {
      //   alert('Please enter Email Address');
      //   return false;
      // }
      // if(jQuery('#billing_phone').val() == "")
      // {
      //   alert('Please enter Phone No');
      //   return false;
      // }
      // if(jQuery('#billing_address_1').val() == "")
      // {
      //   alert('Please enter Address');
      //   return false;
      // }
      // if(jQuery('#billing_address2').val() == "")
      // {
      //   alert('Please enter Address');
      //   return false;
      // }
      // if(jQuery('#billing_city').val() == "")
      // {
      //   alert('Please enter Town/City');
      //   return false;
      // }
      // if(jQuery('#billing_state').val() == "")
      // {
      //   alert('Please enter State');
      //   return false;
      // }
      //
      // jQuery('.accordion-group.two').removeClass('open');
      // jQuery('.accordion-group.three').addClass('open viewed');
      //  jQuery('form#myForm').submit();
       jQuery('form#checkout').submit();
    });

    jQuery('.two.viewed > .acc-title').click(function() {
      jQuery('.accordion-group').removeClass('open');
      jQuery('.accordion-group.two').addClass('open');
    });

    jQuery('.hb-woo-main-link').on('click' , function(e){
      e.preventDefault()
       jQuery('#variation_id').val(jQuery(e.currentTarget).val());
       jQuery('#product_id').val(jQuery(e.currentTarget).attr('data-product'));
       jQuery('#add-to-cart').val(jQuery(e.currentTarget).attr('data-product'));

       jQuery('#attribute_pa_unit_type').val(jQuery('#attributepa_unit_type'+jQuery(e.currentTarget).val()).val());
       jQuery('form#myForm').submit();
    })

    jQuery( document ).ajaxComplete(function() {

    variation_id = jQuery('#variation_id').val();
    jQuery('#buy_button'+variation_id).addClass('variation_seleced');

    jQuery('.hb-woo-main-link-checkout').on('click' , function(e){
      jQuery('.hb-woo-main-link-checkout').removeClass('variation_seleced');

       e.preventDefault()
       jQuery('#variation_id').val(jQuery(e.currentTarget).val());
       jQuery('#product_id').val(jQuery(e.currentTarget).attr('data-product'));
       jQuery('#buy_button'+jQuery('#variation_id').val()).addClass('variation_seleced');
       addToCart(jQuery('#product_id').val(),jQuery('#variation_id').val());
      return false;
    })
      function addToCart(p_id, v_id) {
      jQuery.ajax({
        type: 'POST',
        url: 'http://localhost/Skyicoupon/?add-to-cart=variation&product_id='+p_id,
        data: { 'variation_id':  v_id,
                'product_id':  p_id},
        success: function(response, textStatus, jqXHR){
              // log a message to the console
              console.log("It worked!");
          }/*,
        dataType: 'JSON'*/
      });
    }
});



    // jQuery('#customer_back').on('click',function(e){

    //   jQuery('#customer_details').hide()
    //   jQuery('#payment_options').hide()
    //   jQuery('form').clearForm()


    // })

    jQuery('#customer_back').click(function() {
      jQuery('.accordion-group').removeClass('open');
      jQuery('.accordion-group.one').addClass('open');
    });



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
