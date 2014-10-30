define ['app'
		'controllers/region-controller'
		'apps/Options/Add/addView'], (App, RegionController)->

	App.module "AddOption", (AddOption, App)->

		class AddOptionController extends RegionController

			initialize : ->
				
				@optionAddCollection = App.request "get:optionadd:collection"

				#function call
				@view= view = @_getOptionAddView @optionAddCollection

				@listenTo view , "save:new:option" , @_saveOption

				@listenTo view , "get:points:range" , @_getRange

				#show the view
				@show view

			#show a list of all Program members
			_getOptionAddView :(optionAddCollection)->
				new AddOption.Views.OptionAdd
					collection :optionAddCollection

			_saveOption:(data)->
				optionModel = App.request "create:new:option", data
				optionModel.save null,
								wait: true
								success : @optionAdded

			optionAdded :(model,resp)=>
				App.execute "add:new:option:model", model
				@view.triggerMethod "option:added"

			_getRange :(data)=>
				object = @
				$.ajax({
					method: "POST" ,
					url : AJAXURL+'?action=get_points_range',
					data : data,
					success :(result)-> object.showRange result},
					error:(result)-> )

				
			showRange:(data)=>
				@view.triggerMethod "show:range" , data



					

			

		# set handlers
		App.commands.setHandler "show:option:add", (opt = {})->
			new AddOptionController opt		