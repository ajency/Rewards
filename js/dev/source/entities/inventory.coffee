define ['app' , 'backbone'], (App) ->

	App.module "Entities.Inventory", (Inventory, App)->

		#define Inventory model
		class Inventory extends Backbone.Model

			idAttribute : 'ID'

			defaults:
					product_name       		   	: ''
					Confirmed_count				: ''
					Initiated_count 			: ''
					Approved_count				: ''
					Closed_Count                : ''
					opt_id						: ''

							


			name : 'inventory'


		#define Referrallist collection
		class InventoryCollection extends Backbone.Collection

			model : Inventory
			
			url : -> #ajax call to return a list of all the Redemption from the databse
				AJAXURL + '?action=get-inventory'


		# declare a Redemption collection instance
		inventoryCollection = new InventoryCollection
		
		

		# API
		API = 
			getInventory:-> #returns a collection of Redemption
				inventoryCollection.fetch()
				inventoryCollection



			

			


		# Handlers
		App.reqres.setHandler "get:inventory:collection"  , (opt) ->
			API.getInventory()


