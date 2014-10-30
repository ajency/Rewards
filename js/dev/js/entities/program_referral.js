var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.Program.Referral", function(Referral, App) {
    var API, ReferralCollection, referralCollection;
    Referral = (function(_super) {
      __extends(Referral, _super);

      function Referral() {
        return Referral.__super__.constructor.apply(this, arguments);
      }

      Referral.prototype.defaults = {
        'name': '',
        'email': '',
        'phone': '',
        'customer': '',
        'registered_date': ''
      };

      Referral.prototype.name = 'program_referral';

      return Referral;

    })(Backbone.Model);
    ReferralCollection = (function(_super) {
      __extends(ReferralCollection, _super);

      function ReferralCollection() {
        return ReferralCollection.__super__.constructor.apply(this, arguments);
      }

      ReferralCollection.prototype.model = Referral;

      ReferralCollection.prototype.url = function() {
        return AJAXURL;
      };

      return ReferralCollection;

    })(Backbone.Collection);
    referralCollection = new ReferralCollection;
    API = {
      getReferrals: function(ID) {
        console.log(referralCollection);
        return referralCollection;
      }
    };
    return App.reqres.setHandler("get:referral:data", ID(function() {
      return API.getReferral(ID);
    }));
  });
});
