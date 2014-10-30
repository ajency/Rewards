define ['app'
		'controllers/region-controller'
		'apps/products/Add/addview'], (App, RegionController)->

	App.module "Add", (Add, App)->

		class AddController extends RegionController

			initialize : ->
				
				#function call
				@view= view = @_getProductAddView() 

				@listenTo view , "save:new:product" , @_saveProduct

				#show the view
				@show view

			#show a list of all Program members
			_getProductAddView : ->
				new Add.Views.ProductAdd
					


			_saveProduct :(data)=>
				productModel = App.request "create:new:product", data
				productModel.save null,
								wait: true
								success : @productAdded
			
			productAdded :(model,resp)=>
				App.execute "add:new:product:model", model
				@view.triggerMethod "product:added"

		# set handlers
		App.commands.setHandler "show:product:add", (opt = {})->
			new AddController opt		