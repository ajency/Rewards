define [ 'app'
         'controllers/region-controller'
         'apps/program-member/members/member_view' ], ( App, RegionController )->
    App.module "Member", ( Member, App )->
        class MemberController extends RegionController

            initialize: ( opt )->

                #get the ID
                @ID = opt.ID

                @region = opt.topRegion

                #get Program Member details based on the ID
                @model = App.request "get:program_member:data", @ID

                
                @view = view = @_getMembersView @model

                @listenTo view, "set:new:redemption", @_setRedemption

                @listenTo view, "set:rejected:redemption", @_setRejectedRedemption

                @listenTo view, "send:email:reminder", @_sendNotInitiatedEmail

                @listenTo view, "send:closure:reminder", @_sendClosureEmail

                @listenTo view, "get:options:list", @_getOptionsList


                #show the view
                App.execute "when:fetched", [ @model ], =>
                    @show view

            #get Program Member Details
            _getMembersView: ( model )->
                new Member.Views.Info
                    model: model

            _setRedemption: ( option, username, shipping )->
                object = @
                $.ajax
                    method: "POST"
                    url: AJAXURL+"?action=set-redemption"
                    data: 'option=' + option + '&username=' + username + '&shipping=' + shipping
                    success: ( result )->
                        object.confirmDetails result

                    error: ( result )->


            _setRejectedRedemption: ( option, username )->
                object = @
                $.ajax
                    method: "POST"
                    url: AJAXURL+"?action=set-rejected-redemption"
                    data: 'option=' + option + '&username=' + username
                    success: ( result )->
                        object.rejectDetails result

                    error: ( result )->


            confirmDetails: ( data )=>
                @view.triggerMethod "save:approved:redemption", data

            rejectDetails: ( data )=>
                @view.triggerMethod "save:rejected:redemption", data

            _sendNotInitiatedEmail: ( option, ID, str )->
                object = @
                $.ajax
                    method: "POST",
                    url: AJAXURL+"?action=set-notinitiated-email"
                    data: 'option=' + option + '&ID=' + ID + '&str=' + str,
                    success: ( result )->
                        object.sendInitiateMail result

                    error: ( result )->

            sendInitiateMail: ( data )=>
                @view.triggerMethod "send:Initiate:Reminder", data

            _sendClosureEmail: ( option, ID )->
                object = @
                $.ajax
                    method: "POST"
                    url: AJAXURL+"?action=set-closure-email"
                    data: 'option=' + option + '&ID=' + ID
                    success: ( result )->
                        object.sendClosureMail result

                    error: ( result )->

            sendClosureMail: ( data )=>
                @view.triggerMethod "send:Closure:Reminder", data


            _getOptionsList: ->
                object = @
                $.ajax
                    method: "POST"
                    url: AJAXURL+"?action=get-option-list"
                    data: ''
                    success: ( result )->
                        object.optionList result

                    error: ( result )->

            optionList: ( data )=>
                console.log data
                @view.triggerMethod "set:option:list", data


            # set handlers
        App.commands.setHandler "show:member:info", ( opt = {} )->
            new MemberController opt