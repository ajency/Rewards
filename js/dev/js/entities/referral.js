var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.Referral", function(Referral, App) {
    var API, ReferralCollection, itemCount, referralCollection;
    itemCount = 0;
    Referral = (function(_super) {
      __extends(Referral, _super);

      function Referral() {
        return Referral.__super__.constructor.apply(this, arguments);
      }

      Referral.prototype.initialize = function() {
        this.set('id', itemCount);
        return itemCount += 1;
      };

      Referral.prototype.name = 'referral';

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
      getReferrals: function() {
        return referralCollection;
      },
      createReferral: function() {
        return new Referral;
      }
    };
    App.reqres.setHandler("get:referral:collection", function() {
      return API.getReferrals();
    });
    return App.reqres.setHandler("create:referral:model", function() {
      return API.createReferral();
    });
  });
});
