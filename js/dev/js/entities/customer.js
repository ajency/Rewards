var __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['app', 'backbone'], function(App) {
  return App.module("Entities.Customer", function(Customer, App) {
    var API, CustomerCollection, customerCollection;
    Customer = (function(_super) {
      __extends(Customer, _super);

      function Customer() {
        return Customer.__super__.constructor.apply(this, arguments);
      }

      Customer.prototype.idAttribute = 'ID';

      Customer.prototype.defaults = {
        referral_id: '',
        user_email: '',
        phone: '',
        date_of_import: '',
        date_of_purchase: '',
        purchase_value: '',
        date_of_expire: '',
        points: '',
        ref_count: ''
      };

      Customer.prototype.name = 'customer';

      return Customer;

    })(Backbone.Model);
    CustomerCollection = (function(_super) {
      __extends(CustomerCollection, _super);

      function CustomerCollection() {
        return CustomerCollection.__super__.constructor.apply(this, arguments);
      }

      CustomerCollection.prototype.model = Customer;

      CustomerCollection.prototype.url = function() {
        return AJAXURL + '?action=get-customers';
      };

      return CustomerCollection;

    })(Backbone.Collection);
    customerCollection = new CustomerCollection;
    API = {
      getCustomers: function(opt) {
        customerCollection.fetch({
          data: {
            username: opt.username
          }
        });
        return customerCollection;
      }
    };
    return App.reqres.setHandler("get:customer:collection", function(opt) {
      return API.getCustomers(opt);
    });
  });
});
