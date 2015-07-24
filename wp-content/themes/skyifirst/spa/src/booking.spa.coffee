# all modules will start with 'src/'.
# eg: define 'plugins-loader', ['src/bower_component/pluginname'], ->

# add your required plugins here.
define 'plugin-loader', ['handlebars','parsleyjs','jqueryui','autoNumeric'], ->

    # add your marionette apps here
define 'apps-loader', [

    'src/apps/footer/footer-controller'
    'src/apps/booking/header/header-controller'
    'src/apps/booking/booking-main/main-layout'
    'src/apps/booking/screen-one/screen-one-controller'
    'src/apps/booking/screen-two/screen-two-controller'
    'src/apps/booking/screen-three/screen-three-controller'
], ->

    # set all plugins for this page here
require [ 'plugin-loader'
          'extm'
          'src/classes/ap-store'
          'src/apps/router'
          'apps-loader'], ( plugins,Extm )->

    # global application object
    window.App = new Extm.Application

    App.layout = ""

    # add your application main regions here
    App.addRegions
        headerRegion : '#header-region'
        footerRegion : '#footer-region'
        filterRegion : '#filter-region'
        mainRegion : '#main-region'
       


    
        


        


  
        
        

    # load static apps
    staticApps = [

    ]
    



    if window.location.hash is ''
        staticApps.push [ 'booking:main:app', App.mainRegion ]
       

















    App.addStaticApps staticApps

    # start application
    App.start()

