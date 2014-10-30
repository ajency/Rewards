var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/users/list/views'], function(App, RegionController) {
  return App.module("Users.List", function(List, App) {
    var Listcontroller;
    Listcontroller = (function(_super) {
      __extends(Listcontroller, _super);

      function Listcontroller() {
        return Listcontroller.__super__.constructor.apply(this, arguments);
      }

      Listcontroller.prototype.initialize = function() {
        var userCollection, view;
        userCollection = App.request("get:user:collection");
        this.view = view = this._getUserView(userCollection);
        return this.show(view);
      };

      Listcontroller.prototype._getUserView = function(userCollection) {
        return new List.Views.UserList({
          collection: userCollection,
          templateHelpers: {
            roles: ROLES
          }
        });
      };

      return Listcontroller;

    })(RegionController);
    return App.commands.setHandler("show:users:list", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new Listcontroller(opt);
    });
  });
});
