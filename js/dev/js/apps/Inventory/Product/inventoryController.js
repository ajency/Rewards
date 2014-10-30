var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/Inventory/Product/inventoryView'], function(App, RegionController) {
  return App.module("ListInventory", function(ListInventory, App) {
    var inventoryController;
    inventoryController = (function(_super) {
      __extends(inventoryController, _super);

      function inventoryController() {
        return inventoryController.__super__.constructor.apply(this, arguments);
      }

      inventoryController.prototype.initialize = function() {
        var view;
        this.inventoryCollection = App.request("get:inventory:collection");
        this.view = view = this._getInventoryView(this.inventoryCollection);
        return App.execute("when:fetched", [this.inventoryCollection], (function(_this) {
          return function() {
            return _this.show(view);
          };
        })(this));
      };

      inventoryController.prototype._getInventoryView = function(inventoryCollection) {
        return new ListInventory.Views.Show({
          collection: inventoryCollection
        });
      };

      return inventoryController;

    })(RegionController);
    return App.commands.setHandler("show:inventory:product", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new inventoryController(opt);
    });
  });
});
