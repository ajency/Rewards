define ['app', 'controllers/region-controller'], (App, RegionController)->

		class LoadingController extends RegionController

			initialize: (options) ->
				{ view, config } = options
		
				config = if _.isBoolean(config) then {} else config
				
				_.defaults config,
					loadingType: "spinner"
					entities: @getEntities(view)
					debug: false

				switch config.loadingType
					when "opacity"
						@region.currentView.$el.css "opacity", 0.5
					when "spinner"
						loadingView = @getLoadingView()
						@show loadingView
					else
						throw new Error("Invalid loadingType")
				
				@showRealView view, loadingView, config

		
			showRealView: (realView, loadingView, config) ->

				callbackFn = _.debounce ()=>
					
					switch config.loadingType
						when "opacity"
							@region.currentView.$el.removeAttr "style"
						when "spinner"
							return realView.close() if @region.currentView isnt loadingView


					if not config.debug
						@show realView
						realView.triggerMethod "dependencies:fetched" 
				, 10

				App.commands.execute "when:fetched", config.entities, callbackFn
					
			
			getEntities: (view) ->
				_.chain(view).pick("model", "collection").toArray().compact().value()
		
			
			getLoadingView: ->
				new LoadingView


		class LoadingView extends Marionette.ItemView

	        template : '<i></i>'

	        className : 'loading-container'

	        onShow : ->
	            opts = @._getOptions()
	            @$el.spin opts

	        onClose : ->
	            @$el.spin false

	        _getOptions : ->
	            lines : 10
	            length : 6
	            width : 2.5
	            radius : 7
	            corners : 1
	            rotate : 9
	            direction : 1
	            color : '#fff'
	            speed : 1
	            trail : 60
	            shadow : false
	            hwaccel : true
	            className : 'spinner'
	            zIndex : 2e9
	            top : 'auto'
	            left : 'auto'


		App.commands.setHandler "show:loading", (view, options) ->
			
			new LoadingController
				view: view
				region: options.region
				config: options.loading