define [ 'app', 'text!apps/customer/shipping/templates/shipping.html' ], ( App, shippingTpl )->
    App.module "Shipping.Views", ( Views, App )->
        option_name = ""
        points = ""
        option_id = ""
        date_approve = ""
        class SingleView extends Marionette.ItemView


            template: '<div class="tiles-body">
            							<div class="row">
            							  <div class="col-md-6">
            							   <h4 class="semi-bold">You have chosen:</h4>
            								<p class="semi-bold" id="option">{{option}}</p>
            								<ol id=productlist>
            								 {{#product_details}}
            								<li>{{product_name}}</li>

            								 {{/product_details}}
            								</ol>
            								  <div class="clearfix"></div>
            							  </div>
            							  <div class="col-md-6">
            								 <h4 class="semi-bold">Your details as in our system:</h4>
            								 <div class="m-t-10">
            								  <div class="pull-left semi-bold"> Name :&nbsp; </div>
            								  <div class="pull-left"> {{display_name}} </div>
            								  <div class="clearfix"></div>
            								</div>
            								<div class="m-t-10">
            								  <div class="pull-left semi-bold"> Email :&nbsp; </div>
            								  <div class="pull-left">{{user_email}} </div>
            								  <div class="clearfix"></div>
            								</div>
            								 <div class="m-t-10">
            								  <div class="pull-left semi-bold"> Phone :&nbsp; </div>
            								  <div class="pull-left">{{phone}} </div>

            								</div>
            								<br>
            								</div>
            								</div>
            								</div>'

        class Views.Options extends Marionette.CompositeView

            template: shippingTpl

            className: "padding-20"

            initialize: ->
                option_name = Marionette.getOption( @, 'option' )
                points = Marionette.getOption( @, 'ID' )


            itemView: SingleView

            itemViewContainer: 'div#shippingrow'

            #collectionEvents:
            #'add ' : 'DisplayRedemptionMessage'

            events:
                'click #final-redemption': ->
                    @$el.find( '.pace-inactive' ).show()
                    @$el.find( '.ref_msg' ).remove()
                    @$el.find( "#final-redemption" ).attr 'disabled', true
                    @trigger "save:final:redemption", option_name

                'click #final_confirm_button': ->
                    @$el.find( '.ref_msg' ).remove()

                    if @$el.find( "#datepicker" ).val() != "" || @$el.find( "#address" ).val() != ""
                        @$el.find( '.pace-inactive' ).show()
                        @$el.find( "#final_confirm_button" ).attr 'disabled', true

                        @trigger "save:final:details", option_name, @$el.find( "#datepicker" ).val(), @$el.find( "#timepicker" ).val(), @$el.find( "#address" ).val()
                    else if @$el.find( "#address" ).val() == "" && $( '#rad2' ).is(':checked')
                        @$el.find( "#rewards_msg" ).before '<div class="ref_msg alert alert-error"><button data-dismiss="alert" class="close"></button>Please enter
                                                                    Address</div>'
                    else
                        @$el.find( "#rewards_msg" ).before '<div class="ref_msg alert alert-error"><button data-dismiss="alert" class="close"></button>Please select
                                                date and Time</div>'



                'click .radio_delivery': ( e )->
                    @$el.find( '.ref_msg' ).remove()
                    if $( '#' + e.target.id ).val() == '1'
                        @$el.find( "#time_details" ).removeClass "hidden"
                        @$el.find( "#address_details" ).addClass "hidden"

                        @$el.find( "#rad1" ).parent(".inline").addClass "selected"
                        @$el.find( "#rad2" ).parent(".inline").removeClass "selected"
                        @$el.find( "#ini_msg" ).text "You will need to collect your reward from our office. From the date and time picker below, please select a convenient option and confirm below. (You can select a date 1-3 months from the date of your reward request was approved)."
                        @$el.find( "#final-redemption" ).text 'Confirm'
                    else
                        @$el.find( "#address_details" ).removeClass "hidden"
                        @$el.find( "#time_details" ).addClass "hidden"
                        @$el.find( "#rad2" ).parent(".inline").addClass "selected"
                        @$el.find( "#rad1" ).parent(".inline").removeClass "selected"
                        @$el.find( "#ini_msg" ).text " The reward will be shipped to you. Please enter your complete address below and confirm."
                        @$el.find( "#final-redemption" ).text 'Confirm'


            onShow: ->
                @trigger "show:final:view" , points, option_name

            onFinalRedemptionView:(result)->
                object = @
                object.$el.find( "#pointer_val_field" ).val result.points
                object.$el.find( "#sum_points" ).text result.points
                option_id = result.option
                console.log result.status
                if(result.status == "" || result.status == null || result.status == 'Redemption Not initiated' )
                    status = 'Redemption Not Initiated'
                    text_msg = 'Select a reward package to initiate redemption of points.'
                    object.$el.find( "#ini_msg" ).text "You can initiate redemption of points below. Once you initiate, all your points will lapse. (Partial redemption of points is not allowed). Also, once initiated, you will not be able to change your reward package option."
                    object.$el.find( "#final-redemption" ).text 'Initiate'
                if (result.status == "Initiated" )
                    status = 'Redemption initiated. Waiting for Approval'
                    text_msg = 'The Rewards Manager needs to approve your reward request. Please wait for an email.'
                    object.$el.find( "#ini_msg" ).text "You have initiated redemption of points. The reward request will be approved by the Rewards Manager and you will be notified through an email."
                    object.$el.find( "#final-redemption" ).hide()
                if (result.status == "Approved" )
                    status = 'Reward Request Approved'
                    text_msg = 'To collect your reward from our office, confirm a convenient date and time.'
                if (result.status == "Confirmed" )
                    status = 'Confirmed'
                    text_msg = 'Do remember to pick up your reward on the set date and time.'
                if (result.status == "closed" )
                    status = 'Closed'
                    text_msg = 'Redemption process complete and closed.'
                object.$el.find( "#redemption_status" ).text status
                object.$el.find( "#redemption_msg" ).text text_msg
                $( "#lireferrals" ).removeClass 'active'
                $( "#lishipping" ).addClass 'active'
                $( "#lirewards" ).removeClass 'active'
                date_approve = result.approved_date
                template = ""
                object.$el.find( "#option" ).text result.option_name
                product = result.product
                if product != null
                    for element , index in product
                        template += '<li>' + element + '</li>'

                object.$el.find( "ol" ).text ""
                object.$el.find( "ol" ).append template
                if option_name == undefined && option_id == 0
                    console.log "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
                    object.$el.find( "#redemption_notinitaited" ).removeClass "hidden"
                    object.$el.find( "#initiated" ).addClass "hidden"
                    object.$el.find( "#initiated_div" ).addClass "hidden"
                    object.$el.find( "#shippingrow" ).addClass "hidden"
                    object.$el.find( "#hr1" ).addClass "hidden"
                    object.$el.find( "#hr2" ).addClass "hidden"
                    object.$el.find( "#ini_msg" ).hide()
                    object.$el.find( "#final-redemption" ).hide()
                    object.$el.find( "#time_details" ).hide()
                    object.$el.find( "#redemption_initiation_div" ).hide()
                name = result.initiatedby
                date = result.date
                status = result.status

                if option_id == 1
                    object.$el.find( "#redemption_msg1" ).text( "Redemption was initiated by " + name + " on " + date )
                    object.$el.find( "#final-redemption" ).hide()
                    object.$el.find( "#final_confirm_button" ).addClass "hidden"

                if option_id == 2
                    object.$el.find( "#final-redemption" ).hide()
                    object.$el.find( "#final_confirm_button" ).removeClass "hidden"
                    object.$el.find( "#time_details" ).removeClass "hidden"
                    object.$el.find( "#rad1" ).parent(".inline").addClass "selected"
                    object.$el.find( "#rad2" ).parent(".inline").removeClass "selected"
                    object.$el.find( "#redemption_msg1" ).text "Redemption was initiated by " + name + " on " + date
                    object.$el.find( "#ini_msg" ).text "You will need to collect your reward from our office. From the date and time picker below, please select a convenient option and confirm below. (You can select a date 1-3 months from the date of your reward request was approved)."
                    object.$el.find( "#final-redemption" ).text 'Confirm'

                    if parseInt( result.shipping ) == 1
                        object.$el.find( "#delivery_details" ).removeClass "hidden"
                    else
                        object.$el.find( "#time_details" ).removeClass "hidden"


                if option_id == 3

                    object.$el.find( "#final-redemption" ).hide()
                    object.$el.find( "#final_confirm_button" ).addClass "hidden"
                    object.$el.find( "#redemption_msg1" ).text "Redemption was initiated by " + name + " on " + date
                    object.$el.find( "#confirmation_div" ).removeClass "hidden"
                    object.$el.find( "#time_details" ).hide()
                    confirm_date = result.confirm_date
                    if confirm_date != ""
                        object.$el.find( "#pickdetails" ).removeClass "hidden"

                        arr = confirm_date.split( "|" )
                        object.$el.find( "#date" ).text arr[0]
                        object.$el.find( "#time" ).text arr[1]
                        object.$el.find( "#ini_msg" ).text "You have confirmed to collect your reward from our office. We look forward to meeting you!"
                        object.$el.find( "#final-redemption" ).hide()

                    else
                        object.$el.find( "#ship_details" ).removeClass "hidden"
                        object.$el.find( "#add_value" ).text result.address
                        object.$el.find( "#ini_msg" ).text "Your reward will be shipped to "+result.address+"."
                        object.$el.find( "#final-redemption" ).hide()
                if option_id == 4
                    object.$el.find( "#final-redemption" ).hide()
                    object.$el.find( "#final_confirm_button" ).addClass "hidden"
                    object.$el.find( "#redemption_msg1" ).text "Redemption was initiated by " + name + " on " + date
                    #object.$el.find( "#confirmation_div" ).removeClass "hidden"
                    object.$el.find( "#time_details" ).hide()

                    object.$el.find( "#ini_msg" ).text "Redemption process complete and closed."
                    object.$el.find( "#final-redemption" ).hide()


                object.$el.find( '#datepicker' ).datepicker( {
                    format: 'yyyy-mm-dd ',
                    startDate: date_approve
                } )
                   


                $( '#timepicker' ).timepicker( {
                    'timeFormat': 'H:i'

                } )




            #@$el.find("#final_confirm_button").attr 'disabled'  , true
            #@$el.find("#confirm_details").attr 'disabled', true
            #@$el.find("#time_details").attr 'disabled', true


            onNewRedemptionInitiated: ( data )->
                @$el.find( '.pace-inactive' ).hide()
                @$el.find( "#final-redemption" ).hide()

                @$el.find( "#confirm_msg" ).removeClass 'hidden'
                @$el.find( "#redemption_msg" ).text "Redemption was initiated by " + data.display_name + " on " + data.date
            #@trigger "new:member:info" , @$el.find("#option_name").val()

            onFinalRedemptionInitiated: ( data )->
                @$el.find( '.pace-inactive' ).hide()
                @$el.find( "#final_confirm_button" ).hide()
                @$el.find( "#time_details" ).hide()
                @$el.find( "#delivery_details" ).addClass "hidden"
                @$el.find( "#address_details" ).addClass "hidden"
                if data.date == ""
                    @$el.find( "#ship_details" ).removeClass "hidden"
                    @$el.find( "#add_value" ).text data.address
                if data.address == ""
                    @$el.find( "#pickdetails" ).removeClass "hidden"
                    @$el.find( "#date" ).text data.date
                    @$el.find( "#time" ).text data.time
                # @$el.find( "#confirm_msg" ).removeClass "hidden"
#@trigger "new:member:info" , @$el.find("#option_name").val()


			
				




				


			   

			

		


			



		
