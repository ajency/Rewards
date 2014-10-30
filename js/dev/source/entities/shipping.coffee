define ['app' , 'backbone'], (App) ->

	App.module "Entities.Shipping", (Shipping, App)->

		#define customer model
		class Shipping extends Backbone.Model

			idAttribute : 'ID'

			defaults:
					option						: ''
					product_name     		   	: ''
					product_price				: ''
					product_details				: ''
					product_img 				: ''
					display_name				: ''
					user_email					: ''
					phone						: ''
					sum_of_points 				: ''
					date 						: ''
					confirmed					: ''
					initiatedby					: ''
					status						: ''
					


			
			name : 'shipping'


		#define customer collection
		class ShippingCollection extends Backbone.Collection

			model : Shipping
			
			url : -> #ajax call to return a list of all the users from the databse
				AJAXURL + '?action=get-shippingdetails'


		# declare a customer collection instance
		shippingCollection = new ShippingCollection
		

		# API
		API = 
			getRewards:(opt)-> #returns a collection of customers
				shippingCollection.fetch
					data : 
						username : opt.username
						option   : opt.option

				
				shippingCollection



			

			


		# Handlers
		
		App.reqres.setHandler "get:shipping:data", (opt) ->
			API.getRewards opt 


