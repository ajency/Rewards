var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/program-member/programmember/program-member-view'], function(App, RegionController) {
  return App.module("Member", function(Member, App) {
    var ProgramMembersController;
    ProgramMembersController = (function(_super) {
      __extends(ProgramMembersController, _super);

      function ProgramMembersController() {
        this._changeCollection = __bind(this._changeCollection, this);
        return ProgramMembersController.__super__.constructor.apply(this, arguments);
      }

      ProgramMembersController.prototype.initialize = function() {
        var view;
        this.memberCollection = App.request("get:member:collection");
        this.view = view = this._getView(this.memberCollection);
        this.listenTo(view, "filter:member:info", this._filterMember);
        this.listenTo(view, "change:member:collection", this._changeCollection);
        return App.execute("when:fetched", [this.memberCollection], (function(_this) {
          return function() {
            return _this.show(view);
          };
        })(this));
      };

      ProgramMembersController.prototype._getView = function(memberCollection) {
        return new Member.Views.ProgramMember({
          collection: memberCollection,
          templateHelpers: {
            AJAXURL: AJAXURL
          }
        });
      };

      ProgramMembersController.prototype._filterMember = function(data) {
        var newMemberCollection;
        newMemberCollection = App.request("filter:member:model", data);
        console.log(newMemberCollection);
        this.memberCollection.reset(newMemberCollection);
        return $("#program-member-table").trigger("update");
      };

      ProgramMembersController.prototype._changeCollection = function(data) {
        return App.request("change:cloned:Collection", data);
      };

      return ProgramMembersController;

    })(RegionController);
    return App.commands.setHandler("show:program:members", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new ProgramMembersController(opt);
    });
  });
});
