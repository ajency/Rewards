define ['app'
		'controllers/region-controller'
		'apps/ImportReferrals/importreferralcontroller'
		], (App, RegionController, ListApp)->

	App.module "ImportRef", (ImportRef, App)->

		# define routers
		class ImportRefRouter extends Marionette.AppRouter
			
			appRoutes:
				'ImportRef' 		 : 'list'
				


		RouterAPI = 
			#display user list view
			list : ->
				App.execute "show:importreferral:app", region:App.mainContentRegion

			
		#start user App
		ImportRef.on 'start',->
			new ImportRefRouter
					controller : RouterAPI