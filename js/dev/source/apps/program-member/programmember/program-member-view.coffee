define ['app','text!apps/program-member/programmember/templates/program-member.html'], (App,memberTpl)->

	App.module "Member.Views", (Views, App)->

		
		class SingleView extends Marionette.ItemView
			
			tagName     : 'tr'
			
			className   : 'user_class'

			template 	: '<td class="v-align-middle width20 clickable"><div class="table_mob_hidden">Name</div>{{display_name}}</td>
                          <td class="v-align-middle width20"><div class="table_mob_hidden">Date Joined</div>{{user_registered}}</td>
                          <td class="v-align-middle width20"><div class="table_mob_hidden">No Of Referrals</div>{{referral_count}}</td>
                          <td class="v-align-middle width20"><div class="table_mob_hidden">Points</div>{{points}}</td>
                          <td class="v-align-middle width20 status"><div class="table_mob_hidden">Status</div>{{status}}</td>
                          <td class="v-align-middle width20"><div class="table_mob_hidden">Is a Customer</div>{{customer_val}}</td>'

			events  	:
				'click ': 'click'

			modelEvents	:
				'change:status': ->
					@$el.find('.status').text @model.get "status"

			#click event to set the url
			click :->
				location.href = '#referrals/'+@model.get('user_login')+'/'+@model.get('ID')

			onShow:->
				@$el.find('.bolesemi').text @model.get "user_role"


					



		
		class Views.ProgramMember extends Marionette.CompositeView

			template 	: memberTpl

			className 	: ''

			itemView    : SingleView

			itemViewContainer : 'table#program-member-table tbody'

			
			#enable all the options
			onShow :->
				role = _.str.capitalize @collection.models[0].attributes.user_role

				@$el.find('.bolesemi').text role
				@$el.find('#customer').attr('checked',true)
				@$el.find('#noncustomer').attr('checked',true)
				@$el.find('#ref_radio1').prop('checked',true)
				@$el.find('#ref_radio2').prop('checked',true)
				@$el.find('#ref_radio3').prop('checked',true)
				@$el.find('#ref_radio4').prop('checked',true)
				@$el.find('#ref_radio5').prop('checked',true)
				@$el.find('#point1').prop('checked',true)
				@$el.find('#point2').prop('checked',true)
				@$el.find('#point3').prop('checked',true)
				@$el.find('#point4').prop('checked',true)
				@$el.find('#point5').prop('checked',true)
				@$el.find('#point6').prop('checked',true)
				@$el.find('#status1').prop('checked',true)
				@$el.find('#status2').prop('checked',true)
				@$el.find('#status3').prop('checked',true)
				@$el.find('#status4').prop('checked',true)
				@$el.find('#status5').prop('checked',true)
				#@$el.find('#titlename').text @collection.response
				#@$el.find('#ref_radio1').attr('checked',true)
				#@$el.find('#ref_radio2').attr('checked',true)
				#@$el.find('#ref_radio3').attr('checked',true)
				#@$el.find('#ref_radio4').attr('checked',true)
				#@$el.find('#ref_radio5').attr('checked',true)
				object = @
				@$el.find("#program-member-table")
				.tablesorter({theme: 'blue',widthFixed: true,sortList: [ [0,1] ], widgets: ['zebra', 'filter']})
				.tablesorterPager({
                container: $(".pager")
      	        size: 25
				})

			events      :
				#to check all checkboxes
				'click #customer_check' :(e)->
					@$el.find('#customer').prop('checked',true)
					@$el.find('#noncustomer').prop('checked',true)

				#to check all radio buttons
				'click #referral_check' :(e)->
					@$el.find('#ref_radio1').prop('checked',true)
					@$el.find('#ref_radio2').prop('checked',true)
					@$el.find('#ref_radio3').prop('checked',true)
					@$el.find('#ref_radio4').prop('checked',true)
					@$el.find('#ref_radio5').prop('checked',true)


				#to uncheck all checkboxes
				'click #customer_uncheck' :(e)->
					$('#noncustomer').prop('checked', false);
					$('#customer').prop('checked', false);

				#to uncheck all radio
				'click #referral_uncheck' :(e)->
					@$el.find('#ref_radio1').prop('checked',false)
					@$el.find('#ref_radio2').prop('checked',false)
					@$el.find('#ref_radio3').prop('checked',false)
					@$el.find('#ref_radio4').prop('checked',false)
					@$el.find('#ref_radio5').prop('checked',false) 

				#submit the form
				'click #submitform' :(e)->
					e.preventDefault()
					@$el.find('#hideshow').addClass 'collapsed'
					@$el.find('#collapseOne').removeClass 'collapse in'
					@$el.find('#collapseOne').addClass 'collapse'
					@trigger "filter:member:info" , Backbone.Syphon.serialize @

				#check a radio utton
				'click .ref_class' :(e)->
					@$el.find('#ref_point1').val('false')
					@$el.find('#ref_point2').val('false')
					@$el.find('#ref_point3').val('false')
					@$el.find('#ref_point4').val('false')
					@$el.find('#ref_point5').val('false')
					@$el.find('#ref_radio'+e.target.value).prop('checked',true)
					@$el.find('#ref_point'+e.target.value).val('true')

				'click #status_check' :(e)->
					@$el.find('#status1').prop('checked',true)
					@$el.find('#status2').prop('checked',true)
					@$el.find('#status3').prop('checked',true)
					@$el.find('#status4').prop('checked',true)
					@$el.find('#status5').prop('checked',true)

				'click #status_uncheck' :(e)->
					@$el.find('#status1').prop('checked',false)
					@$el.find('#status2').prop('checked',false)
					@$el.find('#status3').prop('checked',false)
					@$el.find('#status4').prop('checked',false)
					@$el.find('#status5').prop('checked',false)

 
				#to check all points
				'click #point_check' :(e)->
					@$el.find('#point1').prop('checked',true)
					@$el.find('#point2').prop('checked',true)
					@$el.find('#point3').prop('checked',true)
					@$el.find('#point4').prop('checked',true)
					@$el.find('#point5').prop('checked',true) 
					@$el.find('#point6').prop('checked',true) 

				#to uncheck all points
 
				'click #point_uncheck' :(e)->
					@$el.find('#point1').prop('checked',false)
					@$el.find('#point2').prop('checked',false)
					@$el.find('#point3').prop('checked',false)
					@$el.find('#point4').prop('checked',false)
					@$el.find('#point5').prop('checked',false)
					@$el.find('#point6').prop('checked',false) 

				'click .point_class' :(e)->
					@$el.find('#point_check1').val('false')
					@$el.find('#point_check2').val('false')
					@$el.find('#point_check3').val('false')
					@$el.find('#point_check4').val('false')
					@$el.find('#point_check5').val('false')
					@$el.find('#point'+e.target.value).prop('checked',true)
					@$el.find('#point_check'+e.target.value).val('true')









