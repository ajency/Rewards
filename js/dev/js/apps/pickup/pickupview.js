var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/pickup/templates/pickup.html'], function(App, pickupTpl) {
  return App.module("ListPickup.Views", function(Views, App) {
    var SingleView;
    SingleView = (function(_super) {
      __extends(SingleView, _super);

      function SingleView() {
        return SingleView.__super__.constructor.apply(this, arguments);
      }

      SingleView.prototype.template = '<li class="month"> <h5>{{month}} {{year}}</h5> <ul class="days"> {{#date}} <li class="date"> <div class="date-num"> {{date_array}} </div> <div class="people"> {{#name_array}} <a href="#referrals/{{hash}}/{{user_id}}">{{name}}</a>, {{/name_array}} </div> </li> {{/date}} </ul> </li>';

      return SingleView;

    })(Marionette.ItemView);
    return Views.Show = (function(_super) {
      __extends(Show, _super);

      function Show() {
        return Show.__super__.constructor.apply(this, arguments);
      }

      Show.prototype.template = pickupTpl;

      Show.prototype.itemView = SingleView;

      Show.prototype.itemViewContainer = 'ul.pickup ';

      return Show;

    })(Marionette.CompositeView);
  });
});
