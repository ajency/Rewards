define [ "marionette" ], ( Marionette )->

   class ScreenThreeView extends Marionette.ItemView

        template : '<div>
                        <div class="alert alert-warning">All fields are mandatory</div>
                        <form id="store_order" parsley-validate class="details-form">
                            <input type="hidden"  required  name="user_id" id="user_id" value="'+unit_id+'" />
                            <input type="hidden"  required  name="recAmount" id="recAmount" value="'+recAmount+'" />
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>First Name: </label>
                                        <input type="text" pattern="^[a-zA-z]*$" data-parsley-error-message="Enter only characters" placeholder="Enter First Name" class="form-control" required data-parsley-type="alphanum" name="first_name" id="first_name" value="" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Last Name: </label>
                                        <input type="text" placeholder="Enter Last Name" class="form-control" required pattern="^[a-zA-z]*$" data-parsley-error-message="Enter only characters" name="last_name" id="last_name" value="" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Email: </label>
                                        <input type="email" placeholder="Enter Email Address" class="form-control" type="number" data-parsley-trigger="change" required name="email" id="email" value="" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Phone: </label>
                                        <input type="text" placeholder="Enter Phone Number" class="form-control" required name="phone" id="phone" data-parsley-type="number" value="" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Birthdate: </label>
                                        <input type="text" placeholder="Enter Date of Birth" class="form-control" required name="birthdate" id="birthdate" value="" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nationality: </label>
                                        <select class="form-control" name="nationality" id="nationality" required>
                                            <option value="">Select Nationality</option>
                                            <option value="indian">Indian</option>
                                            <option value="poi">POI/OCI</option>
                                            <option value="nri">NRI</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Address: </label>
                                        <input type="text" class="form-control" placeholder="Enter Address" name="address" required id="address" value="" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>City: </label>
                                        <input type="text" class="form-control" name="city"  placeholder="Enter City"  pattern="^[a-zA-z]*$" data-parsley-error-message="Enter only characters" required id="city" value="" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>State: </label>
                                        <select name="state" required id="state" class="form-control">
                                        <option value=""></option>
<option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
<option value="Andhra Pradesh">Andhra Pradesh</option>
<option value="Arunachal Pradesh">Arunachal Pradesh</option>
<option value="Assam">Assam</option>
<option value="Bihar">Bihar</option>
<option value="Chandigarh">Chandigarh</option>
<option value="Chhattisgarh">Chhattisgarh</option>
<option value="Dadra and Nagar Haveli">Dadra and Nagar Haveli</option>
<option value="Daman and Diu">Daman and Diu</option>
<option value="Delhi">Delhi</option>
<option value="Goa">Goa</option>
<option value="Gujarat">Gujarat</option>
<option value="Haryana">Haryana</option>
<option value="Himachal Pradesh">Himachal Pradesh</option>
<option value="Jammu and Kashmir">Jammu and Kashmir</option>
<option value="Jharkhand">Jharkhand</option>
<option value="Karnataka">Karnataka</option>
<option value="Kerala">Kerala</option>
<option value="Lakshadweep">Lakshadweep</option>
<option value="Madhya Pradesh">Madhya Pradesh</option>
<option value="Maharashtra">Maharashtra</option>
<option value="Manipur">Manipur</option>
<option value="Meghalaya">Meghalaya</option>
<option value="Mizoram">Mizoram</option>
<option value="Nagaland">Nagaland</option>
<option value="Odisha">Odisha</option>
<option value="Puducherry">Puducherry</option>
<option value="Punjab">Punjab</option>
<option value="Rajasthan">Rajasthan</option>
<option value="Sikkim">Sikkim</option>
<option value="Tamil Nadu">Tamil Nadu</option>
<option value="Telengana">Telengana</option>
<option value="Tripura">Tripura</option>
<option value="Uttar Pradesh">Uttar Pradesh</option>
<option value="Uttarakhand">Uttarakhand</option>
<option value="West Bengal">West Bengal</option>
</select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Zipcode: </label>
                                        <input type="text" class="form-control" name="zipcode" placeholder="Enter Zipcode" data-parsley-type="number" required id="zipcode" value="" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Country: </label>
                                        <select class="form-control" name="country" id="country" required>
                                            <option value="">Select Country</option>
                                            <option value="india">India</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">

                                </div>
                            </div>
                        </form>

                    </div>

                    <div class="text-center">
                        <button id="payment" class="next-three btn btn-primary">
                            Continue to Payment
                        </button>
                    </div><div class="loader"></div>'


        events:
            "click #payment":(e)->
                $('.loader').show()
                e.preventDefault()
                if $("#store_order").parsley().validate()
                    $.ajax({
                        type : "POST",
                        url : SITEURL+"/wp-json/units/"+unit_id,
                        data : $("#store_order").serialize(),
                        success:(response,status,xhr)=>

                            $('.loader').hide()
                            $('.accordion-group.three').removeClass('open')
                            $('.accordion-group.four').addClass('open')
                            $('.accordion-group.three').addClass('viewed')

                            
                        error :(response,status,xhr)=>
                            $('.loader').hide()
                            if response.status == 408
                                App.layout.screenOneRegion.el.innerHTML = ""
                                App.layout.screenTwoRegion.el.innerHTML = ""
                                App.layout.screenThreeRegion.el.innerHTML = ""
                                App.layout.screenFourRegion.el.innerHTML = ""
                                $(".accordion").hide()
                                $(".session").text "Your session has expired"



                    })


        onShow:->
            $("#birthdate").datepicker({
                dateFormat : "yy-mm-dd"
                changeYear: true,
                changeMonth: true,
                maxDate: new Date(),
                yearRange: "-100:+0",
            });

            $('.two.viewed > .acc-title').click ->
                $('.accordion-group').removeClass('open')
                $('.accordion-group.two').addClass('open')







       
           





    










