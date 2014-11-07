var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.User", function(User, App) {
    var API, UserCollection, userCollection;
    User = (function(_super) {
      __extends(User, _super);

      function User() {
        return User.__super__.constructor.apply(this, arguments);
      }

      User.prototype.idAttribute = 'ID';

      User.prototype.defaults = {
        display_name: '',
        role: '',
        user_registered: '',
        user_email: '',
        checked: ''
      };

      User.prototype.name = 'user';

      return User;

    })(Backbone.Model);
    UserCollection = (function(_super) {
      __extends(UserCollection, _super);

      function UserCollection() {
        return UserCollection.__super__.constructor.apply(this, arguments);
      }

      UserCollection.prototype.model = User;

      UserCollection.prototype.url = function() {
        return AJAXURL + '?action=get-users';
      };

      return UserCollection;

    })(Backbone.Collection);
    userCollection = new UserCollection;
    API = {
      getUsers: function() {
        userCollection.fetch();
        return userCollection;
      },
      saveUser: function(data) {
        var userSingle;
        if (data == null) {
          data = {};
        }
        userSingle = new User(data);
        return userSingle;
      },
      addUser: function(model) {
        return userCollection.add(model);
      },
      editUser: function(id) {
        var user;
        user = userCollection.get(id);
        if (!user) {
          user = new User({
            ID: id
          });
          userCollection.add(user);
        }
        return user;
      }
    };
    App.reqres.setHandler("get:user:collection", function() {
      return API.getUsers();
    });
    App.reqres.setHandler("create:user:model", function(data) {
      return API.saveUser(data);
    });
    App.commands.setHandler("add:new:user:model", function(model) {
      return API.addUser(model);
    });
    return App.reqres.setHandler("get:user:data", function(id) {
      return API.editUser(id);
    });
  });
});
