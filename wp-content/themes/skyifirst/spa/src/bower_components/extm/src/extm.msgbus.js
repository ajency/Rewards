(function() {
  window.msgbus = Backbone.Wreqr.radio.channel("global");

  msgbus.request = function() {
    return msgbus.reqres.request.apply(msgbus.reqres, arguments);
  };

  msgbus.execute = function() {
    return msgbus.commands.request.apply(msgbus.commands, arguments);
  };

  msgbus.registerController = function(name, controller) {
    return _Controllers[name] = controller;
  };

  msgbus.registerModel = function(name, model) {
    return _Models[name] = model;
  };

  msgbus.showApp = function(appName) {
    var appLauncher;
    appLauncher = new AppLauncher(appName);
    return appLauncher;
  };

  msgbus._store = new Extm.Store;

}).call(this);
