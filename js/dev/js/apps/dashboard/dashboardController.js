var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/dashboard/dashboardView'], function(App, RegionController) {
  return App.module("dashboard", function(dashboard, App) {
    var dashboardController;
    dashboardController = (function(_super) {
      __extends(dashboardController, _super);

      function dashboardController() {
        return dashboardController.__super__.constructor.apply(this, arguments);
      }

      dashboardController.prototype.initialize = function() {
        var view;
        this.view = view = this._getDashboardView();
        this.listenTo(view, "show:dashboard:info", this._showDashboardInfo);
        return this.show(view);
      };

      dashboardController.prototype._getDashboardView = function() {
        return new dashboard.Views.List({
          templateHelpers: {
            date: DATE
          }
        });
      };

      dashboardController.prototype._showDashboardInfo = function() {
        var object;
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + '?action=show_dashboard',
          data: '',
          success: function(result) {
            return object.showAllInfo(result);
          }
        }, {
          error: function(result) {}
        });
      };

      dashboardController.prototype.showAllInfo = function(result) {
        return this.view.triggerMethod("show:All:DashboardInfo", result);
      };

      return dashboardController;

    })(RegionController);
    return App.commands.setHandler("show:dashboard", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new dashboardController;
    });
  });
});
