var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.Product", function(Product, App) {
    var API, ProductCollection, productCollection;
    Product = (function(_super) {
      __extends(Product, _super);

      function Product() {
        return Product.__super__.constructor.apply(this, arguments);
      }

      Product.prototype.idAttribute = 'ID';

      Product.prototype.defaults = {
        product_name: '',
        product_price: '',
        product_details: '',
        product_img: '',
        attachment: '',
        file: ''
      };

      Product.prototype.name = 'product';

      return Product;

    })(Backbone.Model);
    ProductCollection = (function(_super) {
      __extends(ProductCollection, _super);

      function ProductCollection() {
        return ProductCollection.__super__.constructor.apply(this, arguments);
      }

      ProductCollection.prototype.model = Product;

      ProductCollection.prototype.url = function() {
        return AJAXURL + '?action=get-products';
      };

      return ProductCollection;

    })(Backbone.Collection);
    productCollection = new ProductCollection;
    API = {
      saveProduct: function(data) {
        var product;
        product = new Product(data);
        return product;
      },
      getProducts: function() {
        productCollection.fetch();
        return productCollection;
      },
      addProduct: function(model) {
        return productCollection.add(model);
      },
      getSingleProduct: function(ID) {
        var productModel;
        productModel = productCollection.get(ID);
        if (!productModel) {
          productModel = new Product({
            ID: ID
          });
          productCollection.add(productModel);
        }
        return productModel;
      }
    };
    App.reqres.setHandler("create:new:product", function(data) {
      return API.saveProduct(data);
    });
    App.reqres.setHandler("get:product:collection", function(data) {
      return API.getProducts(data);
    });
    App.commands.setHandler("add:new:product:model", function(model) {
      return API.addProduct(model);
    });
    return App.reqres.setHandler("get:user:model", function(ID) {
      return API.getSingleProduct(ID);
    });
  });
});
