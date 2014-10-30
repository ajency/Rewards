var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

define(['app', 'controllers/region-controller', 'apps/program-member/members/member_controller', 'apps/customer/customerHead/customerHeadController', 'apps/customer/Info/InfoController', 'apps/customer/rewards/rewardsController', 'apps/customer/shipping/shippingController', 'text!apps/customer/templates/mainCustomer.html'], function(App, RegionController, MemeberApp, HeadApp, InfoApp, rewardsApp, shippingApp, mainfileTpl) {
  return App.module("CustomerInfo", function(CustomerInfo, App) {
    var CustomerRouter, ProductOptionsController, ProductView, RouterAPI, shipping_val, username_id, username_value;
    username_value = "";
    username_id = "";
    shipping_val = "";
    CustomerRouter = (function(_super) {
      __extends(CustomerRouter, _super);

      function CustomerRouter() {
        return CustomerRouter.__super__.constructor.apply(this, arguments);
      }

      CustomerRouter.prototype.appRoutes = {
        'user/:username/:id': 'edit',
        'shipping/:username/:id': 'shipping'
      };

      return CustomerRouter;

    })(Marionette.AppRouter);
    RouterAPI = {
      edit: function(username, id) {
        console.log(username);
        console.log(id);
        username_value = username;
        username_id = id;
        return App.execute("show:customers", {
          region: App.mainContentRegion,
          subregion: App.mainContentRegion,
          username: username,
          ID: username_id,
          topRegion: App.mainContentRegion
        });
      },
      show: function() {
        return App.execute("show:info", {
          region: App.mainContentRegion
        });
      },
      shipping: function(username, id) {
        console.log(username);
        console.log(id);
        username_value = username;
        username_id = id;
        shipping_val = 1;
        return App.execute("show:shipping", {
          region: App.mainContentRegion,
          username: username,
          topRegion: this.topRegion,
          ID: this.ID,
          subregion: App.mainContentRegion
        });
      }
    };
    CustomerInfo.on('start', function() {
      return new CustomerRouter({
        controller: RouterAPI
      });
    });
    ProductOptionsController = (function(_super) {
      __extends(ProductOptionsController, _super);

      function ProductOptionsController() {
        this._getProductsView = __bind(this._getProductsView, this);
        this.showRegionViews = __bind(this.showRegionViews, this);
        return ProductOptionsController.__super__.constructor.apply(this, arguments);
      }

      ProductOptionsController.prototype.initialize = function() {
        var layout;
        this.layout = layout = this._getProductsView();
        this.listenTo(layout, 'show', this.showRegionViews);
        return this.show(layout);
      };

      ProductOptionsController.prototype.showRegionViews = function() {
        console.log(shipping_val);
        return App.execute("show:customer:head", {
          region: this.layout.topRegion,
          username: username_value,
          subregion: App.mainContentRegion,
          ID: username_id,
          shipping_val: shipping_val,
          topRegion: App.mainContentRegion
        });
      };

      ProductOptionsController.prototype._getProductsView = function() {
        return new ProductView;
      };

      return ProductOptionsController;

    })(RegionController);
    ProductView = (function(_super) {
      __extends(ProductView, _super);

      function ProductView() {
        return ProductView.__super__.constructor.apply(this, arguments);
      }

      ProductView.prototype.template = mainfileTpl;

      ProductView.prototype.className = 'content';

      ProductView.prototype.regions = {
        topRegion: '#topregion',
        bottomRegion: '#bottomregion'
      };

      return ProductView;

    })(Marionette.Layout);
    return App.commands.setHandler("show:customerapp", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new ProductOptionsController(opt);
    });
  });
});
