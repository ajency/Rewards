var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.Shipping", function(Shipping, App) {
    var API, ShippingCollection, shippingCollection;
    Shipping = (function(_super) {
      __extends(Shipping, _super);

      function Shipping() {
        return Shipping.__super__.constructor.apply(this, arguments);
      }

      Shipping.prototype.idAttribute = 'ID';

      Shipping.prototype.defaults = {
        option: '',
        product_name: '',
        product_price: '',
        product_details: '',
        product_img: '',
        display_name: '',
        user_email: '',
        phone: '',
        sum_of_points: '',
        date: '',
        confirmed: '',
        initiatedby: '',
        status: ''
      };

      Shipping.prototype.name = 'shipping';

      return Shipping;

    })(Backbone.Model);
    ShippingCollection = (function(_super) {
      __extends(ShippingCollection, _super);

      function ShippingCollection() {
        return ShippingCollection.__super__.constructor.apply(this, arguments);
      }

      ShippingCollection.prototype.model = Shipping;

      ShippingCollection.prototype.url = function() {
        return AJAXURL + '?action=get-shippingdetails';
      };

      return ShippingCollection;

    })(Backbone.Collection);
    shippingCollection = new ShippingCollection;
    API = {
      getRewards: function(opt) {
        shippingCollection.fetch({
          data: {
            username: opt.username,
            option: opt.option
          }
        });
        return shippingCollection;
      }
    };
    return App.reqres.setHandler("get:shipping:data", function(opt) {
      return API.getRewards(opt);
    });
  });
});
