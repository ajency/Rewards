define [ 'extm', 'src/apps/booking/screen-one/screen-one-view' ], ( Extm, ScreenOneView )->

	# Screen one controller
	class ScreenOneController extends Extm.RegionController

		initialize : ->
			@view = view = @_getUnitTypesView()


			@show view

		_getUnitTypesView:->
			console.log "aaaaaaaaaaaaaa"
			
			new ScreenOneView
				


	






	   






	msgbus.registerController 'booking:screen:one', ScreenOneController



