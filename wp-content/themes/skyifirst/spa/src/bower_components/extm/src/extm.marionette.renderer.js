(function() {
  Marionette.Renderer.render = function(template, data) {
    if (data == null) {
      data = {};
    }
    if (!template) {
      template = '';
    }
    return Mustache.to_html(template, data);
  };

}).call(this);
