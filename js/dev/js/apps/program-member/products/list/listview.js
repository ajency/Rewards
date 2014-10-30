var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/products/list/templates/productlist.html'], function(App, listTpl) {
  return App.module("List.Views", function(Views, App) {
    var SingleView;
    SingleView = (function(_super) {
      __extends(SingleView, _super);

      function SingleView() {
        return SingleView.__super__.constructor.apply(this, arguments);
      }

      SingleView.prototype.tagName = 'div';

      SingleView.prototype.template = '<div id="showdiv" class="panel panel-default"> <div class="panel-heading"> <h4 class="panel-title"> <a class="collapsed" id="collapsediv{{ID}}" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{ID}}"> <div class="row"> <div class="col-md-1"> <img src="{{product_img}}" id="header_img{{ID}}" class="img-responsive" width="60px"> </div> <div class="col-md-7" > <h4 id="header_name{{ID}}">{{product_name}}   {{product_details}}</h4> </div> <div class="col-md-2" > <h4 class="bold" id="header_price{{ID}}" >{{product_price}}</h4> </div> <div class="col-md-2" > <button class="btn btn-success btn-cons" type="button"  id="edit-product-data">Edit</button> </div> </div> </a> </h4> </div> <div id="collapseOne{{ID}}" class="panel-collapse collapse " > <div class="panel-body"> <form  id="edit-new-form{{ID}}" enctype="multipart/form-data" method="POST"> <div class="row form-row simple"> <div class="col-md-4"> <div class="thumbnail upload-img"> <i class="fa fa-cloud-upload fa fa-6x custom-icon-space" ></i> <img id="img_select{{ID}}" src={{product_img}} /> <div class="caption"> <p><a href="#" class="btn btn-default" role="button">Upload Image</a> <input type="hidden" id="product_img" name="product_img" value="{{product_img}}" /> <input type="file" name="productimg" size="50" id="productimg" /></p> </div> </div> </div> <div class="col-md-8"><input type="hidden" name="prod_id" id="prod_id" value="{{ID}}" /> <input type="text" placeholder="Product Name" class="form-control" id="product_name" value="{{product_name}}" name="product_name"> <div class="row form-row"> <div class="col-md-12"> <textarea rows="5" class="form-control" id="product_details"  name="product_details" placeholder="Products Details">{{product_details}}</textarea> </div> </div> <div class="row form-row m-t-5"> <div class="col-md-6"> <input type="text" placeholder="Product Price" class="form-control" id="product_price" value="{{product_price}}" name="product_price"> </div> </div> </div> </div> <div class="row form-row"> <div class="col-md-12 margin-top-10"> <div class="pull-right"> <button  data-toggle="collapse"  id="submit-edit-form{{ID}}" class="btn btn-primary btn-cons edit" type="submit" >Submit</button> </div> </div> </div> </form> </div> </div> </div>';

      SingleView.prototype.events = {
        'click .edit': function(e) {
          var ID;
          e.preventDefault();
          ID = this.$el.find("#prod_id").val();
          console.log(ID);
          if (this.$el.find("#edit-new-form" + ID).valid()) {
            this.$el.find('.alert').remove();
            this.$el.find('#submit-edit-form' + ID).attr('disabled', true);
            return this.trigger("update:new:product", ID, Backbone.Syphon.serialize(this));
          }
        },
        'change #productimg': function() {
          return this.$el.find('#product_img').val(this.$el.find('#productimg').val());
        }
      };

      return SingleView;

    })(Marionette.ItemView);
    return Views.Product = (function(_super) {
      __extends(Product, _super);

      function Product() {
        return Product.__super__.constructor.apply(this, arguments);
      }

      Product.prototype.template = listTpl;

      Product.prototype.className = 'row';

      Product.prototype.itemView = SingleView;

      Product.prototype.emptyView = SingleView;

      Product.prototype.itemViewContainer = 'div#rowdata';

      Product.prototype.onNewProductEdited = function(model) {
        this.$el.find("#showdiv").before('<div class="alert alert-success alert-dismissable"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> Poduct Updated successfully</div>');
        this.$el.find('#submit-edit-form' + model.attributes.ID).removeAttr('disabled');
        this.$el.find("#collapseOne" + model.attributes.ID).removeClass("panel-collapse collapse in ");
        this.$el.find("#collapseOne" + model.attributes.ID).addClass("panel-collapse collapse ");
        this.$el.find("#header_img" + model.attributes.ID).attr('src', model.attributes.product_img);
        this.$el.find("#img_select" + model.attributes.ID).attr('src', model.attributes.product_img);
        this.$el.find("#header_price" + model.attributes.ID).text(model.attributes.product_price);
        return this.$el.find("#header_name" + model.attributes.ID).text(model.attributes.product_name + '  ' + model.attributes.product_details);
      };

      return Product;

    })(Marionette.CompositeView);
  });
});
