define ['app','text!apps/Inventory/Package/templates/inventoryPackage.html'], (App,inventoryPackageTpl)->

    App.module "ListInventoryPackage.Views", (Views, App)->

        
        class SingleView extends Marionette.ItemView
            
            tagName     : 'tr'
            
            template    : '
                          <td class="v-align-middle width25"><div class="table_mob_hidden">Package</div>{{option_name}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">Product</div>{{product_name}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">No of Closed R</div>{{Closed_Count}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">No of Confirmed R</div>{{Confirmed_count}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">No of Initiated R</div>{{Initiated_count}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">No of Approved R</div>{{Approved_count}}</td>'


           



        class Views.ShowPackage extends Marionette.CompositeView

            template    : inventoryPackageTpl

           

            itemView    : SingleView

            itemViewContainer : 'table#inventory_table tbody'


            onShow:->
              @$el.find("#inventory_table")
              .tablesorter({theme: 'blue',widthFixed: true,sortList: [ [0,1] ], widgets: ['zebra', 'filter']})
              .tablesorterPager({
                container: $(".pager1")
                size: 25
              })


         

            


        


            



        
        