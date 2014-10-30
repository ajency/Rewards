define ['app'
		'controllers/region-controller'
		'text!apps/header/left/templates/left.html'], (App, RegionController, leftTpl)->

	App.module "HeaderApp.LeftHeaderApp", (LeftHeaderApp, App)->

		class Controller.LeftHeaderController extends RegionController

			initialize : ->
				
				#function call
				@view= view = @_getLeftHeaderView()
				
				@show view

			#function to get Leaft Header View
			_getLeftHeaderView : ->
				new LeftHeaderView


		class LeftHeaderView extends Marionette.ItemView

			template 	: leftTpl

			
			className 	: 'pull-left'	
				

		# set handlers
		App.commands.setHandler "show:leftheaderapp", (opt = {})->
			new Controller.LeftHeaderController opt		

