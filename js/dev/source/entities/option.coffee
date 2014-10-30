define ['app' , 'backbone'], (App) ->

	App.module "Entities.Option", (Option, App)->

		# define the Product model
		class Option extends Backbone.Model

			idAttribute : 'ID'

			defaults:
					option_name     		   	: ''
					optiont_price				: ''
					optiont_desc				: ''
					product_details				: ''
					opt_id						: ''
					min_opt						: ''
					max_opt						: ''
					count 						: ''
					selected_arr				: ''
					min_range   				: ''
					max_range					: ''
					sum							: ''
					prod_array 					: ''
					check 						: ''
						


			name : 'option'

			
		# define the menu collection
		class OptionCollection extends Backbone.Collection

			model : Option
			
			url : ->
				AJAXURL + '?action=get-option'

		optionCollection = new OptionCollection
		
		

		# API
		API = 
			getOption:->
				optionCollection.fetch()
				optionCollection

			saveOption:(data)->
				option = new Option data
				option

			addOption :(model)->
				optionCollection.add model
				
				

			getSingleOption:(ID)->
				optionModel = optionCollection.get ID
				
				
				if not optionModel 
						optionModel = new Product ID : ID
						
						optionCollection.add(optionModel)
				optionModel


			
		
		App.reqres.setHandler "get:option:collection", ->
			API.getOption() 


		App.reqres.setHandler "create:new:option", (data)->
			API.saveOption data

		App.commands.setHandler "add:new:option:model", (model)->
			API.addOption model

		App.reqres.setHandler  "get:option:model" , (ID)->
			API.getSingleOption ID


