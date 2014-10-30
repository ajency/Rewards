var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.ProgramMember", function(ProgramMember, App) {
    var API, ProgramMemberCollection, programMemberCollection;
    ProgramMember = (function(_super) {
      __extends(ProgramMember, _super);

      function ProgramMember() {
        return ProgramMember.__super__.constructor.apply(this, arguments);
      }

      ProgramMember.prototype.idAttribute = 'ID';

      ProgramMember.prototype.defaults = {
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
        initiated: '',
        confirmed: '',
        rejected: '',
        option: '',
        approved: '',
        date_confirm: ''
      };

      ProgramMember.prototype.name = 'programmember';

      return ProgramMember;

    })(Backbone.Model);
    ProgramMemberCollection = (function(_super) {
      __extends(ProgramMemberCollection, _super);

      function ProgramMemberCollection() {
        return ProgramMemberCollection.__super__.constructor.apply(this, arguments);
      }

      ProgramMemberCollection.prototype.model = ProgramMember;

      ProgramMemberCollection.prototype.url = function() {
        return AJAXURL + '?action=get-programmembers';
      };

      return ProgramMemberCollection;

    })(Backbone.Collection);
    programMemberCollection = new ProgramMemberCollection;
    API = {
      getMembers: function() {
        programMemberCollection.fetch();
        return programMemberCollection;
      }
    };
    return App.reqres.setHandler("get:programmember:data", function(ID) {
      return API.getProgramMemberUser(ID);
    });
  });
});
