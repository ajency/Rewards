define ['app'
		'controllers/region-controller'
		'apps/users/add/adduserview'], (App, RegionController)->

	App.module "Users.Add", (Add, App)->

		class Addcontroller extends RegionController

			initialize : ->
				#get the view of add form
				@view= view = @_getUserAddView()
				
				@listenTo view , "save:new:user" , @_saveUser

				@show view

			#returns the view of Add form
			_getUserAddView : ->
				 new Add.Views.UserAddView
				 	templateHelpers : 
							roles : ROLES
							AJAXURL : AJAXURL

			#to save the user newly added	
			_saveUser :(data)=>
				userModel = App.request "create:user:model", data
				userModel.save null,
								wait: true
								success : @userAdded

			#success callback function
			userAdded:(model,resp)=>
				App.execute "add:new:user:model", model
				@view.triggerMethod "new:user:added" , resp



	# set handlers
		App.commands.setHandler "show:users:add", (opt = {})->
			new Addcontroller opt		