var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.Member", function(Member, App) {
    var API, MemberCollection, clonedCollection, memberCollection, newMemberCollection;
    Member = (function(_super) {
      __extends(Member, _super);

      function Member() {
        return Member.__super__.constructor.apply(this, arguments);
      }

      Member.prototype.idAttribute = 'ID';

      Member.prototype.defaults = {
        display_name: '',
        referral_count: '',
        user_registered: '',
        customer: '',
        email: '',
        phone: '',
        user_login: '',
        points: '',
        purchased_ref: '',
        ref_discussion: '',
        status: '',
        action: '',
        confirmed: '',
        option: '',
        redem_date: '',
        date_confirm: '',
        option_arr: '',
        user_role: '',
        customer_val: '',
        rejected_status: '',
        history: '',
        history_date: '',
        history_status: '',
        user: ''
      };

      Member.prototype.name = 'member';

      return Member;

    })(Backbone.Model);
    MemberCollection = (function(_super) {
      __extends(MemberCollection, _super);

      function MemberCollection() {
        return MemberCollection.__super__.constructor.apply(this, arguments);
      }

      MemberCollection.prototype.model = Member;

      MemberCollection.prototype.filterbyname = function(data) {
        var events;
        events = this.filter(function(model) {
          var dat2, data1, data2, point1, point2, point3, point4, point5, point6, ref1, ref2, ref3, ref4, ref5, status1, status2, status3, status4, status5;
          if (data.customer) {
            data1 = model.get('customer') === 'true';
          } else {
            data1 = false;
          }
          if (data.noncustomer) {
            data2 = model.get('customer') === 'false' || model.get('customer') === '';
          } else {
            dat2 = false;
          }
          if (data.ref_radio1) {
            ref1 = model.get('referral_count') === 0;
          } else {
            ref1 = false;
          }
          if (data.ref_radio2) {
            ref2 = model.get('referral_count') <= 5 && model.get('referral_count') >= 1;
          } else {
            ref2 = false;
          }
          if (data.ref_radio3) {
            ref3 = model.get('referral_count') <= 10 && model.get('referral_count') >= 6;
          } else {
            ref3 = false;
          }
          if (data.ref_radio4) {
            ref4 = model.get('referral_count') <= 50 && model.get('referral_count') >= 11;
          } else {
            ref4 = false;
          }
          if (data.ref_radio5) {
            ref5 = model.get('referral_count') > 50;
          } else {
            ref5 = false;
          }
          if (data.point1) {
            point1 = model.get('points') === 0;
          } else {
            point1 = false;
          }
          if (data.point2) {
            point2 = model.get('points') >= 1 && model.get('points') <= 2;
          } else {
            point2 = false;
          }
          if (data.point3) {
            point3 = model.get('points') >= 3 && model.get('points') <= 5;
          } else {
            point3 = false;
          }
          if (data.point4) {
            point4 = model.get('points') >= 6 && model.get('points') <= 10;
          } else {
            point4 = false;
          }
          if (data.point6) {
            point6 = model.get('points') >= 11 && model.get('points') <= 50;
          } else {
            point6 = false;
          }
          if (data.point5) {
            point5 = model.get('points') > 50;
          } else {
            point5 = false;
          }
          if (data.status1) {
            status1 = model.get('status') === 'Redemption Not initiated';
          } else {
            status1 = false;
          }
          if (data.status2) {
            status2 = model.get('status') === 'Initiated';
          } else {
            status2 = false;
          }
          if (data.status3) {
            status3 = model.get('status') === 'Approved';
          } else {
            status3 = false;
          }
          if (data.status4) {
            status4 = model.get('status') === 'Confirmed';
          } else {
            status4 = false;
          }
          if (data.status5) {
            status5 = model.get('status') === 'closed';
          } else {
            status5 = false;
          }
          return (data1 || data2) && (ref1 || ref2 || ref3 || ref4 || ref5) && (point1 || point2 || point3 || point4 || point5 || point6) && (status1 || status2 || status3 || status4 || status5);
        });
        return events;
      };

      MemberCollection.prototype.url = function() {
        return AJAXURL + '?action=get-members';
      };

      return MemberCollection;

    })(Backbone.Collection);
    memberCollection = new MemberCollection;
    newMemberCollection = new MemberCollection;
    clonedCollection = new MemberCollection;
    API = {
      getMembers: function() {
        clonedCollection.fetch();
        memberCollection.fetch();
        return memberCollection;
      },
      filterMembers: function(data) {
        var memberArray;
        memberArray = clonedCollection.filterbyname(data);
        return memberArray;
      },
      getProgramMemberUser: function(id) {
        var program_member;
        program_member = clonedCollection.get(id);
        if (!program_member) {
          program_member = new Member({
            ID: id
          });
          program_member.fetch({
            data: {
              action: 'get_pm_model',
              userid: id
            }
          });
          memberCollection.add(program_member);
        }
        return program_member;
      },
      getNewCollection: function(data) {
        return data;
      },
      getClonedCollection: function(data) {
        return clonedCollection.reset(data);
      }
    };
    App.reqres.setHandler("get:member:collection", function() {
      return API.getMembers();
    });
    App.reqres.setHandler("filter:member:model", function(data) {
      return API.filterMembers(data);
    });
    App.reqres.setHandler("get:program_member:data", function(ID) {
      return API.getProgramMemberUser(ID);
    });
    App.reqres.setHandler("get:new:collection", function(data) {
      return API.getNewCollection(data);
    });
    return App.reqres.setHandler("change:cloned:Collection", function(data) {
      return API.getClonedCollection(data);
    });
  });
});
