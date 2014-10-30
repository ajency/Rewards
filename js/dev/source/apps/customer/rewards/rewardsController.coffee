define ['app'
		'controllers/region-controller','apps/customer/rewards/rewardsView'], (App, RegionController)->

	App.module "Rewards", (Rewards, App)->

		class RewardsController extends RegionController

			initialize :(opt)->

				@region  = opt.region

				@username = opt.username

				@topRegion = opt.topRegion

				@ID = opt.ID
				
				@rewardsCollection = App.request "get:rewards:collection" , opt 

				
				@view = view = @_getCustomerRewardsView @rewardsCollection , @ID

				@listenTo view , "save:inititate:redemption" , @_saveRedemption

				@listenTo view , "change:customerShipping:view"  , @_getCustomerShippingView 

				@listenTo view , "get:rewards:model"  , @_getRewardsModelView 

				App.execute "when:fetched", [@rewardsCollection], =>
          			@show view

			#function to get the view of Customer
			_getCustomerRewardsView :(rewardsCollection,ID)->
				new Rewards.Views.ListRewards
					collection : rewardsCollection
					ID : ID
					

			_saveRedemption:(id)=>
				object = @
				$.ajax({method: "POST" ,url : AJAXURL+'?action=save_redemption',data : 'optionid='+id+'&username='+object.username,success :(result)-> object.showRef result },error:(result)-> )

			
			showRef:(data)=>
				@view.triggerMethod "new:redemption:added" , data

			_getCustomerShippingView:(option)=>
				App.execute "show:shipping" , 
								region : @region
								username : @username
								option : option
								ID     : @ID
								topRegion : @topRegion

			_getRewardsModelView:(option)=>
				model = App.request "get:new:rewards:model", option
				@rewardsCollection.reset(model)
				App.execute "when:fetched", [@rewardsCollection], =>
          			@show @view
				


						

		# set handlers
		App.commands.setHandler "show:info", (opt = {})->
			
			new RewardsController opt