var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/program-member/members/templates/member_info.html'], function(App, memberTpl) {
  return App.module("Member.Views", function(Views, App) {
    var packages_arr;
    packages_arr = Array();
    return Views.Info = (function(_super) {
      __extends(Info, _super);

      function Info() {
        return Info.__super__.constructor.apply(this, arguments);
      }

      Info.prototype.template = memberTpl;

      Info.prototype.events = {
        'click .confirm_reminder': function(e) {
          return this.trigger("set:new:redemption", this.model.get('option'), this.model.get('user_login'), this.$el.find('#delivery').val());
        },
        'click .reject_reminder': function(e) {
          return this.trigger("set:rejected:redemption", this.model.get('option'), this.model.get('user_login'));
        },
        'click #ini_redemption': function(e) {
          return this.trigger("get:options:list");
        },
        'click #send_remin': function(e) {
          this.$el.find('#send_remin').attr('disabled', true);
          return this.trigger("send:closure:reminder", this.model.get('option'), this.model.get('ID'));
        },
        'click #send_ini_redemption': function(e) {
          if (packages_arr.length === 0) {
            return false;
          }
          this.$el.find('#send_ini_redemption').attr('disabled', true);
          return this.trigger("send:email:reminder", this.model.get('option'), this.model.get('ID'), this.$el.find("#packagestring").val());
        },
        'click .package_select': function(e) {
          var last, str;
          if ($('#' + e.target.id).prop('checked') === true) {
            packages_arr.push(e.target.value);
            str = packages_arr.join(',');
            return this.$el.find("#packagestring").val(str);
          } else {
            last = packages_arr.indexOf(e.target.value);
            packages_arr.splice(last, 1);
            str = packages_arr.join(',');
            return this.$el.find("#packagestring").val(str);
          }
        },
        'click #delivery': function(e) {
          if ($('#' + e.target.id).prop('checked') === true) {
            return $('#' + e.target.id).val(1);
          } else {
            return $('#' + e.target.id).val(0);
          }
        }
      };

      Info.prototype.onShow = function() {
        var points, rejected_status, stringname;
        stringname = this.model.get('status');
        rejected_status = this.model.get('rejected_status');
        points = this.model.get('points');
        stringname.replace(/\s/g, '');
        if (stringname === 'Approved') {
          $('#approved_send').removeClass('hidden');
          return $('#approved-redemt').hide();
        } else if (stringname === 'Redemption Not initiated' && rejected_status === 0) {
          $('#redem_not').removeClass('hidden');
          $('#noti_redem_not').addClass('hidden');
          if (parseInt(points) === 0) {
            return this.$el.find('#ini_redemption').hide();
          }
        } else if (stringname === 'Initiated') {
          return $('#initiated_div').removeClass('hidden');
        } else if (stringname === 'Confirmed') {
          $('#send_remin').removeClass('hidden');
          return $('#confirmed_div').removeClass('hidden');
        } else if (stringname === 'Redemption Not initiated' && rejected_status === 1) {
          return $('#redem_not').removeClass('hidden');
        } else if (stringname === 'closed') {
          return $('#closed').removeClass('hidden');
        }
      };

      Info.prototype.serializeData = function() {
        var customer, data;
        data = Info.__super__.serializeData.call(this);
        customer = this.model.get('customer');
        if (customer === "" || customer === 'false') {
          data.customer = 'Not an existing Customer';
        } else {
          data.customer = 'Existing Customer';
        }
        return data;
      };

      Info.prototype.onSaveRejectedRedemption = function(data) {
        var element, index, text_val, _i, _len, _ref;
        $('#redem_not').removeClass('hidden');
        $('#initiated_div').addClass('hidden');
        $('.status').text(data.status);
        $('#ini_redemption').text(data.action);
        console.log(data.initiated);
        text_val = "";
        text_val += '<div class="collapse-trigger collapsed" data-toggle="collapse" data-target="#history8"> View History <span class="glyphicon glyphicon-chevron-down pull-right"></span><span class="glyphicon glyphicon-chevron-up pull-right"></span> </div> <div id="history8" class="collapse">';
        _ref = data.initiated;
        for (index = _i = 0, _len = _ref.length; _i < _len; index = ++_i) {
          element = _ref[index];
          text_val += '<h5 class="">' + element.history_status + ' on : <span class="semi-bold rejected">' + element.history_date + '</span> by ' + data.user + '</h5> <div class="clearfix"></div>';
        }
        text_val += '</div></div>';
        $('#rejecteddiv').append(text_val);
        $('#rejecteddiv_original').hide();
        $('#rejecteddiv').removeClass('hidden');
        return $('#noti_redem_not').removeClass('hidden');
      };

      Info.prototype.onSaveApprovedRedemption = function(data) {
        var element, index, text_val, _i, _len, _ref;
        $('#redem_not').addClass('hidden');
        $('#initiated_div').addClass('hidden');
        $('#approved_send').removeClass('hidden');
        $('.status').text(data.status);
        $('#approved-redemt').hide();
        text_val = "";
        console.log(data.initiated);
        text_val += '<div class="collapse-trigger collapsed" data-toggle="collapse" data-target="#history7"> View History <span class="glyphicon glyphicon-chevron-down pull-right"></span><span class="glyphicon glyphicon-chevron-up pull-right"></span> </div> <div id="history7" class="collapse">';
        _ref = data.initiated;
        for (index = _i = 0, _len = _ref.length; _i < _len; index = ++_i) {
          element = _ref[index];
          text_val += '<h5 class="">' + element.history_status + ' on : <span class="semi-bold rejected">' + element.history_date + ' by ' + data.user + '</h5> <div class="clearfix"></div>';
        }
        text_val += '</div></div>';
        console.log(text_val);
        $('#approvediv').append(text_val);
        $('#approvediv_original').hide();
        return $('#approvediv').removeClass('hidden');
      };

      Info.prototype.onSendInitiateReminder = function() {
        $('.modal-backdrop.in').remove();
        $('body').removeClass('modal-open');
        this.$el.find(".email_message").after('<div class="alert alert-info ref_msg"> <button data-dismiss="alert" class="close"></button> Message has been sent. </div>');
        $('#ini_redemption').attr('disabled', false);
        $('#send_ini_redemption').attr('disabled', false);
        $('#packages_data').addClass('hidden');
        packages_arr = Array();
        return $("#packagestring").val("");
      };

      Info.prototype.onSendClosureReminder = function() {
        $('#send_remin').hide();
        $('#confirmed_div').addClass('hidden');
        return $('#closed').removeClass('hidden');
      };

      Info.prototype.onSetOptionList = function(data) {
        var element, index, product, template, _i, _len;
        console.log(data);
        product = data;
        template = "";
        if (product !== null) {
          for (index = _i = 0, _len = product.length; _i < _len; index = ++_i) {
            element = product[index];
            template += '<li> <div class="checkbox check-success "> <input id="customer' + element.ID + '" class="package_select" name="customer' + element.ID + '" type="checkbox" value="' + element.ID + '" > <label for="customer' + element.ID + '" style="padding-left:25px;"><b>' + element.option_name + '</b></label> </div> </li>';
          }
        }
        this.$el.find("ol").text("");
        this.$el.find("ol").append(template);
        return this.$el.find('#packages_data').removeClass('hidden');
      };

      return Info;

    })(Marionette.ItemView);
  });
});
