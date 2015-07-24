define [ 'extm', 'src/apps/booking/screen-three/screen-three-view' ], ( Extm, ScreenThreeView )->

    # Screen Three controller
    class ScreenThreeController extends Extm.RegionController

        initialize : ->
            @view = view = @_getUnitTypesView()


            @show view

        _getUnitTypesView:->
            new ScreenThreeView
                


    






       






    msgbus.registerController 'booking:screen:three', ScreenThreeController



