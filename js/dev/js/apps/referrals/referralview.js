var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/referrals/templates/referrallist.html'], function(App, referralTpl) {
  return App.module("Add.Views", function(Views, App) {
    var SingleView, add_array, count_val, counter, delete_array;
    add_array = Array();
    delete_array = Array();
    counter = 0;
    count_val = 0;
    SingleView = (function(_super) {
      __extends(SingleView, _super);

      function SingleView() {
        return SingleView.__super__.constructor.apply(this, arguments);
      }

      SingleView.prototype.tagName = 'tr';

      SingleView.prototype.id = 'id';

      SingleView.prototype.template = '<td class="v-align-middle "><div class="table_mob_hidden">Name</div><input class="itemAdd" data-id="0" name="referral_name{{id}}" type="text" id="referral_name{{id}}" size="20" /></td> <td class="v-align-middle del "><div class="table_mob_hidden">Email</div><input data-id="{{id}}" name="referral_email{{id}}" class="email_check"  type="email" id="referral_email{{id}}" size="20" /> <span style="display:none" id="span{{id}}" class="field-validation-error" data-valmsg-for="UserName" data-valmsg-replace="true"> <span for="UserName" generated="true" class="">Any 1 of these fields is required</span></span></td> <td class="v-align-middle del"><div class="table_mob_hidden">Contact No.*</div><input class="email_check form " data-id="{{id}}" name="referral_phone{{id}}"  type="tel" id="referral_phone{{id}}"  /> <span style="display:none" id="span_phone{{id}}" class="field-validation-error" data-valmsg-for="UserName" data-valmsg-replace="true"> <span for="UserName" generated="true" class="">Any 1 of these fields is required</span></span><span style="display:none" id="phonecheck{{id}}" class="field-validation-error" data-valmsg-for="UserName" data-valmsg-replace="true"> <span for="UserName" generated="true" class="">Not a valid Contact No</span></span></td> <td class="v-align-middle "><div class="table_mob_hidden">City</div><input name="referral_city{{id}}" type="text" id="referral_city{{id}}" size="20" /></td> <td><button  class="close m-t-8 delete-referral hidden" type="button">×</button><input type="hidden" name="hide{{id}}" id="hide{{id}}" value="0" /></td>';

      SingleView.prototype.events = {
        'focus .itemAdd': function(e) {
          var trselect;
          trselect = this.$el.find(e.target).closest("tr").is('tr:last');
          this.$el.find(e.target).closest("tr").attr('id', 'row' + this.model.id);
          if (trselect) {
            return this.trigger("create:new:referral");
          }
        },
        'click .delete-referral': function(e) {
          $('#row' + this.model.id).hide();
          return this.model.destroy();
        },
        'change .email_check': function(e) {
          var element, index, index_del, span, span_phone;
          element = this.$('#' + e.target.id).attr('data-id');
          span = 'span' + element;
          span_phone = 'span_phone' + element;
          if (e.target.value !== "") {
            add_array.push(this.model.id);
            delete_array.push(this.model.id);
            add_array = _.uniq(add_array);
            delete_array = _.uniq(delete_array);
            return console.log(delete_array);
          } else {
            index = add_array.indexOf(this.model.id);
            add_array.splice(index, 1);
            index_del = delete_array.indexOf(this.model.id);
            delete_array.splice(index_del, 1);
            add_array = _.uniq(add_array);
            delete_array = _.uniq(delete_array);
            this.$el.find("#" + span + ".field-validation-error").css('display', 'none');
            return this.$el.find("#" + span_phone + ".field-validation-error").css('display', 'none');
          }
        },
        'keypress .email_check': function(e) {
          var element, span, span_phone;
          element = this.$('#' + e.target.id).attr('data-id');
          span = 'span' + element;
          span_phone = 'span_phone' + element;
          if (e.target.value === "") {
            this.$el.find("#" + span + ".field-validation-error").css('display', 'none');
            return this.$el.find("#" + span_phone + ".field-validation-error").css('display', 'none');
          }
        },
        'keydown  .form': function(e) {
          var element;
          element = this.$('#' + e.target.id).attr('data-id');
          return this.$el.find("#phonecheck" + element + ".field-validation-error").css({
            'display': 'none'
          });
        }
      };

      SingleView.prototype.onShow = function() {
        return $('input[type="tel"]').intlTelInput({
          preferredCountries: ["in", "us", "gb"]
        });
      };

      return SingleView;

    })(Marionette.ItemView);
    return Views.Referral = (function(_super) {
      __extends(Referral, _super);

      function Referral() {
        return Referral.__super__.constructor.apply(this, arguments);
      }

      Referral.prototype.template = referralTpl;

      Referral.prototype.className = 'login-container';

      Referral.prototype.itemView = SingleView;

      Referral.prototype.emptyView = SingleView;

      Referral.prototype.itemViewContainer = 'table#referral_table tbody';

      Referral.prototype.collectionEvents = {
        'add reset remove': 'showHideDeleteButton'
      };

      Referral.prototype.showHideDeleteButton = function(model) {
        var num_rows;
        if (this.collection.length >= 2) {
          num_rows = this.collection.length;
          return $('.delete-referral').removeClass('hidden');
        } else {
          return $('.delete-referral').addClass('hidden');
        }
      };

      Referral.prototype.events = {
        'click #customer': function(e) {
          if (this.$el.find("#customer").prop('checked', true)) {
            return this.$el.find("#customer").val(1);
          } else {
            return this.$el.find("#customer").val(0);
          }
        },
        'keydown  #program_member_phone': function(e) {
          return this.$el.find("#programphone.field-validation-error").css({
            'display': 'none'
          });
        },
        'submit #referral_form': function(e) {
          var add_string, element, flag, hide, index, phonecheck, phoneno, program_member_phone, referral_email, referral_phone, span, span_phone, _i, _len;
          this.$el.find('.success').remove();
          this.$el.find('.danger').remove();
          this.$el.find('.info').remove();
          this.$el.find('.custom_table').remove();
          this.$el.find('.ref_msg').remove();
          flag = 0;
          program_member_phone = this.$el.find('#program_member_phone').val();
          phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})([0-9]{4})([0-9]{2})$/;
          if (program_member_phone !== "") {
            if (program_member_phone.match(phoneno)) {
              counter = 0;
              this.$el.find("#programphone.field-validation-error").css({
                'display': 'none'
              });
            } else {
              counter = 1;
              console.log("message");
              this.$el.find("#programphone.field-validation-error").css({
                'display': 'block',
                'color': 'red'
              });
            }
          }
          if (parseInt(add_array.length) === 0) {
            this.$el.find('.alert').remove();
            this.$el.find("#referral_form").before('<div class="alert alert-info ref_msg"> <button data-dismiss="alert" class="close"></button> Please enter details of at least one referral. </div>');
            return false;
          }
          e.preventDefault();
          console.log(delete_array);
          for (index = _i = 0, _len = delete_array.length; _i < _len; index = ++_i) {
            element = delete_array[index];
            referral_email = 'referral_email' + element;
            referral_phone = 'referral_phone' + element;
            span = 'span' + element;
            span_phone = 'span_phone' + element;
            phonecheck = "phonecheck" + element;
            hide = 'hide' + element;
            if (parseInt(this.$el.find("#" + hide).val()) === 0) {
              if (this.$el.find("#" + referral_email).val() === "" && this.$el.find("#" + referral_phone).val() === "") {
                flag = 1;
                this.$el.find("#" + span + ".field-validation-error").css({
                  'display': 'block',
                  'color': 'red'
                });
                this.$el.find("#" + span_phone + ".field-validation-error").css({
                  'display': 'block',
                  'color': 'red'
                });
              } else {
                flag = 0;
                this.$el.find("#" + span + ".field-validation-error").css('display', 'none');
                this.$el.find("#" + span_phone + ".field-validation-error").css('display', 'none');
              }
              phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})([0-9]{4})([0-9]{2})$/;
              console.log(referral_phone);
              if (this.$el.find("#" + referral_phone).val() !== "") {
                if (this.$el.find("#" + referral_phone).val().match(phoneno)) {
                  flag = 0;
                  this.$el.find("#" + phonecheck + ".field-validation-error").css({
                    'display': 'none'
                  });
                } else {
                  flag = 1;
                  console.log("message11");
                  this.$el.find("#" + phonecheck + ".field-validation-error").css({
                    'display': 'block',
                    'color': 'red'
                  });
                }
              }
            }
          }
          if (flag === 0 && counter === 0) {
            if (this.$el.find("#referral_form").valid()) {
              this.$el.find('.alert').remove();
              this.$el.find('#referral_add').attr('disabled', true);
              this.$el.find('.form-actions .pace-inactive').show();
              add_string = add_array.join(',');
              this.$el.find('#num_ref').val(add_string);
              this.trigger("save:new:user", Backbone.Syphon.serialize(this));
              add_array.length = 0;
              return delete_array.length = 0;
            }
          }
        }
      };

      Referral.prototype.onShow = function() {
        var element, new_array, num_array, _i, _len;
        new_array = Array();
        num_array = Array("1", "2", "3");
        for (_i = 0, _len = num_array.length; _i < _len; _i++) {
          element = num_array[_i];
          new_array.push(element);
          this.trigger("itemview:create:new:referral");
        }
        return $('input[type="tel"]').intlTelInput({
          preferredCountries: ["in", "us", "gb"]
        });
      };

      Referral.prototype.onNewReferralsAdded = function(response) {
        var accept, accepted_msg, element, message, reject, rejected_msg, table, _i, _j, _len, _len1;
        reject = response.data['reject'];
        accept = response.data['accept'];
        accepted_msg = "";
        rejected_msg = "";
        message = "";
        table = "<table class='table table-bordered m-b-20'><thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>City</th><th>Status</th></tr></thead>";
        if (response.data['reject'].length === 0) {
          accepted_msg = '<div class="ref_msg">Done! Your referrals have been added into our system. Thank you!</div><button class="close close_ref_msg" data-dismiss="alert"></button>';
        } else if (response.data['accept'].length === 0) {
          rejected_msg = '<div class="ref_msg">Sorry, looks like your referrals are already present with us. Why don\'t you try adding some more.</div><button class="close close_ref_msg" data-dismiss="alert"></button>';
        } else if (response.data['reject'].length !== 0 && response.data['accept'].length !== 0) {
          message = '<div class="ref_msg">Thank you for the referrals. Looks like some of the referrals are present with us, but don\'t worry we will add the others.</div><button class="close close_ref_msg" data-dismiss="alert"></button>';
        }
        for (_i = 0, _len = accept.length; _i < _len; _i++) {
          element = accept[_i];
          table += "<tr><td>" + element.referral_name + "</td><td>" + element.referral_email + "</td> <td>" + element.referral_phone + "</td><td>" + element.referral_city + "</td><td>" + element.status + "</td></tr>";
        }
        for (_j = 0, _len1 = reject.length; _j < _len1; _j++) {
          element = reject[_j];
          table += "<tr><td>" + element.referral_name + "</td><td>" + element.referral_email + "</td> <td>" + element.referral_phone + "</td><td>" + element.referral_city + "</td><td>" + element.status + "</td></tr>";
        }
        table += "<table>";
        this.$el.find('.form-actions .pace-inactive').hide();
        this.$el.find("#referral_form").before('<div class="custom_table alert alert-info">' + accepted_msg + rejected_msg + message + '<p class="pull-left m-b-10 semi-bold">Following are your referrals and their status</p>' + table + '</div>');
        this.$el.find('#referral_add').attr('disabled', false);
        this.$el.find('#msg_text').addClass('hidden');
        return this.$el.find('button[type="reset"]').trigger('click');
      };

      return Referral;

    })(Marionette.CompositeView);
  });
});