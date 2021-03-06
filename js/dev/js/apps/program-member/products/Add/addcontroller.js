var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/products/Add/addview'], function(App, RegionController) {
  return App.module("Add", function(Add, App) {
    var AddController;
    AddController = (function(_super) {
      __extends(AddController, _super);

      function AddController() {
        this.productAdded = __bind(this.productAdded, this);
        this._saveProduct = __bind(this._saveProduct, this);
        return AddController.__super__.constructor.apply(this, arguments);
      }

      AddController.prototype.initialize = function() {
        var view;
        this.view = view = this._getProductAddView();
        this.listenTo(view, "save:new:product", this._saveProduct);
        return this.show(view);
      };

      AddController.prototype._getProductAddView = function() {
        return new Add.Views.ProductAdd;
      };

      AddController.prototype._saveProduct = function(data) {
        var productModel;
        productModel = App.request("create:new:product", data);
        return productModel.save(null, {
          wait: true,
          success: this.productAdded
        });
      };

      AddController.prototype.productAdded = function(model, resp) {
        console.log(model);
        App.execute("add:new:product:model", model);
        return this.view.triggerMethod("product:added");
      };

      return AddController;

    })(RegionController);
    return App.commands.setHandler("show:product:add", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new AddController(opt);
    });
  });
});
