var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.Pickup", function(Pickup, App) {
    var API, PickupCollection, pickupCollection;
    Pickup = (function(_super) {
      __extends(Pickup, _super);

      function Pickup() {
        return Pickup.__super__.constructor.apply(this, arguments);
      }

      Pickup.prototype.idAttribute = 'ID';

      Pickup.prototype.defaults = {
        month: '',
        date: '',
        year: '',
        name_array: '',
        date_array: '',
        hash: '',
        user_id: ''
      };

      Pickup.prototype.name = 'pickup';

      return Pickup;

    })(Backbone.Model);
    PickupCollection = (function(_super) {
      __extends(PickupCollection, _super);

      function PickupCollection() {
        return PickupCollection.__super__.constructor.apply(this, arguments);
      }

      PickupCollection.prototype.model = Pickup;

      PickupCollection.prototype.url = function() {
        return AJAXURL + '?action=get-pickup';
      };

      return PickupCollection;

    })(Backbone.Collection);
    pickupCollection = new PickupCollection;
    API = {
      getPickup: function() {
        pickupCollection.fetch();
        return pickupCollection;
      }
    };
    return App.reqres.setHandler("get:pickup:collection", function(opt) {
      return API.getPickup();
    });
  });
});
