var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/customer/customerHead/templates/customerHead.html'], function(App, customerTpl) {
  return App.module("customerHead.Views", function(Views, App) {
    var shipping_val;
    shipping_val = "";
    return Views.Head = (function(_super) {
      __extends(Head, _super);

      function Head() {
        return Head.__super__.constructor.apply(this, arguments);
      }

      Head.prototype.template = customerTpl;

      Head.prototype.initialize = function() {
        return shipping_val = Marionette.getOption(this, 'shipping_val');
      };

      Head.prototype.events = {
        'click #changeView': function(e) {
          return this.trigger("change:customer:view");
        },
        'click #changeInfoView': function(e) {
          return this.trigger("change:customerInfo:view");
        },
        'click #userstep3': function(e) {
          e.preventDefault();
          return this.trigger("change:customerShipping:view");
        }
      };

      Head.prototype.onShow = function() {
        console.log(shipping_val);
        if (shipping_val === 1) {
          return $('lishipping').addClass('active');
        }
      };

      return Head;

    })(Marionette.ItemView);
  });
});
