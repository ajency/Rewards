var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller'], function(App, RegionController) {
  var LoadingController, LoadingView;
  LoadingController = (function(_super) {
    __extends(LoadingController, _super);

    function LoadingController() {
      return LoadingController.__super__.constructor.apply(this, arguments);
    }

    LoadingController.prototype.initialize = function(options) {
      var config, loadingView, view;
      view = options.view, config = options.config;
      config = _.isBoolean(config) ? {} : config;
      _.defaults(config, {
        loadingType: "spinner",
        entities: this.getEntities(view),
        debug: false
      });
      switch (config.loadingType) {
        case "opacity":
          this.region.currentView.$el.css("opacity", 0.5);
          break;
        case "spinner":
          loadingView = this.getLoadingView();
          this.show(loadingView);
          break;
        default:
          throw new Error("Invalid loadingType");
      }
      return this.showRealView(view, loadingView, config);
    };

    LoadingController.prototype.showRealView = function(realView, loadingView, config) {
      var callbackFn;
      callbackFn = _.debounce((function(_this) {
        return function() {
          switch (config.loadingType) {
            case "opacity":
              _this.region.currentView.$el.removeAttr("style");
              break;
            case "spinner":
              if (_this.region.currentView !== loadingView) {
                return realView.close();
              }
          }
          if (!config.debug) {
            _this.show(realView);
            return realView.triggerMethod("dependencies:fetched");
          }
        };
      })(this), 10);
      return App.commands.execute("when:fetched", config.entities, callbackFn);
    };

    LoadingController.prototype.getEntities = function(view) {
      return _.chain(view).pick("model", "collection").toArray().compact().value();
    };

    LoadingController.prototype.getLoadingView = function() {
      return new LoadingView;
    };

    return LoadingController;

  })(RegionController);
  LoadingView = (function(_super) {
    __extends(LoadingView, _super);

    function LoadingView() {
      return LoadingView.__super__.constructor.apply(this, arguments);
    }

    LoadingView.prototype.template = '<i></i>';

    LoadingView.prototype.className = 'loading-container';

    LoadingView.prototype.onShow = function() {
      var opts;
      opts = this._getOptions();
      return this.$el.spin(opts);
    };

    LoadingView.prototype.onClose = function() {
      return this.$el.spin(false);
    };

    LoadingView.prototype._getOptions = function() {
      return {
        lines: 10,
        length: 6,
        width: 2.5,
        radius: 7,
        corners: 1,
        rotate: 9,
        direction: 1,
        color: '#fff',
        speed: 1,
        trail: 60,
        shadow: false,
        hwaccel: true,
        className: 'spinner',
        zIndex: 2e9,
        top: 'auto',
        left: 'auto'
      };
    };

    return LoadingView;

  })(Marionette.ItemView);
  return App.commands.setHandler("show:loading", function(view, options) {
    return new LoadingController({
      view: view,
      region: options.region,
      config: options.loading
    });
  });
});
