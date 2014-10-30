var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/settings/templates/settings.html'], function(App, settingsTpl) {
  return App.module("SettingsView.Views", function(Views, App) {
    return Views.List = (function(_super) {
      __extends(List, _super);

      function List() {
        return List.__super__.constructor.apply(this, arguments);
      }

      List.prototype.template = settingsTpl;

      List.prototype.events = {
        'click #save_settings': function() {
          if (this.$el.find("#SettingsForm").valid()) {
            this.$el.find("#save_settings").attr('disabled', true);
            return this.trigger("save:expiry:date", Backbone.Syphon.serialize(this));
          }
        }
      };

      List.prototype.onShowExpiryData = function() {
        return this.$el.find("#save_settings").attr('disabled', false);
      };

      List.prototype.onShow = function() {
        var object;
        $("#SettingsForm").validate({
          rules: {
            expiry_date: {
              number: true
            },
            min_per: {
              number: true
            },
            max_per: {
              number: true
            }
          }
        });
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + '?action=get_date',
          data: '',
          success: function(result) {
            object.$el.find("#expiry_date").val(result.date);
            object.$el.find("#min_per").val(result.min);
            return object.$el.find("#max_per").val(result.max);
          }
        });
      };

      return List;

    })(Marionette.ItemView);
  });
});
