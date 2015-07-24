(function() {
  var __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  Extm.FormView = (function(_super) {
    __extends(FormView, _super);

    function FormView() {
      return FormView.__super__.constructor.apply(this, arguments);
    }

    FormView.prototype.tagName = 'form';

    FormView.prototype.className = 'extm-form-view';

    FormView.prototype.onShow = function() {
      return this.$el.validate();
    };

    return FormView;

  })(Marionette.ItemView);

}).call(this);
