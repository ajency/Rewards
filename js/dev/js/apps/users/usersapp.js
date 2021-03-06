var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'apps/users/list/userslistcontroller', 'apps/users/add/useraddcontroller', 'apps/users/bulkadd/bulkaddcontroller', 'apps/users/edit/editusercontroller'], function(App) {
  return App.module("Users", function(Users, App) {
    var RouterAPI, UsersRouter;
    UsersRouter = (function(_super) {
      __extends(UsersRouter, _super);

      function UsersRouter() {
        return UsersRouter.__super__.constructor.apply(this, arguments);
      }

      UsersRouter.prototype.appRoutes = {
        'users': 'list',
        'users/list': 'list',
        'users/add': 'add',
        'users/edit/:id': 'edit',
        'users/bulk-add': 'bulkAdd'
      };

      return UsersRouter;

    })(Marionette.AppRouter);
    RouterAPI = {
      list: function() {
        return App.execute("show:users:list", {
          region: App.mainContentRegion
        });
      },
      add: function() {
        return App.execute("show:users:add", {
          region: App.mainContentRegion
        });
      },
      edit: function(id) {
        return App.execute("show:users:edit", {
          region: App.mainContentRegion,
          ID: id
        });
      },
      bulkAdd: function() {
        return App.execute("show:users:bulkadd", {
          region: App.mainContentRegion
        });
      }
    };
    return Users.on('start', function() {
      return new UsersRouter({
        controller: RouterAPI
      });
    });
  });
});
