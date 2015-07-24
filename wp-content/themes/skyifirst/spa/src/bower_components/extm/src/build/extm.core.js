
var Extm;

Extm = (function ( global, Backbone, _ , Marionette, Mustache, async) {

    "use strict";

    Extm = {};
    Extm.$ = Backbone.$;

    //@include ../extm.wp.model.js

    //@include ../extm.controllers.js

    //@include ../extm.applauncher.js
    //@include ../extm.store.js
    //@include ../extm.msgbus.js

    //@include ../extm.application.js
    //@include ../extm.region.controller.js
    //@include ../extm.marionette.renderer.js

    //@include ../extm.formview.js
    //@include ../extm.formlayoutview.js

    return Extm;

})( this, Backbone, _, Marionette, Mustache, async );