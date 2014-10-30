define ['app' , 'backbone'], (App) ->

	App.module "Entities.Pickup", (Pickup, App)->

		#define Pickup model
		class Pickup extends Backbone.Model

			idAttribute : 'ID'

			defaults:
					month       		   	: ''
					date 					: ''
					year					: ''
					name_array 				: ''
					date_array				: ''
					hash					: ''
					user_id					: ''
					
							


			name : 'pickup'


		#define Pickup collection
		class PickupCollection extends Backbone.Collection

			model : Pickup
			
			url : -> #ajax call to return a list of all the Pickups from the databse
				AJAXURL + '?action=get-pickup'


		# declare a Pickup collection instance
		pickupCollection = new PickupCollection
		
		

		# API
		API = 
			getPickup:-> #returns a collection of Pickup
				pickupCollection.fetch()
				pickupCollection



			

			


		# Handlers
		App.reqres.setHandler "get:pickup:collection"  , (opt) ->
			API.getPickup()


