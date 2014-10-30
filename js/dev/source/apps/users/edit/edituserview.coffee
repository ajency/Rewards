define ['app', 'text!apps/users/edit/templates/useredit.html'], (App,userEditTpl)->

	App.module "Users.Edit.Views", (Views, App)->

		class Views.UserEditView extends Marionette.ItemView
			
			template 	: userEditTpl

			className   : ''

			events		:
				#function to update the user
				'click #updateUser' :(e)->
					e.preventDefault()
					
					if @$el.find("#editUserForm").valid()
						@$el.find('.alert').remove()
						@$el.find('#updateUser').attr 'disabled', true
						@trigger "update:new:user" , Backbone.Syphon.serialize @ 

				'click .suspend':(e)->
					if $('#'+e.target.id).prop('checked') == true
						$('#'+e.target.id).val 1
					else
						$('#'+e.target.id).val 0
					

			#function to capitalize
			onShow :->
				$('html, body').animate({scrollTop:0}, 'slow')
				role_obj = @model.attributes.role
				role = _.str.capitalize role_obj
				@$el.find("#role option[value='"+role_obj+"']").attr("selected","selected")


			#function to display the msg
			onUserUpdated:(resp)->
				if resp.code == "Error"
					@$el.find("#editUserForm").before '<div class="alert alert-success">
					<button data-dismiss="alert" class="close"></button>
					User with the given email address is already present in the system</div>'
				else
					@$el.find("#editUserForm").before '<div class="alert alert-success">
					<button data-dismiss="alert" class="close"></button>
					User updated successfully</div>'
					location.href = "#users"
				@$el.find('#updateUser').removeAttr 'disabled'
				@$el.find('button[type="reset"]').trigger 'click'

				# clear the form.before


						
						
						


