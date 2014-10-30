define ['app'
        'controllers/region-controller'
        'apps/program-member/programmember/program-member-view'], (App, RegionController)->
  App.module "Member", (Member, App)->
    class ProgramMembersController extends RegionController

      initialize: ->
        #get Program Member Collection
        @memberCollection = App.request "get:member:collection"

        #function call
        @view = view = @_getView @memberCollection

        #listen to the event
        @listenTo view, "filter:member:info", @_filterMember

        @listenTo view, "change:member:collection", @_changeCollection

        
        #show the view
        App.execute "when:fetched", [@memberCollection], =>
          @show view

      #show a list of all Program members
      _getView: (memberCollection) ->
       new Member.Views.ProgramMember
          collection: memberCollection
          templateHelpers:
            AJAXURL: AJAXURL

      #filter the list of Program Members
      _filterMember: (data)->
        newMemberCollection = App.request "filter:member:model", data
        console.log newMemberCollection
        @memberCollection.reset(newMemberCollection)
      #@view.triggerMethod "filtered:models:list" , newMemberCollection
      #console.log newMemberCollection
        $("#program-member-table").trigger("update")
       

      _changeCollection: (data)=>
        App.request "change:cloned:Collection", data
    #@memberCollection.reset data


    # set handlers
    App.commands.setHandler "show:program:members", (opt = {})->
      new ProgramMembersController opt