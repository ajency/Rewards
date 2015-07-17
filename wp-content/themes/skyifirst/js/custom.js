
window.onload = function(){
    jQuery('.woocommerce-message').hide()

    // jQuery('#`customer_next`').on('click',function(e){

    //   jQuery('#customer_details').show()

    // })

    jQuery('#customer_next').click(function() {
      jQuery('.validation').remove();
      jQuery('#billing_state option[value="MH"]').attr("selected",true)
      if(jQuery('#variation_id').val()==""){

        jQuery("#customer_next").before("<div class='validation' style='color:red'>Choose unit type</div>");
        return false;
      }
      jQuery('.accordion-group.one').removeClass('open');
      jQuery('.accordion-group.two').addClass('open viewed');
      jQuery('.progress-outer').css('width', '50%');
    });

    jQuery('.one.viewed > .acc-title').click(function() {
      jQuery('.accordion-group').removeClass('open');
      jQuery('.accordion-group.one').addClass('open');
      jQuery('.progress-outer').css('width', '15%');
    });


    // jQuery('#payment_next').on('click',function(e){

    //   jQuery('#payment_options').show()

    // })

    jQuery('#payment_next').click(function() {

      jQuery('.validation').remove();
      if(jQuery('#billing_first_name').val() == "")
      {
        jQuery("#billing_first_name").after("<div class='validation' style='color:red'>Please enter First name</div>");
        return false;
      }
      if(jQuery('#billing_last_name').val() == "")
      {
        jQuery("#billing_last_name").after("<div class='validation' style='color:red'>Please enter Last name</div>");
        return false;
      }
      if(jQuery('#billing_email').val() == "")
      {
        jQuery("#billing_email").after("<div class='validation' style='color:red'>Please enter Email Address</div>");
        return false;
      }
      if(jQuery('#billing_email-2').val() == "")
      {
        jQuery("#billing_email-2").after("<div class='validation' style='color:red'>Please enter Email Address</div>");
        return false;
      }


      if(!(validateEmail(jQuery('#billing_email').val())))
      {
        jQuery("#billing_email").after("<div class='validation' style='color:red'>Enter Valid Email Address</div>");
        return false;
      }
      if(!(validateEmail(jQuery('#billing_email-2').val())))
      {
        jQuery("#billing_email-2").after("<div class='validation' style='color:red'>Enter Valid Email Address</div>");
        return false;
      }
      if(jQuery('#billing_email-2').val() != jQuery('#billing_email').val())
      {
        jQuery("#billing_email-2").after("<div class='validation' style='color:red'>Email addresses you entered do not match</div>");
           return false;
      }
      if(jQuery('#billing_phone').val() == "")
      {
        jQuery("#billing_phone").after("<div class='validation' style='color:red'>Please enter Phone No</div>");
        return false;
      }
      var phone = jQuery('#billing_phone').val(),
        intRegex = /^[0-9]*(?:\.\d{1,2})?$/;
      if((phone.length < 6) || (!intRegex.test(phone)))
      {
          jQuery("#billing_phone").after("<div class='validation' style='color:red'>Please enter a valid phone number</div>");
           return false;
      }
      if(jQuery('#billing_address_1').val() == "")
      {
        jQuery("#billing_address_1").after("<div class='validation' style='color:red'>Please enter Address</div>");
        return false;
      }
      if(jQuery('#billing_address2').val() == "")
      {
        jQuery("#billing_address2").after("<div class='validation' style='color:red'>Please enter Address</div>");
        return false;
      }
      if(jQuery('#billing_city').val() == "")
      {
        jQuery("#billing_city").after("<div class='validation' style='color:red'>Please enter Town/City</div>");
        return false;
      }
      if(jQuery('#billing_state').val() == "")
      {
        jQuery("#billing_state").after("<div class='validation' style='color:red'>Please enter State</div>");
        return false;
      }

      jQuery('.accordion-group.two').removeClass('open');
      jQuery('.accordion-group.three').addClass('open viewed');



      jQuery('.progress-outer').css('width', '85%');
      jQuery('.two.viewed > .acc-title').on('click',function() {
        jQuery('.accordion-group').removeClass('open');
        jQuery('.accordion-group.two').addClass('open');
      });



    });


    jQuery('.variant_product').on('click' , function(e){
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
        url: SITEURL+'/?add-to-cart=variation&product_id='+p_id,
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
    url: SITEURL+'/?add-to-cart=variation&product_id='+p_id,
    data: { 'variation_id':  v_id,
            'product_id':  p_id},
    success: function(response, textStatus, jqXHR){
          // log a message to the console
          console.log("It worked!");
      }/*,
    dataType: 'JSON'*/
  });
}

    // jQuery('#customer_back').on('click',function(e){

    //   jQuery('#customer_details').hide()
    //   jQuery('#payment_options').hide()
    //   jQuery('form').clearForm()


    // })

    jQuery('#customer_back').click(function() {
      jQuery('.accordion-group').removeClass('open');
      jQuery('.accordion-group.one').addClass('open');
      jQuery('.progress-outer').css('width', '15%');
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

      function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
  }

  jQuery('#billing_email').on('change' , function(e){
      jQuery('.validation').remove();
      if(!(validateEmail(jQuery('#billing_email').val())))
      {
        jQuery("#billing_email").after("<div class='validation' style='color:red'>Enter Valid Email Address</div>");
         return false;
      }
  })

  jQuery('#billing_email-2').on('change' , function(e){
      jQuery('.validation').remove();
      if(!(validateEmail(jQuery('#billing_email-2').val())))
      {
        jQuery("#billing_email-2").after("<div class='validation' style='color:red'>Enter Valid Email Address</div>");
         return false;
      }
      if(jQuery('#billing_email-2').val() !=   jQuery('#billing_email').val())
      {
      jQuery("#billing_email-2").after("<div class='validation' style='color:red'>Email addresses you entered do not match</div>");
         return false;
      }
  })

  jQuery('#billing_phone').on('change' , function(e){
      jQuery('.validation').remove();
    var phone = jQuery('#billing_phone').val(),
    intRegex = /^[0-9]*(?:\.\d{1,2})?$/;
    if((phone.length < 6) || (!intRegex.test(phone)))
    {
      jQuery("#billing_phone").after("<div class='validation' style='color:red'>Please enter a valid phone number</div>");
       return false;
    }
  })




    window.addEventListener('scroll', function(e){
        var distanceY = window.pageYOffset || document.documentElement.scrollTop,
            shrinkOn = 20,
            header = document.querySelector(".fixed-header");
        if (distanceY > shrinkOn) {
            classie.add(header,"smaller");
        } else {
            if (classie.has(header,"smaller")) {
                classie.remove(header,"smaller");
            }
        }
    });

    jQuery('.input-text ').on('keypress' , function(e){
        jQuery('.validation').remove();


    })
    jQuery(document).on('keypress' , function(e){
        if(e.keyCode == 13)
        e.preventDefault();


    })

    if(window.location.href == SITEURL+'/partner-application/')
    {

      jQuery('.payment_method_payu_in').hide();
      jQuery('#payment_method_cheque').attr('checked' , true);
      jQuery('.payment_method_cheque').hide();
    }



    jQuery('#place_order').on('click',function(e){
      e.preventDefault();
      jQuery('.validation').remove();
      if(jQuery('#cheque_no').val() == "")
      {
        jQuery("#cheque_no").after("<div class='validation' style='color:red'>Please enter Cheque No</div>");
        return false;
      }
      if(jQuery('#confirm_cheque_no').val() != jQuery('#cheque_no').val())
      {
        jQuery("#confirm_cheque_no").after("<div class='validation' style='color:red'>Cheque nos do not match</div>");
        return false;
      }
      if(jQuery('#confirm_cheque_no').val() == "")
      {
        jQuery("#confirm_cheque_no").after("<div class='validation' style='color:red'>Please enter Cheque No</div>");
        return false;
      }
      if(jQuery('#booking_amount').val() == "")
      {
        jQuery("#booking_amount").after("<div class='validation' style='color:red'>Please enter Amount</div>");
        return false;
      }
      if(jQuery('#cheque_bank').val() == "")
      {
        jQuery("#cheque_bank").after("<div class='validation' style='color:red'>Please enter Bank details</div>");
        return false;
      }
      if(jQuery('#sale_person_name').val() == "")
      {
        jQuery("#sale_person_name").after("<div class='validation' style='color:red'>Please enter name</div>");
        return false;
      }
      if(jQuery('#sale_person_email').val() == "")
      {
        jQuery("#sale_person_email").after("<div class='validation' style='color:red'>Please enter email address</div>");
        return false;
      }
      if(jQuery('#sale_person_phone').val() == "")
      {
        jQuery("#sale_person_phone").after("<div class='validation' style='color:red'>Please enter phone no</div>");
        return false;
      }
      if(jQuery('#sale_person_company').val() == "")
      {
        jQuery("#sale_person_company").after("<div class='validation' style='color:red'>Please enter company</div>");
        return false;
      }

      var phone = jQuery('#sale_person_phone').val(),
        intRegex = /^[0-9]*(?:\.\d{1,2})?$/;
      if((phone.length < 6) || (!intRegex.test(phone)))
      {
          jQuery("#sale_person_phone").after("<div class='validation' style='color:red'>Please enter a valid phone number</div>");
           return false;
      }
      var amount = jQuery('#booking_amount').val(),
        intRegex = /^[0-9]*(?:\.\d{1,2})?$/;
      if((amount.length < 6) || (!intRegex.test(amount)))
      {
          jQuery("#booking_amount").after("<div class='validation' style='color:red'>Please enter a valid phone number</div>");
           return false;
      }
      if(!(jQuery('#terms').is(":checked")))
      {
          jQuery("#terms").after("<div class='validation' style='color:red'>Accept terms and conditions to proceed</div>");
           return false;
      }



    });
    jQuery('#booking_amount,#sale_person_phone').on('change' , function(e){
        jQuery('.validation').remove();
      var phone = jQuery(e.target).val(),
      intRegex = /^[0-9]*(?:\.\d{1,2})?$/;
      if((phone.length < 6) || (!intRegex.test(phone)))
      {
        jQuery(e.target).after("<div class='validation' style='color:red'>Please enter a valid phone number</div>");
         return false;
      }
    })

    jQuery('#cheque_no,#confirm_cheque_no').on('keypress' , function(e){
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
    jQuery('#cheque_no').on('change' , function(e){
      jQuery('.validation').remove();
      jQuery.ajax({
        type: 'POST',
        url: AJAXURL+'?action=check_cheque_no',
        data: { 'cheque_no':  jQuery(e.target).val()},
        success: function(response, textStatus, jqXHR){
              // log a message to the console

              if(jqXHR.status ==200){
                if(response == 1){
                  jQuery(e.target).val("");
                  jQuery(e.target).after("<div class='validation' style='color:red'>Duplicate entry!!Please enter again</div>");
                   return false;
                }
              }
              else {
                jQuery(e.target).val("");
                jQuery(e.target).after("<div class='validation' style='color:red'>Some problerm occurred.Please enter again</div>");
                 return false;
              }

          }/*,
        dataType: 'JSON'*/
      });
    })
jQuery('#billing_state option[value="MH"]').attr("selected",true)
}
