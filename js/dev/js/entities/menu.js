var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.Menu", function(Menu, App) {
    var API;
    Menu.MenuModel = (function(_super) {
      __extends(MenuModel, _super);

      function MenuModel() {
        return MenuModel.__super__.constructor.apply(this, arguments);
      }

      MenuModel.prototype.idAttribute = 'ID';

      MenuModel.prototype.name = 'menu';

      MenuModel.prototype.parse = function(resp) {
        resp['ID'] = parseInt(resp['ID']);
        return resp;
      };

      return MenuModel;

    })(Backbone.Model);
    Menu.MenuCollection = (function(_super) {
      __extends(MenuCollection, _super);

      function MenuCollection() {
        return MenuCollection.__super__.constructor.apply(this, arguments);
      }

      MenuCollection.prototype.model = Menu.MenuModel;

      MenuCollection.prototype.url = function() {
        return AJAXURL + '?action=get-menus';
      };

      return MenuCollection;

    })(Backbone.Collection);
    API = {
      getMenuItems: function() {
        var menuCollection;
        menuCollection = new Menu.MenuCollection;
        menuCollection.fetch();
        return menuCollection;
      }
    };
    return App.reqres.setHandler("get:menu:collection", function() {
      return API.getMenuItems();
    });
  });
});
