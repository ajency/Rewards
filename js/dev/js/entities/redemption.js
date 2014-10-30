var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.Redemption", function(Redemption, App) {
    var API, RedemptionCollection, redemptionCollection;
    Redemption = (function(_super) {
      __extends(Redemption, _super);

      function Redemption() {
        return Redemption.__super__.constructor.apply(this, arguments);
      }

      Redemption.prototype.idAttribute = 'ID';

      Redemption.prototype.defaults = {
        display_name: '',
        user_email: '',
        status: '',
        date: ''
      };

      Redemption.prototype.name = 'redemption';

      return Redemption;

    })(Backbone.Model);
    RedemptionCollection = (function(_super) {
      __extends(RedemptionCollection, _super);

      function RedemptionCollection() {
        return RedemptionCollection.__super__.constructor.apply(this, arguments);
      }

      RedemptionCollection.prototype.model = Redemption;

      RedemptionCollection.prototype.url = function() {
        return AJAXURL + '?action=get-redemption';
      };

      return RedemptionCollection;

    })(Backbone.Collection);
    redemptionCollection = new RedemptionCollection;
    API = {
      getRedemption: function() {
        redemptionCollection.fetch();
        return redemptionCollection;
      }
    };
    return App.reqres.setHandler("get:redemption:collection", function(opt) {
      return API.getRedemption();
    });
  });
});
