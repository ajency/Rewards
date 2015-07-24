
class Extm.FormLayoutView extends Marionette.LayoutView

   tagName : 'form'

   className : 'extm-form-layout-view'

   onShow : ->
      @$el.validate()