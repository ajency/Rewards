var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.Inventory", function(Inventory, App) {
    var API, InventoryCollection, inventoryCollection;
    Inventory = (function(_super) {
      __extends(Inventory, _super);

      function Inventory() {
        return Inventory.__super__.constructor.apply(this, arguments);
      }

      Inventory.prototype.idAttribute = 'ID';

      Inventory.prototype.defaults = {
        product_name: '',
        Confirmed_count: '',
        Initiated_count: '',
        Approved_count: '',
        Closed_Count: '',
        opt_id: ''
      };

      Inventory.prototype.name = 'inventory';

      return Inventory;

    })(Backbone.Model);
    InventoryCollection = (function(_super) {
      __extends(InventoryCollection, _super);

      function InventoryCollection() {
        return InventoryCollection.__super__.constructor.apply(this, arguments);
      }

      InventoryCollection.prototype.model = Inventory;

      InventoryCollection.prototype.url = function() {
        return AJAXURL + '?action=get-inventory';
      };

      return InventoryCollection;

    })(Backbone.Collection);
    inventoryCollection = new InventoryCollection;
    API = {
      getInventory: function() {
        inventoryCollection.fetch();
        return inventoryCollection;
      }
    };
    return App.reqres.setHandler("get:inventory:collection", function(opt) {
      return API.getInventory();
    });
  });
});
