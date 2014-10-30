define ['app','text!apps/referrallist/templates/referral.html'], (App,referrallistTpl)->

    App.module "Add.Views", (Views, App)->

        console.log "test"
        class SingleView extends Marionette.ItemView
            
            tagName     : 'tr'
            
            template    : '<td class="v-align-middle width25"><div class="table_mob_hidden">Name</div>{{display_name}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">Date Added on</div>{{date}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">Program Member</div>{{program_name}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">Status</div>{{status}}</td>
                          <td class="v-align-middle width25"><div class="table_mob_hidden">Conversion Date</div>{{date_import}}</td>'


           



        class Views.List extends Marionette.CompositeView

            template    : referrallistTpl

           

            itemView    : SingleView

            itemViewContainer : 'table#referrallist_table tbody'


            onShow:->
              dates = @collection.pluck('old')
              first = _.first(dates)
              newdates = @collection.pluck('current')
              console.log newfirst = _.first(newdates)
              @$el.find("#referrallist_table")
              .tablesorter({theme: 'blue',widthFixed: true,sortList: [ [0,1] ], widgets: ['zebra', 'filter']})
              .tablesorterPager({
                container: $(".pager")
                size: 25
              })
              if @$el.find('#to_date').val() == ""
                  @$el.find('#to_date').val newfirst
                  @$el.find('#to_date').datepicker({
                  format: 'yyyy-mm-dd ',
                  startDate : newfirst
             
                  })
              if @$el.find('#from_date').val() == ""
                  @$el.find('#from_date').val first
                  @$el.find('#from_date').datepicker({
                  format: 'yyyy-mm-dd ',
                  startDate : first
                  })

             
              @$el.find('#status1').prop('checked',true)
              @$el.find('#status2').prop('checked',true)
              @$el.find('#from_date').prop('checked',true)
              @$el.find('#to_date').prop('checked',true)

            events      :->
              'click #status_check' :(e)->
                @$el.find('#status1').prop('checked',true)
                @$el.find('#status2').prop('checked',true)
                

              'click #status_uncheck' :(e)->
                @$el.find('#status1').prop('checked',false)
                @$el.find('#status2').prop('checked',false)

              'click #date_uncheck' :(e)->
                @$el.find('#from_date').val ""
                @$el.find('#to_date').val ""

              #submit the form
              'click #submitform' :(e)->
                e.preventDefault()
                $(".ref_msg").remove()
                if @$el.find('#to_date').val() < @$el.find('#from_date').val()
                  $(".date_msg").before '<div class="ref_msg alert alert-error m-b-5 m-t-20">
                  <button data-dismiss="alert" class="close"></button>To date cannot be less than From date</div>'


                  
                  return false
                @$el.find('#hideshow').addClass 'collapsed'
                @$el.find('#collapseOne').removeClass 'collapse in'
                @$el.find('#collapseOne').addClass 'collapse'
                @trigger "filter:referral:info" , Backbone.Syphon.serialize @


              'click #exportcsv' :(e)->
                e.preventDefault()
                @trigger "export:to:csv" , Backbone.Syphon.serialize @


               

            


        


            



        
        