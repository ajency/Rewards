var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'text!apps/header/right/templates/right.html'], function(App, RegionController, rightTpl) {
  return App.module("HeaderApp.RightHeaderApp", function(RightHeaderApp, App) {
    var RightHeaderController, RightHeaderView;
    RightHeaderController = (function(_super) {
      __extends(RightHeaderController, _super);

      function RightHeaderController() {
        this.showInfo = __bind(this.showInfo, this);
        this._currentUser = __bind(this._currentUser, this);
        return RightHeaderController.__super__.constructor.apply(this, arguments);
      }

      RightHeaderController.prototype.initialize = function() {
        var view;
        this.view = view = this._getRightHeaderView();
        this.listenTo(view, "get:current:user", this._currentUser);
        this.listenTo(view, "logout:current:user", this._logoutUser);
        return this.show(view);
      };

      RightHeaderController.prototype._getRightHeaderView = function() {
        return new RightHeaderView({
          SITEURL: SITEURL
        });
      };

      RightHeaderController.prototype._currentUser = function() {
        var object;
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + '?action=get_current_user',
          success: function(result) {
            return object.showInfo(result, {
              error: function(result) {
                return object.showInfo(result);
              }
            });
          }
        });
      };

      RightHeaderController.prototype.showInfo = function(result) {
        return this.view.triggerMethod("display:user:info", result);
      };

      RightHeaderController.prototype._logoutUser = function() {
        var object;
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + '?action=logout_current_user',
          success: function(result) {
            return location.href = SITEURL + "/wp-login.php";
          }
        });
      };

      return RightHeaderController;

    })(RegionController);
    RightHeaderView = (function(_super) {
      __extends(RightHeaderView, _super);

      function RightHeaderView() {
        return RightHeaderView.__super__.constructor.apply(this, arguments);
      }

      RightHeaderView.prototype.template = rightTpl;

      RightHeaderView.prototype.className = 'chat-toggler';

      RightHeaderView.prototype.onShow = function() {
        return this.trigger("get:current:user");
      };

      RightHeaderView.prototype.onDisplayUserInfo = function(result) {
        var date, date_elements, role_name, role_name_firststring, role_name_secondstring, user_role;
        date = result.date;
        date_elements = date.split('-');
        this.$el.find('.username').append(result.data['display_name']);
        this.$el.find('.heading').append(result.data['display_name']);
        user_role = result.data['role'];
        role_name = user_role.split('_');
        if (role_name) {
          role_name_firststring = role_name[0];
          role_name_firststring = _.str.capitalize(role_name[0]);
          role_name_secondstring = role_name[1];
          role_name_secondstring = _.str.capitalize(role_name[1]);
          user_role = role_name_firststring + ' ' + role_name_secondstring;
        }
        this.$el.find('.description').append(user_role);
        return this.$el.find('.pull-left').append(moment([date_elements[0], date_elements[1], date_elements[2]]).fromNow());
      };

      RightHeaderView.prototype.events = {
        'click #my-task-list': function(e) {
          if (this.$el.find('#notification-list').css('display') === 'none') {
            return this.$el.find('#notification-list').show();
          } else {
            return this.$el.find('#notification-list').hide();
          }
        },
        'click #logout': function(e) {
          return this.trigger("logout:current:user");
        }
      };

      return RightHeaderView;

    })(Marionette.ItemView);
    return App.commands.setHandler("show:rightheaderapp", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new RightHeaderController(opt);
    });
  });
});
