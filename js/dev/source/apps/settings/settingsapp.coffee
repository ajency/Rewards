define ['app'
		'controllers/region-controller'
		'apps/settings/settingsController'
		], (App, RegionController, ListApp)->

	App.module "settings", (settings, App)->

		# define routers
		class settingsRouter extends Marionette.AppRouter
			
			appRoutes:
				'settings' 		 : 'view'


		RouterAPI = 
			#display settings view
			view : ->
				App.execute "show:settings", region:App.mainContentRegion

			
		#start settings App
		settings.on 'start',->
			new settingsRouter
					controller : RouterAPI