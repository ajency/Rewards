var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

define(['app', 'controllers/region-controller', 'apps/Inventory/Package/inventPackageController', 'apps/Inventory/Product/inventoryController', 'text!apps/Inventory/templates/inventory.html'], function(App, RegionController, inventoryProductApp, inventoryPackageApp, inventoryMainTpl) {
  return App.module("inventory", function(inventory, App) {
    var InventoryRouter, RouterAPI;
    InventoryRouter = (function(_super) {
      __extends(InventoryRouter, _super);

      function InventoryRouter() {
        return InventoryRouter.__super__.constructor.apply(this, arguments);
      }

      InventoryRouter.prototype.appRoutes = {
        'inventory': 'list'
      };

      return InventoryRouter;

    })(Marionette.AppRouter);
    RouterAPI = {
      list: function() {
        return App.execute("show:inventory:mainapp", {
          region: App.mainContentRegion
        });
      }
    };
    return inventory.on('start', function() {
      var InventoryMainController, InventoryView;
      new InventoryRouter({
        controller: RouterAPI
      });
      InventoryMainController = (function(_super) {
        __extends(InventoryMainController, _super);

        function InventoryMainController() {
          this._getMainInventoryView = __bind(this._getMainInventoryView, this);
          this.showInventoryViews = __bind(this.showInventoryViews, this);
          return InventoryMainController.__super__.constructor.apply(this, arguments);
        }

        InventoryMainController.prototype.initialize = function() {
          var layout;
          this.layout = layout = this._getMainInventoryView();
          this.listenTo(layout, 'show', this.showInventoryViews);
          return this.show(layout);
        };

        InventoryMainController.prototype.showInventoryViews = function() {
          App.execute("show:inventory:product", {
            region: this.layout.topRegion
          });
          return App.execute("show:inventory:package", {
            region: this.layout.bottomRegion
          });
        };

        InventoryMainController.prototype._getMainInventoryView = function() {
          return new InventoryView;
        };

        return InventoryMainController;

      })(RegionController);
      InventoryView = (function(_super) {
        __extends(InventoryView, _super);

        function InventoryView() {
          return InventoryView.__super__.constructor.apply(this, arguments);
        }

        InventoryView.prototype.template = inventoryMainTpl;

        InventoryView.prototype.regions = {
          topRegion: '#topregion',
          bottomRegion: '#bottomregion'
        };

        return InventoryView;

      })(Marionette.Layout);
      return App.commands.setHandler("show:inventory:mainapp", function(opt) {
        if (opt == null) {
          opt = {};
        }
        return new InventoryMainController(opt);
      });
    });
  });
});
