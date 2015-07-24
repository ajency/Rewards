define [ 'extm', 'src/apps/booking/screen-two/screen-two-view' ], ( Extm, ScreenTwoView )->

    # Screen Two controller
    class ScreenTwoController extends Extm.RegionController

        initialize : ->
            @view = view = @_getUnitTypesView()


            @show view

        _getUnitTypesView:->
            new ScreenTwoView
                


    






       






    msgbus.registerController 'booking:screen:two', ScreenTwoController



