var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/settings/settingsView'], function(App, RegionController) {
  return App.module("SettingsView", function(SettingsView, App) {
    var settingsController;
    settingsController = (function(_super) {
      __extends(settingsController, _super);

      function settingsController() {
        this.showData = __bind(this.showData, this);
        this._saveExpiry = __bind(this._saveExpiry, this);
        return settingsController.__super__.constructor.apply(this, arguments);
      }

      settingsController.prototype.initialize = function() {
        var view;
        this.view = view = this._getSettingsView();
        this.listenTo(view, "save:expiry:date", this._saveExpiry);
        return this.show(view);
      };

      settingsController.prototype._getSettingsView = function() {
        return new SettingsView.Views.List;
      };

      settingsController.prototype._saveExpiry = function(data) {
        var object;
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + '?action=save_expiry',
          data: data,
          success: function(result) {
            return object.showData();
          }
        }, {
          error: function(result) {}
        });
      };

      settingsController.prototype.showData = function() {
        return this.view.triggerMethod("show:expiry:data");
      };

      return settingsController;

    })(RegionController);
    return App.commands.setHandler("show:settings", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new settingsController;
    });
  });
});
