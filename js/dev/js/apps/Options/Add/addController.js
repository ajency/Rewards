var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/Options/Add/addView'], function(App, RegionController) {
  return App.module("AddOption", function(AddOption, App) {
    var AddOptionController;
    AddOptionController = (function(_super) {
      __extends(AddOptionController, _super);

      function AddOptionController() {
        this.showRange = __bind(this.showRange, this);
        this._getRange = __bind(this._getRange, this);
        this.optionAdded = __bind(this.optionAdded, this);
        return AddOptionController.__super__.constructor.apply(this, arguments);
      }

      AddOptionController.prototype.initialize = function() {
        var view;
        this.optionAddCollection = App.request("get:optionadd:collection");
        this.view = view = this._getOptionAddView(this.optionAddCollection);
        this.listenTo(view, "save:new:option", this._saveOption);
        this.listenTo(view, "get:points:range", this._getRange);
        return this.show(view);
      };

      AddOptionController.prototype._getOptionAddView = function(optionAddCollection) {
        return new AddOption.Views.OptionAdd({
          collection: optionAddCollection
        });
      };

      AddOptionController.prototype._saveOption = function(data) {
        var optionModel;
        optionModel = App.request("create:new:option", data);
        return optionModel.save(null, {
          wait: true,
          success: this.optionAdded
        });
      };

      AddOptionController.prototype.optionAdded = function(model, resp) {
        App.execute("add:new:option:model", model);
        return this.view.triggerMethod("option:added");
      };

      AddOptionController.prototype._getRange = function(data) {
        var object;
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + '?action=get_points_range',
          data: data,
          success: function(result) {
            return object.showRange(result);
          }
        }, {
          error: function(result) {}
        });
      };

      AddOptionController.prototype.showRange = function(data) {
        return this.view.triggerMethod("show:range", data);
      };

      return AddOptionController;

    })(RegionController);
    return App.commands.setHandler("show:option:add", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new AddOptionController(opt);
    });
  });
});
