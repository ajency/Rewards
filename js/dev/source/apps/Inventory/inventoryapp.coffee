define ['app'
		'controllers/region-controller'
		'apps/Inventory/Package/inventPackageController'
    'apps/Inventory/Product/inventoryController'
    'text!apps/Inventory/templates/inventory.html'], (App, RegionController, inventoryProductApp,inventoryPackageApp,inventoryMainTpl)->

	App.module "inventory", (inventory, App)->

		# define routers
		class InventoryRouter extends Marionette.AppRouter
			
			appRoutes:
				'inventory' 		 : 'list'
				


		RouterAPI = 
			#display inventory list view
			list : ->
				App.execute "show:inventory:mainapp", region:App.mainContentRegion

			
		#start inventory App
		inventory.on 'start',->
			new InventoryRouter
					controller : RouterAPI

    class InventoryMainController extends RegionController

      initialize : ->

        # get the inventory outer layout
        @layout = layout = @_getMainInventoryView()

        #listen to show event of layout to trigger sub apps
        @listenTo layout, 'show', @showInventoryViews

        #show the layout
        @show layout

      # start the sub apps of inventory
      showInventoryViews:=>
        App.execute "show:inventory:product", region : @layout.topRegion
        App.execute "show:inventory:package", region : @layout.bottomRegion



      _getMainInventoryView :=>
        new InventoryView


    ##
    # The outer layout for the inventory app
    #
    class InventoryView extends Marionette.Layout

      template 	: inventoryMainTpl

      regions:
        topRegion	: '#topregion'
        bottomRegion	: '#bottomregion'


    # set handlers
    App.commands.setHandler "show:inventory:mainapp", (opt = {})->
      new InventoryMainController opt