##
## The main dashboard App
##
define ['marionette'], (Marionette)->
    window.App = new Marionette.Application

    # Main app regions
    App.addRegions
        headerRegion: '#header-region'
        leftNavRegion: '#left-nav-region'
        mainContentRegion: '#main-content-region'
        breadcrumbRegion: '#breadcrumb-region'
        footerRegion: '#footer-region'
        dialogRegion: '#dialog-region'
        loginRegion: '#login-region'


    # The default route for app
    App.rootRoute = ""

    # loginRoute in case session expires
    App.loginRoute = "login"

    # App command to handle async request and action to be performed after that
    # entities are the the dependencies which trigger a fetch to server.
    App.commands.setHandler "when:fetched", (entities, callback) ->
        xhrs = _.chain([entities]).flatten().pluck("_fetch").value()
        $.when(xhrs...).done ->
            callback()


    # Reqres handler to return a default region. If a controller is not explicitly specified a
    # region it will trigger default region handler
    App.reqres.setHandler "default:region", ->
        App.mainContentRegion

    App.on "initialize:after", (options) ->
        App.startHistory()
        App.execute "show:headerapp", region: App.headerRegion
        App.execute "show:leftnavapp", region: App.leftNavRegion

        App.navigate(@rootRoute, trigger: true) unless App.getCurrentRoute()

    App