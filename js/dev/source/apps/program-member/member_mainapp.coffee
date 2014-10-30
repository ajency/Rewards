define ['app'
		'controllers/region-controller'
		'apps/program-member/members/member_controller'
		'apps/program-member/referrals/referral_controller'
		'apps/customer/customerHead/customerHeadController'
		'apps/customer/Info/InfoController'
		'apps/customer/rewards/rewardsController'
		'apps/customer/shipping/shippingController'
		'text!apps/program-member/templates/program_main.html'], (App, RegionController, memberApp,referralApp,customerApp,InfoApp,RewardsApp,shippingApp,  mainTpl)->

	App.module "MainApp", (MainApp, App)->

		class MainController extends RegionController

			initialize :(opt) ->

				@ID = opt.ID

				@userid = opt.userid
				
				# get the main layout				
				@layout = layout = @_getMainView()

				#listen to show event of layout to trigger sub apps
				@listenTo layout, 'show', @showViews

				#show the layout
				@show layout

			# start the sub apps of main 
			showViews:=>
				
				App.execute "show:member:info",
								topRegion : @layout.topRegion
								ID      : @userid

				App.execute "show:customer:head", 
								region : @layout.bottomRegion
								username : @ID
								subregion : @layout.secondRegion
								topRegion : @layout.topRegion
								ID      : @userid

				App.execute "show:customers" , 
								region : @layout.secondRegion
								username : @ID
								topRegion : @layout.topRegion
								ID      : @userid

			_getMainView : =>
				new MainView
					

		##
		# The outer layout for the main app
		#
		class MainView extends Marionette.Layout

			template 	: mainTpl

			className 	: ''

			regions:
				topRegion	: '#program-member-region'
				bottomRegion	: '#referral-region'
				secondRegion 	: '#info-region'

			
		# set handlers
		App.commands.setHandler "show:main:App", (opt = {})->
			new MainController opt		

