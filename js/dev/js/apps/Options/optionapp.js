var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
  __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

define(['app', 'controllers/region-controller', 'apps/Options/List/listController', 'apps/Options/Add/addController', 'text!apps/Options/templates/mainfile.html'], function(App, RegionController, ListApp, AddApp, mainfileTpl) {
  return App.module("Options", function(Options, App) {
    var OptionRouter, OptionView, OptionsController, RouterAPI;
    OptionRouter = (function(_super) {
      __extends(OptionRouter, _super);

      function OptionRouter() {
        return OptionRouter.__super__.constructor.apply(this, arguments);
      }

      OptionRouter.prototype.appRoutes = {
        'options': 'list'
      };

      return OptionRouter;

    })(Marionette.AppRouter);
    RouterAPI = {
      list: function() {
        return App.execute("show:optionapp", {
          region: App.mainContentRegion
        });
      }
    };
    Options.on('start', function() {
      return new OptionRouter({
        controller: RouterAPI
      });
    });
    OptionsController = (function(_super) {
      __extends(OptionsController, _super);

      function OptionsController() {
        this._getOptionView = __bind(this._getOptionView, this);
        this.showRegionViews = __bind(this.showRegionViews, this);
        return OptionsController.__super__.constructor.apply(this, arguments);
      }

      OptionsController.prototype.initialize = function() {
        var layout;
        this.layout = layout = this._getOptionView();
        this.listenTo(layout, 'show', this.showRegionViews);
        return this.show(layout);
      };

      OptionsController.prototype.showRegionViews = function() {
        App.execute("show:option:add", {
          region: this.layout.topRegion
        });
        return App.execute("show:option:list", {
          region: this.layout.bottomRegion
        });
      };

      OptionsController.prototype._getOptionView = function() {
        return new OptionView;
      };

      return OptionsController;

    })(RegionController);
    OptionView = (function(_super) {
      __extends(OptionView, _super);

      function OptionView() {
        return OptionView.__super__.constructor.apply(this, arguments);
      }

      OptionView.prototype.template = mainfileTpl;

      OptionView.prototype.regions = {
        topRegion: '#topregion',
        bottomRegion: '#bottomregion'
      };

      return OptionView;

    })(Marionette.Layout);
    return App.commands.setHandler("show:optionapp", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new OptionsController(opt);
    });
  });
});
