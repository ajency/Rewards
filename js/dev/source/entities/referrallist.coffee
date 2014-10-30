define ['app' , 'backbone'], (App) ->

	App.module "Entities.Referrallist", (Referrallist, App)->

		#define Referrallist model
		class Referrallist extends Backbone.Model

			idAttribute : 'ID'

			defaults:
					display_name       		   	: ''
					program_name 				: ''
					status						: ''
					date 						: ''
					date_import					: ''
					datevalue					: ''

							


			name : 'referrallist'


		#define Referrallist collection
		class ReferrallistCollection extends Backbone.Collection

			model : Referrallist
			
			url : -> #ajax call to return a list of all the Redemption from the databse
				AJAXURL + '?action=get-referrallist'

			 #funcion to filter member collection and return an array of models
			filterbydata: (data)->
				events1 = @filter (model)->
				   
					if  data.status1
						status1 = model.get('status') == 'New Referral'
					else
						status1 = false
					if  data.status2
						status2 = model.get('status') == 'Converted'
					else
						status2 = false
					datecompare = true
					if  data.from_date !=""  &&  data.to_date != ""
						if    data.from_date  <= model.get('datevalue') && model.get('datevalue')  <= data.to_date
							datecompare = true
							
						else
							datecompare = false
							
					
				   

					
					(status1 || status2 ) &&  
					(datecompare)




				#newMemberCollection.add(events)
				events1


		# declare a Redemption collection instance
		referrallistCollection = new ReferrallistCollection
		clonedRefCollection = new ReferrallistCollection
		
		
		

		# API
		API = 
			getRedemption:-> #returns a collection of Redemption
				referrallistCollection.fetch
					reset :  true
					

				clonedRefCollection.fetch
					reset :  true

				referrallistCollection
					



			filterReferral: (data)->#filter collection
				memberArray = clonedRefCollection.filterbydata(data)
				memberArray



			 


			

			


		# Handlers
		App.reqres.setHandler "get:referrallist:collection"  , (opt) ->
			API.getRedemption()
		App.reqres.setHandler "filter:referral:model", (data) ->
			API.filterReferral data


