define [ 'extm'], ( Extm)->

    # Main controller
    view = []
    facing = []
    facingnames = []
    viewnames = []
    class MainController extends Extm.RegionController

        initialize : ->

            @layout = layout = @_getView()

            App.layout = @layout

            #listen to show event of layout to trigger sub apps
            @listenTo layout, 'show', @showRegionViews

            #show the layout
            @show layout

        showRegionViews: =>
            msgbus.showApp 'booking:header'
            .insideRegion  App.headerRegion
                .withOptions()

            
            msgbus.showApp 'booking:screen:one'
            .insideRegion  @layout.screenOneRegion
                .withOptions()

        _getView: =>
            new mainView
                templateHelpers:
                    SITEURL : SITEURL
                    VIEWS : VIEWS
                    FACINGS : FACINGS


    class mainView extends Marionette.LayoutView

        template: '<div class="container ">
                        <div class="page-container">
                            <h3 class="session text-center"></h3>
                            <div class="accordion ">

                                <h3 class="light text-center m-t-0 step1">4 STEPS TO BUYING YOUR APARTMENT</h3>
                                <h4 class="text-center introTxt">Complete your booking securely through our payment gateway.</h4>
                                <div class="accordion-group one open viewed">

                                    <div class="acc-title">
                                        <h4>1. Sign In</h4>
                                    </div>
                                    <div class="acc-body">
                                        <div id="screen-one-region" class="section">
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-group two">
                                    <div class="acc-title">
                                        <h4>2. Review Details</h4>
                                    </div>
                                    <div class="acc-body">
                                        <div id="screen-two-region" >
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-group three">
                                    <div class="acc-title">
                                        <h4>3. Enter Personal Details</h4>
                                    </div>
                                    <div class="acc-body">
                                        <div id="screen-three-region" >
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-group four">
                                    <div class="acc-title">
                                        <h4>4. Payment</h4>
                                    </div>
                                    <div class="acc-body">
                                        <div id="screen-four-region" >
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>'

                 



        regions:
            screenOneRegion: '#screen-one-region'
            screenTwoRegion: '#screen-two-region'
            screenThreeRegion: '#screen-three-region'
            screenFourRegion: '#screen-four-region'


        
          
      
    

            


        





    msgbus.registerController 'booking:main:app', MainController