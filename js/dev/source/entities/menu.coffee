define ['app' , 'backbone'], (App) ->

	App.module "Entities.Menu", (Menu, App)->

		# define the menu model
		class Menu.MenuModel extends Backbone.Model

			idAttribute : 'ID'

			name : 'menu'

			parse:(resp)->
				resp['ID'] = parseInt resp['ID']
				resp

		# define the menu collection
		class Menu.MenuCollection extends Backbone.Collection

			model : Menu.MenuModel
			
			url : ->
				AJAXURL + '?action=get-menus'

		# API
		API = 
			getMenuItems:-> #returns collection of menus
				menuCollection = new Menu.MenuCollection
				menuCollection.fetch()
				menuCollection

		# Handlers
		App.reqres.setHandler "get:menu:collection", ->
			API.getMenuItems()