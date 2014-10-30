define ['app','text!apps/Redemption/templates/redemption.html'], (App,redemptionTpl)->

    App.module "AddRedemption.Views", (Views, App)->

        
        class SingleView extends Marionette.ItemView
            
            tagName     : 'tr'
            
            template    : '<td class="v-align-middle width25"><div class="table_mob_hidden">Name</div>{{display_name}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">Email</div>{{user_email}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">Status</div>{{status}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">Date</div>{{date}}</td>'


           



        class Views.ListRedemption extends Marionette.CompositeView

            template    : redemptionTpl

           

            itemView    : SingleView

            itemViewContainer : 'table#redemption_table tbody'


            

            


        


            



        
        