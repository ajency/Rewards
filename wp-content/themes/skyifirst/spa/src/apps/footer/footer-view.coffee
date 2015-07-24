define [ 'marionette' ], ( Mariontte )->

    class FooterView extends Marionette.ItemView

        template : '<div class="text-center">
        				<div class="link small termsLink" >Terms &amp; Conditions</div> |
        				<div  class="salesLink text-center small">Sales Login</div>
                        <div style="display:none"  class="salesLogout text-center small ">Logout</div>
        			</div>'

        events:
        	'click .salesLogout':(e)->
                localStorage.setItem("login" , 0)
                win = window.open(SITEURL+'/wp-login/', '_self')

            'click .link':(e)->
                win = window.open('http://manaslake.com/terms-conditions/', '_blank')

            'click .salesLink':(e)->
                win = window.open(SITEURL+'/wp-admin/', '_self')

            

        onShow:->
            login = localStorage.getItem("login")
            if parseInt(login) == 1
                $('.salesLink').hide()
                $('.salesLogout').show()

                
        		
       	