# Use mustache js instead of default underscore js templating
Marionette.Renderer.render = ( template , data = {} ) ->

   # if template is not passed/set reset it to empty string
   if not template
      template = ''

   # use mustache to compile the template
   Mustache.to_html template, data
