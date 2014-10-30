define ['app'
		'controllers/region-controller'
		'apps/Options/List/listController'
		'apps/Options/Add/addController'
		'text!apps/Options/templates/mainfile.html'], (App, RegionController, ListApp, AddApp , mainfileTpl)->

	App.module "Options", (Options, App)->

		# define routers
		class OptionRouter extends Marionette.AppRouter
			
			appRoutes:
				'options' 		 : 'list'
				


		RouterAPI = 
			#display user list view
			list : ->
				App.execute "show:optionapp", region:App.mainContentRegion

			
		#start user App
		Options.on 'start',->
			new OptionRouter
					controller : RouterAPI

		class OptionsController extends RegionController

			initialize : ->
				
				# get the Products outer layout				
				@layout = layout = @_getOptionView()

				#listen to show event of layout to trigger sub apps
				@listenTo layout, 'show', @showRegionViews

				#show the layout
				@show layout

			# start the sub apps of Products 
			showRegionViews:=>
				App.execute "show:option:add", region : @layout.topRegion
				App.execute "show:option:list" , region : @layout.bottomRegion

			_getOptionView : =>
				new OptionView
					

		##
		# The outer layout for the Products app
		#
		class OptionView extends Marionette.Layout

			template 	: mainfileTpl

			regions:
				topRegion	: '#topregion'
				bottomRegion	: '#bottomregion'

			
		# set handlers
		App.commands.setHandler "show:optionapp", (opt = {})->
			new OptionsController opt		

