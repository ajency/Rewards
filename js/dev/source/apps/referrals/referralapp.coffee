define ['app'
		'apps/referrals/referralcontroller'
		], (App)->

	App.module "Referrals", (Referrals, App)->

		# define routers
		class ReferralRouter extends Marionette.AppRouter
			
			appRoutes:
				'referrals' 		 : 'list'
				


		RouterAPI = 
			list : ->
				App.execute "show:referrals" , region : App.mainContentRegion

			
		#Start Referral App
		Referrals.on 'start',->
			new ReferralRouter
					controller : RouterAPI

