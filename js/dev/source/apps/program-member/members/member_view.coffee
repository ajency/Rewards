define [ 'app', 'text!apps/program-member/members/templates/member_info.html' ], ( App, memberTpl )->
    App.module "Member.Views", ( Views, App )->
        packages_arr = Array()

        class Views.Info extends Marionette.ItemView

            template: memberTpl

            events:
                'click .confirm_reminder': ( e )->
                    @trigger "set:new:redemption", @model.get( 'option' ), @model.get( 'user_login' ), @$el.find( '#delivery' ).val()

                'click .reject_reminder': ( e )->
                    @trigger "set:rejected:redemption", @model.get( 'option' ), @model.get( 'user_login' )

                'click #ini_redemption': ( e )->
                    @trigger "get:options:list"
            #@$el.find('#packages_data').removeClass 'hidden'
            #@$el.find('#ini_redemption').attr 'disabled' , true
            #@trigger "send:email:reminder" , @model.get('option'), @model.get('ID')

                'click #send_remin': ( e )->
                    @$el.find( '#send_remin' ).attr 'disabled', true
                    @trigger "send:closure:reminder", @model.get( 'option' ), @model.get( 'ID' )

                'click #send_ini_redemption': ( e )->
                    if packages_arr.length == 0
                        return false
                    @$el.find( '#send_ini_redemption' ).attr 'disabled', true
                    @trigger "send:email:reminder", @model.get( 'option' ), @model.get( 'ID' ), @$el.find( "#packagestring" ).val()

                'click .package_select': ( e )->
                    if $( '#' + e.target.id ).prop( 'checked' ) == true
                        packages_arr.push e.target.value
                        str = packages_arr.join( ',' )
                        @$el.find( "#packagestring" ).val( str )
                    else
                        last = packages_arr.indexOf e.target.value
                        packages_arr.splice( last, 1 )
                        str = packages_arr.join( ',' )
                        @$el.find( "#packagestring" ).val( str )

                'click #delivery': ( e )->
                    if $( '#' + e.target.id ).prop( 'checked' ) == true
                        $( '#' + e.target.id ).val 1
                    else
                        $( '#' + e.target.id ).val 0


            #disply the name
            onShow: ->
                stringname = @model.get 'status'
                rejected_status = @model.get 'rejected_status'
                points = @model.get 'points'
                stringname.replace( /\s/g, '' )
                if stringname == 'Approved'
                    $( '#approved_send' ).removeClass 'hidden'
                    $( '#approved-redemt' ).hide()
                else if stringname == 'Redemption Not initiated' && rejected_status == 0
                    $( '#redem_not' ).removeClass 'hidden'
                    $( '#noti_redem_not' ).addClass 'hidden'
                    if parseInt( points ) == 0
                        @$el.find( '#ini_redemption' ).hide()
                else if stringname == 'Initiated'
                    $( '#initiated_div' ).removeClass 'hidden'
                else if stringname == 'Confirmed'
                    #date = @model.get 'date_confirm'
                    #date_arr = date.split(' ')
                    #today = new Date()
                    #dd = today.getDate()
                    #mm = today.getMonth()+1
                    #yyyy = today.getFullYear()

                    #if (dd<10)
                    #dd= '0'+dd


                    #if(mm<10)
                    #mm= '0'+mm

                    #today = yyyy+'-'+mm+'-'+dd;

                    #if today == date_arr[0]
                    $( '#send_remin' ).removeClass 'hidden'
                    $( '#confirmed_div' ).removeClass 'hidden'
                else if stringname == 'Redemption Not initiated' && rejected_status == 1
                    $( '#redem_not' ).removeClass 'hidden'
                else if stringname == 'closed'
                    $( '#closed' ).removeClass 'hidden'





            #format the data returned
            serializeData: ->
                data = super()
                customer = @model.get 'customer'
                if customer == "" || customer == 'false'
                    data.customer = 'Not an existing Customer'
                else
                    data.customer = 'Existing Customer'
                data

            onSaveRejectedRedemption: ( data )->
                $( '#redem_not' ).removeClass 'hidden'
                $( '#initiated_div' ).addClass 'hidden'
                $( '.status' ).text data.status
                $( '#ini_redemption' ).text data.action
                console.log data.initiated
                text_val = ""
                text_val += '<div class="collapse-trigger collapsed" data-toggle="collapse" data-target="#history8">
                                                                View History <span class="glyphicon glyphicon-chevron-down pull-right"></span><span class="glyphicon glyphicon-chevron-up pull-right"></span>
                                                            </div>
                                                            <div id="history8" class="collapse">'
                for element,index in data.initiated

                    text_val += '<h5 class="">' + element.history_status + ' on : <span class="semi-bold rejected">' + element.history_date + '</span> by '+data.user+'</h5>
                    					<div class="clearfix"></div>'
                text_val += '</div></div>'
                $( '#rejecteddiv' ).append text_val
                $( '#rejecteddiv_original' ).hide()
                $( '#rejecteddiv' ).removeClass 'hidden'
                $( '#noti_redem_not' ).removeClass 'hidden'

            onSaveApprovedRedemption: ( data )->
                $( '#redem_not' ).addClass 'hidden'
                $( '#initiated_div' ).addClass 'hidden'
                $( '#approved_send' ).removeClass 'hidden'

                $( '.status' ).text data.status
                $( '#approved-redemt' ).hide()
                text_val = ""
                console.log data.initiated
                text_val += '<div class="collapse-trigger collapsed" data-toggle="collapse" data-target="#history7">
                                                View History <span class="glyphicon glyphicon-chevron-down pull-right"></span><span class="glyphicon glyphicon-chevron-up pull-right"></span>
                                            </div>
                                            <div id="history7" class="collapse">'
                for element,index in data.initiated

                    text_val += '<h5 class="">' + element.history_status + ' on : <span class="semi-bold rejected">' + element.history_date + ' by '+data.user+'</h5>
                    					<div class="clearfix"></div>'
                text_val += '</div></div>'
                console.log text_val
                $( '#approvediv' ).append text_val
                $( '#approvediv_original' ).hide()
                $( '#approvediv' ).removeClass 'hidden'


            onSendInitiateReminder: ->
                $( '.modal-backdrop.in' ).remove()
                @$el.find( ".email_message" ).after '<div class="alert alert-info ref_msg">
                                        <button data-dismiss="alert" class="close"></button>
                        				Message has been sent.
                        				</div>'
                $( '#ini_redemption' ).attr 'disabled', false
                $( '#send_ini_redemption' ).attr 'disabled', false
                $( '#packages_data' ).addClass 'hidden'
                packages_arr = Array()
                $( "#packagestring" ).val ""


            onSendClosureReminder: ->
                 $( '#send_remin' ).hide()
                 $( '#confirmed_div' ).addClass 'hidden'
                 $( '#closed' ).removeClass 'hidden'



            onSetOptionList: ( data )->
                        console.log data
                        product = data
                        template = ""
                        if product != null
                            for element , index in product
                                template += '<li>
                                                                <div class="checkbox check-success ">
                                                                <input id="customer' + element.ID + '" class="package_select" name="customer' + element.ID + '" type="checkbox" value="' + element.ID + '" >
                                                                <label for="customer' + element.ID + '" style="padding-left:25px;"><b>' + element.option_name + '</b></label>
                                                                </div>
                                                              </li>'

                        @$el.find( "ol" ).text ""
                        @$el.find( "ol" ).append template
                        @$el.find( '#packages_data' ).removeClass 'hidden'






			





		


		

			

			
			



			
       


				