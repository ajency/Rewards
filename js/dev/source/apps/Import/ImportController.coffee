define ['app'
		'controllers/region-controller'
		'apps/Import/ImportView'], (App, RegionController)->

	App.module "Show", (Show, App)->

		class showController extends RegionController

			initialize : ->
				
				#function call

				

				@view= view = @_getImportView() 

				@listenTo view , "save:csv:file" , @_uploadCSV



				#show the view
				@show view

			#show a list of all Program members
			_getImportView:(dateModel)->
				new Show.Views.Import
					templateHelpers : 
							date : DATE

			_uploadCSV:(data)=>
				object = @
				$("#uploadFormdata").ajaxForm({method: "POST" ,url : AJAXURL+'?action=upload_CSV',success :(result)-> object.showResponse result },error:(result)-> )

					
			showResponse:(result)->
				@view.triggerMethod "data:response:csv" , result


			

		# set handlers
		App.commands.setHandler "show:importapp", (opt = {})->
			new showController opt		