var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/products/list/listview'], function(App, RegionController) {
  return App.module("List", function(List, App) {
    var ProductController;
    ProductController = (function(_super) {
      __extends(ProductController, _super);

      function ProductController() {
        this.productEdited = __bind(this.productEdited, this);
        this._updateProduct = __bind(this._updateProduct, this);
        return ProductController.__super__.constructor.apply(this, arguments);
      }

      ProductController.prototype.initialize = function() {
        var view;
        this.productCollection = App.request("get:product:collection");
        this.view = view = this._getProductView(this.productCollection);
        this.listenTo(view, "itemview:update:new:product", this._updateProduct);
        return this.show(view);
      };

      ProductController.prototype._getProductView = function(productCollection) {
        return new List.Views.Product({
          collection: productCollection
        });
      };

      ProductController.prototype._updateProduct = function(iv, ID, data) {
        var productModel;
        console.log(data);
        productModel = App.request("get:user:model", ID);
        return productModel.save(data, {
          wait: true,
          success: this.productEdited
        });
      };

      ProductController.prototype.productEdited = function(model, resp) {
        console.log(model);
        return this.view.triggerMethod("new:product:edited", model);
      };

      return ProductController;

    })(RegionController);
    return App.commands.setHandler("show:product:list", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new ProductController(opt);
    });
  });
});
