
window.onload = function(){
    jQuery('.woocommerce-message').hide()

    // jQuery('#customer_next').on('click',function(e){

    //   jQuery('#customer_details').show()

    // })

    jQuery('#customer_next').click(function() {
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
      if(jQuery('#billing_first_name').val() == "")
      {
        alert('Please enter First name');
        return false;
      }
      if(jQuery('#billing_last_name').val() == "")
      {
        alert('Please enter Last name');
        return false;
      }
      if(jQuery('#billing_email').val() == "")
      {
        alert('Please enter Email Address');
        return false;
      }
      if(jQuery('#billing_email-2').val() == "")
      {
        alert('Please enter Email Address');
        return false;
      }
      if(jQuery('#billing_phone').val() == "")
      {
        alert('Please enter Phone No');
        return false;
      }
      if(jQuery('#billing_address_1').val() == "")
      {
        alert('Please enter Address');
        return false;
      }
      if(jQuery('#billing_address2').val() == "")
      {
        alert('Please enter Address');
        return false;
      }
      if(jQuery('#billing_city').val() == "")
      {
        alert('Please enter Town/City');
        return false;
      }
      if(jQuery('#billing_state').val() == "")
      {
        alert('Please enter State');
        return false;
      }

      jQuery('.accordion-group.two').removeClass('open');
      jQuery('.accordion-group.three').addClass('open viewed');
      jQuery('.progress-outer').css('width', '75%');
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





}
