var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/referrals/referralview'], function(App, RegionController) {
  return App.module("Add", function(Add, App) {
    var Referralcontroller;
    Referralcontroller = (function(_super) {
      __extends(Referralcontroller, _super);

      function Referralcontroller() {
        this.showRef = __bind(this.showRef, this);
        return Referralcontroller.__super__.constructor.apply(this, arguments);
      }

      Referralcontroller.prototype.initialize = function() {
        var view;
        this.referralCollection = App.request("get:referral:collection");
        this.view = view = this._getReferralView(this.referralCollection);
        this.listenTo(view, "itemview:create:new:referral", this._addReferral);
        this.listenTo(view, "save:new:user", this._saveUser);
        return this.show(view);
      };

      Referralcontroller.prototype._getReferralView = function(referralCollection) {
        return new Add.Views.Referral({
          collection: referralCollection
        });
      };

      Referralcontroller.prototype._addReferral = function() {
        var referralModel;
        referralModel = App.request("create:referral:model");
        return this.referralCollection.add(referralModel);
      };

      Referralcontroller.prototype._saveUser = function(data) {
        var object;
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + '?action=get_userdata',
          data: data,
          success: function(result) {
            return object.showRef(result);
          }
        }, {
          error: function(result) {
            return object.showRef(result);
          }
        });
      };

      Referralcontroller.prototype.showRef = function(result) {
        return this.view.triggerMethod("new:referrals:added", result);
      };

      return Referralcontroller;

    })(RegionController);
    return App.commands.setHandler("show:referrals", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new Referralcontroller(opt);
    });
  });
});
