define ['app'
		'controllers/region-controller'
		'apps/users/list/views'], (App, RegionController)->

	App.module "Users.List", (List, App)->

		class Listcontroller extends RegionController

			initialize : ->
				#get user collection
				userCollection = App.request "get:user:collection"
				
				#function call
				@view= view = @_getUserView userCollection

				#show the view
				@show view


				
			#display the users
			_getUserView :(userCollection) ->
				new List.Views.UserList
						collection : userCollection
						templateHelpers : 
							roles : ROLES
			
					


	# set handlers
		App.commands.setHandler "show:users:list", (opt = {})->
			new Listcontroller opt		