var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.ReferralUser", function(ReferralUser, App) {
    var API, ReferralUserCollection, referralUserCollection;
    ReferralUser = (function(_super) {
      __extends(ReferralUser, _super);

      function ReferralUser() {
        return ReferralUser.__super__.constructor.apply(this, arguments);
      }

      ReferralUser.prototype.idAttribute = 'ID';

      ReferralUser.prototype.defaults = {
        name: '',
        phone: '',
        email: ''
      };

      ReferralUser.prototype.name = 'referralUser';

      return ReferralUser;

    })(Backbone.Model);
    ReferralUserCollection = (function(_super) {
      __extends(ReferralUserCollection, _super);

      function ReferralUserCollection() {
        return ReferralUserCollection.__super__.constructor.apply(this, arguments);
      }

      ReferralUserCollection.prototype.model = ReferralUser;

      ReferralUserCollection.prototype.url = function() {
        return AJAXURL + '?action=get-referrals';
      };

      return ReferralUserCollection;

    })(Backbone.Collection);
    referralUserCollection = new ReferralUserCollection;
    referralUserCollection.fetch();
    API = {
      getReferrals: function() {
        return referralUserCollection;
      }
    };
    return App.reqres.setHandler("get:referral:list", function() {
      return API.getReferrals();
    });
  });
});
