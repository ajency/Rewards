
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
      jQuery('.accordion-group.two').removeClass('open');
      jQuery('.accordion-group.three').addClass('open viewed');
    });

    jQuery('.two.viewed > .acc-title').click(function() {
      jQuery('.accordion-group').removeClass('open');
      jQuery('.accordion-group.two').addClass('open');
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
