var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/users/edit/templates/useredit.html'], function(App, userEditTpl) {
  return App.module("Users.Edit.Views", function(Views, App) {
    return Views.UserEditView = (function(_super) {
      __extends(UserEditView, _super);

      function UserEditView() {
        return UserEditView.__super__.constructor.apply(this, arguments);
      }

      UserEditView.prototype.template = userEditTpl;

      UserEditView.prototype.className = '';

      UserEditView.prototype.events = {
        'click #updateUser': function(e) {
          e.preventDefault();
          if (this.$el.find("#editUserForm").valid()) {
            this.$el.find('.alert').remove();
            this.$el.find('#updateUser').attr('disabled', true);
            return this.trigger("update:new:user", Backbone.Syphon.serialize(this));
          }
        },
        'click .suspend': function(e) {
          if ($('#' + e.target.id).prop('checked') === true) {
            return $('#' + e.target.id).val(1);
          } else {
            return $('#' + e.target.id).val(0);
          }
        }
      };

      UserEditView.prototype.onShow = function() {
        var role, role_obj;
        $('html, body').animate({
          scrollTop: 0
        }, 'slow');
        role_obj = this.model.attributes.role;
        role = _.str.capitalize(role_obj);
        return this.$el.find("#role option[value='" + role_obj + "']").attr("selected", "selected");
      };

      UserEditView.prototype.onUserUpdated = function(resp) {
        if (resp.code === "Error") {
          this.$el.find("#editUserForm").before('<div class="alert alert-success"> <button data-dismiss="alert" class="close"></button> User with the given email address is already present in the system</div>');
        } else {
          this.$el.find("#editUserForm").before('<div class="alert alert-success"> <button data-dismiss="alert" class="close"></button> User updated successfully</div>');
          location.href = "#users";
        }
        this.$el.find('#updateUser').removeAttr('disabled');
        return this.$el.find('button[type="reset"]').trigger('click');
      };

      return UserEditView;

    })(Marionette.ItemView);
  });
});
