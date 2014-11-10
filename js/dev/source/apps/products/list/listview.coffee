define ['app', 'text!apps/products/list/templates/productlist.html'], (App, listTpl)->
    App.module "List.Views", (Views, App)->
        class SingleView extends Marionette.ItemView

            tagName : 'div'

            template : '<div id="showdiv" class="panel panel-default" >
                            <div class="panel-heading">
                                <div class="panel-title">
                                    <a class="collapsed" id="collapsediv{{ID}}" data-toggle="collapse" data-parent="#accordion"
                                    href="#collapseOne{{ID}}">
                                    <div class="row">
                                    <div class="col-md-1">
                                    <img src="{{product_image}}" id="header_img{{ID}}" class="img-responsive" width="60px">
                                    </div>
                                    <div class="col-md-7" >
                                    <h4 class="text_wrap" ><span class="semi-bold" id="header_name{{ID}}">{{product_name}}  </span> - <span  id="header_desc{{ID}}">{{product_details}}</span></h4>
                                    </div>
                                    <div class="col-md-2" >
                                    <h4 class="bold" id="header_price{{ID}}" ><i class="font18 fa fa-rupee"></i>{{product_price}}</h4>
                                    </div>
                                    <div class="col-md-2" >
                                    <div class="plus_img"></div>
                                    </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                            <div id="collapseOne{{ID}}" class="panel-collapse collapse ">
                                <div class="panel-body">
                                    <form id="edit-new-form{{ID}}" enctype="multipart/form-data" method="POST">
                                        <div class="row form-row simple">
                                            <div class="col-md-4">
                                                <div class="thumbnail upload-img">
                                                    <i class="p-l-10 fa fa-cloud-upload fa fa-6x custom-icon-space">
                                                    </i>
                                                    <div class="caption">
                                                        <img class="uploaded-image" src="{{product_image}}"/>
                                                        <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-primary btn-cons m-t-20"
                                                                    id="{{uniqueID}}">
                                                                Choose Image
                                                            </button>
                                                            </div></div>
                                                        <div class="row">
                                                        <div class="col-md-12">
                                                            <div id="progress-{{uniqueID}}" style="width: 100%; display: none;"
                                                                 class="progress progress-striped active m-t-10 m-b-10">
                                                                <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="progress-bar"></div>
                                                                <span class="sr-only">0% Complete </span>
                                                            </div>
                                                        <input type="hidden" name="attachmentid" value="{{product_thumbnail_id}}"/>
                                                    </div></div></div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="hidden" name="prod_id" id="prod_id" value="{{ID}}" />
                                                <input type="text" placeholder="Product Name" class="form-control" id="product_name"
                                                value="{{product_name}}" name="product_name">
                                                <div class="row form-row">
                                                    <div class="col-md-12">
                                                        <textarea rows="5" class="form-control" id="product_details" name="product_details"
                                                        placeholder="Products Details">
                                                            {{product_details}}
                                                        </textarea>
                                                    </div>
                                                </div>
                                                <div class="row form-row m-t-5">
                                                    <div class="col-md-6">
                                                        <input type="text" placeholder="Product Price" class="form-control price" id="product_price"
                                                        value="{{product_price}}" name="product_price">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-row">
                                            <div class="col-md-12 margin-top-10">
                                                <div class="pull-right">
                                                    <button data-toggle="collapse" id="submit-edit-form{{ID}}" class="btn btn-primary btn-cons edit"
                                                    type="submit">
                                                        Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>'


            events :
                'click .edit' : (e)->
                    e.preventDefault()
                    ID = @$el.find("#prod_id").val()
                    @$el.find('.alert').remove()
                    if @$el.find("#edit-new-form" + ID).valid()
                        @$el.find('.alert').remove()
                        @$el.find('#submit-edit-form' + ID).attr 'disabled', true
                        @trigger "update:new:product", ID, Backbone.Syphon.serialize @

                'keydown  .price' :(e)->
                    num = e.target.value
                    code = e.keyCode || e.which
                    if (code >64 && code < 91) || (code >96 && code < 123 )
                        return false

            initialize : (opt)->
                super opt
                @uniqueID = "choose-file-#{@model.get 'ID'}"
                

            mixinTemplateHelpers : (data)->
                data = super data
                data.uniqueID = @uniqueID
                data

            onShow : ->
                # setup plupload on show
                # the url for plupload will be async-upload.php(wordpress default)
                # this plupload configuration is copied over from wordpress core
                # Note: do not change these settings
                #bind plupload script
                @uploader = new plupload.Uploader
                    runtimes : "gears,html5,flash,silverlight,browserplus"
                    file_data_name : "async-upload" # key passed to $_FILE.
                    multiple_queues : true
                    browse_button : @uniqueID
                    multipart : true
                    urlstream_upload : true
                    max_file_size : "10mb"
                    url : UPLOADURL
                    flash_swf_url : SITEURL + "/wp-includes/js/plupload/plupload.flash.swf"
                    silverlight_xap_url : SITEURL + "/wp-includes/js/plupload/plupload.silverlight.xap"
                    filters : [
                        title : "Image files"
                        extensions : "jpg,gif,png"
                    ]
                    multipart_params :
                        action : "upload-attachment"
                        _wpnonce : _WPNONCE


                @uploader.init()

                @uploader.bind "FilesAdded", (up, files)=>
                    @uploader.start()
                    @$el.find("#progress-#{@uniqueID}").show()

                @uploader.bind "UploadProgress", (up, file)=>
                    @$el.find(".progress-bar").css "width", file.percent + "%"

                @uploader.bind "Error", (up, err)=>
                    up.refresh() # Reposition Flash/Silverlight

                @uploader.bind "FileUploaded", (up, file, response)=>
                    @$el.find(".progress-bar").css "width", "0%"
                    @$el.find("#progress-#{@uniqueID}").hide()
                    response = JSON.parse(response.response)
                    @$el.find('input[name="attachmentid"]').val response.data.id
                    @$el.find("#progress-#{@uniqueID}").closest('.caption').find('.uploaded-image')
                    .attr 'src', response.data.sizes.thumbnail.url

            # destroyt the plupload instance on close to release memory
            onClose : ->
                @uploader.destroy()


            onRender:->
                @$el

          
               
               


        class EmptyProductView extends Marionette.ItemView

            template : '<div id="showdiv" class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">No Products found</h4>
                            </div>
                        </div>'



        class Views.Product extends Marionette.CompositeView

            template : listTpl

            className : 'row'

            itemView : SingleView

            emptyView : EmptyProductView

            itemViewContainer : 'div#rowdata'

            

            onNewProductEdited : (model)->
                @collection.trigger ('reset')
                @$el.find('.alert').remove()
                @$el.find("#showdiv").before '<div class="alert alert-success">
                                <button data-dismiss="alert" class="close"></button>
                				Product Updated Successfully.
                				</div>'

               

				
		
		

			
			

		
			