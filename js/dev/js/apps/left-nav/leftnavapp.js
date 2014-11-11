var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller'], function(App, RegionController) {
  return App.module("LeftNavApp", function(LeftNavApp, App) {
    var LeftNavView, SingleMenu;
    LeftNavApp.Controller = (function(_super) {
      __extends(Controller, _super);

      function Controller() {
        this._getLeftNavView = __bind(this._getLeftNavView, this);
        return Controller.__super__.constructor.apply(this, arguments);
      }

      Controller.prototype.initialize = function() {
        var view;
        this.collection = App.request("get:menu:collection");
        this.view = view = this._getLeftNavView(this.collection);
        return this.show(view);
      };

      Controller.prototype._getLeftNavView = function(menuCollection) {
        return new LeftNavView({
          collection: menuCollection
        });
      };

      return Controller;

    })(RegionController);
    SingleMenu = (function(_super) {
      __extends(SingleMenu, _super);

      function SingleMenu() {
        return SingleMenu.__super__.constructor.apply(this, arguments);
      }

      SingleMenu.prototype.tagName = 'li';

      SingleMenu.prototype.template = '<a href="{{menu_item_link}}"> <i class="fa fa-caret-right"></i> <span class="title">{{post_title}}</span> <span class="selected"></span> </a>';

      return SingleMenu;

    })(Marionette.ItemView);
    LeftNavView = (function(_super) {
      __extends(LeftNavView, _super);

      function LeftNavView() {
        return LeftNavView.__super__.constructor.apply(this, arguments);
      }

      LeftNavView.prototype.template = '<p class="menu-title">BROWSE </p> <ul class="menuitems"</ul>';

      LeftNavView.prototype.className = 'page-sidebar-wrapper';

      LeftNavView.prototype.id = 'main-menu-wrapper';

      LeftNavView.prototype.itemView = SingleMenu;

      LeftNavView.prototype.itemViewContainer = 'ul.menuitems';

      return LeftNavView;

    })(Marionette.CompositeView);
    return App.commands.setHandler("show:leftnavapp", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new LeftNavApp.Controller(opt);
    });
  });
});
