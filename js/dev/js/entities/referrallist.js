var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.Referrallist", function(Referrallist, App) {
    var API, ReferrallistCollection, clonedRefCollection, referrallistCollection;
    Referrallist = (function(_super) {
      __extends(Referrallist, _super);

      function Referrallist() {
        return Referrallist.__super__.constructor.apply(this, arguments);
      }

      Referrallist.prototype.idAttribute = 'ID';

      Referrallist.prototype.defaults = {
        display_name: '',
        program_name: '',
        status: '',
        date: '',
        date_import: '',
        datevalue: ''
      };

      Referrallist.prototype.name = 'referrallist';

      return Referrallist;

    })(Backbone.Model);
    ReferrallistCollection = (function(_super) {
      __extends(ReferrallistCollection, _super);

      function ReferrallistCollection() {
        return ReferrallistCollection.__super__.constructor.apply(this, arguments);
      }

      ReferrallistCollection.prototype.model = Referrallist;

      ReferrallistCollection.prototype.url = function() {
        return AJAXURL + '?action=get-referrallist';
      };

      ReferrallistCollection.prototype.filterbydata = function(data) {
        var events1;
        events1 = this.filter(function(model) {
          var datecompare, status1, status2;
          if (data.status1) {
            status1 = model.get('status') === 'New Referral';
          } else {
            status1 = false;
          }
          if (data.status2) {
            status2 = model.get('status') === 'Converted';
          } else {
            status2 = false;
          }
          datecompare = true;
          if (data.from_date !== "" && data.to_date !== "") {
            if (data.from_date <= model.get('datevalue') && model.get('datevalue') <= data.to_date) {
              datecompare = true;
            } else {
              datecompare = false;
            }
          }
          return (status1 || status2) && datecompare;
        });
        return events1;
      };

      return ReferrallistCollection;

    })(Backbone.Collection);
    referrallistCollection = new ReferrallistCollection;
    clonedRefCollection = new ReferrallistCollection;
    API = {
      getRedemption: function() {
        referrallistCollection.fetch({
          reset: true
        });
        clonedRefCollection.fetch({
          reset: true
        });
        return referrallistCollection;
      },
      filterReferral: function(data) {
        var memberArray;
        memberArray = clonedRefCollection.filterbydata(data);
        return memberArray;
      }
    };
    App.reqres.setHandler("get:referrallist:collection", function(opt) {
      return API.getRedemption();
    });
    return App.reqres.setHandler("filter:referral:model", function(data) {
      return API.filterReferral(data);
    });
  });
});
