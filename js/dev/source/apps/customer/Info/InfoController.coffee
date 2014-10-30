define ['app'
		'controllers/region-controller','apps/customer/Info/InfoView'], (App, RegionController)->

	App.module "Customer", (Customer, App)->
		user = ""
		class CustomerController extends RegionController

			initialize :(opt) ->

				{username} = opt

				user = username

				@subregion = opt.region

				@ID = opt.ID

				@topRegion = opt.topRegion

				#get customer collection
				@customerCollection = App.request "get:customer:collection" , opt
				
				
				#function call				
				@view = view = @_getCustomerView @customerCollection

				@listenTo view , "change:customer:view"  , @_changecustomerView 

				
				#show the layout
				@show view

			#function to get the view of Customer
			_getCustomerView :(customerCollection)->
				
				new Customer.Views.List
					collection : customerCollection
					ID : @ID

			_changecustomerView:(points)=>
				
				App.execute "show:info" , 
								region : @subregion
								username : user
								ID :@ID
								topRegion : @topRegion
								
						
			

		# set handlers
		App.commands.setHandler "show:customers", (opt = {})->
			console.log opt
			new CustomerController opt

			