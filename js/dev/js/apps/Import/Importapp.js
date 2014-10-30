var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/Import/ImportController'], function(App, RegionController, ListApp) {
  return App.module("Import", function(Import, App) {
    var ImportRouter, RouterAPI;
    ImportRouter = (function(_super) {
      __extends(ImportRouter, _super);

      function ImportRouter() {
        return ImportRouter.__super__.constructor.apply(this, arguments);
      }

      ImportRouter.prototype.appRoutes = {
        'Import': 'list'
      };

      return ImportRouter;

    })(Marionette.AppRouter);
    RouterAPI = {
      list: function() {
        return App.execute("show:importapp", {
          region: App.mainContentRegion
        });
      }
    };
    return Import.on('start', function() {
      return new ImportRouter({
        controller: RouterAPI
      });
    });
  });
});
