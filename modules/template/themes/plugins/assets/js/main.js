require.config({
  baseUrl: "modules/template/themes/plugins/assets/js/lib"
  , shim: {
    'backbone': {
      deps: ['underscore', 'jquery'],
      exports: 'Backbone' 
    },
    'underscore': {
      exports: '_'
    },
    'bootstrap': {
      deps: ['jquery'],
      exports: '$.fn.popover'
    }
  }
  , paths: {
    app         : ""
    , collections : "modules/template/themes/plugins/assets/js/collections"
    , data        : "modules/template/themes/plugins/assets/js/data"
    , models      : "modules/template/themes/plugins/assets/js/models"
    , helper      : "modules/template/themes/plugins/assets/js/helper"
    , templates   : "modules/template/themes/plugins/assets/js/templates"
    , views       : "modules/template/themes/plugins/assets/js/views"
  }
});
require([ 'app/app'], function(app){
  app.initialize();
});
