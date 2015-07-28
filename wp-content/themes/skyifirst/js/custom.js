
jQuery(document).ready(function(){
	jQuery('.woocommerce-message').hide()

})
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
	  
	 

	   jQuery.ajax({
		  type: 'POST',
		  url: AJAXURL+'?action=get_product_variantion',
		  success: function(response, textStatus, jqXHR){
			jQuery('.amount').text(response.price)
		
				jQuery('.accordion-group.two').removeClass('open');
				jQuery('.accordion-group.three').addClass('open viewed');



				jQuery('.progress-outer').css('width', '85%');
				jQuery('.two.viewed > .acc-title').on('click',function() {
				  jQuery('.accordion-group').removeClass('open');
				  jQuery('.accordion-group.two').addClass('open');
				});


			}/*,
		  dataType: 'JSON'*/
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
		jQuery('.woocommerce-message').hide()
	variation_id = jQuery('#variation_id').val();
	jQuery('#buy_button'+variation_id).addClass('variation_seleced');

	jQuery('.hb-woo-main-link-checkout').on('click' , function(e){
	  jQuery('.hb-woo-main-link-checkout').removeClass('variation_seleced');

	   e.preventDefault()
	   jQuery('#variation_id').val(jQuery(e.currentTarget).val());
	   jQuery('#product_id').val(jQuery(e.currentTarget).attr('data-product'));
	   jQuery('#buy_button'+jQuery('#variation_id').val()).addClass('variation_seleced');
	   jQuery('#attribute_pa_unit_type').val(jQuery('#attributepa_unit_type'+jQuery('#product_id').val()).val());
   	   variation = jQuery('#attributepa_unit_type'+jQuery('#variation_id').val()).val();
	   addToCart(jQuery('#product_id').val(),jQuery('#variation_id').val(),variation);
	  return false;
	})
	  function addToCart(p_id, v_id,variation) {
  jQuery.ajax({
	type: 'POST',
	url: AJAXURL+'?action=add_prodcut_variation',
	data: { 'vid':  v_id,
			'pid':  p_id,
			'qty':1,
			'variation' : {
			  'unit_type' : variation
			}
		  },
	success: function(response, textStatus, jqXHR){
		  // log a message to the console
		  jQuery('.unit_type').text(response.unit_type)
		  
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
   jQuery('#attribute_pa_unit_type').val(jQuery('#attributepa_unit_type'+jQuery('#product_id').val()).val());
   variation = jQuery('#attributepa_unit_type'+jQuery('#variation_id').val()).val();
   addToCart(jQuery('#product_id').val(),jQuery('#variation_id').val(),variation);
  return false;
})
  function addToCart(p_id, v_id,variation) {
  jQuery.ajax({
	type: 'POST',
	url: AJAXURL+'?action=add_prodcut_variation',
	data: { 'vid':  v_id,
			'pid':  p_id,
			'qty':1,
			'variation' : {
			  'unit_type' : variation
			}
		  },
	success: function(response, textStatus, jqXHR){
		  // log a message to the console
		   jQuery('.unit_type').text(response.unit_type)
		  console.log(response);

	  }/*,
	dataType: 'JSON'*/
  });
}

	

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

	jQuery(document).bind('keyup' , '.input-text', function(e){
		jQuery('.validation').remove();
		jQuery('.accept_text').hide();
	    jQuery('.place_order_button').hide();


	})
	jQuery(document).bind('change' , '.input-text', function(e){
		jQuery('.validation').remove();
		jQuery('.accept_text').hide();
	    jQuery('.place_order_button').hide();


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
	  // jQuery('input[name="_wp_http_referer"]').val("/wp-admin/admin-ajax.php")
	  // jQuery('input[name="_wpnonce"]').val("a1f1ba4333")
	  // jQuery('.added').remove();
	}



	jQuery(document).on('click','#accpt_terms',function(e){
	  e.preventDefault();
	  jQuery('.validation').remove();
	  
	 if(window.location.href == SITEURL+'/partner-application/')
	{
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
	  // if(jQuery('#booking_amount').val() == "")
	  // {
	  //   jQuery("#booking_amount").after("<div class='validation' style='color:red'>Please enter Amount</div>");
	  //   return false;
	  // }
	  if(jQuery('#cheque_bank').val() == "")
	  {
		jQuery("#cheque_bank").after("<div class='validation' style='color:red'>Please enter Bank details</div>");
		return false;
	  }
	  if(jQuery('#sale_person_name').val() == "")
	  {
		jQuery("#sale_person_name").after("<div class='validation' style='color:red'>Please enter first name</div>");
		return false;
	  }
	  if(jQuery('#sale_person_last_name').val() == "")
	  {
		jQuery("#sale_person_last_name").after("<div class='validation' style='color:red'>Please enter last name</div>");
		return false;
	  }
	  if(jQuery('#sale_person_email').val() == "")
	  {
		jQuery("#sale_person_email").after("<div class='validation' style='color:red'>Please enter email address</div>");
		return false;
	  }
	  if(!(validateEmail(jQuery('#sale_person_email').val())))
	  {
		jQuery("#sale_person_email").after("<div class='validation' style='color:red'>Enter Valid Email Address</div>");
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
	  if(!(jQuery('#terms').is(":checked")))
	{

	  			jQuery('#popup').bPopup();
	  			return false;
	  }

	  var phone = jQuery('#sale_person_phone').val(),
		intRegex = /^[0-9]*(?:\.\d{1,2})?$/;
		if(jQuery('#sale_person_phone').val() != undefined){
			 if((phone.length < 6) || (!intRegex.test(phone)))
			  {
				  jQuery("#sale_person_phone").after("<div class='validation' style='color:red'>Please enter a valid phone number</div>");
				   return false;
			  }
		}
	 }
	 else
	 {
	 	if(jQuery('#payment_method_payu_in').is(':checked')){
	 			flag = 0;
			   jQuery('.payu-options input[type="radio"]').each(function(indx,value){
			  		if(jQuery(value).is(':checked') && jQuery('#payment_method_payu_in').is(':checked'))
			  		{
			  			flag = 1;
			  		}

			  })
			   if(flag == 0){
			   	jQuery(".payu-options").after("<div class='validation' style='color:red'>Choose atleast one online mode of Payment</div>");
				   return false;
			   }
	 	}
	 	if(!(jQuery('#terms').is(":checked")))
		  {
		  		jQuery( "#payment .terms a" ).trigger('click')
			    jQuery("#terms").after("<div class='validation' style='color:red'>Accept terms and conditions to proceed</div>");
			    return false;
		  }
	 	
	 }
	  
	  


	
	  jQuery('.accept_text').show();
	 jQuery('.place_order_button').show();



	});

	jQuery('#sale_person_email').on('change' , function(e){
		jQuery('.validation').remove();
		if(!(validateEmail(jQuery('#sale_person_email').val())))
		{
		  jQuery("#sale_person_email").after("<div class='validation' style='color:red'>Enter Valid Email Address</div>");
		   return false;
		}
	})
	jQuery('#sale_person_phone').on('change' , function(e){
		jQuery('.validation').remove();
	  var phone = jQuery(e.target).val(),
	  intRegex = /^[0-9]*(?:\.\d{1,2})?$/;
	  if((phone.length < 6) || (!intRegex.test(phone)))
	  {
		jQuery(e.target).after("<div class='validation' style='color:red'>Please enter a valid number</div>");
		 return false;
	  }
	})

	jQuery('#cheque_no').on('keyup' , function(e){
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

	
	jQuery('#confirm_cheque_no').on('change' , function(e){
		jQuery('.validation').remove();
		  var phone = jQuery(e.target).val(),
		  intRegex = /^[0-9 A-Z]*(?:\.\d{1,2})?$/;
		  if((!intRegex.test(phone)))
		  {
			jQuery(e.target).val("");
			jQuery(e.target).after("<div class='validation' style='color:red'>Please enter a valid cheque number</div>");
			 return false;
		  }
		  if(jQuery('#confirm_cheque_no').val() !=   jQuery('#cheque_no').val())
		  {
		  jQuery("#confirm_cheque_no").after("<div class='validation' style='color:red'>Cheque nos do not match</div>");
			 return false;
		  }
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

jQuery('#disagree').on('click',function(){
	jQuery('#terms').attr('checked',false);
	tb_remove();
	  jQuery('.accept_text').hide();
	 jQuery('.place_order_button').hide();
})
jQuery('#p_disagree').on('click',function(){
	jQuery('#terms').attr('checked',false);
	jQuery("#popup").bPopup().close()
	  jQuery('.accept_text').show();
	 jQuery('.place_order_button').show();
	
})
jQuery('#p_agree').on('click',function(){
	jQuery('#terms').attr('checked',true);
	jQuery("#popup").bPopup().close()
	  jQuery('.accept_text').show();
	 jQuery('.place_order_button').show();
	
})
jQuery('#wc_terms_conditions_popup-close').on('click',function(){
	jQuery('.accept_text').show();
	 jQuery('.place_order_button').show();
	
})


// jQuery('.save_order ').on('click',function(e){

// 	e.preventDefault();
// 	console.log(jQuery('#order_status').val())
// 	if(jQuery('#order_status').val() == 'wc-completed')
// 	{
// 		console.log(jQuery('#order_status').val())
// 		if(jQuery('#myplugin_cheque_no').val() == "")
// 		{
// 			jQuery('#myplugin_cheque_no').after("<div class='validation' style='color:red'>Enter Cheque No</div>");
// 			return false;
// 		}
// 		if(jQuery('#myplugin_cheque_bank').val() == "")
// 		{
// 			jQuery('#myplugin_cheque_bank').after("<div class='validation' style='color:red'>Enter Bank details</div>");
// 			return false;
// 		}
// 	}
// 	jQuery('form#post').submit();
// })