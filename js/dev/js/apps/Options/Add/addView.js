var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/Options/Add/templates/addOption.html'], function(App, addTpl) {
  return App.module("AddOption.Views", function(Views, App) {
    var SingleView, max_range, min_range, price_total, productsarray;
    productsarray = Array();
    min_range = 0;
    max_range = 0;
    price_total = 0;
    SingleView = (function(_super) {
      __extends(SingleView, _super);

      function SingleView() {
        return SingleView.__super__.constructor.apply(this, arguments);
      }

      SingleView.prototype.template = '<div class="row"> <div class="col-md-7"> <div class="checkbox check-success p-t-5"> <input id="checkbox{{ID}}" class="checkboxSelect" type="checkbox" value="{{ID}}" > <label class="text_wrap" for="checkbox{{ID}}" style="padding-left:25px;"><b>{{product_name}}</b></label></div> </div> <div class="col-md-5"> <label id="" class="p-l-25"><i class="font18 fa fa-rupee"></i><b>{{product_price}}</b></label> </div> </div>';

      SingleView.prototype.className = '';

      SingleView.prototype.events = {
        'click .checkboxSelect': function(e) {
          var price, prod_val, str, val;
          $(".ref_msg").remove();
          prod_val = e.target.value;
          price = this.model.get('product_price');
          if ($('#' + e.target.id).prop('checked') === true) {
            price_total = parseInt(price_total) + parseInt(price);
            productsarray.push(prod_val);
            str = productsarray.join(',');
            $("#optionstring").val(str);
            $('#price_val').text(price_total);
          } else {
            price_total = parseInt(price_total) - parseInt(price);
            $('#price_val').text(price_total);
            productsarray.pop(prod_val);
          }
          if (parseInt(price_total) < parseInt(min_range)) {
            val = parseInt(min_range) - parseInt(price_total);
            $('#submit-new-option').addClass('hidden');
            return $("#desc").before('<div class="ref_msg alert alert-error m-b-5 m-t-20"><button data-dismiss="alert" class="close"></button>Package value is less than the selected price range by ' + val + '. Please choose products within the price range.</div>');
          } else if (parseInt(price_total) > parseInt(max_range)) {
            val = parseInt(price_total) - parseInt(max_range);
            $('#submit-new-option').addClass('hidden');
            return $("#desc").before('<div class="ref_msg alert alert-error m-b-5 m-t-20"><button data-dismiss="alert" class="close"></button>Package value has exceeded the selected price range by ' + val + '. Please choose products within the price range.</div>');
          } else {
            return $('#submit-new-option').removeClass('hidden');
          }
        }
      };

      return SingleView;

    })(Marionette.ItemView);
    return Views.OptionAdd = (function(_super) {
      __extends(OptionAdd, _super);

      function OptionAdd() {
        return OptionAdd.__super__.constructor.apply(this, arguments);
      }

      OptionAdd.prototype.template = addTpl;

      OptionAdd.prototype.itemView = SingleView;

      OptionAdd.prototype.itemViewContainer = 'div#product';

      OptionAdd.prototype.events = {
        'click #submit-new-option': function(e) {
          e.preventDefault();
          this.$el.find('.alert').remove();
          if (parseInt(this.$el.find('#min_opt').val()) > parseInt(this.$el.find('#max_opt').val())) {
            this.$el.find("#add-new-option").before('<div class="alert alert-success"> <button data-dismiss="alert" class="close"></button> Min range has to be less than or eaual to Max range</div>');
            return false;
          }
          if (productsarray.length === 0) {
            this.$el.find("#add-new-option").before('<div class="alert alert-success"> <button data-dismiss="alert" class="close"></button> Select atleast one product range</div>');
            return false;
          }
          if (this.$el.find("#add-new-option").valid()) {
            this.$el.find('.alert').remove();
            this.$el.find('.pace-inactive').show();
            this.$el.find('#submit-new-option').attr('disabled', true);
            return this.trigger("save:new:option", Backbone.Syphon.serialize(this));
          }
        },
        'click #add-product-option': function() {
          return this.$el.find("#add-option-details").show();
        },
        'click #cancel_product_option': function() {
          this.$el.find('button[type="reset"]').trigger('click');
          return this.$el.find("#add-option-details").hide();
        },
        'keyup #min_opt': function(e) {
          var code;
          this.$el.find('.alert').remove();
          code = e.keyCode || e.which;
          console.log(code);
          if (parseInt(code) === 48) {
            this.$el.find("#add-new-option").before('<div class="alert alert-success"> <button data-dismiss="alert" class="close"></button> Cannot create package with points 0 </div>');
            $('#submit-new-option').addClass('hidden');
            return false;
          } else if ($('#min_opt').val() === "") {
            return $('#submit-new-option').addClass('hidden');
          } else {
            return this.trigger("get:points:range", Backbone.Syphon.serialize(this));
          }
        },
        'click #archive': function(e) {
          if ($('#archive').prop('checked') === true) {
            return this.$el.find('#archiveval').val('1');
          } else {
            return this.$el.find('#archiveval').val('0');
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

      OptionAdd.prototype.onOptionAdded = function() {
        this.$el.find('.alert').remove();
        this.$el.find('.pace-inactive').hide();
        this.$el.find("#add-option-details").before('<div class="alert alert-success"> <button data-dismiss="alert" class="close"></button> Package has been added successfully</div>');
        this.$el.find("#add-option-details").hide();
        this.$el.find('#submit-new-option').removeAttr('disabled', false);
        this.$el.find('button[type="reset"]').trigger('click');
        min_range = 0;
        max_range = 0;
        price_total = 0;
        this.$el.find('#min_range').text("");
        this.$el.find('#max_range').text("");
        $('#price_val').text("0");
        productsarray = Array();
        $("#optionstring").val("");
        return $('html, body').animate({
          scrollTop: $(document).height()
        }, 'slow');
      };

      OptionAdd.prototype.onShowRange = function(data) {
        var val;
        $(".ref_msg").remove();
        this.$el.find('#min_range').text(data.min);
        this.$el.find('#max_range').text(data.max);
        min_range = data.min;
        max_range = data.max;
        if (parseInt(price_total) < parseInt(min_range)) {
          val = parseInt(min_range) - parseInt(price_total);
          $('#submit-new-option').addClass('hidden');
          return $("#desc").before('<div class="ref_msg alert alert-error m-b-5 m-t-20"> <button data-dismiss="alert" class="close"></button>Package value is less than the selected price range by ' + val + '. Please choose products within the price range.</div>');
        } else if (parseInt(price_total) > parseInt(max_range)) {
          val = parseInt(price_total) - parseInt(max_range);
          $('#submit-new-option').addClass('hidden');
          return $("#desc").before('<div class="ref_msg alert alert-error m-b-5 m-t-20"> <button data-dismiss="alert" class="close"></button>Package value has exceeded the selected price range by ' + val + '. Please choose products within the price range.</div>');
        } else {
          return $('#submit-new-option').removeClass('hidden');
        }
      };

      return OptionAdd;

    })(Marionette.CompositeView);
  });
});
