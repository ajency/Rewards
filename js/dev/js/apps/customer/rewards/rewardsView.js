var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/customer/rewards/templates/rewards.html'], function(App, rewardsTpl) {
  return App.module("Rewards.Views", function(Views, App) {
    var RewardsView, checkArray, optionval, points;
    points = "";
    optionval = "";
    checkArray = [];
    RewardsView = (function(_super) {
      __extends(RewardsView, _super);

      function RewardsView() {
        return RewardsView.__super__.constructor.apply(this, arguments);
      }

      RewardsView.prototype.initialize = function() {
        var Id;
        return Id = this.model.get('disabled');
      };

      RewardsView.prototype.template = '<div id="reward{{ID}}" class="tiles white m-t-10 m-b-20 reward-container {{selected}}"> <div class="sel-indicator"><span class="glyphicon glyphicon-ok"></span> Selected Reward</div> <div class="row"> <div class="col-md-4"> <input type="radio"  id="option{{ID}}" {{disabled}} {{checked}} value="0" class="option_set" name=option"> <label class="pull-left m-t-20 radio-label" for="option{{ID}}"><span class="{{classname}} radio_txt_lrg pull-left semi-bold">{{option}}</span></label> <h4 class="semi-bold m-t-20">{{option}}</h4> </div> <div class="col-md-8"> <h4 class="{{classname}} semi-bold m-t-20">Points: {{min}}</h4> </div> <div class="clearfix"></div> <h5 class="m-t-10 p-l-15">{{option_desc}}</h5> <div class="clearfix"></div> <ol class="m-l-5 m-t-20 m-b-10 user_step_list"> {{#product_details}} <li><div class="rewards_img"> <img  src="{{product_img}}" class="hide-for-small"></div> <h4 class="m-t-5 semi-bold">{{product_name}}</h4> <h5 >{{product_details}}</h5> </li> {{/product_details}} </ol> </div>';

      RewardsView.prototype.events = {
        'click .reward-container': function(e) {
          var ID, check, element, optionid, _i, _len;
          ID = this.model.get('ID');
          for (_i = 0, _len = checkArray.length; _i < _len; _i++) {
            element = checkArray[_i];
            if (element === this.model.get('ID')) {
              $("#option" + ID).val('1');
            } else {
              $("#option" + ID).val('0');
              checkArray = [];
            }
          }
          this.$el.find(".ref_msg1").remove();
          this.$el.find(".ref_msg").remove();
          optionid = this.model.get('ID');
          console.log(parseInt(this.$el.find("#option" + ID).val()));
          $('.reward-container').removeClass('selected');
          $('.option_set').attr('checked', false);
          console.log(check = this.model.get('disabled'));
          if (parseInt(this.$el.find("#option" + ID).val()) === 0) {
            checkArray.push(this.model.get('ID'));
            optionval = this.model.get('ID');
            if (check !== 'disabled') {
              this.$el.find('.reward-container').removeClass('selected');
              this.$el.find('.option_set').attr('checked', false);
              this.$el.find("#reward" + ID).addClass('selected');
              return this.$el.find("#option" + ID).attr('checked', true);
            } else {
              return this.$el.find("#reward" + ID).before('<div class="ref_msg1 alert alert-error m-b-5 m-t-20"><button data-dismiss="alert" class="close"></button>You Don\'t have enough points</div>');
            }
          } else {
            this.$el.find('.reward-container').removeClass('selected');
            this.$el.find('.option_set').attr('checked', false);
            $("#option" + ID).val("0");
            checkArray = [];
            return optionval = "";
          }
        }
      };

      return RewardsView;

    })(Marionette.ItemView);
    return Views.ListRewards = (function(_super) {
      __extends(ListRewards, _super);

      function ListRewards() {
        return ListRewards.__super__.constructor.apply(this, arguments);
      }

      ListRewards.prototype.template = rewardsTpl;

      ListRewards.prototype.className = "padding-20";

      ListRewards.prototype.initialize = function() {
        this.collection.trigger('reset');
        return points = Marionette.getOption(this, 'ID');
      };

      ListRewards.prototype.itemView = RewardsView;

      ListRewards.prototype.itemViewContainer = 'div#rewardsdata';

      ListRewards.prototype.events = {
        'click #confirm_redempt': function() {
          this.$el.find(".ref_msg1").remove();
          this.$el.find(".ref_msg").remove();
          console.log(optionval);
          console.log(this.$el.find("#pointer_val_field").val());
          if (optionval !== "" && parseInt(this.$el.find("#pointer_val_field").val()) !== 0) {
            $("#lireferrals").removeClass('active');
            $("#lishipping").addClass('active');
            $("#lirewards").removeClass('active');
            return this.trigger("change:customerShipping:view", optionval);
          } else {
            return this.$el.find("#rewardsdata").before('<div class="ref_msg alert alert-error m-b-5 m-t-20"><button data-dismiss="alert" class="close"></button>Please select an option</div>');
          }
        }
      };

      ListRewards.prototype.onShow = function() {
        var object;
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + '?action=get_points',
          data: 'username=' + points,
          success: function(result) {
            var option, status, text_msg;
            object.$el.find("#pointer_val_field").val(result.points);
            object.$el.find("#pointer_val").text(result.points);
            option = result.option;
            optionval = result.option;
            if (optionval === null) {
              optionval = "";
            }
            if (result.status === "" || result.status === 'Redemption Not initiated') {
              status = 'Redemption Not Initiated';
              text_msg = 'Select a reward package to initiate redemption of points.';
            }
            if (result.status === "Initiated") {
              console.log(result.status);
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
              status = 'Closed';
              text_msg = 'Redemption process complete and closed.';
            }
            console.log(status);
            console.log(text_msg);
            object.$el.find("#redemption_status").text(status);
            object.$el.find("#redemption_msg").text(text_msg);
            if (result.status === 'Approved' || result.status === 'Confirmed' || result.status === 'Initiated' || result.status === 'closed') {
              object.trigger("get:rewards:model", option);
              object.$el.find("#pointer_val_field").val(result.points);
              object.$el.find("#pointer_val").text(result.points);
              object.$el.find("#redemption_status").text(status);
              return object.$el.find("#redemption_msg").text(text_msg);
            }
          },
          error: function(result) {}
        });
      };

      ListRewards.prototype.onNewRedemptionAdded = function(data) {
        return console.log(data);
      };

      return ListRewards;

    })(Marionette.CompositeView);
  });
});
