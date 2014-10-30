var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/users/add/adduserview'], function(App, RegionController) {
  return App.module("Users.Add", function(Add, App) {
    var Addcontroller;
    Addcontroller = (function(_super) {
      __extends(Addcontroller, _super);

      function Addcontroller() {
        this.userAdded = __bind(this.userAdded, this);
        this._saveUser = __bind(this._saveUser, this);
        return Addcontroller.__super__.constructor.apply(this, arguments);
      }

      Addcontroller.prototype.initialize = function() {
        var view;
        this.view = view = this._getUserAddView();
        this.listenTo(view, "save:new:user", this._saveUser);
        return this.show(view);
      };

      Addcontroller.prototype._getUserAddView = function() {
        return new Add.Views.UserAddView({
          templateHelpers: {
            roles: ROLES,
            AJAXURL: AJAXURL
          }
        });
      };

      Addcontroller.prototype._saveUser = function(data) {
        var userModel;
        userModel = App.request("create:user:model", data);
        return userModel.save(null, {
          wait: true,
          success: this.userAdded
        });
      };

      Addcontroller.prototype.userAdded = function(model, resp) {
        App.execute("add:new:user:model", model);
        return this.view.triggerMethod("new:user:added", resp);
      };

      return Addcontroller;

    })(RegionController);
    return App.commands.setHandler("show:users:add", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new Addcontroller(opt);
    });
  });
});
