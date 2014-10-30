var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/customer/Info/InfoView'], function(App, RegionController) {
  return App.module("Customer", function(Customer, App) {
    var CustomerController, user;
    user = "";
    CustomerController = (function(_super) {
      __extends(CustomerController, _super);

      function CustomerController() {
        this._changecustomerView = __bind(this._changecustomerView, this);
        return CustomerController.__super__.constructor.apply(this, arguments);
      }

      CustomerController.prototype.initialize = function(opt) {
        var username, view;
        username = opt.username;
        user = username;
        this.subregion = opt.region;
        this.ID = opt.ID;
        this.topRegion = opt.topRegion;
        this.customerCollection = App.request("get:customer:collection", opt);
        this.view = view = this._getCustomerView(this.customerCollection);
        this.listenTo(view, "change:customer:view", this._changecustomerView);
        return this.show(view);
      };

      CustomerController.prototype._getCustomerView = function(customerCollection) {
        return new Customer.Views.List({
          collection: customerCollection,
          ID: this.ID
        });
      };

      CustomerController.prototype._changecustomerView = function(points) {
        return App.execute("show:info", {
          region: this.subregion,
          username: user,
          ID: this.ID,
          topRegion: this.topRegion
        });
      };

      return CustomerController;

    })(RegionController);
    return App.commands.setHandler("show:customers", function(opt) {
      if (opt == null) {
        opt = {};
      }
      console.log(opt);
      return new CustomerController(opt);
    });
  });
});
