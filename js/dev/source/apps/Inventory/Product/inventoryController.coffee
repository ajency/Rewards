define ['app'
		'controllers/region-controller','apps/Inventory/Product/inventoryView'], (App, RegionController)->

	App.module "ListInventory", (ListInventory, App)->

		class inventoryController extends RegionController

			initialize :->

				@inventoryCollection = App.request "get:inventory:collection"

				@view= view = @_getInventoryView @inventoryCollection

				#show the layout
				App.execute "when:fetched", [@inventoryCollection], =>
          			@show view

			#function to get the view of Customer
			
			_getInventoryView :(inventoryCollection)->
				new ListInventory.Views.Show
					collection : inventoryCollection
					

			
					
						

		# set handlers
		App.commands.setHandler "show:inventory:product", (opt = {})->
			new inventoryController opt