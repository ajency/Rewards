define ['app'
		'controllers/region-controller','apps/Inventory/Package/inventPackageView'], (App, RegionController)->

	App.module "ListInventoryPackage", (ListInventoryPackage, App)->

		class inventoryPackageController extends RegionController

			initialize :->

				@inventoryPackCollection = App.request "get:inventoryPackage:collection"

				@view= view = @_getInventoryViewPack @inventoryPackCollection

				#show the layout
				App.execute "when:fetched", [@inventoryPackCollection], =>
          			@show view

			#function to get the view of Customer

			_getInventoryViewPack :(inventoryPackCollection)->
				new ListInventoryPackage.Views.ShowPackage
					collection : inventoryPackCollection
					

			
					
						

		# set handlers
		App.commands.setHandler "show:inventory:package", (opt = {})->

			new inventoryPackageController opt