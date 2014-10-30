define ['app'
		'controllers/region-controller','apps/Redemption/redemptionView'], (App, RegionController)->

	App.module "AddRedemption", (AddRedemption, App)->

		class redemptionController extends RegionController

			initialize :->

				

				@redemptionCollection = App.request "get:redemption:collection" 

				@view= view = @_getRedemptionRewardsView @redemptionCollection

				
				#show the layout
				@show view

			#function to get the view of Customer
			_getRedemptionRewardsView :(redemptionCollection)->
				new AddRedemption.Views.ListRedemption
					collection : redemptionCollection

			
					
						

		# set handlers
		App.commands.setHandler "show:redemption", (opt = {})->
			
			new redemptionController 