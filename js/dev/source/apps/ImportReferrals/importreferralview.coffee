define ['app', 'text!apps/ImportReferrals/templates/importRef.html'], (App,importrefTpl)->

	App.module "ShowRef.Views", (Views, App)->

		
		class Views.ImportRef extends Marionette.ItemView

			
			template 	: importrefTpl


			events :
				'click #submit-csvfile':(e)->
					#e.preventDefault()
					object = @
					@$el.find('.pace-inactive').show()
					@trigger "save:csv:file"
					#$("#uploadFormdata").ajaxForm({method: "POST" ,url : AJAXURL+'?action=upload_CSV',success :(result)-> object.$el.find('.pace-inactive').hide(); object.$el.find("#showdiv").show(); object.$el.find("#totalrecords").text result[0];object.$el.find("#duplicaterecords").text result[1];object.$el.find("#newcustomers").text result[2];object.$el.find("#referrlas").text result[3];object.$el.find("#import_date").text result[4]},error:(result)-> )


			onDataResponserefCsv:(data)->
				@$el.find('.pace-inactive').hide() 
				@$el.find("#showdiv").show() 
				@$el.find("#totalrecords").text data[0]
				@$el.find("#recordsAdded").text data[1]
				@$el.find("#dupli_ref").text data[2]
				@.$el.find("#dupli_cus").text data[3]
				@$el.find("#dupli_pm").text data[4]
				
