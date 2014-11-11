var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/program-member/programmember/templates/program-member.html'], function(App, memberTpl) {
  return App.module("Member.Views", function(Views, App) {
    var SingleView;
    SingleView = (function(_super) {
      __extends(SingleView, _super);

      function SingleView() {
        return SingleView.__super__.constructor.apply(this, arguments);
      }

      SingleView.prototype.tagName = 'tr';

      SingleView.prototype.className = 'user_class';

      SingleView.prototype.template = '<td class="v-align-middle width20 clickable"><div class="table_mob_hidden">Name</div>{{display_name}}</td> <td class="v-align-middle width20"><div class="table_mob_hidden">Date Joined</div>{{user_registered}}</td> <td class="v-align-middle width20"><div class="table_mob_hidden">No Of Referrals</div>{{referral_count}}</td> <td class="v-align-middle width20"><div class="table_mob_hidden">Points</div>{{points}}</td> <td class="v-align-middle width20 status"><div class="table_mob_hidden">Status</div>{{status}}</td> <td class="v-align-middle width20"><div class="table_mob_hidden">Is a Customer</div>{{customer_val}}</td>';

      SingleView.prototype.events = {
        'click ': 'click'
      };

      SingleView.prototype.modelEvents = {
        'change:status': function() {
          return this.$el.find('.status').text(this.model.get("status"));
        }
      };

      SingleView.prototype.click = function() {
        return location.href = '#referrals/' + this.model.get('user_login') + '/' + this.model.get('ID');
      };

      SingleView.prototype.onShow = function() {
        return this.$el.find('.bolesemi').text(this.model.get("user_role"));
      };

      return SingleView;

    })(Marionette.ItemView);
    return Views.ProgramMember = (function(_super) {
      __extends(ProgramMember, _super);

      function ProgramMember() {
        return ProgramMember.__super__.constructor.apply(this, arguments);
      }

      ProgramMember.prototype.template = memberTpl;

      ProgramMember.prototype.className = '';

      ProgramMember.prototype.itemView = SingleView;

      ProgramMember.prototype.itemViewContainer = 'table#program-member-table tbody';

      ProgramMember.prototype.onShow = function() {
        var object, role;
        role = _.str.capitalize(this.collection.models[0].attributes.user_role);
        this.$el.find('.bolesemi').text(role);
        this.$el.find('#customer').attr('checked', true);
        this.$el.find('#noncustomer').attr('checked', true);
        this.$el.find('#ref_radio1').prop('checked', true);
        this.$el.find('#ref_radio2').prop('checked', true);
        this.$el.find('#ref_radio3').prop('checked', true);
        this.$el.find('#ref_radio4').prop('checked', true);
        this.$el.find('#ref_radio5').prop('checked', true);
        this.$el.find('#point1').prop('checked', true);
        this.$el.find('#point2').prop('checked', true);
        this.$el.find('#point3').prop('checked', true);
        this.$el.find('#point4').prop('checked', true);
        this.$el.find('#point5').prop('checked', true);
        this.$el.find('#point6').prop('checked', true);
        this.$el.find('#status1').prop('checked', true);
        this.$el.find('#status2').prop('checked', true);
        this.$el.find('#status3').prop('checked', true);
        this.$el.find('#status4').prop('checked', true);
        this.$el.find('#status5').prop('checked', true);
        object = this;
        return this.$el.find("#program-member-table").tablesorter({
          theme: 'blue',
          widthFixed: true,
          sortList: [[0, 1]],
          widgets: ['zebra', 'filter']
        }).tablesorterPager({
          container: $(".pager"),
          size: 25
        });
      };

      ProgramMember.prototype.events = {
        'click #customer_check': function(e) {
          this.$el.find('#customer').prop('checked', true);
          return this.$el.find('#noncustomer').prop('checked', true);
        },
        'click #referral_check': function(e) {
          this.$el.find('#ref_radio1').prop('checked', true);
          this.$el.find('#ref_radio2').prop('checked', true);
          this.$el.find('#ref_radio3').prop('checked', true);
          this.$el.find('#ref_radio4').prop('checked', true);
          return this.$el.find('#ref_radio5').prop('checked', true);
        },
        'click #customer_uncheck': function(e) {
          $('#noncustomer').prop('checked', false);
          return $('#customer').prop('checked', false);
        },
        'click #referral_uncheck': function(e) {
          this.$el.find('#ref_radio1').prop('checked', false);
          this.$el.find('#ref_radio2').prop('checked', false);
          this.$el.find('#ref_radio3').prop('checked', false);
          this.$el.find('#ref_radio4').prop('checked', false);
          return this.$el.find('#ref_radio5').prop('checked', false);
        },
        'click #submitform': function(e) {
          e.preventDefault();
          this.$el.find('#hideshow').addClass('collapsed');
          this.$el.find('#collapseOne').removeClass('collapse in');
          this.$el.find('#collapseOne').addClass('collapse');
          return this.trigger("filter:member:info", Backbone.Syphon.serialize(this));
        },
        'click .ref_class': function(e) {
          this.$el.find('#ref_point1').val('false');
          this.$el.find('#ref_point2').val('false');
          this.$el.find('#ref_point3').val('false');
          this.$el.find('#ref_point4').val('false');
          this.$el.find('#ref_point5').val('false');
          this.$el.find('#ref_radio' + e.target.value).prop('checked', true);
          return this.$el.find('#ref_point' + e.target.value).val('true');
        },
        'click #status_check': function(e) {
          this.$el.find('#status1').prop('checked', true);
          this.$el.find('#status2').prop('checked', true);
          this.$el.find('#status3').prop('checked', true);
          this.$el.find('#status4').prop('checked', true);
          return this.$el.find('#status5').prop('checked', true);
        },
        'click #status_uncheck': function(e) {
          this.$el.find('#status1').prop('checked', false);
          this.$el.find('#status2').prop('checked', false);
          this.$el.find('#status3').prop('checked', false);
          this.$el.find('#status4').prop('checked', false);
          return this.$el.find('#status5').prop('checked', false);
        },
        'click #point_check': function(e) {
          this.$el.find('#point1').prop('checked', true);
          this.$el.find('#point2').prop('checked', true);
          this.$el.find('#point3').prop('checked', true);
          this.$el.find('#point4').prop('checked', true);
          this.$el.find('#point5').prop('checked', true);
          return this.$el.find('#point6').prop('checked', true);
        },
        'click #point_uncheck': function(e) {
          this.$el.find('#point1').prop('checked', false);
          this.$el.find('#point2').prop('checked', false);
          this.$el.find('#point3').prop('checked', false);
          this.$el.find('#point4').prop('checked', false);
          this.$el.find('#point5').prop('checked', false);
          return this.$el.find('#point6').prop('checked', false);
        },
        'click .point_class': function(e) {
          this.$el.find('#point_check1').val('false');
          this.$el.find('#point_check2').val('false');
          this.$el.find('#point_check3').val('false');
          this.$el.find('#point_check4').val('false');
          this.$el.find('#point_check5').val('false');
          this.$el.find('#point' + e.target.value).prop('checked', true);
          return this.$el.find('#point_check' + e.target.value).val('true');
        }
      };

      return ProgramMember;

    })(Marionette.CompositeView);
  });
});
