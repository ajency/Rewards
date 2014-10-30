define [ 'app', 'text!apps/customer/Info/templates/customerinfolist.html' ], ( App, customerTpl )->
    App.module "Customer.Views", ( Views, App )->
        points = ""
        class SingleView extends Marionette.ItemView

            tagName: 'tr'



            template: '<td>{{srno}}</td><td>{{name}}</td><td>{{phone}}</td><td>{{user_email}}</td><td>{{date_of_purchase}}</td><td>{{date_of_expire}}</td><td>{{points}}</td>'


            serializeData: ->
                data = super()
                date_of_expire = @model.get 'date_of_expire'
                date_of_import = @model.get 'date_of_import'
                result = '--'
                if date_of_import != '--'
                    date_elements = date_of_expire.split( '-' )
                    date_elements_import = date_of_import.split( '-' )
                    end = moment( [ date_elements[0], date_elements[1], date_elements[2] ] )
                    start = moment( [ date_elements_import[0], date_elements_import[1], date_elements_import[2] ] )
                    res = start.from( end )
                    result = res.replace( 'ago', 'left' )

                data.date_of_expire = result
                data


        class Views.List extends Marionette.CompositeView

            template: customerTpl

            className: "padding-20"

            initialize: ->
                points = Marionette.getOption( @, 'ID' )


            itemView: SingleView

            itemViewContainer: 'table#customer_table tbody'

            collectionEvents:
                'add': 'DisplayMessage'

            events:
                'click #inititate-redemt': ->
                    if @collection.length != 0
                        pts = @collection.models[0].attributes.sum_of_points
                    else
                        pts = ""
                    $( "#lireferrals" ).removeClass 'active'
                    $( "#lishipping" ).removeClass 'active'
                    $( "#lirewards" ).addClass 'active'
                    @trigger "change:customer:view", pts

                'click #changeView': ->
                    if @collection.length != 0
                        pts = @collection.models[0].attributes.sum_of_points
                    else
                        pts = ""
                    $( "#lireferrals" ).removeClass 'active'
                    $( "#lishipping" ).removeClass 'active'
                    $( "#lirewards" ).addClass 'active'
                    @trigger "change:customer:view", pts




            #function to display the number of customers
            DisplayMessage: ( model )->
                sum = model.get 'sum_of_points'
                ref_count = model.get 'ref_count'
                # check collection length
                counter = @collection.length
                if counter == 0
                    @$el.find( "#counter_val" ).text ref_count
                    @$el.find( "#pointer_val" ).text ref_count
                else
                    @$el.find( "#counter_val" ).text ref_count
                    @$el.find( "#pointer_val" ).text sum

            onShow: ->
                object = @
                console.log @collection
                @collection.trigger ('reset')
                $.ajax
                    method: "POST",
                    url: AJAXURL + '?action=get_points',
                    data: 'username=' + points,
                    success: ( result )->
                        stringname = result.status
                        object.$el.find( "#pm-name" ).text result.display_name
                        stringname.replace( /\s/g, '' )
                        if(result.status == "" || result.status == 'Redemption Not initiated' )
                            status = 'Redemption Not Initiated'
                            text_msg = 'Select a reward package to initiate redemption of points.'
                        if (result.status == "Initiated" )
                            status = 'Redemption initiated. Waiting for Approval'
                            text_msg = 'The Rewards Manager needs to approve your reward request. Please wait for an email.'
                        if (result.status == "Approved" )
                            status = 'Reward Request Approved'
                            text_msg = 'To collect your reward from our office, confirm a convenient date and time.'
                        if (result.status == "Confirmed" )
                            status = 'Confirmed'
                            text_msg = 'Do remember to pick up your reward on the set date and time.'
                        if (result.status == "closed" )
                            status = 'closed'
                            text_msg = 'Redemption process complete and closed.'
                        object.$el.find( "#redemption_status" ).text status
                        object.$el.find( "#redemption_msg" ).text text_msg
                        if stringname == 'Approved' || stringname == 'Confirmed' || stringname == 'Initiated'
                            object.$el.find( "#inititate-redemt" ).hide()
                            object.$el.find( "#redemption_msg1" ).text "Redemption was initiated by " + result.initiatedby + " on " + result.date

                    error: ( result )->