define [ 'extm', 'src/apps/booking/header/header-view' ], ( Extm, HeaderView )->

    class HeaderController extends Extm.RegionController

        initialize :(opt = {})->
            @view = view = @_getHeaderView() 

            @show view


        _getHeaderView:->
            new HeaderView
                


        



    msgbus.registerController 'booking:header', HeaderController