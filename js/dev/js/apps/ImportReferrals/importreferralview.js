var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/ImportReferrals/templates/importRef.html'], function(App, importrefTpl) {
  return App.module("ShowRef.Views", function(Views, App) {
    return Views.ImportRef = (function(_super) {
      __extends(ImportRef, _super);

      function ImportRef() {
        return ImportRef.__super__.constructor.apply(this, arguments);
      }

      ImportRef.prototype.template = importrefTpl;

      ImportRef.prototype.events = {
        'click #submit-csvfile': function(e) {
          var object;
          object = this;
          this.$el.find('.pace-inactive').show();
          return this.trigger("save:csv:file");
        }
      };

      ImportRef.prototype.onDataResponserefCsv = function(data) {
        this.$el.find('.pace-inactive').hide();
        this.$el.find("#showdiv").show();
        this.$el.find("#totalrecords").text(data[0]);
        this.$el.find("#recordsAdded").text(data[1]);
        this.$el.find("#dupli_ref").text(data[2]);
        this.$el.find("#dupli_cus").text(data[3]);
        return this.$el.find("#dupli_pm").text(data[4]);
      };

      return ImportRef;

    })(Marionette.ItemView);
  });
});
