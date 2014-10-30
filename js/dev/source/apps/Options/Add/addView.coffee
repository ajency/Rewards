define ['app','text!apps/Options/Add/templates/addOption.html'], (App,addTpl)->

	App.module "AddOption.Views", (Views, App)->

		productsarray = Array()
		
		min_range = 0
		max_range= 0
		price_total = 0
		class SingleView extends Marionette.ItemView

			
			template    : '
					<div class="row">
					<div class="col-md-7">
					<div class="checkbox check-success p-t-5">
					<input id="checkbox{{ID}}" class="checkboxSelect" type="checkbox" value="{{ID}}" >
					<label class="text_wrap" for="checkbox{{ID}}" style="padding-left:25px;"><b>{{product_name}}</b></label></div>
					</div>
	                 <div class="col-md-5">
	                 <label id="" class="p-l-25"><i class="font18 fa fa-rupee"></i><b>{{product_price}}</b></label>
	                 </div>
	                 </div>
					'
						  
			  

			className   : ''

			

			events      :
				'click .checkboxSelect':(e)->
					$(".ref_msg").remove()
					prod_val = e.target.value
					price = @model.get 'product_price'
					if $('#'+e.target.id).prop('checked') == true
						price_total = parseInt(price_total) + parseInt(price)
						productsarray.push prod_val
						str = productsarray.join(',')
						$("#optionstring").val str
						$('#price_val').text price_total
					else
						price_total = parseInt(price_total) - parseInt(price)
						$('#price_val').text price_total
						productsarray.pop prod_val
					if parseInt(price_total) < parseInt(min_range)
						val = parseInt(min_range) - parseInt(price_total)
						$('#submit-new-option').addClass 'hidden'
						$("#desc").before '<div class="ref_msg alert alert-error m-b-5 m-t-20"><button data-dismiss="alert" class="close"></button>Package value is less than the selected price range by ' + val+'. Please choose products within the price range.</div>'
					
						
					else if parseInt(price_total) > parseInt(max_range)
						val = parseInt(price_total) - parseInt(max_range)
						$('#submit-new-option').addClass 'hidden'
						$("#desc").before '<div class="ref_msg alert alert-error m-b-5 m-t-20"><button data-dismiss="alert" class="close"></button>Package value has exceeded the selected price range by ' + val+'. Please choose products within the price range.</div>'
					
						
					else
						$('#submit-new-option').removeClass 'hidden'



					






				




		class Views.OptionAdd extends Marionette.CompositeView

			template 	: addTpl

			itemView    : SingleView

			itemViewContainer : 'div#product'


			events       :
				'click #submit-new-option':(e)->
					e.preventDefault()

					@$el.find('.alert').remove()
					
					if parseInt(@$el.find('#min_opt').val()) >  parseInt(@$el.find('#max_opt').val())
						@$el.find("#add-new-option").before '<div class="alert alert-success">
						<button data-dismiss="alert" class="close"></button>
						Min range has to be less than or eaual to Max 
						range</div>'
						return false
					if productsarray.length == 0
						@$el.find("#add-new-option").before '<div class="alert alert-success">
						<button data-dismiss="alert" class="close"></button>
						Select atleast one product
						range</div>'
						return false
					if  @$el.find("#add-new-option").valid()
						@$el.find('.alert').remove()
						@$el.find('.pace-inactive').show()
						@$el.find('#submit-new-option').attr 'disabled', true
						@trigger "save:new:option" , Backbone.Syphon.serialize @

					

				'click #add-product-option' :->
					@$el.find("#add-option-details").show()

				'click #cancel_product_option' :->
					@$el.find('button[type="reset"]').trigger 'click'
					@$el.find("#add-option-details").hide()

				'keyup #min_opt':(e)->
					@$el.find('.alert').remove()
					code = e.keyCode || e.which		
					console.log code
					if parseInt(code) == 48
						@$el.find("#add-new-option").before '<div class="alert alert-success">
						<button data-dismiss="alert" class="close"></button>
						Cannot create package with points 0
						</div>'
						$('#submit-new-option').addClass 'hidden'
						return false
					else if $('#min_opt').val() == ""
						$('#submit-new-option').addClass 'hidden'
					else

						@trigger "get:points:range" , Backbone.Syphon.serialize @

				'click #archive':(e)->
					if $('#archive').prop('checked') == true
						@$el.find('#archiveval').val '1'
						
					else 
						@$el.find('#archiveval').val '0'
						
				

				'keydown  .price' :(e)->
					num = e.target.value
					code = e.keyCode || e.which
					if (code >64 && code < 91) || (code >96 && code < 123 )
						return false











			onOptionAdded :->
				@$el.find('.alert').remove()
				@$el.find('.pace-inactive').hide()
				@$el.find("#add-option-details").before '<div class="alert alert-success">
				<button data-dismiss="alert" class="close"></button>
				Package has been added successfully</div>'
				@$el.find("#add-option-details").hide()
				@$el.find('#submit-new-option').removeAttr 'disabled' ,  false
				@$el.find('button[type="reset"]').trigger 'click'
				min_range = 0
				max_range= 0
				price_total = 0
				@$el.find('#min_range').text ""
				@$el.find('#max_range').text ""
				$('#price_val').text "0"
				productsarray = Array()
				$("#optionstring").val ""
				$('html, body').animate({scrollTop:$(document).height()}, 'slow')

			onShowRange :(data)->
				$(".ref_msg").remove()
				@$el.find('#min_range').text data.min
				@$el.find('#max_range').text data.max
				min_range = data.min
				max_range = data.max
				if parseInt(price_total) < parseInt(min_range)
					val = parseInt(min_range) - parseInt(price_total)
					$('#submit-new-option').addClass 'hidden'
					$("#desc").before '<div class="ref_msg alert alert-error m-b-5 m-t-20">
						<button data-dismiss="alert" class="close"></button>Package value is less than the selected price range by ' + val+'. Please choose products within the price range.</div>'
					
					
				else if parseInt(price_total) > parseInt(max_range)
					val = parseInt(price_total) - parseInt(max_range)
					$('#submit-new-option').addClass 'hidden'
					$("#desc").before '<div class="ref_msg alert alert-error m-b-5 m-t-20">
						<button data-dismiss="alert" class="close"></button>Package value has exceeded the selected price range by ' + val+'. Please choose products within the price range.</div>'
					
					
				else
					$('#submit-new-option').removeClass 'hidden'

					
		

			
			

		
			