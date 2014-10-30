define ['app' , 'backbone'], (App) ->

	App.module "Entities.Referral", (Referral, App)->
		itemCount = 0
		#define referral model
		class Referral extends Backbone.Model

			initialize :->
				@set 'id', itemCount
				itemCount += 1;

			
			name : 'referral'


		#define a referral collection
		class ReferralCollection extends Backbone.Collection

			model : Referral
			
			url : -> #ajax call to return a list of all the users from the databse
				AJAXURL 


		# declare a referral collection instance
		referralCollection = new ReferralCollection
		
		
	

		# API
		API = 
			getReferrals:-> #returns a collection of referrals
				referralCollection

			createReferral :->#create referral
				new Referral
			

		# Handlers
		App.reqres.setHandler "get:referral:collection", ->
			API.getReferrals()

		App.reqres.setHandler "create:referral:model", ->
			API.createReferral()
		
		



