var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'text!apps/Options/List/templates/optionList.html'], function(App, listTpl) {
  return App.module("OptionList.Views", function(Views, App) {
    var SingleView;
    SingleView = (function(_super) {
      __extends(SingleView, _super);

      function SingleView() {
        return SingleView.__super__.constructor.apply(this, arguments);
      }

      SingleView.prototype.tagName = 'div';

      SingleView.prototype.className = 'panel panel-default';

      SingleView.prototype.template = '<div class="panel-heading m-b-10" > <h4 class="panel-title"> <a class="collapsed" data-toggle="collapse"  href="#collapseOne{{ID}}"> <div class="row"> <div class="col-md-7"> <h4 class="text_wrap" id="header_name{{ID}}"><span class="semi-bold">{{option_name}} - </span> {{option_desc}}</h4> </div> <div class="col-md-3"> <h4 class="" ><label class="pull-left" id="min{{ID}}">{{min_opt}}&nbsp;</label></h4> </div> <div class="col-md-2"> <div class="plus_img"></div> </div> </div> </a> </h4> </div> <div id="collapseOne{{ID}}" class="panel-collapse collapse"> <div class="panel-body"> <form class="" id="edit-option-form{{ID}}"> <div class="row form-row simple"> <div class="col-md-8"> <input type="text" placeholder="Title" required class="form-control" id="option_name" name="option_name" value="{{option_name}}"> <div class="row form-row"> <div class="col-md-12"> <textarea rows="5" class="form-control" id="option_desc" required name="option_desc"  placeholder="Description">{{option_desc}}</textarea> </div> </div> <div class="row form-row m-t-5"> <div class="col-md-6"> <div class="row "> <div class="col-md-2"> <h5 class="semi-bold">Points:  </h5> </div> <div class="col-md-10"> <input type="text" placeholder="Minimum Points required" required class="form-control price" id="min_opt" name="min_opt" value="{{min_opt}}"> </div></div> </div> <div class="col-md-6"> <div class="row "> <div class="col-md-5"> <h5 class="semi-bold">Package Value: </h5> </div> <div class="col-md-7"> <h5 id="" class="semi-bold text-left"><i class="font18 fa fa-rupee"></i></i><span id="price_val{{ID}}">{{sum}}</span></h5> </div></div> </div> </div> <div class="row m-b-10"> <div class="col-md-6"> <div class="row "> <div class="col-md-4"> <h5 class="semi-bold">Price Range: </h5> </div> <div class="col-md-8"> <h5 class="semi-bold text-left"><i class="font18 fa fa-rupee"></i><span id="min_range{{ID}}">{{min_range}}</span> - <i class="font18 fa fa-rupee"></i><span id="max_range{{ID}}">{{max_range}}</span></h5> </div></div> </div> <div class="col-md-6"></div> </div> <input type="hidden" name="archiveval" id="archiveval" value="0" /> <div class="checkbox check-success "> <input class="archive" id="archive{{ID}}" {{check}} name="archive{{ID}}" type="checkbox" value="0" > <label class="semi-bold" for="archive{{ID}}" style="padding-left:25px;margin-left: 0;"><b>Archive</b></label> </div> <div id="desc"></div> </div> <div class="col-md-4"> <div class="thumbnail grid simple"> <div class="grid-title "> <div class="row"> <div class="col-md-7"> <h4>Products </h4> </div> <div class="col-md-5"> <h4>Price </h4> </div></div> </div><input type="hidden" id="price_total{{ID}}" name="price_total{{ID}}" value="{{sum}}" /> <input type="hidden" id="minrange{{ID}}" name="minrange{{ID}}" value="{{min_range}}" /> <input type="hidden" id="maxrange{{ID}}" name="minrange{{ID}}" value="{{max_range}}" /> <div class="grid-body product"> {{#product_details}} <div class="row"> <div class="col-md-7"> <div class="checkbox check-success p-t-5"> <input id="{{opt_id}}{{ID}}" class="checkboxSelect" type="checkbox" {{selected}} value="{{ID}}" > <label for="{{opt_id}}{{ID}}" style="padding-left:25px;"><b>{{product_name}}</b></label> <input type="hidden" id="product_price{{opt_id}}{{ID}}" name="product_price{{opt_id}}{{ID}}" value="{{product_price}}" /> </div> </div> <div class="col-md-5"> <label id="" class="p-l-25"><i class="font18 fa fa-rupee"></i><b>{{product_price}}</b></label> </div> </div> {{/product_details}} </div> </div> </div> </div> <div class="row form-row"> <div class="col-md-12 margin-top-10"> <div class="pull-right"> <input type="hidden" name="opt_id" id="opt_id" value="{{ID}}" /> <input type="hidden" name="count{{ID}}" id="count{{ID}}" value="0" /> <input type="hidden" name="optionstring" id="optionstring" value="" /> <input type="hidden" name="optionstring1" id="optionstring1" value="" /> <button  data-toggle="collapse" class="btn btn-primary btn-cons edit pull-right" id="submit-edit-form{{ID}}"  type="submit" >Save</button> <div class="pace pace-inactive pull-right  m-r-10"> <div class="pace-activity"></div></div></div> </div> </div> </form> </div> </div>';

      SingleView.prototype.events = {
        'click .edit': function(e) {
          var ID;
          e.preventDefault();
          ID = this.$el.find("#opt_id").val();
          this.$el.find('.alert').remove();
          if (parseInt(this.$el.find('#min_opt').val()) > parseInt(this.$el.find('#max_opt').val())) {
            this.$el.find("#edit-option-form" + ID).before('<div class="alert alert-success"> <button data-dismiss="alert" class="close"></button> Min range has to be less than or eaual to Max range</div>');
            return false;
          }
          if (parseInt($('#count' + ID).val()) === 0) {
            this.$el.find("#edit-option-form" + ID).before('<div class="alert alert-successe"> <button data-dismiss="alert" class="close"></button> Select atleast one product range</div>');
            return false;
          }
          if (this.$el.find("#edit-option-form" + ID).valid()) {
            this.$el.find('.alert').remove();
            this.$el.find('.pace-inactive').show();
            this.$el.find('#submit-edit-form' + ID).attr('disabled', true);
            return this.trigger("update:new:option", ID, Backbone.Syphon.serialize(this));
          }
        },
        'click .checkboxSelect': function(e) {
          var ID, count, element, index, last, max_range, min_range, price, price_total, prod_val, productdelsarray, productsarray, str, str1, val, val_arry, val_string, _i, _len;
          $(".ref_msg").remove();
          productsarray = Array();
          productdelsarray = Array();
          val_arry = this.$el.find("#optionstring").val();
          val_string = val_arry.split(',');
          for (index = _i = 0, _len = val_string.length; _i < _len; index = ++_i) {
            element = val_string[index];
            productsarray.push(element);
          }
          prod_val = e.target.value;
          price = this.$el.find("#product_price" + e.target.id).val();
          ID = this.$el.find("#opt_id").val();
          price_total = this.$el.find("#price_total" + ID).val();
          min_range = this.$el.find("#minrange" + ID).val();
          max_range = this.$el.find("#maxrange" + ID).val();
          if ($('#' + e.target.id).prop('checked') === true) {
            price_total = parseInt(price_total) + parseInt(price);
            this.$el.find("#price_total" + ID).val(price_total);
            count = $('#count' + ID).val();
            count = parseInt(count) + 1;
            $('#count' + ID).val(count);
            productsarray.push(prod_val);
            str = productsarray.join(',');
            this.$el.find("#optionstring").val(str);
            $('#price_val' + ID).text(price_total);
          } else {
            price_total = parseInt(price_total) - parseInt(price);
            $('#price_val' + ID).text(price_total);
            this.$el.find("#price_total" + ID).val(price_total);
            count = $('#count' + ID).val();
            count = parseInt(count) - 1;
            $('#count' + ID).val(count);
            last = productsarray.indexOf(prod_val);
            productsarray.splice(last, 1);
            str = productsarray.join(',');
            this.$el.find("#optionstring").val(str);
            productdelsarray.push(prod_val);
            str1 = productdelsarray.join(',');
            this.$el.find("#optionstring1").val(str1);
          }
          if (price_total < min_range) {
            val = parseInt(min_range) - parseInt(price_total);
            $('#submit-edit-form' + ID).addClass('hidden');
            return $("#edit-option-form" + ID).before('<div class="ref_msg alert alert-error m-b-5 m-t-20"><button data-dismiss="alert" class="close"></button>Package value is less than the selected price range by ' + val + '. Please choose products within the price range.</div>');
          } else if (price_total > max_range) {
            val = parseInt(price_total) - parseInt(max_range);
            $('#submit-edit-form' + ID).addClass('hidden');
            return $("#edit-option-form" + ID).before('<div class="ref_msg alert alert-error m-b-5 m-t-20"><button data-dismiss="alert" class="close"></button>Package value has exceeded the selected price range by ' + val + '. Please choose products within the price range.</div>');
          } else {
            return $('#submit-edit-form' + ID).removeClass('hidden');
          }
        },
        'keyup .price': function(e) {
          var ID, code;
          ID = this.model.get('ID');
          this.$el.find('.alert').remove();
          code = e.keyCode || e.which;
          console.log(code);
          if (parseInt(code) === 48) {
            $("#edit-option-form" + ID).before('<div class="alert alert-success"> <button data-dismiss="alert" class="close"></button> Cannot create package with points 0 </div>');
            $('#submit-edit-form' + ID).addClass('hidden');
            return false;
          } else {
            console.log('code');
            return this.trigger("get:pointslist:range", Backbone.Syphon.serialize(this));
          }
        },
        'click .archive': function(e) {
          if ($('#' + e.target.id).prop('checked') === true) {
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

      SingleView.prototype.onShow = function() {
        var ID, prod_arr, selected;
        ID = this.model.get('ID');
        $('#count' + ID).val(this.model.get('count'));
        selected = this.model.get('selected_arr');
        $('#count' + ID).val(selected.length);
        prod_arr = this.model.get('prod_array');
        return this.$el.find("#optionstring").val(prod_arr);
      };

      return SingleView;

    })(Marionette.ItemView);
    return Views.ProductList = (function(_super) {
      __extends(ProductList, _super);

      function ProductList() {
        return ProductList.__super__.constructor.apply(this, arguments);
      }

      ProductList.prototype.template = listTpl;

      ProductList.prototype.className = 'row';

      ProductList.prototype.itemView = SingleView;

      ProductList.prototype.itemViewContainer = 'div#rowdata';

      ProductList.prototype.onNewOptionEdited = function(model) {
        var ID;
        ID = model.get('ID');
        this.collection.trigger('reset');
        this.$el.find('.alert').remove();
        this.$el.find('.pace-inactive').hide();
        this.$el.find('#min_range' + ID).text(model.get('min_range'));
        this.$el.find('#max_range' + ID).text(model.get('max_range'));
        this.$el.find('#minrange' + ID).val(model.get('min_range'));
        this.$el.find('#maxrange' + ID).val(model.get('max_range'));
        this.$el.find('#archiveval').val(model.get('archiveval'));
        return this.$el.find("#rowdata").before('<div class="alert alert-success"> <button data-dismiss="alert" class="close"></button> Package details updated successfully</div>');
      };

      ProductList.prototype.onShowRangeList = function(data, ID) {
        var price_total, val;
        $(".ref_msg").remove();
        this.$el.find('#min_range' + ID).text(data.min);
        this.$el.find('#max_range' + ID).text(data.max);
        this.$el.find('#minrange' + ID).val(data.min);
        this.$el.find('#maxrange' + ID).val(data.max);
        price_total = this.$el.find('#price_total' + ID).val();
        if (parseInt(price_total) < parseInt(data.min)) {
          val = parseInt(data.min) - parseInt(price_total);
          $('#submit-edit-form' + ID).addClass('hidden');
          return $("#edit-option-form" + ID).before('<div class="ref_msg alert alert-error m-b-5 m-t-20"><button data-dismiss="alert" class="close"></button>Package value is less than the selected price range by ' + val + '. Please choose products within the price range.</div>');
        } else if (parseInt(price_total) > parseInt(data.max)) {
          val = parseInt(price_total) - parseInt(data.max);
          $('#submit-edit-form' + ID).addClass('hidden');
          return $("#edit-option-form" + ID).before('<div class="ref_msg alert alert-error m-b-5 m-t-20"><button data-dismiss="alert" class="close"></button>Package value has exceeded the selected price range by ' + val + '. Please choose products within the price range.</div>');
        } else {
          return $('#submit-edit-form' + ID).removeClass('hidden');
        }
      };

      return ProductList;

    })(Marionette.CompositeView);
  });
});
