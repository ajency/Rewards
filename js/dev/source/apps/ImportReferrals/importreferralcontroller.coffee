define ['app'
		'controllers/region-controller'
		'apps/ImportReferrals/importreferralview'], (App, RegionController)->

	App.module "ShowRef", (ShowRef, App)->

		class ShowRefController extends RegionController

			initialize : ->
				
				#function call

				

				@view= view = @_getImportRefView() 

				@listenTo view , "save:csv:file" , @_uploadRefCSV



				#show the view
				@show view

			#show a list of all Program members
			_getImportRefView:->
				new ShowRef.Views.ImportRef
					

			_uploadRefCSV:(data)=>
				console.log data
				object = @
				$("#uploadRefFormdata").ajaxForm({method: "POST" ,url : AJAXURL+'?action=upload_Ref_CSV',success :(result)-> object.showRefResponse result },error:(result)-> )

					
			showRefResponse:(result)->
				@view.triggerMethod "data:responseref:csv" , result


			

		# set handlers
		App.commands.setHandler "show:importreferral:app", (opt = {})->
			new ShowRefController opt		