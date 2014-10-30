define ['app'
		'controllers/region-controller'
		'apps/products/list/listview'], (App, RegionController)->

	App.module "List", (List, App)->

		class ProductController extends RegionController

			initialize : ->
				#get product Collection
				@productCollection = App.request "get:product:collection"
				
				#function call
				@view= view = @_getProductView @productCollection

				#listen to the event
				@listenTo view , "itemview:update:new:product" , @_updateProduct

				#show the view
				@show view

			#show a list of all products
			_getProductView :(productCollection)->
				new List.Views.Product
					collection :productCollection

			_updateProduct :(iv, ID, data)=>
				productModel = App.request "get:user:model", ID
				
				productModel.save data,
								wait: true
								success : @productEdited

			#success callback function
			productEdited:(model,resp)=>
				#App.execute "show:productapp", region:App.mainContentRegion
				@view.triggerMethod "new:product:edited" , model

				


		# set handlers
		App.commands.setHandler "show:product:list", (opt = {})->
			new ProductController opt		