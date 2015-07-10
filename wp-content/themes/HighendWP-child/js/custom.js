
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
