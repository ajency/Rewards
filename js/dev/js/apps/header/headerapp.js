var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/header/right/rightapp', 'text!apps/header/templates/header.html'], function(App, RegionController, RightApp, headerTpl) {
  return App.module("HeaderApp", function(HeaderApp, App) {
    var HeaderController, HeaderView;
    HeaderController = (function(_super) {
      __extends(HeaderController, _super);

      function HeaderController() {
        this._getHeaderView = __bind(this._getHeaderView, this);
        this.showLeftRightViews = __bind(this.showLeftRightViews, this);
        return HeaderController.__super__.constructor.apply(this, arguments);
      }

      HeaderController.prototype.initialize = function() {
        var layout;
        this.layout = layout = this._getHeaderView();
        this.listenTo(layout, 'show', this.showLeftRightViews);
        return this.show(layout);
      };

      HeaderController.prototype.showLeftRightViews = function() {
        return App.execute("show:rightheaderapp", {
          region: this.layout.rightRegion
        });
      };

      HeaderController.prototype._getHeaderView = function() {
        return new HeaderView;
      };

      return HeaderController;

    })(RegionController);
    HeaderView = (function(_super) {
      __extends(HeaderView, _super);

      function HeaderView() {
        return HeaderView.__super__.constructor.apply(this, arguments);
      }

      HeaderView.prototype.template = headerTpl;

      HeaderView.prototype.className = 'navbar-inner';

      HeaderView.prototype.regions = {
        leftRegion: '#header-left-region',
        rightRegion: '#header-right-region'
      };

      return HeaderView;

    })(Marionette.Layout);
    return App.commands.setHandler("show:headerapp", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new HeaderController(opt);
    });
  });
});
