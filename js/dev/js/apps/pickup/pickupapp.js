var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/pickup/pickupcontroller'], function(App, RegionController, pickupApp) {
  return App.module("pickup", function(pickup, App) {
    var PickupRouter, RouterAPI;
    PickupRouter = (function(_super) {
      __extends(PickupRouter, _super);

      function PickupRouter() {
        return PickupRouter.__super__.constructor.apply(this, arguments);
      }

      PickupRouter.prototype.appRoutes = {
        'pickup': 'list'
      };

      return PickupRouter;

    })(Marionette.AppRouter);
    RouterAPI = {
      list: function() {
        return App.execute("show:pickup", {
          region: App.mainContentRegion
        });
      }
    };
    return pickup.on('start', function() {
      return new PickupRouter({
        controller: RouterAPI
      });
    });
  });
});
