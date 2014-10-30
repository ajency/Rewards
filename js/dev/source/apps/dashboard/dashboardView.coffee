define ['app','text!apps/dashboard/templates/dashboard.html'], (App,dashboardTpl)->

	App.module "dashboard.Views", (Views, App)->

				
		class Views.List extends Marionette.ItemView
						
			template    : dashboardTpl



			onShow:->
				@trigger 'show:dashboard:info' 


			onShowAllDashboardInfo:(result)->
				@$el.find('.program_member').text result.program_count
				@$el.find('.pgm_lastweek').text result.program_count_last_week
				@$el.find('.pgm_yest').text result.program_count_previous_day
				@$el.find('.ref_yest').text result.ref_previous_day_count
				@$el.find('.ref_lastweek').text result.ref_last_week_count
				@$el.find('.ref_count').text result.ref_count
				@$el.find('.converted').text result.conversion_count
				@$el.find('.program').text result.program_member_count
				@$el.find('.points').text result.points
				@$el.find('.redem_count').text result.redem_count
				@$el.find('.redem_lastweek').text result.redem_last_week
				@$el.find('.redem_yesterday').text result.redem_yesterday



						



					 



				

						


				


						



				
				