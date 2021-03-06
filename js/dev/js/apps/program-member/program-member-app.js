var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'apps/program-member/programmember/program-member-controller'], function(App) {
  return App.module("ProgramMember", function(ProgramMember, App) {
    var ProgramMemberRouter, RouterAPI;
    ProgramMemberRouter = (function(_super) {
      __extends(ProgramMemberRouter, _super);

      function ProgramMemberRouter() {
        return ProgramMemberRouter.__super__.constructor.apply(this, arguments);
      }

      ProgramMemberRouter.prototype.appRoutes = {
        'view': 'list',
        'referrals/:id/:userid': 'show'
      };

      return ProgramMemberRouter;

    })(Marionette.AppRouter);
    RouterAPI = {
      list: function() {
        return App.execute("show:program:members", {
          region: App.mainContentRegion
        });
      },
      show: function(id, userid) {
        return App.execute("show:main:App", {
          region: App.mainContentRegion,
          ID: id,
          userid: userid
        });
      }
    };
    return ProgramMember.on('start', function() {
      return new ProgramMemberRouter({
        controller: RouterAPI
      });
    });
  });
});
