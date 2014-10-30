define ['app'
		'controllers/region-controller','apps/pickup/pickupview'], (App, RegionController)->

	App.module "ListPickup", (ListPickup, App)->

		class pickupController extends RegionController

			initialize :->

				@pickupCollection = App.request "get:pickup:collection"

				@view= view = @_getPickUpView @pickupCollection

				@show view

			#function to get the view of Customer
			
			_getPickUpView :(pickupCollection)->
				new ListPickup.Views.Show
					collection : pickupCollection
					
					

			
					
						

		# set handlers
		App.commands.setHandler "show:pickup", (opt = {})->
			new pickupController 