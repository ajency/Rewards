var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/ImportReferrals/importreferralview'], function(App, RegionController) {
  return App.module("ShowRef", function(ShowRef, App) {
    var ShowRefController;
    ShowRefController = (function(_super) {
      __extends(ShowRefController, _super);

      function ShowRefController() {
        this._uploadRefCSV = __bind(this._uploadRefCSV, this);
        return ShowRefController.__super__.constructor.apply(this, arguments);
      }

      ShowRefController.prototype.initialize = function() {
        var view;
        this.view = view = this._getImportRefView();
        this.listenTo(view, "save:csv:file", this._uploadRefCSV);
        return this.show(view);
      };

      ShowRefController.prototype._getImportRefView = function() {
        return new ShowRef.Views.ImportRef;
      };

      ShowRefController.prototype._uploadRefCSV = function(data) {
        var object;
        console.log(data);
        object = this;
        return $("#uploadRefFormdata").ajaxForm({
          method: "POST",
          url: AJAXURL + '?action=upload_Ref_CSV',
          success: function(result) {
            return object.showRefResponse(result);
          }
        }, {
          error: function(result) {}
        });
      };

      ShowRefController.prototype.showRefResponse = function(result) {
        return this.view.triggerMethod("data:responseref:csv", result);
      };

      return ShowRefController;

    })(RegionController);
    return App.commands.setHandler("show:importreferral:app", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new ShowRefController(opt);
    });
  });
});
