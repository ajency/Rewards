define ['app' , 'backbone'], (App) ->

	App.module "Entities.OptionAdd", (OptionAdd, App)->

		# define the Product model
		class OptionAdd extends Backbone.Model

			idAttribute : 'ID'

			defaults:
					product_name     		   	: ''
					product_price				: ''
					product_details				: ''
					product_img 				: ''
					attachment					: ''
					options						: ''
					


			name : 'optionAdd'

			
		# define the menu collection
		class OptionAddCollection extends Backbone.Collection

			model : OptionAdd
			
			url : ->
				AJAXURL + '?action=get-optionAdd'

		optionAddCollection = new OptionAddCollection
		

		# API
		API = 
			getOptionAdd:->
				optionAddCollection.fetch()
				optionAddCollection

			
		
		App.reqres.setHandler "get:optionadd:collection", ->
			API.getOptionAdd() 
