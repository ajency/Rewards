define ['app','text!apps/settings/templates/settings.html'], (App,settingsTpl)->

		App.module "SettingsView.Views", (Views, App)->

				
				class Views.List extends Marionette.ItemView
						
						template    : settingsTpl


						events      :
							'click #save_settings':->
								if @$el.find("#SettingsForm").valid()
									@$el.find("#save_settings").attr 'disabled'  , true
									@trigger "save:expiry:date" , Backbone.Syphon.serialize @

						onShowExpiryData:->
							@$el.find('.alert').remove()
							@$el.find("#save_settings").attr 'disabled'  , false
							@$el.find("#settingsmsg").before '<div class="alert alert-success">
							<button data-dismiss="alert" class="close"></button>
							Your changes have been saved</div>'
							$('html, body').animate({
							scrollTop: 0
							}, 'slow')

						onShow:->
							$( "#SettingsForm" ).validate({
								rules: 
										expiry_date: 
											number: true
										min_per :
											number: true
										max_per :
											number: true

							})
						 object = @
							$.ajax({
								method: "POST" ,
								url : AJAXURL+'?action=get_date',
								data : '',
								success :(result)-> 
									object.$el.find("#expiry_date").val result.date
									object.$el.find("#min_per").val result.min
									object.$el.find("#max_per").val result.max
									

							,
							
							})

				

			 




					 



				

						


				


						



				
				