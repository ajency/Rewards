define ['app', 'text!apps/products/Add/templates/addproduct.html'], (App, addTpl)->
    App.module "Add.Views", (Views, App)->
        class Views.ProductAdd extends Marionette.ItemView

            template : addTpl

            events :
                #function to save a user
                'click #submit-new-product' : (e)->
                    e.preventDefault()
                    @$el.find('.alert').remove()
                    if  @$el.find("#addnewform").valid()
                        @$el.find('.alert').remove()
                        @$el.find('#submit-new-product').attr 'disabled', true
                        @trigger "save:new:product", Backbone.Syphon.serialize @

                'click #add-new-product,#cancel_product' : ->
                    @$el.find("#add-new-div").toggle()

                'keydown  .price' :(e)->
                    num = e.target.value
                    code = e.keyCode || e.which
                    if (code >64 && code < 91) || (code >96 && code < 123 )
                        return false

            initialize : ->
                @uniqueID = _.uniqueId "choose-file-add"

            mixinTemplateHelpers : (data)->
                data = super()
                data.uniqueID = @uniqueID
                data.dummyImage = "#{SITEURL}/wp-content/themes/skyi/img/placeholder.jpg"
                data

            onProductAdded : ->
                @$el.find('.alert').remove()
                @$el.find("#showmsg").before '<div class="alert alert-success">
                                                				<button data-dismiss="alert" class="close"></button>
                                                				Poduct Added successfully</div>'
                @$el.find("#add-new-div").hide()
                @$el.find('#submit-new-product').removeAttr 'disabled', false
                @$el.find('button[type="reset"]').trigger 'click'
                @$el.find("#progress-#{@uniqueID}").closest('.caption').find('.uploaded-image')
                        .attr 'src', "#{SITEURL}/wp-content/themes/skyi/img/placeholder.jpg"
                $('html, body').animate({ scrollTop : $(document).height() }, 'slow')


            onShow : ->
                $("#addnewform").validate
                    rules :
                        product_price :
                            number : true
                            required : true

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

