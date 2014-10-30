var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/users/list/templates/userlist.html'], function(App, userListTpl) {
  return App.module("Users.List.Views", function(Views, App) {
    var SingleView;
    SingleView = (function(_super) {
      __extends(SingleView, _super);

      function SingleView() {
        return SingleView.__super__.constructor.apply(this, arguments);
      }

      SingleView.prototype.tagName = 'tr';

      SingleView.prototype.template = '<td class="v-align-middle width25"><div class="table_mob_hidden">Name</div>{{display_name}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">Mobile</div>{{role}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">Last Login</div>{{user_registered}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">Action</div> <a href="#users/edit/{{ID}}" class="btn btn-primary btn-sm btn-small editUser">Edit</a></td>';

      SingleView.prototype.className = '';

      SingleView.prototype.serializeData = function() {
        var data, display_name, display_name_manager, role;
        data = SingleView.__super__.serializeData.call(this);
        display_name = this.model.get('display_name');
        role = this.model.get('role');
        display_name = _.str.capitalize(display_name);
        display_name_manager = _.str.capitalize(role);
        data.display_name = display_name;
        data.role = display_name_manager;
        return data;
      };

      return SingleView;

    })(Marionette.ItemView);
    return Views.UserList = (function(_super) {
      __extends(UserList, _super);

      function UserList() {
        return UserList.__super__.constructor.apply(this, arguments);
      }

      UserList.prototype.template = userListTpl;

      UserList.prototype.className = 'user-list';

      UserList.prototype.itemView = SingleView;

      UserList.prototype.itemViewContainer = 'table#user-list tbody';

      return UserList;

    })(Marionette.CompositeView);
  });
});
