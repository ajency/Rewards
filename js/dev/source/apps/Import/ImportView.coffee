define ['app', 'text!apps/Import/templates/import.html'], (App,importTpl)->

	App.module "Show.Views", (Views, App)->

		
		class Views.Import extends Marionette.ItemView

			
			template 	: importTpl


			events :
				'click #submit-csvfile':(e)->
					#e.preventDefault()
					object = @
					@$el.find('.pace-inactive').show()
					@trigger "save:csv:file"
					#$("#uploadFormdata").ajaxForm({method: "POST" ,url : AJAXURL+'?action=upload_CSV',success :(result)-> object.$el.find('.pace-inactive').hide(); object.$el.find("#showdiv").show(); object.$el.find("#totalrecords").text result[0];object.$el.find("#duplicaterecords").text result[1];object.$el.find("#newcustomers").text result[2];object.$el.find("#referrlas").text result[3];object.$el.find("#import_date").text result[4]},error:(result)-> )


			onDataResponseCsv:(data)->
				@$el.find('.pace-inactive').hide() 
				@$el.find("#showdiv").show() 
				@$el.find("#totalrecords").text data[0]
				@$el.find("#duplicaterecords").text data[1]
				@$el.find("#newcustomers").text data[2]
				@.$el.find("#referrlas").text data[3]
				@$el.find("#import_date").text data[4]
