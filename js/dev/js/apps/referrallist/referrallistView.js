var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/referrallist/templates/referral.html'], function(App, referrallistTpl) {
  return App.module("Add.Views", function(Views, App) {
    var SingleView;
    console.log("test");
    SingleView = (function(_super) {
      __extends(SingleView, _super);

      function SingleView() {
        return SingleView.__super__.constructor.apply(this, arguments);
      }

      SingleView.prototype.tagName = 'tr';

      SingleView.prototype.template = '<td class="v-align-middle width25"><div class="table_mob_hidden">Name</div>{{display_name}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">Date Added on</div>{{date}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">Program Member</div>{{program_name}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">Status</div>{{status}}</td> <td class="v-align-middle width25"><div class="table_mob_hidden">Conversion Date</div>{{date_import}}</td>';

      return SingleView;

    })(Marionette.ItemView);
    return Views.List = (function(_super) {
      __extends(List, _super);

      function List() {
        return List.__super__.constructor.apply(this, arguments);
      }

      List.prototype.template = referrallistTpl;

      List.prototype.itemView = SingleView;

      List.prototype.itemViewContainer = 'table#referrallist_table tbody';

      List.prototype.onShow = function() {
        var dates, first, newdates, newfirst;
        dates = this.collection.pluck('old');
        first = _.first(dates);
        newdates = this.collection.pluck('current');
        console.log(newfirst = _.first(newdates));
        this.$el.find("#referrallist_table").tablesorter({
          theme: 'blue',
          widthFixed: true,
          sortList: [[0, 1]],
          widgets: ['zebra', 'filter']
        }).tablesorterPager({
          container: $(".pager"),
          size: 25
        });
        if (this.$el.find('#to_date').val() === "") {
          this.$el.find('#to_date').val(newfirst);
          this.$el.find('#to_date').datepicker({
            format: 'yyyy-mm-dd ',
            startDate: newfirst
          });
        }
        if (this.$el.find('#from_date').val() === "") {
          this.$el.find('#from_date').val(first);
          this.$el.find('#from_date').datepicker({
            format: 'yyyy-mm-dd ',
            startDate: first
          });
        }
        this.$el.find('#status1').prop('checked', true);
        this.$el.find('#status2').prop('checked', true);
        this.$el.find('#from_date').prop('checked', true);
        return this.$el.find('#to_date').prop('checked', true);
      };

      List.prototype.events = function() {
        return {
          'click #status_check': function(e) {
            this.$el.find('#status1').prop('checked', true);
            return this.$el.find('#status2').prop('checked', true);
          },
          'click #status_uncheck': function(e) {
            this.$el.find('#status1').prop('checked', false);
            return this.$el.find('#status2').prop('checked', false);
          },
          'click #date_uncheck': function(e) {
            this.$el.find('#from_date').val("");
            return this.$el.find('#to_date').val("");
          },
          'click #submitform': function(e) {
            e.preventDefault();
            $(".ref_msg").remove();
            if (this.$el.find('#to_date').val() < this.$el.find('#from_date').val()) {
              $(".date_msg").before('<div class="ref_msg alert alert-error m-b-5 m-t-20"> <button data-dismiss="alert" class="close"></button>To date cannot be less than From date</div>');
              return false;
            }
            this.$el.find('#hideshow').addClass('collapsed');
            this.$el.find('#collapseOne').removeClass('collapse in');
            this.$el.find('#collapseOne').addClass('collapse');
            return this.trigger("filter:referral:info", Backbone.Syphon.serialize(this));
          },
          'click #exportcsv': function(e) {
            e.preventDefault();
            return this.trigger("export:to:csv", Backbone.Syphon.serialize(this));
          }
        };
      };

      return List;

    })(Marionette.CompositeView);
  });
});
