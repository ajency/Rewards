var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/products/list/templates/productlist.html'], function(App, listTpl) {
  return App.module("List.Views", function(Views, App) {
    var EmptyProductView, SingleView;
    SingleView = (function(_super) {
      __extends(SingleView, _super);

      function SingleView() {
        return SingleView.__super__.constructor.apply(this, arguments);
      }

      SingleView.prototype.tagName = 'div';

      SingleView.prototype.template = '<div id="showdiv" class="panel panel-default" > <div class="panel-heading"> <div class="panel-title"> <a class="collapsed" id="collapsediv{{ID}}" data-toggle="collapse" data-parent="#accordion" href="#collapseOne{{ID}}"> <div class="row"> <div class="col-md-1"> <img src="{{product_image}}" id="header_img{{ID}}" class="img-responsive" width="60px"> </div> <div class="col-md-7" > <h4 class="text_wrap" ><span class="semi-bold" id="header_name{{ID}}">{{product_name}}  </span> - <span  id="header_desc{{ID}}">{{product_details}}</span></h4> </div> <div class="col-md-2" > <h4 class="bold" id="header_price{{ID}}" ><i class="font18 fa fa-rupee"></i>{{product_price}}</h4> </div> <div class="col-md-2" > <div class="plus_img"></div> </div> </div> </a> </div> </div> <div id="collapseOne{{ID}}" class="panel-collapse collapse "> <div class="panel-body"> <form id="edit-new-form{{ID}}" enctype="multipart/form-data" method="POST"> <div class="row form-row simple"> <div class="col-md-4"> <div class="thumbnail upload-img"> <i class="p-l-10 fa fa-cloud-upload fa fa-6x custom-icon-space"> </i> <div class="caption"> <img class="uploaded-image" src="{{product_image}}"/> <div class="row"> <div class="col-md-12"> <button type="button" class="btn btn-primary btn-cons m-t-20" id="{{uniqueID}}"> Choose Image </button> </div></div> <div class="row"> <div class="col-md-12"> <div id="progress-{{uniqueID}}" style="width: 100%; display: none;" class="progress progress-striped active m-t-10 m-b-10"> <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="progress-bar"></div> <span class="sr-only">0% Complete </span> </div> <input type="hidden" name="attachmentid" value="{{product_thumbnail_id}}"/> </div></div></div> </div> </div> <div class="col-md-8"> <input type="hidden" name="prod_id" id="prod_id" value="{{ID}}" /> <input type="text" placeholder="Product Name" class="form-control" id="product_name" value="{{product_name}}" name="product_name"> <div class="row form-row"> <div class="col-md-12"> <textarea rows="5" class="form-control" id="product_details" name="product_details" placeholder="Products Details"> {{product_details}} </textarea> </div> </div> <div class="row form-row m-t-5"> <div class="col-md-6"> <input type="text" placeholder="Product Price" class="form-control price" id="product_price" value="{{product_price}}" name="product_price"> </div> </div> </div> </div> <div class="row form-row"> <div class="col-md-12 margin-top-10"> <div class="pull-right"> <button data-toggle="collapse" id="submit-edit-form{{ID}}" class="btn btn-primary btn-cons edit" type="submit"> Save </button> </div> </div> </div> </form> </div> </div> </div>';

      SingleView.prototype.events = {
        'click .edit': function(e) {
          var ID;
          e.preventDefault();
          ID = this.$el.find("#prod_id").val();
          this.$el.find('.alert').remove();
          if (this.$el.find("#edit-new-form" + ID).valid()) {
            this.$el.find('.alert').remove();
            this.$el.find('#submit-edit-form' + ID).attr('disabled', true);
            return this.trigger("update:new:product", ID, Backbone.Syphon.serialize(this));
          }
        },
        'keydown  .price': function(e) {
          var code, num;
          num = e.target.value;
          code = e.keyCode || e.which;
          if ((code > 64 && code < 91) || (code > 96 && code < 123)) {
            return false;
          }
        }
      };

      SingleView.prototype.initialize = function(opt) {
        SingleView.__super__.initialize.call(this, opt);
        return this.uniqueID = "choose-file-" + (this.model.get('ID'));
      };

      SingleView.prototype.mixinTemplateHelpers = function(data) {
        data = SingleView.__super__.mixinTemplateHelpers.call(this, data);
        data.uniqueID = this.uniqueID;
        return data;
      };

      SingleView.prototype.onShow = function() {
        this.uploader = new plupload.Uploader({
          runtimes: "gears,html5,flash,silverlight,browserplus",
          file_data_name: "async-upload",
          multiple_queues: true,
          browse_button: this.uniqueID,
          multipart: true,
          urlstream_upload: true,
          max_file_size: "10mb",
          url: UPLOADURL,
          flash_swf_url: SITEURL + "/wp-includes/js/plupload/plupload.flash.swf",
          silverlight_xap_url: SITEURL + "/wp-includes/js/plupload/plupload.silverlight.xap",
          filters: [
            {
              title: "Image files",
              extensions: "jpg,gif,png"
            }
          ],
          multipart_params: {
            action: "upload-attachment",
            _wpnonce: _WPNONCE
          }
        });
        this.uploader.init();
        this.uploader.bind("FilesAdded", (function(_this) {
          return function(up, files) {
            _this.uploader.start();
            return _this.$el.find("#progress-" + _this.uniqueID).show();
          };
        })(this));
        this.uploader.bind("UploadProgress", (function(_this) {
          return function(up, file) {
            return _this.$el.find(".progress-bar").css("width", file.percent + "%");
          };
        })(this));
        this.uploader.bind("Error", (function(_this) {
          return function(up, err) {
            return up.refresh();
          };
        })(this));
        return this.uploader.bind("FileUploaded", (function(_this) {
          return function(up, file, response) {
            _this.$el.find(".progress-bar").css("width", "0%");
            _this.$el.find("#progress-" + _this.uniqueID).hide();
            response = JSON.parse(response.response);
            _this.$el.find('input[name="attachmentid"]').val(response.data.id);
            return _this.$el.find("#progress-" + _this.uniqueID).closest('.caption').find('.uploaded-image').attr('src', response.data.sizes.thumbnail.url);
          };
        })(this));
      };

      SingleView.prototype.onClose = function() {
        return this.uploader.destroy();
      };

      SingleView.prototype.onRender = function() {
        return this.$el;
      };

      return SingleView;

    })(Marionette.ItemView);
    EmptyProductView = (function(_super) {
      __extends(EmptyProductView, _super);

      function EmptyProductView() {
        return EmptyProductView.__super__.constructor.apply(this, arguments);
      }

      EmptyProductView.prototype.template = '<div id="showdiv" class="panel panel-default"> <div class="panel-heading"> <h4 class="panel-title">No Products found</h4> </div> </div>';

      return EmptyProductView;

    })(Marionette.ItemView);
    return Views.Product = (function(_super) {
      __extends(Product, _super);

      function Product() {
        return Product.__super__.constructor.apply(this, arguments);
      }

      Product.prototype.template = listTpl;

      Product.prototype.className = 'row';

      Product.prototype.itemView = SingleView;

      Product.prototype.emptyView = EmptyProductView;

      Product.prototype.itemViewContainer = 'div#rowdata';

      Product.prototype.onNewProductEdited = function(model) {
        this.collection.trigger('reset');
        this.$el.find('.alert').remove();
        return this.$el.find("#showdiv").before('<div class="alert alert-success"> <button data-dismiss="alert" class="close"></button> Product Updated Successfully. </div>');
      };

      return Product;

    })(Marionette.CompositeView);
  });
});
