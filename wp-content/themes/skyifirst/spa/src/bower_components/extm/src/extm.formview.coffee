
class Extm.FormView extends Marionette.ItemView

   tagName : 'form'

   className : 'extm-form-view'

   onShow : ->
      @$el.validate()