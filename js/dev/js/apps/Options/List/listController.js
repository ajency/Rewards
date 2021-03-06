var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'controllers/region-controller', 'apps/Options/List/listView'], function(App, RegionController) {
  return App.module("OptionList", function(OptionList, App) {
    var OptionListController;
    OptionListController = (function(_super) {
      __extends(OptionListController, _super);

      function OptionListController() {
        this.showRangeList = __bind(this.showRangeList, this);
        this._getRangeList = __bind(this._getRangeList, this);
        this.optionEdited = __bind(this.optionEdited, this);
        this._updateOption = __bind(this._updateOption, this);
        return OptionListController.__super__.constructor.apply(this, arguments);
      }

      OptionListController.prototype.initialize = function() {
        var view;
        this.optionCollection = App.request("get:option:collection");
        this.view = view = this._getOptionListView(this.optionCollection);
        this.listenTo(view, "itemview:update:new:option", this._updateOption);
        this.listenTo(view, "itemview:get:pointslist:range", this._getRangeList);
        return this.show(view);
      };

      OptionListController.prototype._getOptionListView = function(optionCollection) {
        return new OptionList.Views.ProductList({
          collection: optionCollection
        });
      };

      OptionListController.prototype._updateOption = function(iv, ID, data) {
        var optionModel;
        optionModel = App.request("get:option:model", ID);
        return optionModel.save(data, {
          wait: true,
          success: this.optionEdited
        });
      };

      OptionListController.prototype.optionEdited = function(model, resp) {
        return this.view.triggerMethod("new:option:edited", model);
      };

      OptionListController.prototype._getRangeList = function(iv, data) {
        var object;
        object = this;
        return $.ajax({
          method: "POST",
          url: AJAXURL + '?action=get_points_range',
          data: data,
          success: function(result) {
            return object.showRangeList(result, data.opt_id);
          }
        }, {
          error: function(result) {}
        });
      };

      OptionListController.prototype.showRangeList = function(data, opt_id) {
        return this.view.triggerMethod("show:range:list", data, opt_id);
      };

      return OptionListController;

    })(RegionController);
    return App.commands.setHandler("show:option:list", function(opt) {
      if (opt == null) {
        opt = {};
      }
      return new OptionListController(opt);
    });
  });
});
