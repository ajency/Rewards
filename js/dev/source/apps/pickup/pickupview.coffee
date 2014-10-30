define ['app','text!apps/pickup/templates/pickup.html'], (App,pickupTpl)->

    App.module "ListPickup.Views", (Views, App)->

        
        class SingleView extends Marionette.ItemView
            
          
            template    : '<li class="month">
                    <h5>{{month}} {{year}}</h5>
                    <ul class="days">
                      {{#date}}
                      <li class="date">
                        <div class="date-num">
                         {{date_array}}
                        </div>
                        <div class="people">
                          {{#name_array}}
                          <a href="#referrals/{{hash}}/{{user_id}}">{{name}}</a>, 
                          {{/name_array}}
                        </div>
                      </li>
                      {{/date}}
                    </ul>
                  </li>'
                          

           

        class Views.Show extends Marionette.CompositeView

            template    : pickupTpl

           

            itemView    : SingleView

            itemViewContainer : 'ul.pickup '





         

            


        


            



        
        