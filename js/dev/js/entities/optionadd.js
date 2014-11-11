var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.OptionAdd", function(OptionAdd, App) {
    var API, OptionAddCollection, optionAddCollection;
    OptionAdd = (function(_super) {
      __extends(OptionAdd, _super);

      function OptionAdd() {
        return OptionAdd.__super__.constructor.apply(this, arguments);
      }

      OptionAdd.prototype.idAttribute = 'ID';

      OptionAdd.prototype.defaults = {
        product_name: '',
        product_price: '',
        product_details: '',
        product_img: '',
        attachment: '',
        options: ''
      };

      OptionAdd.prototype.name = 'optionAdd';

      return OptionAdd;

    })(Backbone.Model);
    OptionAddCollection = (function(_super) {
      __extends(OptionAddCollection, _super);

      function OptionAddCollection() {
        return OptionAddCollection.__super__.constructor.apply(this, arguments);
      }

      OptionAddCollection.prototype.model = OptionAdd;

      OptionAddCollection.prototype.url = function() {
        return AJAXURL + '?action=get-optionAdd';
      };

      return OptionAddCollection;

    })(Backbone.Collection);
    optionAddCollection = new OptionAddCollection;
    API = {
      getOptionAdd: function() {
        optionAddCollection.fetch();
        return optionAddCollection;
      }
    };
    return App.reqres.setHandler("get:optionadd:collection", function() {
      return API.getOptionAdd();
    });
  });
});
