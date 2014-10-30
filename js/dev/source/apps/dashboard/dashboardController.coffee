define ['app'
		'controllers/region-controller','apps/dashboard/dashboardView'], (App, RegionController)->

	App.module "dashboard", (dashboard, App)->

		class dashboardController extends RegionController

			initialize :->

				@view= view = @_getDashboardView()

				@listenTo view , "show:dashboard:info" , @_showDashboardInfo

				#show the layout
				@show view

			#function to get the view of Settings
			_getDashboardView :->
				new dashboard.Views.List
					templateHelpers : 
							date : DATE

			_showDashboardInfo:->
				object = @
				$.ajax({method: "POST" ,url : AJAXURL+'?action=show_dashboard',data : '',success :(result)-> object.showAllInfo result },error:(result)-> )

			showAllInfo:(result)->
				@view.triggerMethod "show:All:DashboardInfo" , result
			
		# set handlers
		App.commands.setHandler "show:dashboard", (opt = {})->
			new dashboardController