var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/referrallist/referrallistView'], function(App, RegionController) {
  return App.module("Add", function(Add, App) {
    var referrallistController;
    referrallistController = (function(_super) {
      __extends(referrallistController, _super);

      function referrallistController() {
        this._exportCSV = __bind(this._exportCSV, this);
        return referrallistController.__super__.constructor.apply(this, arguments);
      }

      referrallistController.prototype.initialize = function() {
        var view;
        this.referrallistCollection = App.request("get:referrallist:collection");
        this.view = view = this._getReferrallistCollectionView(this.referrallistCollection);
        this.listenTo(view, "filter:referral:info", this._filterReferral);
        this.listenTo(view, "export:to:csv", this._exportCSV);
        return App.execute("when:fetched", [this.referrallistCollection], (function(_this) {
          return function() {
            return _this.show(view);
          };
        })(this));
      };

      referrallistController.prototype._getReferrallistCollectionView = function(referrallistCollection) {
        console.log(referrallistCollection);
        return new Add.Views.List({
          collection: referrallistCollection,
          templateHelpers: {
            roles: ROLES,
            AJAXURL: AJAXURL
          }
        });
      };

      referrallistController.prototype._filterReferral = function(data) {
        var newMemberCollection;
        newMemberCollection = App.request("filter:referral:model", data);
        this.referrallistCollection.reset(newMemberCollection);
        return $("#referrallist_table").trigger("update");
      };

      referrallistController.prototype._exportCSV = function(data) {
        var object;
        object = this;
        return window.location.href = AJAXURL + '?action=export_csv&from_date=' + data.from_date + '&to_date=' + data.to_date + '&status1=' + data.status1 + '&status2=' + data.status2 + '&coll=' + this.referrallistCollection;
      };

      return referrallistController;

    })(RegionController);
    return App.commands.setHandler("show:referralslist", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new referrallistController;
    });
  });
});
