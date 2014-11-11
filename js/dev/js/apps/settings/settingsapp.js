var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/settings/settingsController'], function(App, RegionController, ListApp) {
  return App.module("settings", function(settings, App) {
    var RouterAPI, settingsRouter;
    settingsRouter = (function(_super) {
      __extends(settingsRouter, _super);

      function settingsRouter() {
        return settingsRouter.__super__.constructor.apply(this, arguments);
      }

      settingsRouter.prototype.appRoutes = {
        'settings': 'view'
      };

      return settingsRouter;

    })(Marionette.AppRouter);
    RouterAPI = {
      view: function() {
        return App.execute("show:settings", {
          region: App.mainContentRegion
        });
      }
    };
    return settings.on('start', function() {
      return new settingsRouter({
        controller: RouterAPI
      });
    });
  });
});
