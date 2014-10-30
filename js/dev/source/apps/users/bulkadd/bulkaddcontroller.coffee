define ['app'
		'controllers/region-controller'
		'apps/users/bulkadd/bulkview'], (App, RegionController)->

	App.module "Users.BulkAdd", (BulkAdd, App)->

		class BulkAddcontroller extends RegionController

			initialize : ->
				#function call
				@view= view = @_getUserBulkView()
				
				#show the view
				@show view

			#function to retrieve bulk of users
			_getUserBulkView : ->
				 new BulkAdd.Views.UsersBulkView
						


	# set handlers
		App.commands.setHandler "show:users:bulkadd", (opt = {})->
			new BulkAddcontroller opt		