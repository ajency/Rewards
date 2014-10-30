define [ 'app'
         'controllers/region-controller'
         'apps/program-member/members/member_controller'
         'apps/customer/customerHead/customerHeadController'
         'apps/customer/Info/InfoController'
         'apps/customer/rewards/rewardsController'
         'apps/customer/shipping/shippingController'
         'text!apps/customer/templates/mainCustomer.html' ], ( App, RegionController, MemeberApp, HeadApp, InfoApp, rewardsApp, shippingApp, mainfileTpl )->
    App.module "CustomerInfo", ( CustomerInfo, App )->

        # define routers
        username_value = ""
        username_id = ""
        shipping_val = ""
        class CustomerRouter extends Marionette.AppRouter

            appRoutes:
                'user/:username/:id': 'edit'
                'shipping/:username/:id': 'shipping'


        RouterAPI =
        #function to start the Info App
            edit: ( username, id )->
                console.log username
                console.log id
                username_value = username
                username_id = id
                App.execute "show:customers",
                    region: App.mainContentRegion
                    subregion: App.mainContentRegion
                    username: username
                    ID: username_id
                    topRegion: App.mainContentRegion

            show: ->
                App.execute "show:info", region: App.mainContentRegion

            shipping :(username,id)->
                console.log username
                console.log id
                username_value = username
                username_id = id
                shipping_val  = 1

                App.execute "show:shipping" ,
                    region : App.mainContentRegion
                    username : username
                    topRegion : @topRegion
                    ID 		 : @ID
                    subregion : App.mainContentRegion


        #start Customer App
        CustomerInfo.on 'start', ->
            new CustomerRouter
                controller: RouterAPI


        class ProductOptionsController extends RegionController

            initialize: ->

                # get the Products outer layout
                @layout = layout = @_getProductsView()

                #listen to show event of layout to trigger sub apps
                @listenTo layout, 'show', @showRegionViews

                #show the layout
                @show layout

            # start the sub apps of Products
            showRegionViews: =>
                console.log shipping_val
                App.execute "show:customer:head",
                    region: @layout.topRegion
                    username: username_value
                    subregion: App.mainContentRegion
                    ID: username_id
                    shipping_val : shipping_val
                    topRegion: App.mainContentRegion



            _getProductsView: =>
                new ProductView


        ##
        # The outer layout for the Products app
        #
        class ProductView extends Marionette.Layout

            template: mainfileTpl

            className: 'content'

            regions:
                topRegion: '#topregion'
                bottomRegion: '#bottomregion'


        # set handlers
        App.commands.setHandler "show:customerapp", ( opt = {} )->
            new ProductOptionsController opt

