define ['app'
		'controllers/region-controller'
		'apps/users/edit/edituserview'], (App, RegionController)->


	App.module "Users.Edit", (Edit, App)->

		class Editcontroller extends RegionController

			initialize : (opt)->

				#get the ID
				{ID} = opt
				
				#get the user details based on Id
				@model = App.request "get:user:data" ,ID
				
				#get the view of edit form
				@view = view = @_getUserEditView @model

				#listen to the event
				@listenTo view , "update:new:user" , @_updateUser 

				#show the layout
				@show view

			#show the user details
			_getUserEditView :(model) ->
				new Edit.Views.UserEditView 
					model:model
					templateHelpers : 
							roles : ROLES
							AJAXURL : AJAXURL

			#updatee user details				
			_updateUser :(data)=>
				@model.save data,
							wait : true
							success : @userUpdated

			#success callback
			userUpdated:(model,resp)=>
				@view.triggerMethod "user:updated" , resp
				


		# set handlers
		App.commands.setHandler "show:users:edit" ,(opt)->
			new Editcontroller opt