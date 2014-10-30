var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/dashboard/dashboardController'], function(App, RegionController, ListApp) {
  return App.module("Dashapp", function(Dashapp, App) {
    var DashappRouter, RouterAPI;
    DashappRouter = (function(_super) {
      __extends(DashappRouter, _super);

      function DashappRouter() {
        return DashappRouter.__super__.constructor.apply(this, arguments);
      }

      DashappRouter.prototype.appRoutes = {
        'dashboard': 'list'
      };

      return DashappRouter;

    })(Marionette.AppRouter);
    RouterAPI = {
      list: function() {
        return App.execute("show:dashboard", {
          region: App.mainContentRegion
        });
      }
    };
    return Dashapp.on('start', function() {
      return new DashappRouter({
        controller: RouterAPI
      });
    });
  });
});
