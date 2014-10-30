define ['app'
		'controllers/region-controller'
		'apps/Options/List/listView'], (App, RegionController)->

	App.module "OptionList", (OptionList, App)->

		class OptionListController extends RegionController

			initialize : ->
				#get product Collection
				@optionCollection = App.request "get:option:collection"
				
				#function call
				@view= view = @_getOptionListView @optionCollection

				@listenTo view , "itemview:update:new:option" , @_updateOption

				@listenTo view , "itemview:get:pointslist:range" , @_getRangeList


				@show view

			#show a list of all products
			_getOptionListView :(optionCollection)->
				new OptionList.Views.ProductList
					collection : optionCollection

			_updateOption :(iv, ID, data)=>
				optionModel = App.request "get:option:model", ID
				
				optionModel.save data,
								wait: true
								success : @optionEdited

			#success callback function
			optionEdited:(model,resp)=>
				#App.execute "show:productapp", region:App.mainContentRegion
				@view.triggerMethod "new:option:edited" , model

			_getRangeList :(iv,data)=>
				object = @
				$.ajax({
					method: "POST" ,
					url : AJAXURL+'?action=get_points_range',
					data : data,
					success :(result)-> object.showRangeList result,data.opt_id},
					error:(result)-> )

				
			showRangeList:(data,opt_id)=>
				@view.triggerMethod "show:range:list" , data , opt_id

					

			


		# set handlers
		App.commands.setHandler "show:option:list", (opt = {})->
			new OptionListController opt		