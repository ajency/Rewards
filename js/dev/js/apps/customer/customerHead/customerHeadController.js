var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/customer/customerHead/customerHeadView'], function(App, RegionController) {
  return App.module("customerHead", function(customerHead, App) {
    var CustomerHeadController, user;
    user = "";
    CustomerHeadController = (function(_super) {
      __extends(CustomerHeadController, _super);

      function CustomerHeadController() {
        this._getCustomerShippingView = __bind(this._getCustomerShippingView, this);
        this._getCustomerInfoView = __bind(this._getCustomerInfoView, this);
        this._changecustomerView = __bind(this._changecustomerView, this);
        return CustomerHeadController.__super__.constructor.apply(this, arguments);
      }

      CustomerHeadController.prototype.initialize = function(opt) {
        var username, view;
        username = opt.username;
        this.subregion = opt.subregion;
        this.topRegion = opt.subregion;
        this.ID = opt.ID;
        this.shipping_val = opt.shipping_val;
        console.log(this.shipping_val);
        user = username;
        this.view = view = this._getCustomerHeaderView();
        this.listenTo(view, "change:customer:view", this._changecustomerView);
        this.listenTo(view, "change:customerInfo:view", this._getCustomerInfoView);
        this.listenTo(view, "change:customerShipping:view", this._getCustomerShippingView);
        return this.show(view);
      };

      CustomerHeadController.prototype._getCustomerHeaderView = function() {
        return new customerHead.Views.Head({
          shipping_val: this.shipping_val
        });
      };

      CustomerHeadController.prototype._changecustomerView = function() {
        return App.execute("show:info", {
          region: this.subregion,
          username: user,
          topRegion: this.topRegion,
          ID: this.ID
        });
      };

      CustomerHeadController.prototype._getCustomerInfoView = function() {
        return App.execute("show:customers", {
          region: this.subregion,
          username: user,
          topRegion: this.topRegion,
          ID: this.ID
        });
      };

      CustomerHeadController.prototype._getCustomerShippingView = function() {
        return App.execute("show:shipping", {
          region: this.subregion,
          username: user,
          topRegion: this.topRegion,
          ID: this.ID
        });
      };

      return CustomerHeadController;

    })(RegionController);
    return App.commands.setHandler("show:customer:head", function(opt) {
      if (opt == null) {
        opt = {};
      }
      console.log(opt);
      return new CustomerHeadController(opt);
    });
  });
});
