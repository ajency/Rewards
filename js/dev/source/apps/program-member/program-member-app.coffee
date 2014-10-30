define ['app'
		
		'apps/program-member/programmember/program-member-controller'
		], (App)->

	App.module "ProgramMember", (ProgramMember, App)->

		# define routers
		class ProgramMemberRouter extends Marionette.AppRouter
			
			appRoutes:
				'view' 		 : 'list'
				'referrals/:id/:userid'	 : 'show'
				


		RouterAPI = 
			#Start Sub App
			list : ->
				App.execute "show:program:members" , region : App.mainContentRegion

			show :(id,userid) ->
				App.execute "show:main:App" ,
								region : App.mainContentRegion
								ID : id
								userid : userid



			
		#Start Program Member App
		ProgramMember.on 'start',->
			new ProgramMemberRouter
					controller : RouterAPI