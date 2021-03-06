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
          this.$el.find('.alert').remove();
          if (this.$el.find("#addnewform").valid()) {
            this.$el.find('.alert').remove();
            this.$el.find('#submit-new-product').attr('disabled', true);
            return this.trigger("save:new:product", Backbone.Syphon.serialize(this));
          }
        },
        'click #add-new-product,#cancel_product': function() {
          return this.$el.find("#add-new-div").toggle();
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

      ProductAdd.prototype.initialize = function() {
        return this.uniqueID = _.uniqueId("choose-file-add");
      };

      ProductAdd.prototype.mixinTemplateHelpers = function(data) {
        data = ProductAdd.__super__.mixinTemplateHelpers.call(this);
        data.uniqueID = this.uniqueID;
        data.dummyImage = "" + SITEURL + "/wp-content/themes/Rewards/img/placeholder.jpg";
        return data;
      };

      ProductAdd.prototype.onProductAdded = function() {
        this.$el.find('.alert').remove();
        this.$el.find("#showmsg").before('<div class="alert alert-success"> <button data-dismiss="alert" class="close"></button> Poduct Added successfully</div>');
        this.$el.find("#add-new-div").hide();
        this.$el.find('#submit-new-product').removeAttr('disabled', false);
        this.$el.find('button[type="reset"]').trigger('click');
        this.$el.find('input[name="attachmentid"]').val("");
        this.$el.find("#progress-" + this.uniqueID).closest('.caption').find('.uploaded-image').attr('src', "" + SITEURL + "/wp-content/themes/Rewards/img/placeholder.jpg");
        return $('html, body').animate({
          scrollTop: $(document).height()
        }, 'slow');
      };

      ProductAdd.prototype.onShow = function() {
        $("#addnewform").validate({
          rules: {
            product_price: {
              number: true,
              required: true
            }
          }
        });
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

      ProductAdd.prototype.onClose = function() {
        return this.uploader.destroy();
      };

      return ProductAdd;

    })(Marionette.ItemView);
  });
});
