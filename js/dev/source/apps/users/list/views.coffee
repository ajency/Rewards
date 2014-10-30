define ['app', 'text!apps/users/list/templates/userlist.html'], (App,userListTpl)->

	App.module "Users.List.Views", (Views, App)->

		class SingleView extends Marionette.ItemView
		
			tagName : 'tr'

			template 	: '<td class="v-align-middle width25"><div class="table_mob_hidden">Name</div>{{display_name}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">Mobile</div>{{role}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">Last Login</div>{{user_registered}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">Action</div>
                          <a href="#users/edit/{{ID}}" class="btn btn-primary btn-sm btn-small editUser">Edit</a></td>'


			
			className 	: ''	

			#function to format the data
			serializeData :->
				data = super()
				display_name = @model.get 'display_name'
				role = @model.get 'role'
				display_name = _.str.capitalize display_name
				#role_rewards = role.split('_')
				#display_name_rewards = _.str.capitalize role_rewards[0]
				display_name_manager = _.str.capitalize role
				data.display_name = display_name
				data.role = display_name_manager
				data
					


						


		class Views.UserList extends Marionette.CompositeView

			template 	: userListTpl

			className 	: 'user-list'

			itemView    : SingleView

			itemViewContainer : 'table#user-list tbody'

			
			



