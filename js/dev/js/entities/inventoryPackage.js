var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.InventoryPackage", function(InventoryPackage, App) {
    var API, InventoryPackageCollection, inventoryPackageCollection;
    InventoryPackage = (function(_super) {
      __extends(InventoryPackage, _super);

      function InventoryPackage() {
        return InventoryPackage.__super__.constructor.apply(this, arguments);
      }

      InventoryPackage.prototype.idAttribute = 'ID';

      InventoryPackage.prototype.defaults = {
        product_name: '',
        option_name: '',
        Confirmed_count: '',
        Initiated_count: '',
        Approved_count: '',
        Closed_Count: '',
        opt_id: ''
      };

      InventoryPackage.prototype.name = 'inventoryPackage';

      return InventoryPackage;

    })(Backbone.Model);
    InventoryPackageCollection = (function(_super) {
      __extends(InventoryPackageCollection, _super);

      function InventoryPackageCollection() {
        return InventoryPackageCollection.__super__.constructor.apply(this, arguments);
      }

      InventoryPackageCollection.prototype.model = InventoryPackage;

      InventoryPackageCollection.prototype.url = function() {
        return AJAXURL + '?action=get-inventory_package';
      };

      return InventoryPackageCollection;

    })(Backbone.Collection);
    inventoryPackageCollection = new InventoryPackageCollection;
    API = {
      getInventoryPackage: function() {
        inventoryPackageCollection.fetch();
        return inventoryPackageCollection;
      }
    };
    return App.reqres.setHandler("get:inventoryPackage:collection", function(opt) {
      return API.getInventoryPackage();
    });
  });
});
