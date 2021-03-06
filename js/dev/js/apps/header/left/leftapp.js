var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'text!apps/header/left/templates/left.html'], function(App, RegionController, leftTpl) {
  return App.module("HeaderApp.LeftHeaderApp", function(LeftHeaderApp, App) {
    var LeftHeaderView;
    Controller.LeftHeaderController = (function(_super) {
      __extends(LeftHeaderController, _super);

      function LeftHeaderController() {
        return LeftHeaderController.__super__.constructor.apply(this, arguments);
      }

      LeftHeaderController.prototype.initialize = function() {
        var view;
        this.view = view = this._getLeftHeaderView();
        return this.show(view);
      };

      LeftHeaderController.prototype._getLeftHeaderView = function() {
        return new LeftHeaderView;
      };

      return LeftHeaderController;

    })(RegionController);
    LeftHeaderView = (function(_super) {
      __extends(LeftHeaderView, _super);

      function LeftHeaderView() {
        return LeftHeaderView.__super__.constructor.apply(this, arguments);
      }

      LeftHeaderView.prototype.template = leftTpl;

      LeftHeaderView.prototype.className = 'pull-left';

      return LeftHeaderView;

    })(Marionette.ItemView);
    return App.commands.setHandler("show:leftheaderapp", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new Controller.LeftHeaderController(opt);
    });
  });
});
