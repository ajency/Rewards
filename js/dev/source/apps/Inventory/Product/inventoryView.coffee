define ['app','text!apps/Inventory/Product/templates/inventProduct.html'], (App,inventoryTpl)->

    App.module "ListInventory.Views", (Views, App)->

        
        class SingleViewP extends Marionette.ItemView
            
            tagName     : 'tr'
            
            template    : '
                          <td class="v-align-middle width25"><div class="table_mob_hidden">Product</div>{{product_name}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">No of Closed R</div>{{Closed_Count}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">No of Confirmed R</div>{{Confirmed_count}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">No of Initiated R</div>{{Initiated_count}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">No of Approved R</div>{{Approved_count}}</td>'


           



        class Views.Show extends Marionette.CompositeView

            template    : inventoryTpl



            itemView    : SingleViewP

            itemViewContainer : 'table#inventoryProduct_table tbody'


            onShow:->
              @$el.find("#inventoryProduct_table")
              .tablesorter({theme: 'blue',widthFixed: true,sortList: [ [0,1] ], widgets: ['zebra', 'filter']})
              .tablesorterPager({
                container: $(".pager")
                size: 25
              })


         

            


        


            



        
        