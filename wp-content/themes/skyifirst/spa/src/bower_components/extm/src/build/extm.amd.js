(function ( root, factory ) {

    var babysitter, backbone, underscore, wreqr;

    if (typeof exports === "object") {

        underscore = require( "underscore" );
        backbone = require( "backbone" );
        wreqr = require( "backbone.wreqr" );
        babysitter = require( "backbone.babysitter" );

        return module.exports = factory( underscore, backbone, wreqr, babysitter );

    } else if (typeof define === "function" && define.amd) {
        return define( ["underscore",
                        "backbone",
                        "marionette",
                        "mustache",
                        "async",
                        "jqueryvalidate"], factory );
    }

})( this, function ( _, Backbone, Marionette, Mustache, async ) {

    //@include extm.core.js

    Marionette.Extm = Extm;

    return Extm;
} );
