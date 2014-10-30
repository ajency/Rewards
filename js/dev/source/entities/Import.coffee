define ['app' , 'backbone'], (App) ->

	App.module "Entities.Import", (Import, App)->

		#define Import model
		class Import extends Backbone.Model

			idAttribute : 'ID'


			defaults:
					date       		   	: ''
					

			name : 'import'

			console.log AJAXURL
			urlRoot : AJAXURL + '?action=get-date'

			

		
		
		importfile = new Import
		

		# API
		API = 
			getdate:-> #returns a model
				importfile.fetch()
				
				importfile



			

			


		# Handlers
		App.reqres.setHandler "get:date:model",  ->

			API.getdate()


