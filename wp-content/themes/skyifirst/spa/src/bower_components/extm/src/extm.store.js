(function() {
  Extm.Store = (function() {
    function Store() {}

    Store.prototype.models = {};

    Store.prototype.find = function(name, args) {
      var collection, model, models, _models;
      if (args == null) {
        args = null;
      }
      _models = this.models;
      if (_.isUndefined(this.models[name])) {
        this.models[name] = new Backbone.Collection;
      }
      if (_.isNull(args)) {
        this.models[name].url = "" + AJAXURL;
        return $.Deferred(function(deferred) {
          if (_models[name].length === 0) {
            return _models[name].fetch({
              data: {
                action: "fetch-" + name + "s"
              },
              success: function(collection) {
                return deferred.resolve(collection);
              },
              error: function(error) {
                return deferred.reject(error);
              }
            });
          } else {
            return deferred.resolve(_models[name]);
          }
        }).promise();
      }
      if (_.isNumber(args)) {
        model = this.models[name].get(args);
        if (!model) {
          model = new Backbone.Model;
          model.name = name;
          model.set('id', args);
          return $.Deferred(function(deferred) {
            return model.fetch({
              success: function(model) {
                _models[name].add(model);
                return deferred.resolve(model);
              },
              error: function(error) {
                return deferred.reject(error);
              }
            });
          }).promise();
        }
        return $.Deferred(function(deferred) {
          return deferred.resolve(model);
        }).promise();
      }
      if (_.isObject(args)) {
        models = this.models[name].where(args);
        collection = new Backbone.Collection(models);
        if (collection.length === 0) {
          collection.url = "" + AJAXURL;
          return $.Deferred(function(deferred) {
            return collection.fetch({
              data: {
                action: "fetch-" + name + "s",
                filters: args
              },
              success: function(collection) {
                _models[name].add(collection.models);
                return deferred.resolve(collection);
              },
              error: function(error) {
                return deferred.reject(error);
              }
            });
          }).promise();
        }
        return $.Deferred(function(deferred) {
          return deferred.resolve(collection);
        }).promise();
      }
    };

    Store.prototype.push = function(name, value) {
      var model;
      if (_.isUndefined(this.models[name])) {
        this.models[name] = new Backbone.Collection;
      }
      if (_.isArray(value)) {
        return _.each(value, (function(_this) {
          return function(attr, index) {
            var model;
            model = new Backbone.Model(attr);
            model.name = name;
            return _this.models[name].add(model);
          };
        })(this));
      } else if (_.isObject(value)) {
        model = new Backbone.Model(attr);
        model.name = name;
        return this.models[name].add(model);
      }
    };

    Store.prototype._findAll = function() {};

    Store.prototype._query = function() {};

    return Store;

  })();

}).call(this);
