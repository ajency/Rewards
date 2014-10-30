define ['app'
		'controllers/region-controller'], (App, RegionController)->

	App.module "LeftNavApp", (LeftNavApp, App)->

		class LeftNavApp.Controller extends RegionController

			initialize : ->
				
				# get a menu collection
				@collection = App.request "get:menu:collection"
				
				# get the Left Navbar layout				
				@view = view = @_getLeftNavView @collection

				#show the layout
				@show view

			#function to get the view of Navbar
			_getLeftNavView :(menuCollection)=>
				new LeftNavView
						collection : menuCollection
					

		class SingleMenu extends Marionette.ItemView

			tagName : 'li'

			template : '<a href="{{menu_item_link}}"> 
							<i class="fa fa-caret-right"></i>
							<span class="title">{{post_title}}</span> 
							<span class="selected"></span> 
						</a>'

		##
		# The class which returns the view of Left Navbar
		class LeftNavView extends Marionette.CompositeView

			template 	: '<p class="menu-title">BROWSE </p>
							<ul class="menuitems"</ul>'

			className 	: 'page-sidebar-wrapper'

			id			: 'main-menu-wrapper'

			itemView : SingleMenu

			itemViewContainer : 'ul.menuitems'

			
		# set handlers
		App.commands.setHandler "show:leftnavapp", (opt = {})->
			new LeftNavApp.Controller opt		

