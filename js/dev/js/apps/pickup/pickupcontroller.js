var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/pickup/pickupview'], function(App, RegionController) {
  return App.module("ListPickup", function(ListPickup, App) {
    var pickupController;
    pickupController = (function(_super) {
      __extends(pickupController, _super);

      function pickupController() {
        return pickupController.__super__.constructor.apply(this, arguments);
      }

      pickupController.prototype.initialize = function() {
        var view;
        this.pickupCollection = App.request("get:pickup:collection");
        this.view = view = this._getPickUpView(this.pickupCollection);
        return this.show(view);
      };

      pickupController.prototype._getPickUpView = function(pickupCollection) {
        return new ListPickup.Views.Show({
          collection: pickupCollection
        });
      };

      return pickupController;

    })(RegionController);
    return App.commands.setHandler("show:pickup", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new pickupController;
    });
  });
});
