define [ 'app', 'text!apps/referrals/templates/referrallist.html' ], ( App, referralTpl )->
    App.module "Add.Views", ( Views, App )->
        add_array = Array()
        delete_array = Array()
        counter = 0
        count_val = 0
        class SingleView extends Marionette.ItemView

            tagName: 'tr'

            id: 'id'

            template: '<td class="v-align-middle "><div class="table_mob_hidden">Name</div><input class="itemAdd" data-id="0" name="referral_name{{id}}" type="text" id="referral_name{{id}}" size="20" /></td>
                     <td class="v-align-middle del "><div class="table_mob_hidden">Email</div><input data-id="{{id}}" name="referral_email{{id}}" class="email_check"  type="email" id="referral_email{{id}}" size="20" />
                     	<span style="display:none" id="span{{id}}" class="field-validation-error" data-valmsg-for="UserName" data-valmsg-replace="true">
                     		<span for="UserName" generated="true" class="">Any 1 of these fields is required</span></span></td>
                     <td class="v-align-middle del"><div class="table_mob_hidden">Contact No.*</div><input class="email_check form " data-id="{{id}}" name="referral_phone{{id}}"  type="tel" id="referral_phone{{id}}"  />
                     	<span style="display:none" id="span_phone{{id}}" class="field-validation-error" data-valmsg-for="UserName" data-valmsg-replace="true">
                     		<span for="UserName" generated="true" class="">Any 1 of these fields is required</span></span><span style="display:none" id="phonecheck{{id}}" class="field-validation-error" data-valmsg-for="UserName" data-valmsg-replace="true">
                     			<span for="UserName" generated="true" class="">Not a valid Contact No</span></span></td>
                     <td class="v-align-middle "><div class="table_mob_hidden">City</div><input name="referral_city{{id}}" type="text" id="referral_city{{id}}" size="20" /></td>
                     <td><button  class="close m-t-8 delete-referral hidden" type="button">×</button><input type="hidden" name="hide{{id}}" id="hide{{id}}" value="0" /></td>'



            events:
            #function to add a new row
                'focus .itemAdd': ( e )->
                    trselect = @$el.find( e.target ).closest( "tr" ).is( 'tr:last' )
                    @$el.find( e.target ).closest( "tr" ).attr( 'id', 'row' + @model.id )
                    if trselect
                        @trigger "create:new:referral"

            #function to delete a referral
                'click .delete-referral': ( e )->
                    $( '#row' + @model.id ).hide()
                    @model.destroy()





                'change .email_check': ( e )->
                    element = @$( '#' + e.target.id ).attr 'data-id'
                    span = 'span' + element
                    span_phone = 'span_phone' + element
                    if e.target.value != ""
                        add_array.push( @model.id )
                        delete_array.push( @model.id )
                        add_array = _.uniq( add_array )
                        delete_array = _.uniq( delete_array )
                        console.log delete_array
                    else
                        index = add_array.indexOf( @model.id )

                        add_array.splice( index, 1 )
                        index_del = delete_array.indexOf( @model.id )

                        delete_array.splice( index_del, 1 )
                        add_array = _.uniq( add_array )
                        delete_array = _.uniq( delete_array )
                        @$el.find( "#" + span + ".field-validation-error" ).css( 'display', 'none' )
                        @$el.find( "#" + span_phone + ".field-validation-error" ).css( 'display', 'none' )

                'keypress .email_check': ( e )->
                    element = @$( '#' + e.target.id ).attr 'data-id'
                    span = 'span' + element
                    span_phone = 'span_phone' + element
                    if(e.target.value == "")
                        @$el.find( "#" + span + ".field-validation-error" ).css( 'display', 'none' )
                        @$el.find( "#" + span_phone + ".field-validation-error" ).css( 'display', 'none' )

            #function to check for alphabets
                'keydown  .form': ( e )->
                    element = @$( '#' + e.target.id ).attr 'data-id'
                    @$el.find( "#phonecheck" + element + ".field-validation-error" ).css( 'display': 'none' )

            onShow:->
                $( 'input[type="tel"]' ).intlTelInput( {
                    preferredCountries: [ "in", "us", "gb" ]
                } );


        class Views.Referral extends Marionette.CompositeView

            template: referralTpl

            className: 'login-container'

            itemView: SingleView

            emptyView: SingleView

            itemViewContainer: 'table#referral_table tbody'

            collectionEvents:
                'add reset remove': 'showHideDeleteButton'



            showHideDeleteButton: ( model )->

                # check collection length
                if @collection.length >= 2
                    num_rows = @collection.length
                    $( '.delete-referral' ).removeClass 'hidden'


                else
                    $( '.delete-referral' ).addClass 'hidden'



            events:
            #function to set value of customer checkbox
                'click #customer': ( e )->
                    if @$el.find( "#customer" ).prop( 'checked', true )
                        @$el.find( "#customer" ).val( 1 )
                    else
                        @$el.find( "#customer" ).val( 0 )

                'keydown  #program_member_phone': ( e )->

                    @$el.find( "#programphone.field-validation-error" ).css( 'display': 'none' )



            #function to submit the form
                'submit #referral_form': ( e )->
                    @$el.find( '.success' ).remove()
                    @$el.find( '.danger' ).remove()
                    @$el.find( '.info' ).remove()
                    @$el.find( '.custom_table' ).remove()
                    @$el.find( '.ref_msg' ).remove()
                    flag = 0
                    program_member_phone = @$el.find('#program_member_phone' ).val()
                    phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})([0-9]{4})([0-9]{2})$/
                    if program_member_phone!=""
                        if program_member_phone.match(phoneno)
                            counter = 0
                            @$el.find( "#programphone.field-validation-error" ).css( 'display': 'none' )

                        else
                            counter = 1
                            console.log "message"
                            @$el.find( "#programphone.field-validation-error" ).css( { 'display': 'block', 'color': 'red' } )



                    if parseInt( add_array.length ) == 0
                        @$el.find( '.alert' ).remove()
                        @$el.find( "#referral_form" ).before '<div class="alert alert-info ref_msg">
                                                <button data-dismiss="alert" class="close"></button>
                                				Please enter details of at least one referral.
                                				</div>'
                        return false

                    e.preventDefault()


                    console.log delete_array
                    #delete_array = _.initial delete_array
                    for element , index in delete_array
                        referral_email = 'referral_email' + element
                        referral_phone = 'referral_phone' + element
                        span = 'span' + element
                        span_phone = 'span_phone' + element
                        phonecheck = "phonecheck" + element
                        hide = 'hide' + element
                        if parseInt( @$el.find( "#" + hide ).val() ) == 0

                            if @$el.find( "#" + referral_email ).val() == "" && @$el.find( "#" + referral_phone ).val() == ""
                                flag = 1
                                @$el.find( "#" + span + ".field-validation-error" ).css( { 'display': 'block', 'color': 'red' } )
                                @$el.find( "#" + span_phone + ".field-validation-error" ).css( { 'display': 'block', 'color': 'red' } )

                            else
                                flag = 0
                                @$el.find( "#" + span + ".field-validation-error" ).css( 'display', 'none' )
                                @$el.find( "#" + span_phone + ".field-validation-error" ).css( 'display', 'none' )
                            phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})([0-9]{4})([0-9]{2})$/
                            console.log referral_phone
                            if @$el.find( "#" + referral_phone ).val()!=""
                                if @$el.find( "#" + referral_phone ).val().match(phoneno)
                                    flag = 0
                                    @$el.find( "#"+phonecheck+".field-validation-error" ).css(  'display': 'none' )

                                else
                                    flag = 1
                                    console.log "message11"
                                    @$el.find( "#"+phonecheck+".field-validation-error" ).css( { 'display': 'block', 'color': 'red' } )





                    #delete_array = _.union(add_array,delete_array)
                    if flag == 0 && counter == 0
                        if  @$el.find( "#referral_form" ).valid()

                            @$el.find( '.alert' ).remove()
                            @$el.find( '#referral_add' ).attr 'disabled', true
                            @$el.find( '.form-actions .pace-inactive' ).show()
                            add_string = add_array.join( ',' )
                            @$el.find( '#num_ref' ).val( add_string )
                            @trigger "save:new:user", Backbone.Syphon.serialize @
                            add_array.length = 0
                            delete_array.length = 0


            #function to check for numbers
            onShow: ->
                new_array = Array()
                num_array = Array( "1", "2", "3" )
                for element in num_array
                    new_array.push element
                    @trigger "itemview:create:new:referral"



                $( 'input[type="tel"]' ).intlTelInput( {
                    preferredCountries: [ "in", "us", "gb" ]
                } );




            #function to display the message after submit
            onNewReferralsAdded: ( response )->
                reject = response.data['reject']
                accept = response.data['accept']
                accepted_msg = ""
                rejected_msg = ""
                message = ""
                table = "<table class='table table-bordered m-b-20'><thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>City</th><th>Status</th></tr></thead>"

                if response.data['reject'].length == 0
                    accepted_msg = '<div class="ref_msg">Done! Your referrals have been added into our system. Thank you!</div><button class="close close_ref_msg" data-dismiss="alert"></button>'

                else if response.data['accept'].length == 0
                    rejected_msg = '<div class="ref_msg">Sorry, looks like your referrals are already present with us. Why don\'t you try adding some more.</div><button class="close close_ref_msg" data-dismiss="alert"></button>'
                else if response.data['reject'].length != 0 && response.data['accept'].length != 0
                    message = '<div class="ref_msg">Thank you for the referrals. Looks like some of the referrals are present with us, but don\'t worry we will add the others.</div><button class="close close_ref_msg" data-dismiss="alert"></button>'

                for element in accept
                    table += "<tr><td>" + element.referral_name + "</td><td>" + element.referral_email + "</td>
                    					<td>" + element.referral_phone + "</td><td>" + element.referral_city + "</td><td>" + element.status + "</td></tr>"

                for element in reject
                    table += "<tr><td>" + element.referral_name + "</td><td>" + element.referral_email + "</td>
                    					<td>" + element.referral_phone + "</td><td>" + element.referral_city + "</td><td>" + element.status + "</td></tr>"

                table += "<table>"
                @$el.find( '.form-actions .pace-inactive' ).hide()
                @$el.find( "#referral_form" ).before '<div class="custom_table alert alert-info">' + accepted_msg + rejected_msg + message + '<p class="pull-left m-b-10 semi-bold">Following are your referrals and their status</p>' + table + '</div>'
                #@$el.find('#referral_add').addClass 'hidden'
                @$el.find( '#referral_add' ).attr 'disabled', false
                @$el.find( '#msg_text' ).addClass 'hidden'
                @$el.find( 'button[type="reset"]' ).trigger 'click'
				


