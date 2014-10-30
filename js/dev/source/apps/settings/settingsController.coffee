define ['app'
		'controllers/region-controller','apps/settings/settingsView'], (App, RegionController)->

	App.module "SettingsView", (SettingsView, App)->

		class settingsController extends RegionController

			initialize :->

				@view= view = @_getSettingsView()

				@listenTo view , "save:expiry:date"  , @_saveExpiry

				#show the layout
				@show view

			#function to get the view of Settings
			_getSettingsView :->
				new SettingsView.Views.List
					
			_saveExpiry:(data)=>
				object = @
				$.ajax({method: "POST" ,url : AJAXURL+'?action=save_expiry',data : data,success :(result)-> object.showData() },error:(result)-> )

					
			showData:=>
				@view.triggerMethod "show:expiry:data" 		

		# set handlers
		App.commands.setHandler "show:settings", (opt = {})->
			new settingsController