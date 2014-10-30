var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/Redemption/redemptionController'], function(App, RegionController, ListApp) {
  return App.module("List", function(List, App) {
    var ListRouter, RouterAPI;
    ListRouter = (function(_super) {
      __extends(ListRouter, _super);

      function ListRouter() {
        return ListRouter.__super__.constructor.apply(this, arguments);
      }

      ListRouter.prototype.appRoutes = {
        'redemptions': 'redemption'
      };

      return ListRouter;

    })(Marionette.AppRouter);
    RouterAPI = {
      redemption: function() {
        return App.execute("show:redemption", {
          region: App.mainContentRegion
        });
      }
    };
    return List.on('start', function() {
      return new ListRouter({
        controller: RouterAPI
      });
    });
  });
});
