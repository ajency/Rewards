define ['app' , 'backbone'], (App) ->

	App.module "Entities.Product", (Product, App)->

		# define the Product model
		class Product extends Backbone.Model

			idAttribute : 'ID'

			defaults:
					product_name     		   	: ''
					product_price				: ''
					product_details				: ''
					product_img 				: ''
					attachment					: ''
					file						: ''


			name : 'product'

			
		# define the menu collection
		class ProductCollection extends Backbone.Collection

			model : Product
			
			url : ->
				AJAXURL + '?action=get-products'

		productCollection = new ProductCollection
		

		# API
		API = 
			saveProduct:(data)->
				product = new Product data
				product

			getProducts:->
				productCollection.fetch()
				productCollection

			addProduct :(model)->
				productCollection.add model
				

			getSingleProduct :(ID)->#update a model to the collection
				productModel = productCollection.get ID
				
				if not productModel 
						productModel = new Product ID : ID
						productCollection.add(productModel)
				productModel

		
		App.reqres.setHandler "create:new:product", (data)->
			API.saveProduct data

		App.reqres.setHandler "get:product:collection", (data)->
			API.getProducts data

		App.commands.setHandler "add:new:product:model", (model)->
			API.addProduct model

		App.reqres.setHandler  "get:user:model" , (ID)->
			API.getSingleProduct ID
