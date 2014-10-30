define ['app'
		'controllers/region-controller'
		'apps/Redemption/redemptionController'
		], (App, RegionController, ListApp)->

	App.module "List", (List, App)->

		# define routers
		class ListRouter extends Marionette.AppRouter
			
			appRoutes:
				'redemptions' 		 : 'redemption'
				


		RouterAPI = 
			#display user list view
			redemption : ->
				App.execute "show:redemption", region:App.mainContentRegion

			
		#start user App
		List.on 'start',->
			new ListRouter
					controller : RouterAPI