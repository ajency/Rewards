var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/Import/templates/import.html'], function(App, importTpl) {
  return App.module("Show.Views", function(Views, App) {
    return Views.Import = (function(_super) {
      __extends(Import, _super);

      function Import() {
        return Import.__super__.constructor.apply(this, arguments);
      }

      Import.prototype.template = importTpl;

      Import.prototype.events = {
        'click #submit-csvfile': function(e) {
          var object;
          object = this;
          this.$el.find('.pace-inactive').show();
          return this.trigger("save:csv:file");
        }
      };

      Import.prototype.onDataResponseCsv = function(data) {
        this.$el.find('.pace-inactive').hide();
        this.$el.find("#showdiv").show();
        this.$el.find("#totalrecords").text(data[0]);
        this.$el.find("#duplicaterecords").text(data[1]);
        this.$el.find("#newcustomers").text(data[2]);
        this.$el.find("#referrlas").text(data[3]);
        return this.$el.find("#import_date").text(data[4]);
      };

      return Import;

    })(Marionette.ItemView);
  });
});
