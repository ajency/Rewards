var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/Inventory/Package/templates/inventoryPackage.html'], function(App, inventoryPackageTpl) {
  return App.module("ListInventoryPackage.Views", function(Views, App) {
    var SingleView;
    SingleView = (function(_super) {
      __extends(SingleView, _super);

      function SingleView() {
        return SingleView.__super__.constructor.apply(this, arguments);
      }

      SingleView.prototype.tagName = 'tr';

      SingleView.prototype.template = '<td class="v-align-middle width25"><div class="table_mob_hidden">Package</div>{{option_name}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">Product</div>{{product_name}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">No of Closed R</div>{{Closed_Count}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">No of Confirmed R</div>{{Confirmed_count}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">No of Initiated R</div>{{Initiated_count}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">No of Approved R</div>{{Approved_count}}</td>';

      return SingleView;

    })(Marionette.ItemView);
    return Views.ShowPackage = (function(_super) {
      __extends(ShowPackage, _super);

      function ShowPackage() {
        return ShowPackage.__super__.constructor.apply(this, arguments);
      }

      ShowPackage.prototype.template = inventoryPackageTpl;

      ShowPackage.prototype.itemView = SingleView;

      ShowPackage.prototype.itemViewContainer = 'table#inventory_table tbody';

      ShowPackage.prototype.onShow = function() {
        return this.$el.find("#inventory_table").tablesorter({
          theme: 'blue',
          widthFixed: true,
          sortList: [[0, 1]],
          widgets: ['zebra', 'filter']
        }).tablesorterPager({
          container: $(".pager1"),
          size: 25
        });
      };

      return ShowPackage;

    })(Marionette.CompositeView);
  });
});
