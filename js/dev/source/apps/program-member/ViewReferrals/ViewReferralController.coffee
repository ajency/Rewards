define ['app'
		'controllers/region-controller'
		'apps/program-member/referrals/referral_view'], (App, RegionController)->

	App.module "Referral", (Referral, App)->

		class ReferralController extends RegionController
			
			initialize :(opt)->

				@ID  = opt.ID

				@referralCollection = App.request "get:referral:list" , @ID
				
				@view= view = @_getReferralsView @referralCollection
				
				@show view


			_getReferralsView :(referralCollection)->
				new Referral.Views.Referral
					
					collection : referralCollection
					

			
				



		# set handlers
		App.commands.setHandler "show:referral:list" , (opt = {})->
			new ReferralController opt		