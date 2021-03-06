var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/program-member/referrals/templates/referralinfo.html'], function(App, referralTpl) {
  return App.module("Referral.Views", function(Views, App) {
    var SingleView;
    SingleView = (function(_super) {
      __extends(SingleView, _super);

      function SingleView() {
        return SingleView.__super__.constructor.apply(this, arguments);
      }

      SingleView.prototype.tagName = 'tr';

      SingleView.prototype.template = '<td>{{name}}</td><td>{{phone}}</td><td>{{email}}</td><td>{{points}}</td><td>{{date}}</td><td>{{status}}</td>';

      return SingleView;

    })(Marionette.ItemView);
    return Views.Referral = (function(_super) {
      __extends(Referral, _super);

      function Referral() {
        return Referral.__super__.constructor.apply(this, arguments);
      }

      Referral.prototype.template = referralTpl;

      Referral.prototype.className = '';

      Referral.prototype.itemView = SingleView;

      Referral.prototype.itemViewContainer = 'table#referral_table tbody';

      return Referral;

    })(Marionette.CompositeView);
  });
});
