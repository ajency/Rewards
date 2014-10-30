define ['app'
		'controllers/region-controller'
		#'apps/header/left/leftapp'
		'apps/header/right/rightapp'
		'text!apps/header/templates/header.html'], (App, RegionController, RightApp,  headerTpl)->

	App.module "HeaderApp", (HeaderApp, App)->

		class HeaderController extends RegionController

			initialize : ->
				
				# get the header outer layout				
				@layout = layout = @_getHeaderView()

				#listen to show event of layout to trigger sub apps
				@listenTo layout, 'show', @showLeftRightViews

				#show the layout
				@show layout

			# start the sub apps of header 
			showLeftRightViews:=>
				#App.execute "show:leftheaderapp", region : @layout.leftRegion
				App.execute "show:rightheaderapp", region : @layout.rightRegion

			_getHeaderView : =>
				new HeaderView
					

		##
		# The outer layout for the header app
		#
		class HeaderView extends Marionette.Layout

			template 	: headerTpl

			className 	: 'navbar-inner'

			regions:
				leftRegion	: '#header-left-region'
				rightRegion	: '#header-right-region'

			
		# set handlers
		App.commands.setHandler "show:headerapp", (opt = {})->
			new HeaderController opt		

