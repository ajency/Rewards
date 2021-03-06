var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/users/edit/edituserview'], function(App, RegionController) {
  return App.module("Users.Edit", function(Edit, App) {
    var Editcontroller;
    Editcontroller = (function(_super) {
      __extends(Editcontroller, _super);

      function Editcontroller() {
        this.userUpdated = __bind(this.userUpdated, this);
        this._updateUser = __bind(this._updateUser, this);
        return Editcontroller.__super__.constructor.apply(this, arguments);
      }

      Editcontroller.prototype.initialize = function(opt) {
        var ID, view;
        ID = opt.ID;
        this.model = App.request("get:user:data", ID);
        this.view = view = this._getUserEditView(this.model);
        this.listenTo(view, "update:new:user", this._updateUser);
        return this.show(view);
      };

      Editcontroller.prototype._getUserEditView = function(model) {
        return new Edit.Views.UserEditView({
          model: model,
          templateHelpers: {
            roles: ROLES,
            AJAXURL: AJAXURL
          }
        });
      };

      Editcontroller.prototype._updateUser = function(data) {
        return this.model.save(data, {
          wait: true,
          success: this.userUpdated
        });
      };

      Editcontroller.prototype.userUpdated = function(model, resp) {
        return this.view.triggerMethod("user:updated", resp);
      };

      return Editcontroller;

    })(RegionController);
    return App.commands.setHandler("show:users:edit", function(opt) {
      return new Editcontroller(opt);
    });
  });
});
