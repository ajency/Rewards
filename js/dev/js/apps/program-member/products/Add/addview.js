var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/products/Add/templates/addproduct.html'], function(App, addTpl) {
  return App.module("Add.Views", function(Views, App) {
    return Views.ProductAdd = (function(_super) {
      __extends(ProductAdd, _super);

      function ProductAdd() {
        return ProductAdd.__super__.constructor.apply(this, arguments);
      }

      ProductAdd.prototype.template = addTpl;

      ProductAdd.prototype.events = {
        'click #submit-new-product': function(e) {
          e.preventDefault();
          console.log(this.$el.find("#addnewform"));
          if (this.$el.find("#addnewform").valid()) {
            this.$el.find('.alert').remove();
            this.$el.find('#submit-new-product').attr('disabled', true);
            return this.trigger("save:new:product", Backbone.Syphon.serialize(this));
          }
        },
        'click #add-new-product': function() {
          return this.$el.find("#add-new-div").show();
        },
        'click #product_img': function() {
          console.log(this.$el.find('#product_img').val());
          return this.$el.find('#img_select').attr('src', this.$el.find('#product_img').val());
        }
      };

      ProductAdd.prototype.onProductAdded = function() {
        this.$el.find("#showmsg").before('<div class="alert alert-success alert-dismissable"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Poduct Added successfully</div>');
        this.$el.find("#add-new-div").hide();
        this.$el.find('#add-new-product').removeAttr('disabled');
        return this.$el.find('button[type="reset"]').trigger('click');
      };

      return ProductAdd;

    })(Marionette.ItemView);
  });
});
