var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/users/bulkadd/bulkview'], function(App, RegionController) {
  return App.module("Users.BulkAdd", function(BulkAdd, App) {
    var BulkAddcontroller;
    BulkAddcontroller = (function(_super) {
      __extends(BulkAddcontroller, _super);

      function BulkAddcontroller() {
        return BulkAddcontroller.__super__.constructor.apply(this, arguments);
      }

      BulkAddcontroller.prototype.initialize = function() {
        var view;
        this.view = view = this._getUserBulkView();
        return this.show(view);
      };

      BulkAddcontroller.prototype._getUserBulkView = function() {
        return new BulkAdd.Views.UsersBulkView;
      };

      return BulkAddcontroller;

    })(RegionController);
    return App.commands.setHandler("show:users:bulkadd", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new BulkAddcontroller(opt);
    });
  });
});
