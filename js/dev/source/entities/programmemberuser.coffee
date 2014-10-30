define ['app' , 'backbone'], (App) ->

	App.module "Entities.ProgramMember", (ProgramMember, App)->
		
		#define ProgramMember Model
		class ProgramMember extends Backbone.Model

			idAttribute : 'ID'

			defaults:
					display_name       		   	: ''
					referral_count  			: ''
					user_registered				: ''
					customer                    : ''
					email						: ''
					phone						: ''
					user_login 					: ''
					points						: ''
					purchased_ref				: ''
					ref_discussion 				: ''
					status 						: ''
					action 						: ''
					initiated					: ''
					confirmed					: ''
					rejected					: ''
					option 						: ''
					approved					: ''
					date_confirm				: ''

										

			
			name : 'programmember'

  


		#define ProgramMember Collection
		class ProgramMemberCollection extends Backbone.Collection

			model : ProgramMember

			

  


			
			url : -> #ajax call to return a  ProgramMember from the databse
				AJAXURL + '?action=get-programmembers'


		# declare a ProgramMember collection instance
		programMemberCollection = new ProgramMemberCollection
		


		
		
		
		
	

		# API
		API = 
			getMembers:-> #returns a collection of Program Members
				programMemberCollection.fetch()
				programMemberCollection

		# Handlers
		App.reqres.setHandler "get:programmember:data" ,(ID) ->
			API.getProgramMemberUser ID
		


		



