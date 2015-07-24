# App launcher

class AppLauncher

   region : null

   options : {}

   appName : ''

   constructor : ( appName )->
      @appName = appName

   insideRegion : ( region )->
      @region = region
      @

   withOptions : ( options )->
      @options = _.defaults region : @region, options
      @_launch()

   _launch : ()->
      Controller = @_getControllerClass()
      new Controller @options
      @_deleteReference()

   _getControllerClass : ->
      if _.isUndefined _Controllers[@appName]
         throw new Error 'No such controller registered'

      _Controllers[@appName]

   _deleteReference : ->
      delete @region
      delete @options
      delete @appName