require.config({
  urlArgs: "ver=" + ((new Date()).getTime()),
  baseUrl: '../wp-content/themes/Rewards/js/dev/js/',
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
    datepicker: 'plugins/bootstrap-datepicker',
    timepicker: 'plugins/bootstrap-timepicker.min',
    placeholder: 'plugins/jquery.placeholder',
    moment: 'plugins/moment.min',
    additionalmethod: 'plugins/additional-methods',
    pluginloader: 'plugins/customer-plugin-loader',
    appsloader: 'apps/customer-apps-loader',
    configloader: 'configs/customer-config-loader',
    entitiesloader: 'entities/customer-entities-loader',
    componentloader: 'components/customer-component-loader',
    app: 'pages/customer-app'
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
    datepicker: ['jquery'],
    timepicker: ['jquery'],
    placeholder: ['jquery']
  }
});

require(['pluginloader', 'configloader', 'app', 'entitiesloader', 'componentloader', 'appsloader'], function(pl, configs, App) {
  return App.start();
});
