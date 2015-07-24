(function() {
  _.extend(Backbone.Model.prototype, {
    sync: function(method, model, options) {
      var allData, idAttr, onlyChanged, params, xhr, _action, _ref, _ref1;
      if (!this.name) {
        throw new Error("'name' property not set for the model");
      }
      params = {
        type: "POST",
        dataType: "json",
        data: {}
      };
      params.url = AJAXURL;
      _action = "" + method + "-" + this.name;
      params.data['action'] = _action;
      switch (method) {
        case 'read':
          params.type = 'GET';
          idAttr = model['idAttribute'];
          params.data[idAttr] = model.get(idAttr);
          break;
        case 'create':
          params.data = _.defaults(model.toJSON(), params.data);
          break;
        case 'update':
          onlyChanged = (_ref = options.onlyChanged) != null ? _ref : false;
          idAttr = model['idAttribute'];
          if (onlyChanged) {
            params.data[idAttr] = model.get(idAttr);
            if (model.hasChanged()) {
              params.data.changes = {};
              _.each(model.changed, function(changeAttributeValue, changeAttributeName) {
                return params.data.changes[changeAttributeName] = changeAttributeValue;
              }, this);
            }
          } else {
            params.data = _.defaults(model.toJSON(), params.data);
          }
          break;
        case 'delete':
          allData = (_ref1 = options.allData) != null ? _ref1 : true;
          if (allData) {
            params.data = _.defaults(model.toJSON(), params.data);
          } else {
            idAttr = model['idAttribute'];
            params.data[idAttr] = model.get(idAttr);
          }
      }
      xhr = options.xhr = Backbone.ajax(_.extend(params, options));
      model.trigger("" + method + ":request", model, xhr, options);
      model["_" + method] = xhr;
      return xhr;
    }
  });

}).call(this);
