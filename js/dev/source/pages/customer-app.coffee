##
## The main dashboard App
##
define ['marionette'], (Marionette)->

	window.App = new Marionette.Application
	console.log "hi"
	# Main app regions
	App.addRegions
		mainContentRegion  	: '#main-content-region'
		footerRegion  		: '#footer-region'
		headerRegion		: '#header-region'
		secondRegion 	: '#info-region'
		
		

	# The default route for app
	App.rootRoute = ""

	# loginRoute in case session expires
	App.loginRoute = "login"

	# Reqres handler to return a default region. If a controller is not explicitly specified a 
	# region it will trigger default region handler
	App.reqres.setHandler "default:region", ->
		App.mainContentRegion

	# App command to handle async request and action to be performed after that
	# entities are the the dependencies which trigger a fetch to server.
	App.commands.setHandler "when:fetched", (entities, callback) ->
		xhrs = _.chain([entities]).flatten().pluck("_fetch").value()
		$.when(xhrs...).done ->
			callback()

	# Registers a controller instance
	App.commands.setHandler "register:instance", (instance, id) ->
		App.register instance, id
	
	# Unregisters a controller instance
	App.commands.setHandler "unregister:instance", (instance, id) ->
		App.unregister instance, id
	
	App.on "initialize:after", (options) ->
		App.startHistory()
		
		App.execute "show:customerapp" , region : App.headerRegion
	
		
		App.navigate(@rootRoute, trigger: true) unless App.getCurrentRoute()
			
	App