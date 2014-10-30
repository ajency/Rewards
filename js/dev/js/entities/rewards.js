var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.Rewards", function(Rewards, App) {
    var API, RewardsCollection, rewardsCollection;
    Rewards = (function(_super) {
      __extends(Rewards, _super);

      function Rewards() {
        return Rewards.__super__.constructor.apply(this, arguments);
      }

      Rewards.prototype.idAttribute = 'ID';

      Rewards.prototype.defaults = {
        option: '',
        product_name: '',
        product_price: '',
        product_details: '',
        product_img: '',
        sum_of_points: '',
        disabled: '',
        classname: '',
        option_desc: '',
        min: '',
        max: '',
        checked: '',
        selected: ''
      };

      Rewards.prototype.name = 'rewards';

      return Rewards;

    })(Backbone.Model);
    RewardsCollection = (function(_super) {
      __extends(RewardsCollection, _super);

      function RewardsCollection() {
        return RewardsCollection.__super__.constructor.apply(this, arguments);
      }

      RewardsCollection.prototype.model = Rewards;

      RewardsCollection.prototype.url = function() {
        return AJAXURL + '?action=get-rewards';
      };

      RewardsCollection.prototype.parse = function(resp) {
        return resp;
      };

      return RewardsCollection;

    })(Backbone.Collection);
    rewardsCollection = new RewardsCollection;
    API = {
      getRewards: function(opt) {
        rewardsCollection.fetch({
          reset: true,
          data: {
            username: opt.username
          }
        });
        return rewardsCollection;
      },
      editUser: function(id) {
        var reward;
        reward = rewardsCollection.get(id);
        reward.set('checked', 'checked');
        reward.set('selected', 'selected');
        if (!reward) {
          reward = new Rewards({
            ID: id
          });
          rewardsCollection.add(reward);
        }
        return reward;
      }
    };
    App.reqres.setHandler("get:rewards:collection", function(opt) {
      return API.getRewards(opt);
    });
    return App.reqres.setHandler("get:new:rewards:model", function(id) {
      return API.editUser(id);
    });
  });
});
