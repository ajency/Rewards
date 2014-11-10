define ['app','text!apps/Options/List/templates/optionList.html'], (App,listTpl)->

	App.module "OptionList.Views", (Views, App)->

		
		class SingleView extends Marionette.ItemView

			tagName     : 'div'

			className   : 'panel panel-default'
			
			template 	: '
						<div class="panel-heading m-b-10" >
									  <h4 class="panel-title">
										<a class="collapsed" data-toggle="collapse"  href="#collapseOne{{ID}}">
										   <div class="row">
												<div class="col-md-7">
													 <h4 class="text_wrap" id="header_name{{ID}}"><span class="semi-bold">{{option_name}} - </span> {{option_desc}}</h4>
												</div>
												<div class="col-md-3">
													 <h4 class="" ><label class="pull-left" id="min{{ID}}">{{min_opt}}&nbsp;</label></h4>
												</div>
												<div class="col-md-2">
													<div class="plus_img"></div>
												</div>
										   </div>
										</a>
									  </h4>
									</div>
									<div id="collapseOne{{ID}}" class="panel-collapse collapse">
									  <div class="panel-body">
												<form class="" id="edit-option-form{{ID}}">
										<div class="row form-row simple">
										  <div class="col-md-8">
											<input type="text" placeholder="Title" required class="form-control" id="option_name" name="option_name" value="{{option_name}}"> 
								   <div class="row form-row">
									<div class="col-md-12">
									<textarea rows="5" class="form-control" id="option_desc" required name="option_desc"  placeholder="Description">{{option_desc}}</textarea>
									</div>
								  </div>
								
								   <div class="row form-row m-t-5">
									
									<div class="col-md-6">
									<div class="row ">
									<div class="col-md-2">
									<h5 class="semi-bold">Points:  </h5>
									</div>
									<div class="col-md-10">
									  <input type="text" placeholder="Minimum Points required" required class="form-control price" id="min_opt" name="min_opt" value="{{min_opt}}">
									  </div></div>
									</div>

									<div class="col-md-6">
									<div class="row ">
									<div class="col-md-5">
									<h5 class="semi-bold">Package Value: </h5>
									</div>
									<div class="col-md-7">
									<h5 id="" class="semi-bold text-left"><i class="font18 fa fa-rupee"></i></i><span id="price_val{{ID}}">{{sum}}</span></h5>
									</div></div>
									</div>
								  
								  </div>


								     <div class="row m-b-10">
						            <div class="col-md-6">
						             <div class="row ">
						            <div class="col-md-4">
						            <h5 class="semi-bold">Price Range: </h5>
						            </div>
						            <div class="col-md-8">
						            <h5 class="semi-bold text-left"><i class="font18 fa fa-rupee"></i><span id="min_range{{ID}}">{{min_range}}</span> - <i class="font18 fa fa-rupee"></i><span id="max_range{{ID}}">{{max_range}}</span></h5>
						            </div></div>
						            </div>
						            <div class="col-md-6"></div>
						            </div>
					                <input type="hidden" name="archiveval" id="archiveval" value="0" />
					                <div class="checkbox check-success ">
					                <input class="archive" id="archive{{ID}}" {{check}} name="archive{{ID}}" type="checkbox" value="0" >
					                <label class="semi-bold" for="archive{{ID}}" style="padding-left:25px;margin-left: 0;"><b>Archive</b></label>
					                </div>

									 <div id="desc"></div>
									 </div>


												  <div class="col-md-4">
												  <div class="thumbnail grid simple">
									  <div class="grid-title ">
										<div class="row">
										<div class="col-md-7">
										<h4>Products </h4>
										</div>
										<div class="col-md-5">
											 <h4>Price </h4>
												</div></div>
									  </div><input type="hidden" id="price_total{{ID}}" name="price_total{{ID}}" value="{{sum}}" />
									<input type="hidden" id="minrange{{ID}}" name="minrange{{ID}}" value="{{min_range}}" />
									<input type="hidden" id="maxrange{{ID}}" name="minrange{{ID}}" value="{{max_range}}" />

									  <div class="grid-body product">

										 {{#product_details}}
										<div class="row">
										<div class="col-md-7">
										 <div class="checkbox check-success p-t-5">
											<input id="{{opt_id}}{{ID}}" class="checkboxSelect" type="checkbox" {{selected}} value="{{ID}}" >
											 <label for="{{opt_id}}{{ID}}" style="padding-left:25px;"><b>{{product_name}}</b></label>
											 <input type="hidden" id="product_price{{opt_id}}{{ID}}" name="product_price{{opt_id}}{{ID}}" value="{{product_price}}" />
										</div>
										</div>
										 <div class="col-md-5">
											<label id="" class="p-l-25"><i class="font18 fa fa-rupee"></i><b>{{product_price}}</b></label>
										 </div>
										 </div>
										 {{/product_details}}

									  </div>
									  </div>
									</div>
										</div>
									   
										<div class="row form-row">
										  <div class="col-md-12 margin-top-10">
										 
											<div class="pull-right">
											  <input type="hidden" name="opt_id" id="opt_id" value="{{ID}}" />
											  <input type="hidden" name="count{{ID}}" id="count{{ID}}" value="0" />
											  <input type="hidden" name="optionstring" id="optionstring" value="" />
											  <input type="hidden" name="optionstring1" id="optionstring1" value="" />
											  <button  data-toggle="collapse" class="btn btn-primary btn-cons edit pull-right" id="submit-edit-form{{ID}}"  type="submit" >Save</button>
											<div class="pace pace-inactive pull-right  m-r-10">
											<div class="pace-activity"></div></div></div>
										  </div>
										</div>
									  </form>
									  </div>
									</div>'

			events :
				'click .edit' :(e)->
					e.preventDefault()
					ID = @$el.find("#opt_id").val()
					@$el.find('.alert').remove()
					if parseInt(@$el.find('#min_opt').val()) > parseInt(@$el.find('#max_opt').val())
						@$el.find("#edit-option-form"+ID).before '<div class="alert alert-success">
						<button data-dismiss="alert" class="close"></button>
						Min range has to be less than or eaual to Max 
						range</div>'
						return false
					if parseInt($('#count'+ID).val()) == 0
						@$el.find("#edit-option-form"+ID).before '<div class="alert alert-successe">
						<button data-dismiss="alert" class="close"></button>
						Select atleast one product
						range</div>'
						return false
					if @$el.find("#edit-option-form"+ID).valid()
						@$el.find('.alert').remove()
						@$el.find('.pace-inactive').show()
						@$el.find('#submit-edit-form'+ID).attr 'disabled', true
						@trigger "update:new:option" , ID , Backbone.Syphon.serialize @ 


			
				'click .checkboxSelect':(e)->
					$(".ref_msg").remove()
					productsarray =  Array()
					productdelsarray =  Array()
					val_arry = @$el.find("#optionstring").val()
					val_string = val_arry.split(',')
					for element,index in val_string
						productsarray.push element
						
					prod_val = e.target.value
					price  = @$el.find("#product_price"+e.target.id).val()
					ID = @$el.find("#opt_id").val()
					price_total = @$el.find("#price_total"+ID).val()
					min_range = @$el.find("#minrange"+ID).val()
					max_range = @$el.find("#maxrange"+ID).val()
					if $('#'+e.target.id).prop('checked') == true
						price_total = parseInt(price_total) + parseInt(price)
						@$el.find("#price_total"+ID).val price_total
						count = $('#count'+ID).val()
						count = parseInt(count) + 1
						$('#count'+ID).val count
						productsarray.push prod_val
						str = productsarray.join(',')
						@$el.find("#optionstring").val(str)
						$('#price_val'+ID).text price_total
					else
						price_total = parseInt(price_total) - parseInt(price)
						$('#price_val'+ID).text price_total
						@$el.find("#price_total"+ID).val price_total
						count = $('#count'+ID).val()
						count = parseInt(count) - 1
						$('#count'+ID).val count
						last = productsarray.indexOf prod_val
						productsarray.splice(last,1)
						str = productsarray.join(',')
						@$el.find("#optionstring").val(str)
						productdelsarray.push prod_val
						str1 = productdelsarray.join(',')
						@$el.find("#optionstring1").val(str1)

					if price_total < min_range
						val = parseInt(min_range) - parseInt(price_total)
						$('#submit-edit-form'+ID).addClass 'hidden'
						$("#edit-option-form"+ID).before '<div class="ref_msg alert alert-error m-b-5 m-t-20"><button data-dismiss="alert" class="close"></button>Package value is less than the selected price range by ' + val+'. Please choose products within the price range.</div>'
					
						
					else if price_total > max_range
						val = parseInt(price_total) - parseInt(max_range)
						$('#submit-edit-form'+ID).addClass 'hidden'
						$("#edit-option-form"+ID).before '<div class="ref_msg alert alert-error m-b-5 m-t-20"><button data-dismiss="alert" class="close"></button>Package value has exceeded the selected price range by ' + val+'. Please choose products within the price range.</div>'
					
						
					else
						$('#submit-edit-form'+ID).removeClass 'hidden'

				'keyup .price':(e)->
					ID = @model.get 'ID'
					@$el.find('.alert').remove()
					code = e.keyCode || e.which		
					console.log code
					if parseInt(code) == 48
						$("#edit-option-form"+ID).before '<div class="alert alert-success">
						<button data-dismiss="alert" class="close"></button>
						Cannot create package with points 0
						</div>'
						$('#submit-edit-form'+ID).addClass 'hidden'
						return false
					else
						console.log 'code'
						@trigger "get:pointslist:range" , Backbone.Syphon.serialize @

				'click .archive':(e)->
					if $('#'+e.target.id).prop('checked') == true
						@$el.find('#archiveval').val '1'
						
					else 
						@$el.find('#archiveval').val '0'
						

				'keydown  .price' :(e)->
					num = e.target.value
					code = e.keyCode || e.which
					if (code >64 && code < 91) || (code >96 && code < 123 )
						return false
						

			onShow :->
				ID = @model.get 'ID'
				$('#count'+ID).val @model.get 'count'
				selected = @model.get 'selected_arr'
				$('#count'+ID).val selected.length
				prod_arr = @model.get 'prod_array'
				@$el.find("#optionstring").val(prod_arr)

					



				
				

								  
							

			

			
			

		class Views.ProductList extends Marionette.CompositeView

			template 	: listTpl

			className 	: 'row'

			itemView    : SingleView

			

			itemViewContainer : 'div#rowdata'


			onNewOptionEdited:(model)->
				ID = model.get 'ID'
				@collection.trigger ('reset')
				@$el.find('.alert').remove()
				@$el.find('.pace-inactive').hide()
				@$el.find('#min_range'+ID).text model.get 'min_range'
				@$el.find('#max_range'+ID).text model.get 'max_range'
				@$el.find('#minrange'+ID).val model.get 'min_range'
				@$el.find('#maxrange'+ID).val model.get 'max_range'
				@$el.find('#archiveval').val model.get 'archiveval'
				@$el.find("#rowdata").before '<div class="alert alert-success">
				<button data-dismiss="alert" class="close"></button>
				Package details updated successfully</div>'
				

			onShowRangeList :(data,ID)->
				$(".ref_msg").remove()
				@$el.find('#min_range'+ID).text data.min
				@$el.find('#max_range'+ID).text data.max
				@$el.find('#minrange'+ID).val data.min
				@$el.find('#maxrange'+ID).val data.max
				price_total = @$el.find('#price_total'+ID).val()
				if parseInt(price_total) < parseInt(data.min)
					val = parseInt(data.min) - parseInt(price_total)
					$('#submit-edit-form'+ID).addClass 'hidden'
					$("#edit-option-form"+ID).before '<div class="ref_msg alert alert-error m-b-5 m-t-20"><button data-dismiss="alert" class="close"></button>Package value is less than the selected price range by ' + val+'. Please choose products within the price range.</div>'
					
				else if parseInt(price_total) > parseInt(data.max)
					val = parseInt(price_total) - parseInt(data.max)
					$('#submit-edit-form'+ID).addClass 'hidden'
					$("#edit-option-form"+ID).before '<div class="ref_msg alert alert-error m-b-5 m-t-20"><button data-dismiss="alert" class="close"></button>Package value has exceeded the selected price range by ' + val+'. Please choose products within the price range.</div>'
					
				else
					$('#submit-edit-form'+ID).removeClass 'hidden'

			

				
		
		

			
			

		
