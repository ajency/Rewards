define ['app' , 'backbone'], (App) ->

	App.module "Entities.Customer", (Customer, App)->

		#define customer model
		class Customer extends Backbone.Model

			idAttribute : 'ID'

			defaults:
					referral_id       		   	: ''
					user_email  				: ''
					phone						: ''
					date_of_import				: ''
					date_of_purchase			: ''
					purchase_value 				: ''
					date_of_expire 				: ''
					points						: ''
					ref_count					: ''
					

			name : 'customer'


		#define customer collection
		class CustomerCollection extends Backbone.Collection

			model : Customer
			
			url : -> #ajax call to return a list of all the users from the databse
				AJAXURL + '?action=get-customers'


		# declare a customer collection instance
		customerCollection = new CustomerCollection
		

		# API
		API = 
			getCustomers:(opt)-> #returns a collection of customers
				customerCollection.fetch
					data : 
						username : opt.username 
				customerCollection



			

			


		# Handlers
		App.reqres.setHandler "get:customer:collection", (opt) ->
			API.getCustomers opt


