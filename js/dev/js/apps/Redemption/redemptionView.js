var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/Redemption/templates/redemption.html'], function(App, redemptionTpl) {
  return App.module("AddRedemption.Views", function(Views, App) {
    var SingleView;
    SingleView = (function(_super) {
      __extends(SingleView, _super);

      function SingleView() {
        return SingleView.__super__.constructor.apply(this, arguments);
      }

      SingleView.prototype.tagName = 'tr';

      SingleView.prototype.template = '<td class="v-align-middle width25"><div class="table_mob_hidden">Name</div>{{display_name}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">Email</div>{{user_email}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">Status</div>{{status}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">Date</div>{{date}}</td>';

      return SingleView;

    })(Marionette.ItemView);
    return Views.ListRedemption = (function(_super) {
      __extends(ListRedemption, _super);

      function ListRedemption() {
        return ListRedemption.__super__.constructor.apply(this, arguments);
      }

      ListRedemption.prototype.template = redemptionTpl;

      ListRedemption.prototype.itemView = SingleView;

      ListRedemption.prototype.itemViewContainer = 'table#redemption_table tbody';

      return ListRedemption;

    })(Marionette.CompositeView);
  });
});
