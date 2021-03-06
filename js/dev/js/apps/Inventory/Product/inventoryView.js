var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/Inventory/Product/templates/inventProduct.html'], function(App, inventoryTpl) {
  return App.module("ListInventory.Views", function(Views, App) {
    var SingleViewP;
    SingleViewP = (function(_super) {
      __extends(SingleViewP, _super);

      function SingleViewP() {
        return SingleViewP.__super__.constructor.apply(this, arguments);
      }

      SingleViewP.prototype.tagName = 'tr';

      SingleViewP.prototype.template = '<td class="v-align-middle width25"><div class="table_mob_hidden">Product</div>{{product_name}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">No of Closed R</div>{{Closed_Count}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">No of Confirmed R</div>{{Confirmed_count}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">No of Initiated R</div>{{Initiated_count}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">No of Approved R</div>{{Approved_count}}</td>';

      return SingleViewP;

    })(Marionette.ItemView);
    return Views.Show = (function(_super) {
      __extends(Show, _super);

      function Show() {
        return Show.__super__.constructor.apply(this, arguments);
      }

      Show.prototype.template = inventoryTpl;

      Show.prototype.itemView = SingleViewP;

      Show.prototype.itemViewContainer = 'table#inventoryProduct_table tbody';

      Show.prototype.onShow = function() {
        return this.$el.find("#inventoryProduct_table").tablesorter({
          theme: 'blue',
          widthFixed: true,
          sortList: [[0, 1]],
          widgets: ['zebra', 'filter']
        }).tablesorterPager({
          container: $(".pager"),
          size: 25
        });
      };

      return Show;

    })(Marionette.CompositeView);
  });
});
