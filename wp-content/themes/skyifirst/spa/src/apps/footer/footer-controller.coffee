define [ 'extm', 'src/apps/footer/footer-view' ], ( Extm, FooterView )->

    class FooterController extends Extm.RegionController

        initialize : ->
            @show new FooterView
            	SITEURL : SITEURL

        # onComplete : ->
        #     @show new FooterView

    msgbus.registerController 'footer', FooterController