var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/users/add/templates/useradd.html'], function(App, userAddTpl) {
  return App.module("Users.Add.Views", function(Views, App) {
    return Views.UserAddView = (function(_super) {
      __extends(UserAddView, _super);

      function UserAddView() {
        return UserAddView.__super__.constructor.apply(this, arguments);
      }

      UserAddView.prototype.template = userAddTpl;

      UserAddView.prototype.className = '';

      UserAddView.prototype.events = {
        'click #saveUser': function(e) {
          e.preventDefault();
          if (this.$el.find("#addUserForm").valid()) {
            this.$el.find('.alert').remove();
            this.$el.find('#saveUser').attr('disabled', true);
            return this.trigger("save:new:user", Backbone.Syphon.serialize(this));
          }
        }
      };

      UserAddView.prototype.onNewUserAdded = function(resp) {
        if (resp.code === "Error") {
          this.$el.find("#addUserForm").before('<div class="alert alert-success"> <button data-dismiss="alert" class="close"></button> User with the given email address is already present in the system</div>');
        } else {
          this.$el.find("#addUserForm").before('<div class="alert alert-success"> <button data-dismiss="alert" class="close"></button> New user added successfully</div>');
          location.href = "#users";
        }
        this.$el.find('#saveUser').removeAttr('disabled');
        return this.$el.find('button[type="reset"]').trigger('click');
      };

      return UserAddView;

    })(Marionette.ItemView);
  });
});
