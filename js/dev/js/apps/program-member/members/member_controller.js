var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/program-member/members/member_view'], function(App, RegionController) {
  return App.module("Member", function(Member, App) {
    var MemberController;
    MemberController = (function(_super) {
      __extends(MemberController, _super);

      function MemberController() {
        this.optionList = __bind(this.optionList, this);
        this.sendClosureMail = __bind(this.sendClosureMail, this);
        this.sendInitiateMail = __bind(this.sendInitiateMail, this);
        this.rejectDetails = __bind(this.rejectDetails, this);
        this.confirmDetails = __bind(this.confirmDetails, this);
        return MemberController.__super__.constructor.apply(this, arguments);
      }

      MemberController.prototype.initialize = function(opt) {
        var view;
        this.ID = opt.ID;
        this.region = opt.topRegion;
        this.model = App.request("get:program_member:data", this.ID);
        this.view = view = this._getMembersView(this.model);
        this.listenTo(view, "set:new:redemption", this._setRedemption);
        this.listenTo(view, "set:rejected:redemption", this._setRejectedRedemption);
        this.listenTo(view, "send:email:reminder", this._sendNotInitiatedEmail);
        this.listenTo(view, "send:closure:reminder", this._sendClosureEmail);
        this.listenTo(view, "get:options:list", this._getOptionsList);
        return App.execute("when:fetched", [this.model], (function(_this) {
          return function() {
            return _this.show(view);
          };
        })(this));
      };

      MemberController.prototype._getMembersView = function(model) {
        return new Member.Views.Info({
          model: model
        });
      };

      MemberController.prototype._setRedemption = function(option, username, shipping) {
        var object;
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + "?action=set-redemption",
          data: 'option=' + option + '&username=' + username + '&shipping=' + shipping,
          success: function(result) {
            return object.confirmDetails(result);
          },
          error: function(result) {}
        });
      };

      MemberController.prototype._setRejectedRedemption = function(option, username) {
        var object;
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + "?action=set-rejected-redemption",
          data: 'option=' + option + '&username=' + username,
          success: function(result) {
            return object.rejectDetails(result);
          },
          error: function(result) {}
        });
      };

      MemberController.prototype.confirmDetails = function(data) {
        return this.view.triggerMethod("save:approved:redemption", data);
      };

      MemberController.prototype.rejectDetails = function(data) {
        return this.view.triggerMethod("save:rejected:redemption", data);
      };

      MemberController.prototype._sendNotInitiatedEmail = function(option, ID, str) {
        var object;
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + "?action=set-notinitiated-email",
          data: 'option=' + option + '&ID=' + ID + '&str=' + str,
          success: function(result) {
            return object.sendInitiateMail(result);
          },
          error: function(result) {}
        });
      };

      MemberController.prototype.sendInitiateMail = function(data) {
        return this.view.triggerMethod("send:Initiate:Reminder", data);
      };

      MemberController.prototype._sendClosureEmail = function(option, ID) {
        var object;
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + "?action=set-closure-email",
          data: 'option=' + option + '&ID=' + ID,
          success: function(result) {
            return object.sendClosureMail(result);
          },
          error: function(result) {}
        });
      };

      MemberController.prototype.sendClosureMail = function(data) {
        return this.view.triggerMethod("send:Closure:Reminder", data);
      };

      MemberController.prototype._getOptionsList = function() {
        var object;
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + "?action=get-option-list",
          data: '',
          success: function(result) {
            return object.optionList(result);
          },
          error: function(result) {}
        });
      };

      MemberController.prototype.optionList = function(data) {
        console.log(data);
        return this.view.triggerMethod("set:option:list", data);
      };

      return MemberController;

    })(RegionController);
    return App.commands.setHandler("show:member:info", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new MemberController(opt);
    });
  });
});
