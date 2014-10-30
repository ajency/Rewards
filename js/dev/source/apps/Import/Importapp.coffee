define ['app'
		'controllers/region-controller'
		'apps/Import/ImportController'
		], (App, RegionController, ListApp)->

	App.module "Import", (Import, App)->

		# define routers
		class ImportRouter extends Marionette.AppRouter
			
			appRoutes:
				'Import' 		 : 'list'
				


		RouterAPI = 
			#display user list view
			list : ->
				App.execute "show:importapp", region:App.mainContentRegion

			
		#start user App
		Import.on 'start',->
			new ImportRouter
					controller : RouterAPI