var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/customer/shipping/shippingView'], function(App, RegionController) {
  return App.module("Shipping", function(Shipping, App) {
    var ShippingController;
    ShippingController = (function(_super) {
      __extends(ShippingController, _super);

      function ShippingController() {
        this._memberdetails = __bind(this._memberdetails, this);
        this.finalRedempt = __bind(this.finalRedempt, this);
        this.showRedempt = __bind(this.showRedempt, this);
        this._finalDetails = __bind(this._finalDetails, this);
        this._finalRedemption = __bind(this._finalRedemption, this);
        return ShippingController.__super__.constructor.apply(this, arguments);
      }

      ShippingController.prototype.initialize = function(opt) {
        var view;
        this.username = opt.username;
        this.option = opt.option;
        this.userid = opt.ID;
        this.topRegion = opt.topRegion;
        this.shippingdata = App.request("get:shipping:data", opt);
        this.view = view = this._getCustomerShippingView(this.shippingdata, this.option, this.userid);
        this.listenTo(view, "save:final:redemption", this._finalRedemption);
        this.listenTo(view, "save:final:details", this._finalDetails);
        this.listenTo(view, "new:member:info", this._memberdetails);
        this.listenTo(view, "show:final:view", this._viewdetails);
        return this.show(view);
      };

      ShippingController.prototype._getCustomerShippingView = function(shippingdata, option, ID) {
        console.log(option);
        return new Shipping.Views.Options({
          collection: shippingdata,
          option: option,
          ID: ID
        });
      };

      ShippingController.prototype._finalRedemption = function(option) {
        var object;
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + '?action=final_redemption',
          data: 'option=' + option + '&username=' + object.username,
          success: function(result) {
            return object.showRedempt(result);
          }
        }, {
          error: function(result) {}
        });
      };

      ShippingController.prototype._finalDetails = function(option, date, time, address) {
        var object;
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + '?action=final_save_details',
          data: 'option=' + option + '&username=' + object.username + '&date=' + date + '&time=' + time + '&address=' + address,
          success: function(result) {
            return object.finalRedempt(result);
          }
        }, {
          error: function(result) {}
        });
      };

      ShippingController.prototype._viewdetails = function(points, option_name) {
        var object;
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + '?action=get_shippping_points',
          data: 'username=' + points + '&option=' + option_name,
          success: function(result) {
            return object.viewRedempt(result);
          },
          error: function() {
            return console.log("error");
          }
        });
      };

      ShippingController.prototype.showRedempt = function(data) {
        return this.view.triggerMethod("new:redemption:initiated", data);
      };

      ShippingController.prototype.finalRedempt = function(data) {
        return this.view.triggerMethod("final:redemption:initiated", data);
      };

      ShippingController.prototype.viewRedempt = function(data) {
        return this.view.triggerMethod("final:redemption:view", data);
      };

      ShippingController.prototype._memberdetails = function(option) {
        return App.execute("show:member:info", {
          region: this.topRegion,
          ID: this.userid
        });
      };

      return ShippingController;

    })(RegionController);
    return App.commands.setHandler("show:shipping", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new ShippingController(opt);
    });
  });
});
