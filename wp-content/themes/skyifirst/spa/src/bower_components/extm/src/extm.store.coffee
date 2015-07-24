class Extm.Store

   models : {}

   find : ( name, args = null )->

      _models = @models

      if _.isUndefined @models[name]
         @models[name] = new Backbone.Collection

      if _.isNull( args )
         @models[name].url = "#{AJAXURL}"
         return $.Deferred ( deferred )->

            if _models[name].length is 0
               _models[name].fetch
                  data :
                     action : "fetch-#{name}s"
                  success : ( collection )->
                     deferred.resolve collection
                  error : (error)->
                     deferred.reject error
            else
               deferred.resolve _models[name]

         .promise()

      if _.isNumber args
         model = @models[name].get args
         if not model
            model = new Backbone.Model
            model.name = name
            model.set 'id', args
            return $.Deferred ( deferred )->
               model.fetch
                  success : ( model )->
                     _models[name].add model
                     deferred.resolve model
                  error : (error)->
                     deferred.reject error
            .promise()

         return $.Deferred ( deferred )->
            deferred.resolve model
         .promise()

      if _.isObject args
         models = @models[name].where args
         collection = new Backbone.Collection models

         if collection.length is 0
            collection.url = "#{AJAXURL}"
            return $.Deferred ( deferred )->
                     collection.fetch
                                 data :
                                    action : "fetch-#{name}s"
                                    filters : args
                                 success : ( collection )->
                                    _models[name].add collection.models
                                    deferred.resolve collection
                                 error : (error)->
                                    deferred.reject error
                  .promise()


         return $.Deferred ( deferred )->
            deferred.resolve collection
         .promise()


   push : ( name, value )->
      @models[name] = new Backbone.Collection if _.isUndefined @models[name]

      if _.isArray value
         _.each value, ( attr, index ) =>
            model = new Backbone.Model attr
            model.name = name
            @models[name].add model

      else if _.isObject value
         model = new Backbone.Model attr
         model.name = name
         @models[name].add model


   _findAll : ->

   _query : ->

