var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'apps/referrals/referralcontroller'], function(App) {
  return App.module("Referrals", function(Referrals, App) {
    var ReferralRouter, RouterAPI;
    ReferralRouter = (function(_super) {
      __extends(ReferralRouter, _super);

      function ReferralRouter() {
        return ReferralRouter.__super__.constructor.apply(this, arguments);
      }

      ReferralRouter.prototype.appRoutes = {
        'referrals': 'list'
      };

      return ReferralRouter;

    })(Marionette.AppRouter);
    RouterAPI = {
      list: function() {
        return App.execute("show:referrals", {
          region: App.mainContentRegion
        });
      }
    };
    return Referrals.on('start', function() {
      return new ReferralRouter({
        controller: RouterAPI
      });
    });
  });
});
