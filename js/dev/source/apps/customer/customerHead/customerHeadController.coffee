define [ 'app'
         'controllers/region-controller', 'apps/customer/customerHead/customerHeadView' ], ( App, RegionController )->
    App.module "customerHead", ( customerHead, App )->
        user = ""
        class CustomerHeadController extends RegionController

            initialize: ( opt ) ->
                {username} = opt

                @subregion = opt.subregion

                @topRegion = opt.subregion

                @ID = opt.ID

                @shipping_val = opt.shipping_val

                console.log @shipping_val
                user = username

                @view = view = @_getCustomerHeaderView()

                @listenTo view, "change:customer:view", @_changecustomerView

                @listenTo view, "change:customerInfo:view", @_getCustomerInfoView

                @listenTo view, "change:customerShipping:view", @_getCustomerShippingView

                #show the layout
                @show view

            #function to get the view of Customer
            _getCustomerHeaderView:->
                new customerHead.Views.Head
                    shipping_val : @shipping_val

            _changecustomerView: =>
                App.execute "show:info",
                    region: @subregion
                    username: user
                    topRegion: @topRegion
                    ID: @ID


            _getCustomerInfoView: =>
                App.execute "show:customers",
                    region: @subregion
                    username: user
                    topRegion: @topRegion
                    ID: @ID

            _getCustomerShippingView: =>
                App.execute "show:shipping",
                    region: @subregion
                    username: user
                    topRegion: @topRegion
                    ID: @ID


        # set handlers
        App.commands.setHandler "show:customer:head", ( opt = {} )->
            console.log opt
            new CustomerHeadController opt