var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.Import", function(Import, App) {
    var API, importfile;
    Import = (function(_super) {
      __extends(Import, _super);

      function Import() {
        return Import.__super__.constructor.apply(this, arguments);
      }

      Import.prototype.idAttribute = 'ID';

      Import.prototype.defaults = {
        date: ''
      };

      Import.prototype.name = 'import';

      console.log(AJAXURL);

      Import.prototype.urlRoot = AJAXURL + '?action=get-date';

      return Import;

    })(Backbone.Model);
    importfile = new Import;
    API = {
      getdate: function() {
        importfile.fetch();
        return importfile;
      }
    };
    return App.reqres.setHandler("get:date:model", function() {
      return API.getdate();
    });
  });
});
