(function() {
  var __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  Extm.Application = (function(_super) {
    __extends(Application, _super);

    Application.prototype._staticApps = [];

    Application.prototype.histroyStarted = false;

    Application.prototype.defaultRoute = '';

    function Application(options) {
      if (options == null) {
        options = {};
      }
      this.store = msgbus._store;
      Application.__super__.constructor.call(this, options);
    }

    Application.prototype.start = function(options) {
      if (options == null) {
        options = {};
      }
      if (_.size(this.getRegions()) === 0) {
        throw new Error('application regions not specified');
      }
      Application.__super__.start.call(this, options);
      return this.startHistory();
    };

    Application.prototype._setUpRegions = function(regions) {
      return this.addRegions(regions);
    };

    Application.prototype.startHistory = function() {
      if (!this.histroyStarted) {
        Backbone.history.start();
        if (this.getCurrentRoute() === '') {
          this.navigate(this.defaultRoute, {
            trigger: true
          });
        }
        this.histroyStarted = true;
        if (this._hasStaticApps()) {
          return this._startStaticApps();
        }
      }
    };

    Application.prototype.navigate = function(route, options) {
      return Backbone.history.navigate(route, options);
    };

    Application.prototype.setDefaultRoute = function(route) {
      if (route == null) {
        route = '';
      }
      return this.defaultRoute = route;
    };

    Application.prototype.getCurrentRoute = function() {
      var frag;
      frag = Backbone.history.fragment;
      if (_.isEmpty(frag)) {
        return '';
      } else {
        return frag;
      }
    };

    Application.prototype.addStaticApps = function(apps) {
      return this._staticApps = apps;
    };

    Application.prototype._hasStaticApps = function() {
      return _.size(this._staticApps) > 0;
    };

    Application.prototype._startStaticApps = function() {
      return _.each(this._staticApps, function(app, index) {
        return msgbus.showApp(app[0]).insideRegion(app[1]).withOptions(_.isUndefined(app[2]) ? {} : app[2]);
      });
    };

    return Application;

  })(Marionette.Application);

}).call(this);
