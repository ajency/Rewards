define(['marionette'], function(Marionette) {
  window.App = new Marionette.Application;
  App.addRegions({
    headerRegion: '#header-region',
    leftNavRegion: '#left-nav-region',
    mainContentRegion: '#main-content-region',
    breadcrumbRegion: '#breadcrumb-region',
    footerRegion: '#footer-region',
    dialogRegion: '#dialog-region',
    loginRegion: '#login-region'
  });
  App.rootRoute = "";
  App.loginRoute = "login";
  App.commands.setHandler("when:fetched", function(entities, callback) {
    var xhrs;
    xhrs = _.chain([entities]).flatten().pluck("_fetch").value();
    return $.when.apply($, xhrs).done(function() {
      return callback();
    });
  });
  App.reqres.setHandler("default:region", function() {
    return App.mainContentRegion;
  });
  App.on("initialize:after", function(options) {
    App.startHistory();
    App.execute("show:headerapp", {
      region: App.headerRegion
    });
    App.execute("show:leftnavapp", {
      region: App.leftNavRegion
    });
    if (!App.getCurrentRoute()) {
      return App.navigate(this.rootRoute, {
        trigger: true
      });
    }
  });
  return App;
});
