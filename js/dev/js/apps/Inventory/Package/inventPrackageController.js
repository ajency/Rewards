var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/Inventory/Package/inventPackageView'], function(App, RegionController) {
  return App.module("ListInventoryPackage", function(ListInventoryPackage, App) {
    var inventoryPackageController;
    inventoryPackageController = (function(_super) {
      __extends(inventoryPackageController, _super);

      function inventoryPackageController() {
        return inventoryPackageController.__super__.constructor.apply(this, arguments);
      }

      inventoryPackageController.prototype.initialize = function() {
        var view;
        this.inventoryPackCollection = App.request("get:inventoryPackage:collection");
        this.view = view = this._getInventoryView(this.inventoryPackCollection);
        return App.execute("when:fetched", [this.inventoryPackCollection], (function(_this) {
          return function() {
            return _this.show(view);
          };
        })(this));
      };

      inventoryPackageController.prototype._getInventoryView = function(inventoryPackCollection) {
        return new ListInventoryPackage.Views.ShowPackage({
          collection: inventoryPackCollection
        });
      };

      return inventoryPackageController;

    })(RegionController);
    return App.commands.setHandler("show:inventory:package", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new inventoryPackageController;
    });
  });
});
