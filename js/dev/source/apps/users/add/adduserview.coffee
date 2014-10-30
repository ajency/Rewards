define ['app', 'text!apps/users/add/templates/useradd.html'], (App,userAddTpl)->

	App.module "Users.Add.Views", (Views, App)->

		class Views.UserAddView extends Marionette.ItemView

			template 	: userAddTpl

			className 	: ''	

			events      : 
				#function to save a user
				'click #saveUser'	:(e)-> 
						e.preventDefault();
						if  @$el.find("#addUserForm").valid()
							@$el.find('.alert').remove()
							@$el.find('#saveUser').attr 'disabled', true
							@trigger "save:new:user" , Backbone.Syphon.serialize @

			#function to display message on submit		
			onNewUserAdded:(resp)->
				if resp.code == "Error"
					@$el.find("#addUserForm").before '<div class="alert alert-success">
					<button data-dismiss="alert" class="close"></button>
					User with the given email address is already present in the system</div>'
				else
					@$el.find("#addUserForm").before '<div class="alert alert-success">
					<button data-dismiss="alert" class="close"></button>
					New user added successfully</div>'
					location.href = "#users"
				@$el.find('#saveUser').removeAttr 'disabled'
				@$el.find('button[type="reset"]').trigger 'click'

				# clear the form.before


