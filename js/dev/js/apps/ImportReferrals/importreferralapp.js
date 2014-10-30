var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/ImportReferrals/importreferralcontroller'], function(App, RegionController, ListApp) {
  return App.module("ImportRef", function(ImportRef, App) {
    var ImportRefRouter, RouterAPI;
    ImportRefRouter = (function(_super) {
      __extends(ImportRefRouter, _super);

      function ImportRefRouter() {
        return ImportRefRouter.__super__.constructor.apply(this, arguments);
      }

      ImportRefRouter.prototype.appRoutes = {
        'ImportRef': 'list'
      };

      return ImportRefRouter;

    })(Marionette.AppRouter);
    RouterAPI = {
      list: function() {
        return App.execute("show:importreferral:app", {
          region: App.mainContentRegion
        });
      }
    };
    return ImportRef.on('start', function() {
      return new ImportRefRouter({
        controller: RouterAPI
      });
    });
  });
});
