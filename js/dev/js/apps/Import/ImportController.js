var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/Import/ImportView'], function(App, RegionController) {
  return App.module("Show", function(Show, App) {
    var showController;
    showController = (function(_super) {
      __extends(showController, _super);

      function showController() {
        this._uploadCSV = __bind(this._uploadCSV, this);
        return showController.__super__.constructor.apply(this, arguments);
      }

      showController.prototype.initialize = function() {
        var view;
        this.view = view = this._getImportView();
        this.listenTo(view, "save:csv:file", this._uploadCSV);
        return this.show(view);
      };

      showController.prototype._getImportView = function(dateModel) {
        return new Show.Views.Import({
          templateHelpers: {
            date: DATE
          }
        });
      };

      showController.prototype._uploadCSV = function(data) {
        var object;
        object = this;
        return $("#uploadFormdata").ajaxForm({
          method: "POST",
          url: AJAXURL + '?action=upload_CSV',
          success: function(result) {
            return object.showResponse(result);
          }
        }, {
          error: function(result) {}
        });
      };

      showController.prototype.showResponse = function(result) {
        return this.view.triggerMethod("data:response:csv", result);
      };

      return showController;

    })(RegionController);
    return App.commands.setHandler("show:importapp", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new showController(opt);
    });
  });
});
