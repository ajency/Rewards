var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/program-member/members/member_controller', 'apps/program-member/referrals/referral_controller', 'apps/customer/customerHead/customerHeadController', 'apps/customer/Info/InfoController', 'apps/customer/rewards/rewardsController', 'apps/customer/shipping/shippingController', 'text!apps/program-member/templates/program_main.html'], function(App, RegionController, memberApp, referralApp, customerApp, InfoApp, RewardsApp, shippingApp, mainTpl) {
  return App.module("MainApp", function(MainApp, App) {
    var MainController, MainView;
    MainController = (function(_super) {
      __extends(MainController, _super);

      function MainController() {
        this._getMainView = __bind(this._getMainView, this);
        this.showViews = __bind(this.showViews, this);
        return MainController.__super__.constructor.apply(this, arguments);
      }

      MainController.prototype.initialize = function(opt) {
        var layout;
        this.ID = opt.ID;
        this.userid = opt.userid;
        this.layout = layout = this._getMainView();
        this.listenTo(layout, 'show', this.showViews);
        return this.show(layout);
      };

      MainController.prototype.showViews = function() {
        App.execute("show:member:info", {
          topRegion: this.layout.topRegion,
          ID: this.userid
        });
        App.execute("show:customer:head", {
          region: this.layout.bottomRegion,
          username: this.ID,
          subregion: this.layout.secondRegion,
          topRegion: this.layout.topRegion,
          ID: this.userid
        });
        return App.execute("show:customers", {
          region: this.layout.secondRegion,
          username: this.ID,
          topRegion: this.layout.topRegion,
          ID: this.userid
        });
      };

      MainController.prototype._getMainView = function() {
        return new MainView;
      };

      return MainController;

    })(RegionController);
    MainView = (function(_super) {
      __extends(MainView, _super);

      function MainView() {
        return MainView.__super__.constructor.apply(this, arguments);
      }

      MainView.prototype.template = mainTpl;

      MainView.prototype.className = '';

      MainView.prototype.regions = {
        topRegion: '#program-member-region',
        bottomRegion: '#referral-region',
        secondRegion: '#info-region'
      };

      return MainView;

    })(Marionette.Layout);
    return App.commands.setHandler("show:main:App", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new MainController(opt);
    });
  });
});
