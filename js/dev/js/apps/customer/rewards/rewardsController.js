var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/customer/rewards/rewardsView'], function(App, RegionController) {
  return App.module("Rewards", function(Rewards, App) {
    var RewardsController;
    RewardsController = (function(_super) {
      __extends(RewardsController, _super);

      function RewardsController() {
        this._getRewardsModelView = __bind(this._getRewardsModelView, this);
        this._getCustomerShippingView = __bind(this._getCustomerShippingView, this);
        this.showRef = __bind(this.showRef, this);
        this._saveRedemption = __bind(this._saveRedemption, this);
        return RewardsController.__super__.constructor.apply(this, arguments);
      }

      RewardsController.prototype.initialize = function(opt) {
        var view;
        this.region = opt.region;
        this.username = opt.username;
        this.topRegion = opt.topRegion;
        this.ID = opt.ID;
        this.rewardsCollection = App.request("get:rewards:collection", opt);
        this.view = view = this._getCustomerRewardsView(this.rewardsCollection, this.ID);
        this.listenTo(view, "save:inititate:redemption", this._saveRedemption);
        this.listenTo(view, "change:customerShipping:view", this._getCustomerShippingView);
        this.listenTo(view, "get:rewards:model", this._getRewardsModelView);
        return App.execute("when:fetched", [this.rewardsCollection], (function(_this) {
          return function() {
            return _this.show(view);
          };
        })(this));
      };

      RewardsController.prototype._getCustomerRewardsView = function(rewardsCollection, ID) {
        return new Rewards.Views.ListRewards({
          collection: rewardsCollection,
          ID: ID
        });
      };

      RewardsController.prototype._saveRedemption = function(id) {
        var object;
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + '?action=save_redemption',
          data: 'optionid=' + id + '&username=' + object.username,
          success: function(result) {
            return object.showRef(result);
          }
        }, {
          error: function(result) {}
        });
      };

      RewardsController.prototype.showRef = function(data) {
        return this.view.triggerMethod("new:redemption:added", data);
      };

      RewardsController.prototype._getCustomerShippingView = function(option) {
        return App.execute("show:shipping", {
          region: this.region,
          username: this.username,
          option: option,
          ID: this.ID,
          topRegion: this.topRegion
        });
      };

      RewardsController.prototype._getRewardsModelView = function(option) {
        var model;
        model = App.request("get:new:rewards:model", option);
        this.rewardsCollection.reset(model);
        return App.execute("when:fetched", [this.rewardsCollection], (function(_this) {
          return function() {
            return _this.show(_this.view);
          };
        })(this));
      };

      return RewardsController;

    })(RegionController);
    return App.commands.setHandler("show:info", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new RewardsController(opt);
    });
  });
});
