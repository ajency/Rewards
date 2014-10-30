define ['app' , 'backbone'], (App) ->

	App.module "Entities.ReferralUser", (ReferralUser, App)->
		#define referralUser Model
		class ReferralUser extends Backbone.Model

			idAttribute : 'ID'

			defaults:
					name       		   			: ''
					phone  						: ''
					email						: ''
					date 						: ''
					user_id 					: ''
					points						: ''
					status						: ''
					no_of_perchased_ref 		: ''
					no_of_discussion_referrals	: ''


					

			name : 'referralUser'


		#define referralUser Collection
		class ReferralUserCollection extends Backbone.Collection

			model : ReferralUser
			
			url : -> #ajax call to return a list of all the users from the databse
				AJAXURL + '?action=get-referrals'


			filterById :(ID)->#filter data
				events = @filter (model)-> 
					model.get('user_id') == ID
				events
					


		# declare a referralUser collection instance
		referralUserCollection = new ReferralUserCollection
		clonedCollection = new ReferralUserCollection
		referralUserCollection.fetch()
		clonedCollection.fetch()

		# API
		API = 
			getReferrals:(ID)-> #returns a collection of referralUser
				referralArray = clonedCollection.filterById(ID)
				referralUserCollection.reset(referralArray)
				referralUserCollection



			

			


		# Handlers
		App.reqres.setHandler "get:referral:list" ,(ID) ->
			API.getReferrals ID
		
		



