define ['app'
		'apps/users/list/userslistcontroller'
		'apps/users/add/useraddcontroller'
		'apps/users/bulkadd/bulkaddcontroller'
		'apps/users/edit/editusercontroller'], (App)->

	App.module "Users", (Users, App)->

		# define routers
		class UsersRouter extends Marionette.AppRouter
			
			appRoutes:
				'users' 		 : 'list'
				'users/list' 	 : 'list'
				'users/add' 	 : 'add'
				'users/edit/:id' : 'edit'
				'users/bulk-add' : 'bulkAdd'


		RouterAPI = 
			#display user list view
			list : ->
				App.execute "show:users:list" , region : App.mainContentRegion

			#display user add view	
			add: ->
				App.execute "show:users:add" , region : App.mainContentRegion

			#display user edit view
			edit:(id)->
				App.execute "show:users:edit" , 
								region : App.mainContentRegion
								ID : id
								

			bulkAdd:->
				App.execute "show:users:bulkadd" , region : App.mainContentRegion

		#start user App
		Users.on 'start',->
			new UsersRouter
					controller : RouterAPI

