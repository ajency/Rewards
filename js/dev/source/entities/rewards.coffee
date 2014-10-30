define ['app' , 'backbone'], (App) ->

	App.module "Entities.Rewards", (Rewards, App)->

		#define customer model
		class Rewards extends Backbone.Model

			idAttribute : 'ID'

			defaults:
					option						: ''
					product_name     		   	: ''
					product_price				: ''
					product_details				: ''
					product_img 				: ''
					sum_of_points				: ''
					disabled					: ''
					classname					: '' 
					option_desc					: ''
					min							: ''
					max							: ''
					checked 					: ''
					selected                    : ''
					


			
			name : 'rewards'


		#define customer collection
		class RewardsCollection extends Backbone.Collection

			model : Rewards
			
			url : -> #ajax call to return a list of all the users from the databse
				AJAXURL + '?action=get-rewards'

			parse : (resp)->
				resp


		# declare a customer collection instance
		rewardsCollection = new RewardsCollection
		

		# API
		API = 
			getRewards:(opt)-> #returns a collection of customers
				rewardsCollection.fetch
					reset :  true
					data : 
						username : opt.username 

				
				rewardsCollection

			editUser :(id)->#update a model to the collection
				reward = rewardsCollection.get id
				reward.set 'checked' , 'checked'
				reward.set 'selected' , 'selected'
				if not reward 
						reward = new Rewards ID : id
						rewardsCollection.add(reward)
				reward



			

			


		# Handlers
		
		App.reqres.setHandler "get:rewards:collection", (opt) ->
			API.getRewards opt 
		App.reqres.setHandler "get:new:rewards:model", (id)->
			API.editUser id


