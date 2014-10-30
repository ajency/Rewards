define ['app' , 'backbone'], (App) ->

	App.module "Entities.Redemption", (Redemption, App)->

		#define Redemption model
		class Redemption extends Backbone.Model

			idAttribute : 'ID'

			defaults:
					display_name       		   	: ''
					user_email 					: ''
					status						: ''
					date 						: ''

							


			name : 'redemption'


		#define Redemption collection
		class RedemptionCollection extends Backbone.Collection

			model : Redemption
			
			url : -> #ajax call to return a list of all the Redemption from the databse
				AJAXURL + '?action=get-redemption'


		# declare a Redemption collection instance
		redemptionCollection = new RedemptionCollection
		
		

		# API
		API = 
			getRedemption:-> #returns a collection of Redemption
				redemptionCollection.fetch()
				redemptionCollection



			

			


		# Handlers
		App.reqres.setHandler "get:redemption:collection" , (opt) ->
			API.getRedemption()


