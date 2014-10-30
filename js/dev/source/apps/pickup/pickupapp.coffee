define ['app'
		'controllers/region-controller'
		'apps/pickup/pickupcontroller'
		], (App, RegionController, pickupApp)->

	App.module "pickup", (pickup, App)->

		# define routers
		class PickupRouter extends Marionette.AppRouter
			
			appRoutes:
				'pickup' 		 : 'list'
				


		RouterAPI = 
			#display user list view
			list : ->
				App.execute "show:pickup", region:App.mainContentRegion

			
		#start user App
		pickup.on 'start',->
			new PickupRouter
					controller : RouterAPI