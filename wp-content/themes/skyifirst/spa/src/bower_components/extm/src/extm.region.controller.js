(function() {
  var __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    __slice = [].slice;

  Extm.RegionController = (function(_super) {
    __extends(RegionController, _super);

    function RegionController(options) {
      if (options == null) {
        options = {};
      }
      this.region = false;
      this.currentView = false;
      this._promises = [];
      if (!options.region) {
        throw new Error('Region is not specified for the controller');
      }
      this._assignRegion(options.region);
      this.instanceId = _.uniqueId('region-controller-');
      msgbus.commands.execute('register:controller', this.instanceId, this);
      RegionController.__super__.constructor.call(this, options);
    }

    RegionController.prototype._assignRegion = function(region) {
      return this.region = region;
    };

    RegionController.prototype.store = function() {
      return this;
    };

    RegionController.prototype.find = function(name, args) {
      var promise;
      promise = msgbus._store.find(name, args);
      this._promises.push(promise);
      return promise;
    };

    RegionController.prototype.wait = function() {
      return $.when.apply($, this._promises).done((function(_this) {
        return function() {
          var resolved;
          resolved = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
          resolved.unshift('complete');
          return _this.triggerMethod.apply(_this, resolved);
        };
      })(this));
    };

    RegionController.prototype.destroy = function() {
      var args;
      args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
      delete this.region;
      delete this.currentView;
      delete this.options;
      msgbus.commands.execute("unregister:controller", this.instanceId, this);
      return RegionController.__super__.destroy.call(this, args);
    };

    RegionController.prototype.show = function(view) {
      this.currentView = view;
      return this.region.show(view);
    };

    return RegionController;

  })(Marionette.Controller);

}).call(this);
