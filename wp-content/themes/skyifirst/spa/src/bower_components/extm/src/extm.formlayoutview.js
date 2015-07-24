(function() {
  var __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  Extm.FormLayoutView = (function(_super) {
    __extends(FormLayoutView, _super);

    function FormLayoutView() {
      return FormLayoutView.__super__.constructor.apply(this, arguments);
    }

    FormLayoutView.prototype.tagName = 'form';

    FormLayoutView.prototype.className = 'extm-form-layout-view';

    FormLayoutView.prototype.onShow = function() {
      return this.$el.validate();
    };

    return FormLayoutView;

  })(Marionette.LayoutView);

}).call(this);
