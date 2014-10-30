define ['app'
		'controllers/region-controller','apps/referrallist/referrallistView'], (App, RegionController)->

	App.module "Add", (Add, App)->

		class referrallistController extends RegionController

			initialize :->

				@referrallistCollection = App.request "get:referrallist:collection" 

				@view= view = @_getReferrallistCollectionView @referrallistCollection

				@listenTo view, "filter:referral:info", @_filterReferral

				@listenTo view, "export:to:csv", @_exportCSV

				#show the layout
				App.execute "when:fetched", [@referrallistCollection], =>
          			@show view

			#function to get the view of Customer
			_getReferrallistCollectionView :(referrallistCollection)->
				console.log referrallistCollection
				new Add.Views.List
					collection : referrallistCollection
					templateHelpers : 
							roles : ROLES
							AJAXURL : AJAXURL

			_filterReferral: (data)->
        		newMemberCollection = App.request "filter:referral:model", data
        		@referrallistCollection.reset(newMemberCollection)
        		$("#referrallist_table").trigger("update")

        	_exportCSV:(data)=>
        		object = @
        		window.location.href = AJAXURL+'?action=export_csv&from_date='+data.from_date+
        		'&to_date='+data.to_date+'&status1='+data.status1+'&status2='+data.status2+'&coll='+@referrallistCollection
        		

			
					
						

		# set handlers
		App.commands.setHandler "show:referralslist", (opt = {})->
			new referrallistController 