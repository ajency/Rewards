define ['app','text!apps/program-member/referrals/templates/referralinfo.html'], (App,referralTpl)->

	App.module "Referral.Views", (Views, App)->

		
		class SingleView extends Marionette.ItemView

			tagName    : 'tr'
			
			template 	: '<td>{{name}}</td><td>{{phone}}</td><td>{{email}}</td><td>{{points}}</td><td>{{date}}</td><td>{{status}}</td>'

			
			

		class Views.Referral extends Marionette.CompositeView

			template 	: referralTpl

			className 	: ''

			itemView    : SingleView

			itemViewContainer : 'table#referral_table tbody'

							
			
					



		

			

			
			



			
       


				