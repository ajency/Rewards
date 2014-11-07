var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.Option", function(Option, App) {
    var API, OptionCollection, optionCollection;
    Option = (function(_super) {
      __extends(Option, _super);

      function Option() {
        return Option.__super__.constructor.apply(this, arguments);
      }

      Option.prototype.idAttribute = 'ID';

      Option.prototype.defaults = {
        option_name: '',
        optiont_price: '',
        optiont_desc: '',
        product_details: '',
        opt_id: '',
        min_opt: '',
        max_opt: '',
        count: '',
        selected_arr: '',
        min_range: '',
        max_range: '',
        sum: '',
        prod_array: '',
        check: ''
      };

      Option.prototype.name = 'option';

      return Option;

    })(Backbone.Model);
    OptionCollection = (function(_super) {
      __extends(OptionCollection, _super);

      function OptionCollection() {
        return OptionCollection.__super__.constructor.apply(this, arguments);
      }

      OptionCollection.prototype.model = Option;

      OptionCollection.prototype.url = function() {
        return AJAXURL + '?action=get-option';
      };

      return OptionCollection;

    })(Backbone.Collection);
    optionCollection = new OptionCollection;
    API = {
      getOption: function() {
        optionCollection.fetch();
        return optionCollection;
      },
      saveOption: function(data) {
        var option;
        option = new Option(data);
        return option;
      },
      addOption: function(model) {
        return optionCollection.add(model);
      },
      getSingleOption: function(ID) {
        var optionModel;
        optionModel = optionCollection.get(ID);
        if (!optionModel) {
          optionModel = new Product({
            ID: ID
          });
          optionCollection.add(optionModel);
        }
        return optionModel;
      }
    };
    App.reqres.setHandler("get:option:collection", function() {
      return API.getOption();
    });
    App.reqres.setHandler("create:new:option", function(data) {
      return API.saveOption(data);
    });
    App.commands.setHandler("add:new:option:model", function(model) {
      return API.addOption(model);
    });
    return App.reqres.setHandler("get:option:model", function(ID) {
      return API.getSingleOption(ID);
    });
  });
});
