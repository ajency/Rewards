define ['app'
		'controllers/region-controller'
		'text!apps/header/right/templates/right.html'], (App, RegionController, rightTpl)->

	App.module "HeaderApp.RightHeaderApp", (RightHeaderApp, App)->

		class RightHeaderController extends RegionController

			initialize : ->
				
				@view= view = @_getRightHeaderView()

				@listenTo view , "get:current:user" , @_currentUser

				@listenTo view , "logout:current:user" , @_logoutUser
				
				@show view

			_getRightHeaderView : ->
				new RightHeaderView
					SITEURL : SITEURL


			_currentUser :=>
				object = @
				$.ajax({method: "POST" ,url : AJAXURL+'?action=get_current_user',success :(result)-> object.showInfo result,error:(result)-> object.showInfo result})

			showInfo :(result)=>
				
				@view.triggerMethod "display:user:info" , result
				
				
			_logoutUser :->
				object = @
				$.ajax({method: "POST" ,url : AJAXURL+'?action=logout_current_user',success :(result)->location.href = SITEURL+"/wp-login.php"})


		class RightHeaderView extends Marionette.ItemView

			template 	: rightTpl
			
			className 	: 'chat-toggler'


			onShow:->
				@trigger "get:current:user" 
			
			onDisplayUserInfo:(result)->
				date = result.date
				date_elements = date.split('-')
				@$el.find('.username').append(result.data['display_name'])
				@$el.find('.heading').append(result.data['display_name'])
				user_role = result.data['role']
				role_name = user_role.split '_'
				if role_name
        			role_name_firststring = role_name[0]
        			role_name_firststring= _.str.capitalize role_name[0]
        			role_name_secondstring = role_name[1]
        			role_name_secondstring= _.str.capitalize role_name[1]
        			user_role = role_name_firststring+' '+role_name_secondstring
				@$el.find('.description').append(user_role)
				@$el.find('.pull-left').append(moment([date_elements[0],date_elements[1], date_elements[2]]).fromNow())

			events :
				'click #my-task-list' :(e)->
					if @$el.find('#notification-list').css('display') == 'none'
						@$el.find('#notification-list').show()
					else
						@$el.find('#notification-list').hide()

				'click #logout' :(e)->
					@trigger "logout:current:user" 


		# set handlers
		App.commands.setHandler "show:rightheaderapp", (opt = {})->
			new RightHeaderController opt		

