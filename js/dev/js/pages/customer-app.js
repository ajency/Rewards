define(['marionette'], function(Marionette) {
  window.App = new Marionette.Application;
  console.log("hi");
  App.addRegions({
    mainContentRegion: '#main-content-region',
    footerRegion: '#footer-region',
    headerRegion: '#header-region',
    secondRegion: '#info-region'
  });
  App.rootRoute = "";
  App.loginRoute = "login";
  App.reqres.setHandler("default:region", function() {
    return App.mainContentRegion;
  });
  App.commands.setHandler("when:fetched", function(entities, callback) {
    var xhrs;
    xhrs = _.chain([entities]).flatten().pluck("_fetch").value();
    return $.when.apply($, xhrs).done(function() {
      return callback();
    });
  });
  App.commands.setHandler("register:instance", function(instance, id) {
    return App.register(instance, id);
  });
  App.commands.setHandler("unregister:instance", function(instance, id) {
    return App.unregister(instance, id);
  });
  App.on("initialize:after", function(options) {
    App.startHistory();
    App.execute("show:customerapp", {
      region: App.headerRegion
    });
    if (!App.getCurrentRoute()) {
      return App.navigate(this.rootRoute, {
        trigger: true
      });
    }
  });
  return App;
});
