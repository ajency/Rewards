# The main builder app entry point
# <ul>
# <li>-this file sets the requirejs configurations </li>
# <li>-load all JS files</li>
# </ul>
require.config

  urlArgs : "ver=#{(new Date()).getTime()}"

  baseUrl : '../wp-content/themes/Rewards/js/dev/js/'

  paths :
      jquery : 'plugins/jquery'
      underscore : 'plugins/underscore'
      backbone : 'plugins/backbone'
      marionette : 'plugins/backbone.marionette'
      text : 'plugins/text'
      spin : 'plugins/spin'
      jqueryspin : 'plugins/jquery.spin'
      bootstrap : 'plugins/bootstrap'
      mustache : 'plugins/Mustache'
      underscorestring : 'plugins/underscorestring'
      moment : 'plugins/moment.min'
      tablesorter : 'plugins/jquery.tablesorter'
      tablepager : 'plugins/jquery.tablesorter.pager'
      cookie : 'plugins/cookie.min'
      jqueryForm : 'plugins/jquery.form.min'
      plupload : 'plugins/plupload.full'
      datepicker : 'plugins/bootstrap-datepicker'
      timepicker : 'plugins/bootstrap-timepicker.min'
      placeholder : 'plugins/jquery.placeholder'
      backbonesyphon : 'plugins/backbone.syphon'
      jqueryvalidate : 'plugins/jquery.validate'
      additionalmethod : 'plugins/additional-methods'
      formelements : 'plugins/form_elements'
      select2 : 'plugins/select2.min'
      pluginloader : 'plugins/dashboard-plugin-loader'
      appsloader : 'apps/dashboard-apps-loader'
      configloader : 'configs/dashboard-config-loader'
      entitiesloader : 'entities/dashboard-entities-loader'
      componentloader : 'components/dashboard-component-loader'
      app : 'pages/dashboard-app'
    shim :
        underscore :
            exports : '_'
        jquery : ['underscore']
        jqueryui : ['jquery']
        backbone :
            deps : ['jquery', 'underscore']
            exports : 'Backbone'
        marionette :
            deps : ['backbone']
            exports : 'Marionette'
        plupload :
            deps : ['jquery']
            exports : 'plupload'
        jqueryvalidate : ['jquery']
        underscorestring : ['underscore']
        backbonesyphon : ['backbone']
        jqueryspin : ['spin', 'jquery']
        bootstrap : ['jquery']
        cookie : ['jquery']
        radio : ['bootstrap']
        checkbox : ['bootstrap']
        bootstrapselect : ['bootstrap']
        app : ['pluginloader', 'configloader']
        additionalmethod : ['jquery', 'jqueryvalidate']
        moment : ['jquery']
        tablesorter : ['jquery']
        tablepager : ['jquery', 'tablesorter']
        select2 : ['jquery']
        jqueryForm : ['jquery']
        datepicker : ['jquery']
        timepicker : ['jquery']
        formelements : ['jquery', 'select2', 'datepicker', 'timepicker']
        placeholder  : ['jquery']
        moment : ['jquery']


## Start with application
require [   'pluginloader'
            'configloader'
            'app'
            'entitiesloader'
            'componentloader'
            'appsloader'], (pl, configs, App)->
    App.start()
