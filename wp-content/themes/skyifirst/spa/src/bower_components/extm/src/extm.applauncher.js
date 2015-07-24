(function() {
  var AppLauncher;

  AppLauncher = (function() {
    AppLauncher.prototype.region = null;

    AppLauncher.prototype.options = {};

    AppLauncher.prototype.appName = '';

    function AppLauncher(appName) {
      this.appName = appName;
    }

    AppLauncher.prototype.insideRegion = function(region) {
      this.region = region;
      return this;
    };

    AppLauncher.prototype.withOptions = function(options) {
      this.options = _.defaults({
        region: this.region
      }, options);
      return this._launch();
    };

    AppLauncher.prototype._launch = function() {
      var Controller;
      Controller = this._getControllerClass();
      new Controller(this.options);
      return this._deleteReference();
    };

    AppLauncher.prototype._getControllerClass = function() {
      if (_.isUndefined(_Controllers[this.appName])) {
        throw new Error('No such controller registered');
      }
      return _Controllers[this.appName];
    };

    AppLauncher.prototype._deleteReference = function() {
      delete this.region;
      delete this.options;
      return delete this.appName;
    };

    return AppLauncher;

  })();

}).call(this);
