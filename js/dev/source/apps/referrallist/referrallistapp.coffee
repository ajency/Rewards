define ['app'
		'controllers/region-controller'
		'apps/referrallist/referrallistController'
		], (App, RegionController, ListApp)->

	App.module "referrallist", (referrallist, App)->

		# define routers
		class ReferrallistRouter extends Marionette.AppRouter
			
			appRoutes:
				'referrals' 		 : 'list'
				


		RouterAPI = 
			#display user list view
			list : ->
				App.execute "show:referralslist", region:App.mainContentRegion

			
		#start user App
		referrallist.on 'start',->
			new ReferrallistRouter
					controller : RouterAPI