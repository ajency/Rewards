var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/Redemption/redemptionView'], function(App, RegionController) {
  return App.module("AddRedemption", function(AddRedemption, App) {
    var redemptionController;
    redemptionController = (function(_super) {
      __extends(redemptionController, _super);

      function redemptionController() {
        return redemptionController.__super__.constructor.apply(this, arguments);
      }

      redemptionController.prototype.initialize = function() {
        var view;
        this.redemptionCollection = App.request("get:redemption:collection");
        this.view = view = this._getRedemptionRewardsView(this.redemptionCollection);
        return this.show(view);
      };

      redemptionController.prototype._getRedemptionRewardsView = function(redemptionCollection) {
        return new AddRedemption.Views.ListRedemption({
          collection: redemptionCollection
        });
      };

      return redemptionController;

    })(RegionController);
    return App.commands.setHandler("show:redemption", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new redemptionController;
    });
  });
});
