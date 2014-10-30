define ['app'
		'controllers/region-controller'
		'apps/products/list/listcontroller'
		'apps/products/Add/addcontroller'
		'text!apps/products/templates/mainfile.html'], (App, RegionController, ListApp, AddApp , mainfileTpl)->

	App.module "Products", (Products, App)->

		# define routers
		class ProductsRouter extends Marionette.AppRouter
			
			appRoutes:
				'products' 		 : 'list'
				


		RouterAPI = 
			#display user list view
			list : ->
				App.execute "show:productapp", region:App.mainContentRegion

			
		#start user App
		Products.on 'start',->
			new ProductsRouter
					controller : RouterAPI

		class ProductsController extends RegionController

			initialize : ->
				
				# get the Products outer layout				
				@layout = layout = @_getProductsView()

				#listen to show event of layout to trigger sub apps
				@listenTo layout, 'show', @showRegionViews

				#show the layout
				@show layout

			# start the sub apps of Products 
			showRegionViews:=>
				App.execute "show:product:add", region : @layout.topRegion
				App.execute "show:product:list" , region : @layout.bottomRegion

			_getProductsView : =>
				new ProductView
					

		##
		# The outer layout for the Products app
		#
		class ProductView extends Marionette.Layout

			template 	: mainfileTpl

			regions:
				topRegion	: '#topregion'
				bottomRegion	: '#bottomregion'

			
		# set handlers
		App.commands.setHandler "show:productapp", (opt = {})->
			new ProductsController opt		

