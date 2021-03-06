var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

define(['app', 'controllers/region-controller', 'apps/products/list/listcontroller', 'apps/products/Add/addcontroller', 'text!apps/products/templates/mainfile.html'], function(App, RegionController, ListApp, AddApp, mainfileTpl) {
  return App.module("Products", function(Products, App) {
    var ProductView, ProductsController, ProductsRouter, RouterAPI;
    ProductsRouter = (function(_super) {
      __extends(ProductsRouter, _super);

      function ProductsRouter() {
        return ProductsRouter.__super__.constructor.apply(this, arguments);
      }

      ProductsRouter.prototype.appRoutes = {
        'products': 'list'
      };

      return ProductsRouter;

    })(Marionette.AppRouter);
    RouterAPI = {
      list: function() {
        return App.execute("show:productapp", {
          region: App.mainContentRegion
        });
      }
    };
    Products.on('start', function() {
      return new ProductsRouter({
        controller: RouterAPI
      });
    });
    ProductsController = (function(_super) {
      __extends(ProductsController, _super);

      function ProductsController() {
        this._getProductsView = __bind(this._getProductsView, this);
        this.showRegionViews = __bind(this.showRegionViews, this);
        return ProductsController.__super__.constructor.apply(this, arguments);
      }

      ProductsController.prototype.initialize = function() {
        var layout;
        this.layout = layout = this._getProductsView();
        this.listenTo(layout, 'show', this.showRegionViews);
        return this.show(layout);
      };

      ProductsController.prototype.showRegionViews = function() {
        App.execute("show:product:add", {
          region: this.layout.topRegion
        });
        return App.execute("show:product:list", {
          region: this.layout.bottomRegion
        });
      };

      ProductsController.prototype._getProductsView = function() {
        return new ProductView;
      };

      return ProductsController;

    })(RegionController);
    ProductView = (function(_super) {
      __extends(ProductView, _super);

      function ProductView() {
        return ProductView.__super__.constructor.apply(this, arguments);
      }

      ProductView.prototype.template = mainfileTpl;

      ProductView.prototype.regions = {
        topRegion: '#topregion',
        bottomRegion: '#bottomregion'
      };

      return ProductView;

    })(Marionette.Layout);
    return App.commands.setHandler("show:productapp", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new ProductsController(opt);
    });
  });
});
