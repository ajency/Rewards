var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/referrallist/referrallistController'], function(App, RegionController, ListApp) {
  return App.module("referrallist", function(referrallist, App) {
    var ReferrallistRouter, RouterAPI;
    ReferrallistRouter = (function(_super) {
      __extends(ReferrallistRouter, _super);

      function ReferrallistRouter() {
        return ReferrallistRouter.__super__.constructor.apply(this, arguments);
      }

      ReferrallistRouter.prototype.appRoutes = {
        'referrals': 'list'
      };

      return ReferrallistRouter;

    })(Marionette.AppRouter);
    RouterAPI = {
      list: function() {
        return App.execute("show:referralslist", {
          region: App.mainContentRegion
        });
      }
    };
    return referrallist.on('start', function() {
      return new ReferrallistRouter({
        controller: RouterAPI
      });
    });
  });
});
