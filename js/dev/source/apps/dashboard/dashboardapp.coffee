define ['app'
		'controllers/region-controller'
		'apps/dashboard/dashboardController'
		], (App, RegionController, ListApp)->

	App.module "Dashapp", (Dashapp, App)->

		# define routers
		class DashappRouter extends Marionette.AppRouter
			
			appRoutes:
				'dashboard' 		 : 'list'
				


		RouterAPI = 
			#display user list view
			list : ->
				App.execute "show:dashboard", region:App.mainContentRegion

			
		#start user App
		Dashapp.on 'start',->
			new DashappRouter
					controller : RouterAPI