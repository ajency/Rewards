define ['app'
		'controllers/region-controller'
		'apps/referrals/referralview'], (App, RegionController)->

	App.module "Add", (Add, App)->

		class Referralcontroller extends RegionController

			initialize : ->
				#get referral Collection
				@referralCollection = App.request "get:referral:collection"
					
				#function call			
				@view= view = @_getReferralView @referralCollection

				#listen to the event
				@listenTo view , "itemview:create:new:referral" , @_addReferral

				#listen to the event
				@listenTo view , "save:new:user" , @_saveUser

				#display the view
				@show view

			#display the list of referrals
			_getReferralView :(referralCollection)->
				new Add.Views.Referral
					collection : referralCollection

			#add a referral
			_addReferral :->
				referralModel = App.request "create:referral:model" 
				@referralCollection.add referralModel

			#save a referral
			_saveUser :(data)->
				object = @
				$.ajax({method: "POST" ,url : AJAXURL+'?action=get_userdata',data : data,success :(result)-> object.showRef result},error:(result)-> object.showRef result)

			#function call on success callback	
			showRef :(result)=>
				@view.triggerMethod "new:referrals:added" , result
				

		# set handlers
		App.commands.setHandler "show:referrals", (opt = {})->
			new Referralcontroller opt		