var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/dashboard/templates/dashboard.html'], function(App, dashboardTpl) {
  return App.module("dashboard.Views", function(Views, App) {
    return Views.List = (function(_super) {
      __extends(List, _super);

      function List() {
        return List.__super__.constructor.apply(this, arguments);
      }

      List.prototype.template = dashboardTpl;

      List.prototype.onShow = function() {
        return this.trigger('show:dashboard:info');
      };

      List.prototype.onShowAllDashboardInfo = function(result) {
        this.$el.find('.program_member').text(result.program_count);
        this.$el.find('.pgm_lastweek').text(result.program_count_last_week);
        this.$el.find('.pgm_yest').text(result.program_count_previous_day);
        this.$el.find('.ref_yest').text(result.ref_previous_day_count);
        this.$el.find('.ref_lastweek').text(result.ref_last_week_count);
        this.$el.find('.ref_count').text(result.ref_count);
        this.$el.find('.converted').text(result.conversion_count);
        this.$el.find('.program').text(result.program_member_count);
        this.$el.find('.points').text(result.points);
        this.$el.find('.redem_count').text(result.redem_count);
        this.$el.find('.redem_lastweek').text(result.redem_last_week);
        return this.$el.find('.redem_yesterday').text(result.redem_yesterday);
      };

      return List;

    })(Marionette.ItemView);
  });
});
