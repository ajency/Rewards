define [ 'app', 'text!apps/customer/rewards/templates/rewards.html' ], ( App, rewardsTpl )->
    App.module "Rewards.Views", ( Views, App )->
        points = ""
        optionval = ""
        checkArray = []
        class RewardsView extends Marionette.ItemView

            initialize: ->
                Id = @model.get 'disabled'


            template: '<div id="reward{{ID}}" class="tiles white m-t-10 m-b-20 reward-container {{selected}}">
                                    				<div class="sel-indicator"><span class="glyphicon glyphicon-ok"></span> Selected Reward</div>
                                    				<div class="row">
                                    					<div class="col-md-4">
                                    						<input type="radio"  id="option{{ID}}" {{disabled}} {{checked}} value="0" class="option_set" name=option">
                                    						<label class="pull-left m-t-20 radio-label" for="option{{ID}}"><span class="{{classname}} radio_txt_lrg pull-left semi-bold">{{option}}</span></label>
                                    						<h4 class="semi-bold m-t-20">{{option}}</h4>
                                    					</div>
                                    					<div class="col-md-8">
                                    					<h4 class="{{classname}} semi-bold m-t-20">Points: {{min}}</h4>
                                    						</div>

                                    					<div class="clearfix"></div>
                                    					<h5 class="m-t-10 p-l-15">{{option_desc}}</h5>
                                    					<div class="clearfix"></div>
                                    					<ol class="m-l-5 m-t-20 m-b-10 user_step_list">
                                    					{{#product_details}}
                                    					<li><div class="rewards_img">
                                    					<img  src="{{product_img}}" class="hide-for-small"></div>
                                    					<h4 class="m-t-5 semi-bold">{{product_name}}</h4>
                                    					<h5 >{{product_details}}</h5>

                                    					</li>

                                    					{{/product_details}}
                                    				   </ol>
                                    				  </div>'





            events:
                'click .reward-container': ( e )->
                    ID = @model.get 'ID'
                    for element in checkArray
                        if element == @model.get('ID')
                             $("#option"+ID).val '1'
                        else
                            $("#option"+ID).val '0'
                            checkArray = []
                            

                    @$el.find( ".ref_msg1" ).remove()
                    @$el.find( ".ref_msg" ).remove()
                    optionid = @model.get 'ID'
                    console.log parseInt(@$el.find( "#option" + ID ).val())
                    $( '.reward-container' ).removeClass( 'selected')
                    $( '.option_set' ).attr( 'checked', false )
                    console.log check = @model.get 'disabled'

                    if parseInt(@$el.find( "#option" + ID ).val()) == 0
                        checkArray.push  @model.get('ID')
                        optionval = @model.get 'ID'
                        if check != 'disabled'
                            @$el.find( '.reward-container' ).removeClass( 'selected' )
                            @$el.find( '.option_set' ).attr( 'checked', false )
                            @$el.find( "#reward" + ID ).addClass( 'selected' )
                            @$el.find( "#option" + ID ).attr( 'checked', true )

                        else
                            @$el.find( "#reward" + ID ).before '<div class="ref_msg1 alert alert-error m-b-5 m-t-20"><button data-dismiss="alert" class="close"></button>You Don\'t have enough points</div>'
                    else
                        @$el.find( '.reward-container' ).removeClass( 'selected' )
                        @$el.find( '.option_set' ).attr( 'checked', false )
                        $("#option"+ID).val "0"   
                        checkArray = []
                        optionval = ""


        class Views.ListRewards extends Marionette.CompositeView

            template: rewardsTpl

            className: "padding-20"

            initialize: ->
                @collection.trigger ('reset')
                points = Marionette.getOption( @, 'ID' )



            itemView: RewardsView

            itemViewContainer: 'div#rewardsdata'

            events:
                'click #confirm_redempt': ->
                    @$el.find( ".ref_msg1" ).remove()
                    @$el.find( ".ref_msg" ).remove()
                    console.log optionval
                    console.log @$el.find( "#pointer_val_field" ).val()
                    if  optionval != ""  && parseInt( @$el.find( "#pointer_val_field" ).val() ) != 0
                        $( "#lireferrals" ).removeClass 'active'
                        $( "#lishipping" ).addClass 'active'
                        $( "#lirewards" ).removeClass 'active'
                        @trigger "change:customerShipping:view", optionval

                        #@trigger "save:inititate:redemption" , @$el.find("#option_check").val()
                    else
                        @$el.find( "#rewardsdata" ).before '<div class="ref_msg alert alert-error m-b-5 m-t-20"><button data-dismiss="alert" class="close"></button>Please select an option</div>'

            onShow: ->

                object = @
                $.ajax
                    method: "POST",
                    url: AJAXURL + '?action=get_points',
                    data: 'username=' + points,
                    success: ( result )->
                        object.$el.find( "#pointer_val_field" ).val result.points
                        object.$el.find( "#pointer_val" ).text result.points
                        option = result.option
                        optionval = result.option
                        if optionval == null
                            optionval =""
                        if(result.status == "" || result.status == 'Redemption Not initiated' )
                            status = 'Redemption Not Initiated'
                            text_msg = 'Select a reward package to initiate redemption of points.'
                        if (result.status == "Initiated" )
                            console.log result.status
                            status = 'Redemption initiated. Waiting for Approval'
                            text_msg = 'The Rewards Manager needs to approve your reward request. Please wait for an email.'
                        if (result.status == "Approved" )
                            status = 'Reward Request Approved'
                            text_msg = 'To collect your reward from our office, confirm a convenient date and time.'
                        if (result.status == "Confirmed" )
                            status = 'Confirmed'
                            text_msg = 'Do remember to pick up your reward on the set date and time.'
                        if (result.status == "closed" )
                            status = 'Closed'
                            text_msg = 'Redemption process complete and closed.'
                        console.log status
                        console.log text_msg
                        object.$el.find( "#redemption_status" ).text status
                        object.$el.find( "#redemption_msg" ).text text_msg
                        if result.status == 'Approved' || result.status == 'Confirmed' || result.status == 'Initiated' || result.status == 'closed'
                            object.trigger "get:rewards:model", option
                            #object.$el.find( "#confirm_redempt" ).hide()
                            object.$el.find( "#pointer_val_field" ).val result.points
                            object.$el.find( "#pointer_val" ).text result.points
                            object.$el.find( "#redemption_status" ).text status
                            object.$el.find( "#redemption_msg" ).text text_msg
                    error: ( result )->









            onNewRedemptionAdded: ( data )->
                console.log data
			   

		   
				




		


			



		
		