define ['app'
		'controllers/region-controller','apps/customer/shipping/shippingView'], (App, RegionController)->

	App.module "Shipping", (Shipping, App)->

		class ShippingController extends RegionController

			initialize :(opt)->

				@username = opt.username

				@option  = opt.option

				@userid = opt.ID

				@topRegion = opt.topRegion

				@shippingdata = App.request "get:shipping:data" , opt

				@view = view = @_getCustomerShippingView @shippingdata , @option , @userid

				@listenTo view , "save:final:redemption" , @_finalRedemption

				@listenTo view , "save:final:details" , @_finalDetails

				@listenTo view , "new:member:info" , @_memberdetails

				@listenTo view , "show:final:view" , @_viewdetails


				App.execute "when:fetched", [@_viewdetails], =>
          			@show view

				

			
			_getCustomerShippingView :(shippingdata,option,ID)->
				console.log option
				new Shipping.Views.Options
					collection : shippingdata
					option : option
					ID     : ID

			_finalRedemption:(option)=>
				object = @
				$.ajax({method: "POST" ,url : AJAXURL+'?action=final_redemption',data : 'option='+option+'&username='+object.username,success :(result)-> object.showRedempt result },error:(result)-> )

			_finalDetails:(option,date,time,address)=>
				object = @
				$.ajax({method: "POST" ,url : AJAXURL+'?action=final_save_details',data : 'option='+option+'&username='+object.username+'&date='+date+'&time='+time+'&address='+address,success :(result)-> object.finalRedempt result},error:(result)-> )


			_viewdetails:(points,option_name)->
				object = @
				$.ajax( {
                    method: "POST",
                    url: AJAXURL + '?action=get_shippping_points',
                    data: 'username=' + points + '&option=' + option_name,
                    success: ( result )->
                    	object.viewRedempt  result 
                    error:->
                    	console.log "error"
                 })


			showRedempt:(data)=>
				@view.triggerMethod "new:redemption:initiated" , data

			finalRedempt:(data)=>
				@view.triggerMethod "final:redemption:initiated" , data

			viewRedempt:(data)->
				@view.triggerMethod "final:redemption:view" , data



			_memberdetails:(option)=>
				App.execute "show:member:info",
								region : @topRegion
								ID      : @userid

					

			
						

		# set handlers
		App.commands.setHandler "show:shipping", (opt = {})->
			
			new ShippingController opt