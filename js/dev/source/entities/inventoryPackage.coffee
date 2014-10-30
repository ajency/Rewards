define ['app' , 'backbone'], (App) ->

  App.module "Entities.InventoryPackage", (InventoryPackage, App)->

    #define Inventory model
    class InventoryPackage extends Backbone.Model

      idAttribute : 'ID'

      defaults:
        product_name       		   	: ''
        option_name 				: ''
        Confirmed_count				: ''
        Initiated_count 			: ''
        Approved_count				: ''
        Closed_Count                : ''
        opt_id						: ''




      name : 'inventoryPackage'


    #define Referrallist collection
    class InventoryPackageCollection extends Backbone.Collection

      model : InventoryPackage

      url : -> #ajax call to return a list of all the Redemption from the databse
        AJAXURL + '?action=get-inventory_package'


    # declare a Redemption collection instance
    inventoryPackageCollection = new InventoryPackageCollection



    # API
    API =
      getInventoryPackage:-> #returns a collection of Redemption
        inventoryPackageCollection.fetch()
        inventoryPackageCollection








    # Handlers
    App.reqres.setHandler "get:inventoryPackage:collection"  , (opt) ->
      API.getInventoryPackage()


