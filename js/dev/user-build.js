({
  baseUrl: 'js/',
  name: 'plugins/almond',
  include : 'pages/user-main',
 //optimize : 'none',
  out : '../production/user-main-build.js',
  paths: {
    jquery: 'plugins/jquery',
    underscore: 'plugins/underscore',
    backbone: 'plugins/backbone',
    marionette: 'plugins/backbone.marionette',
    text: 'plugins/text',
    spin: 'plugins/spin',
    jqueryspin: 'plugins/jquery.spin',
    bootstrap: 'plugins/bootstrap',
    mustache: 'plugins/Mustache',
    underscorestring: 'plugins/underscorestring',
    cookie: 'plugins/cookie.min',
    backbonesyphon: 'plugins/backbone.syphon',
    jqueryvalidate: 'plugins/jquery.validate',
    additionalmethod: 'plugins/additional-methods',
    pluginloader: 'plugins/user-plugin-loader',
    placeholder : 'plugins/jquery.placeholder',
    appsloader: 'apps/user-apps-loader',
    configloader: 'configs/user-config-loader',
    entitiesloader: 'entities/user-entities-loader',
    componentloader: 'components/user-component-loader',
    app: 'pages/user-app',
    intltelinput: 'plugins/intlTelInput.min'
  },
  shim: {
    underscore: {
      exports: '_'
    },
    jquery: ['underscore'],
    jqueryui: ['jquery'],
    backbone: {
      deps: ['jquery', 'underscore'],
      exports: 'Backbone'
    },
    marionette: {
      deps: ['backbone'],
      exports: 'Marionette'
    },
    jqueryvalidate: ['jquery'],
    underscorestring: ['underscore'],
    backbonesyphon: ['backbone'],
    jqueryspin: ['spin', 'jquery'],
    bootstrap: ['jquery'],
    cookie: ['jquery'],
    radio: ['bootstrap'],
    checkbox: ['bootstrap'],
    bootstrapselect: ['bootstrap'],
    app: ['pluginloader', 'configloader'],
    additionalmethod: ['jquery', 'jqueryvalidate'],
    placeholder  : ['jquery'],
    intltelinput : ['jquery']
  }
})

