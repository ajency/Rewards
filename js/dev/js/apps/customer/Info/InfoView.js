var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/customer/Info/templates/customerinfolist.html'], function(App, customerTpl) {
  return App.module("Customer.Views", function(Views, App) {
    var SingleView, points;
    points = "";
    SingleView = (function(_super) {
      __extends(SingleView, _super);

      function SingleView() {
        return SingleView.__super__.constructor.apply(this, arguments);
      }

      SingleView.prototype.tagName = 'tr';

      SingleView.prototype.template = '<td>{{srno}}</td><td>{{name}}</td><td>{{phone}}</td><td>{{user_email}}</td><td>{{date_of_purchase}}</td><td>{{date_of_expire}}</td><td>{{points}}</td>';

      SingleView.prototype.serializeData = function() {
        var data, date_elements, date_elements_import, date_of_expire, date_of_import, end, res, result, start;
        data = SingleView.__super__.serializeData.call(this);
        date_of_expire = this.model.get('date_of_expire');
        date_of_import = this.model.get('date_of_import');
        result = '--';
        if (date_of_import !== '--') {
          date_elements = date_of_expire.split('-');
          date_elements_import = date_of_import.split('-');
          end = moment([date_elements[0], date_elements[1], date_elements[2]]);
          start = moment([date_elements_import[0], date_elements_import[1], date_elements_import[2]]);
          res = start.from(end);
          result = res.replace('ago', 'left');
        }
        data.date_of_expire = result;
        return data;
      };

      return SingleView;

    })(Marionette.ItemView);
    return Views.List = (function(_super) {
      __extends(List, _super);

      function List() {
        return List.__super__.constructor.apply(this, arguments);
      }

      List.prototype.template = customerTpl;

      List.prototype.className = "padding-20";

      List.prototype.initialize = function() {
        return points = Marionette.getOption(this, 'ID');
      };

      List.prototype.itemView = SingleView;

      List.prototype.itemViewContainer = 'table#customer_table tbody';

      List.prototype.collectionEvents = {
        'add': 'DisplayMessage'
      };

      List.prototype.events = {
        'click #inititate-redemt': function() {
          var pts;
          if (this.collection.length !== 0) {
            pts = this.collection.models[0].attributes.sum_of_points;
          } else {
            pts = "";
          }
          $("#lireferrals").removeClass('active');
          $("#lishipping").removeClass('active');
          $("#lirewards").addClass('active');
          return this.trigger("change:customer:view", pts);
        },
        'click #changeView': function() {
          var pts;
          if (this.collection.length !== 0) {
            pts = this.collection.models[0].attributes.sum_of_points;
          } else {
            pts = "";
          }
          $("#lireferrals").removeClass('active');
          $("#lishipping").removeClass('active');
          $("#lirewards").addClass('active');
          return this.trigger("change:customer:view", pts);
        }
      };

      List.prototype.DisplayMessage = function(model) {
        var counter, ref_count, sum;
        sum = model.get('sum_of_points');
        ref_count = model.get('ref_count');
        counter = this.collection.length;
        if (counter === 0) {
          this.$el.find("#counter_val").text(ref_count);
          return this.$el.find("#pointer_val").text(ref_count);
        } else {
          this.$el.find("#counter_val").text(ref_count);
          return this.$el.find("#pointer_val").text(sum);
        }
      };

      List.prototype.onShow = function() {
        var object;
        object = this;
        console.log(this.collection);
        this.collection.trigger('reset');
        return $.ajax({
          method: "POST",
          url: AJAXURL + '?action=get_points',
          data: 'username=' + points,
          success: function(result) {
            var status, stringname, text_msg;
            stringname = result.status;
            object.$el.find("#pm-name").text(result.display_name);
            stringname.replace(/\s/g, '');
            if (result.status === "" || result.status === 'Redemption Not initiated') {
              status = 'Redemption Not Initiated';
              text_msg = 'Select a reward package to initiate redemption of points.';
            }
            if (result.status === "Initiated") {
              status = 'Redemption initiated. Waiting for Approval';
              text_msg = 'The Rewards Manager needs to approve your reward request. Please wait for an email.';
            }
            if (result.status === "Approved") {
              status = 'Reward Request Approved';
              text_msg = 'To collect your reward from our office, confirm a convenient date and time.';
            }
            if (result.status === "Confirmed") {
              status = 'Confirmed';
              text_msg = 'Do remember to pick up your reward on the set date and time.';
            }
            if (result.status === "closed") {
              status = 'closed';
              text_msg = 'Redemption process complete and closed.';
            }
            object.$el.find("#redemption_status").text(status);
            object.$el.find("#redemption_msg").text(text_msg);
            if (stringname === 'Approved' || stringname === 'Confirmed' || stringname === 'Initiated') {
              object.$el.find("#inititate-redemt").hide();
              return object.$el.find("#redemption_msg1").text("Redemption was initiated by " + result.initiatedby + " on " + result.date);
            }
          },
          error: function(result) {}
        });
      };

      return List;

    })(Marionette.CompositeView);
  });
});
