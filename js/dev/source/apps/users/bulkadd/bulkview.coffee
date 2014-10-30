define ['app', 'text!apps/users/bulkadd/templates/bulkadd.html'], (App,userAddTpl)->

	App.module "Users.BulkAdd.Views", (Views, App)->

		class Views.UsersBulkView extends Marionette.ItemView

			template 	: userAddTpl

			className 	: ''	


		

