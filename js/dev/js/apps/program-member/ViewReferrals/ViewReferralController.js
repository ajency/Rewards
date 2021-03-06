var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/program-member/referrals/referral_view'], function(App, RegionController) {
  return App.module("Referral", function(Referral, App) {
    var ReferralController;
    ReferralController = (function(_super) {
      __extends(ReferralController, _super);

      function ReferralController() {
        return ReferralController.__super__.constructor.apply(this, arguments);
      }

      ReferralController.prototype.initialize = function(opt) {
        var view;
        this.ID = opt.ID;
        this.referralCollection = App.request("get:referral:list", this.ID);
        this.view = view = this._getReferralsView(this.referralCollection);
        return this.show(view);
      };

      ReferralController.prototype._getReferralsView = function(referralCollection) {
        return new Referral.Views.Referral({
          collection: referralCollection
        });
      };

      return ReferralController;

    })(RegionController);
    return App.commands.setHandler("show:referral:list", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new ReferralController(opt);
    });
  });
});
