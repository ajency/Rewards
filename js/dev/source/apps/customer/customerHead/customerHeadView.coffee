define [ 'app', 'text!apps/customer/customerHead/templates/customerHead.html' ], ( App, customerTpl )->
    App.module "customerHead.Views", ( Views, App )->
        shipping_val = ""
        class Views.Head extends Marionette.ItemView

            template: customerTpl

            initialize: ->
                shipping_val = Marionette.getOption( @, 'shipping_val' )

            events:
                'click #changeView': ( e )->
                    @trigger "change:customer:view"


                'click #changeInfoView': ( e )->
                    @trigger "change:customerInfo:view"

                'click #userstep3': ( e )->
                    e.preventDefault()
                    @trigger "change:customerShipping:view"

            onShow:->
                console.log shipping_val
                if shipping_val == 1
                    $('lishipping').addClass 'active'



				

			
				

			



		
		