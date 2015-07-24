class Extm.RegionController extends Marionette.Controller

   # contruct the controller
   constructor : ( options = {} ) ->

      # holds the region this controller is controlling.
      # Must be an object of Marionette.Region or its subclass
      @region = false

      # current View this region will show.
      # one region can show only one view
      @currentView = false

      @_promises = []

      # continue with super controller constructor
      if not options.region
         throw new Error 'Region is not specified for the controller'

      @_assignRegion options.region
      @instanceId = _.uniqueId 'region-controller-'
      msgbus.commands.execute 'register:controller', @instanceId, @
      super options

   _assignRegion : ( region )->
      @region = region

   store : ->
      @

   find : ( name, args )->
      promise = msgbus._store.find name, args
      @_promises.push promise
      promise

   wait : ->
      $.when( @_promises... ).done ( resolved... )=>
         resolved.unshift 'complete'
         @triggerMethod.apply @, resolved


   destroy : ( args... ) ->
      delete @region
      delete @currentView
      delete @options
      msgbus.commands.execute "unregister:controller", @instanceId, @
      super args

   show : ( view ) ->
      @currentView = view
      @region.show view


