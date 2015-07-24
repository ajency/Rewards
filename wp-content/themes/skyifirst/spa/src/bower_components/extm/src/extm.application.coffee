############ EXTM.APPLICATION class ###################

class Extm.Application extends Marionette.Application

   _staticApps : []

   # extra property of application to track if history is started or not
   histroyStarted : false

   # default route of the application.
   # this is used by initial navigate function to run first route
   # @see: ExtmApplication.setDefaultRoute(route)
   defaultRoute : ''

   constructor : ( options = {} )->
      @store = msgbus._store
      super options

   # @override: start method of marionette add some extra functionality
   # @params : Object
   #     { regions : { regionName : '#element' }}
   # Throws if regions hash is missing
   start : ( options = {} ) ->

      # cannot start the app without any application regions
      # check for regions hash in options and throws error if not found
      if _.size( @getRegions() ) is 0
         throw new Error 'application regions not specified'

      # continue to have the default start behavior
      # calling start of Marionette.Application
      super options

      # finally start the history.
      @startHistory()

   # setup the application regions
   _setUpRegions : ( regions )->
      # TODO: validate regions hash to
      @addRegions regions

   # starts backbone.history
   startHistory : ->
      if not @histroyStarted
         Backbone.history.start()
         @navigate( @defaultRoute, trigger : true ) if @getCurrentRoute() is ''
         @histroyStarted = true
         @_startStaticApps() if @_hasStaticApps()

   # @uses Backbone.navigate to change current route and trigger if passed
   # @params:
   #   options = { trigger : true} || any options possible in backbone.history.navigate
   navigate : ( route, options )->
      Backbone.history.navigate route, options

   setDefaultRoute : ( route = '' )->
      @defaultRoute = route

   # uses backbone to get the current route
   getCurrentRoute : ->
      frag = Backbone.history.fragment
      if _.isEmpty( frag ) then '' else frag

   addStaticApps : ( apps )->
      @_staticApps = apps

   _hasStaticApps : ->
      _.size( @_staticApps ) > 0

   _startStaticApps : ->
      _.each @_staticApps, ( app, index )->
         msgbus.showApp app[0]
               .insideRegion app[1]
               .withOptions if _.isUndefined(app[2]) then {} else app[2]