define [ 'extm', 'src/apps/screen-three/screen-three-view' ], ( Extm, ScreenThreeView )->

    # Screen three controller
    class ScreenThreeController extends Extm.RegionController

        initialize :()->
            @Collection = @_getUnits()

            @layout = new ScreenThreeView.ScreenThreeLayout(
                buildingCollection : @Collection[0]
                countUnits : @Collection[3]
                uintVariantId : @Collection[8]
                uintVariantIdArray : @Collection[8]
                unitVariants:@Collection[7]
                maxvalue:@Collection[9]
                views :@Collection[12] 
                facings : @Collection[13]
                Oviews :@Collection[10] 
                Ofacings : @Collection[11]
                terrace :@Collection[14] 
                terraceID : @Collection[15]
                position : @Collection[16]
                templateHelpers:
                    selection :@Collection[2]
                    countUnits : @Collection[3]
                    range : @Collection[4]
                    high : @Collection[5]
                    rangetext : @Collection[6]
                    unitVariants:@Collection[7]
                    views :@Collection[10] 
                    facings : @Collection[11]
                    terrace :@Collection[14] 
                    terraceID : @Collection[15]
                    maxvalue:@Collection[9]


            )


            @listenTo @layout, "show", @showViews

            @listenTo @layout, 'unit:variants:selected', @_showBuildings

            @listenTo @layout, 'unit:item:selected', @_unitItemSelected

            @listenTo @layout, 'load:range:data', @_loadRangeData



            @show @layout

        showViews:=>
            @buildingCollection = @Collection[0]
            @unitCollection = @Collection[1]
            @showBuildingRegion @buildingCollection
            @showUnitRegion @unitCollection




        _showBuildings:->
                @Collection = @_getUnits()


                @layout = new ScreenThreeView.ScreenThreeLayout(
                        buildingCollection : @Collection[0]
                        countUnits : @Collection[3]
                        uintVariantId : @Collection[8]
                        uintVariantIdArray : @Collection[8]
                        unitVariants:@Collection[7]
                        maxvalue:@Collection[9]
                        views :@Collection[12] 
                        facings : @Collection[13]
                        Oviews :@Collection[10] 
                        Ofacings : @Collection[11]
                        terrace :@Collection[14] 
                        terraceID : @Collection[15]
                        position : @Collection[16]
                        templateHelpers:
                                selection :@Collection[2]
                                countUnits : @Collection[3]
                                range : @Collection[4]
                                high : @Collection[5]
                                rangetext : @Collection[6]
                                unitVariants:@Collection[7]
                                maxvalue:@Collection[9]
                                views :@Collection[10] 
                                facings : @Collection[11]
                                terrace :@Collection[14] 
                                terraceID : @Collection[15]


                )


                @listenTo @layout, "show", @showViews

                @listenTo @layout, 'unit:variants:selected', @_showBuildings

                @listenTo @layout, 'unit:item:selected', @_unitItemSelected

                @listenTo @layout, 'load:range:data', @_loadRangeData



                @show @layout


                #@layout.unitRegion.show(new ScreenThreeView.UnitTypeView
                                    #collection : @Collection[1])

        _loadRangeData:(unitModel)=>
            @Collection = @_getUnits()

            itemview1 = new ScreenThreeView.UnitTypeChildView
                collection : @Collection[0]

            itemview2 = new ScreenThreeView.UnitTypeView
                collection : @Collection[1]

            
            
            @layout.buildingRegion.$el.empty();
            @layout.unitRegion.$el.empty();
            @layout.buildingRegion.$el.append(itemview1.render().el ); 
            @layout.unitRegion.$el.append(itemview2.render().el ); 
            sudoSlider = $("#unitsSlider").sudoSlider(
                customLink: "a"
                prevNext: false
                responsive: true
                speed: 800
                # continuous:true
            )
            sudoSlider.goToSlide(unitModel.get('unitAssigned'));
            msgbus.showApp 'header'
            .insideRegion  App.headerRegion
                .withOptions()
            @layout.triggerMethod "show:range:data" , unitModel, @Collection[1]

            







        showBuildingRegion:(buildingCollection)->
            itemview1 = @getView buildingCollection
            @layout.buildingRegion.show itemview1
            @listenTo itemview1, 'childview:building:link:selected', @_showBuildings



        showUnitRegion:(unitCollection)->
            itemview2 = @getUnitsView unitCollection
            @layout.unitRegion.show itemview2
            #@listenTo itemview2, 'childview:childview:childview:unit:item:selected', @_unitItemSelected








        getView:(buildingCollection)->
            new ScreenThreeView.UnitTypeChildView
                collection : buildingCollection

        getUnitsView:(unitCollection)->
            new ScreenThreeView.UnitTypeView
                collection : unitCollection

        _unitItemSelected:(childview,childview1,childview2)=>
            App.navigate "screen-four" , trigger:true






        _getUnits:->
            buildingArray = []
            unitArray = []
            unitsArray = []
            buildingArrayModel = []
            templateArr = []
            param = {}
            paramkey = {}
            flag = 0
            range = ""
            track = 0
            trackArray = []
            floorUnitsArray = []
            templateString = ""
            myArray = []
            myArray1 = []
            units = App.master.unit
            status = App.currentStore.status.findWhere({'name':'Available'})
            status_onhold = App.currentStore.status.findWhere({'name':'On Hold'})
            Countunits  = _.filter(App.currentStore.unit.toArray(),  (num)->
                    return (parseInt(num.get('status')) == parseInt(status.get('id')) || parseInt(num.get('status')) == parseInt(status_onhold.get('id'))) 

            )
            $.map(App.defaults, (value, index)->
                if value!='All' 
                    if  index != 'unitVariant' 
                        myArray.push({key:index,value:value})
                    if  index != 'facing' && index != 'terrace' && index != 'view'
                        myArray1.push({key:index,value:value})

            )
            flag  = 0
            unitslen = App.master.unit.toArray()
            unitslen1 = App.master.unit.where({'building':parseInt(App.defaults['building'])})


            $.each(unitslen1, (index,value1)->

                if App.defaults['floor'] !='All'
                    floorstring = App.defaults['floor']
                    floorArray  = floorstring.split(',')
                    $.each(floorArray, (index,value)->
                        if value1.get('floor') == parseInt(value)
                            floorUnitsArray.push(value1)




                    )


            )
            if App.defaults['floor'] == "All"
                floorUnitsArray = unitslen1

            floorCollunits = []
            floorCollunits1 = []
            $.each(floorUnitsArray, (index,value1)->
                flag = 0
                $.each(myArray, (index,value)->
                    paramKey = {}
                    paramKey[value.key] = value.value
                    if value.key == 'budget'
                        buildingModel = App.master.building.findWhere({'id':value1.get 'building'})
                        floorRise = buildingModel.get 'floorrise'
                        floorRiseValue = floorRise[value1.get 'floor']
                        unitVariantmodel = App.master.unit_variant.findWhere({'id':value1.get 'unitVariant'})
                        #unitPrice = (parseInt( unitVariantmodel.get('persqftprice')) + parseInt(floorRiseValue)) * parseInt(unitVariantmodel.get 'sellablearea')
                        unitPrice = value1.get 'unitPrice'
                        budget_arr = value.value.split(' ')
                        budget_price = budget_arr[0].split('-')
                        budget_price[0] = budget_price[0]+'00000'
                        budget_price[1] = budget_price[1]+'00000'
                        if parseInt(unitPrice) >= parseInt(budget_price[0]) && parseInt(unitPrice) <= parseInt(budget_price[1])
                            flag++
                    else if value.key != 'floor'
                        tempnew = []
                        
                        if value.key == 'view' ||  value.key == 'apartment_views'
                            tempnew = []
                            value.key = 'apartment_views'
                            tempnew = value1.get(value.key)
                            if tempnew != ""
                                tempnew = tempnew.map((item)->
                                    return parseInt(item))
                        else if value.key == 'facing'
                            tempnew = []
                            tempnew = value1.get(value.key)
                            if tempnew.length != 0
                                tempnew = tempnew.map((item)->
                                    return parseInt(item))
                        temp = []
                        temp.push value.value
                        tempstring = temp.join(',')
                        initvariant = tempstring.split(',').map((item)->
                            return parseInt(item)
                        )
                        
                        if initvariant.length >= 1
                            for element in initvariant
                                if value1.get(value.key) == parseInt(element)
                                    flag++ 
                                else if $.inArray(parseInt(element),tempnew) >=0 
                                    flag++ 

                        else
                            if value1.get(value.key) == parseInt(value.value)
                                flag++
                        


                )
                if flag >= myArray.length - 1
                    if  value1.get('unitType') != 14 && value1.get('unitType') != 16
                        floorCollunits.push(value1)





            )
            
            $.each(floorUnitsArray, (index,value1)->
                flag = 0
                $.each(myArray1, (index,value)->
                    paramKey = {}
                    paramKey[value.key] = value.value
                    if value.key == 'budget'
                        buildingModel = App.master.building.findWhere({'id':value1.get 'building'})
                        floorRise = buildingModel.get 'floorrise'
                        floorRiseValue = floorRise[value1.get 'floor']
                        unitVariantmodel = App.master.unit_variant.findWhere({'id':value1.get 'unitVariant'})
                        #unitPrice = (parseInt( unitVariantmodel.get('persqftprice')) + parseInt(floorRiseValue)) * parseInt(unitVariantmodel.get 'sellablearea')
                        unitPrice = value1.get 'unitPrice'
                        budget_arr = value.value.split(' ')
                        budget_price = budget_arr[0].split('-')
                        budget_price[0] = budget_price[0]+'00000'
                        budget_price[1] = budget_price[1]+'00000'
                        if parseInt(unitPrice) >= parseInt(budget_price[0]) && parseInt(unitPrice) <= parseInt(budget_price[1])
                            flag++
                    else if value.key != 'floor'
                        tempnew = []
                        
                        if value.key == 'view' ||  value.key == 'apartment_views'
                            tempnew = []
                            value.key = 'apartment_views'
                            tempnew = value1.get(value.key)
                            if tempnew != ""
                                tempnew = tempnew.map((item)->
                                    return parseInt(item))
                        else if value.key == 'facing'
                            tempnew = []
                            tempnew = value1.get(value.key)
                            if tempnew.length != 0
                                tempnew = tempnew.map((item)->
                                    return parseInt(item))
                        temp = []
                        temp.push value.value
                        tempstring = temp.join(',')
                        initvariant = tempstring.split(',').map((item)->
                            return parseInt(item)
                        )
                        
                        if initvariant.length >= 1
                            for element in initvariant
                                if value1.get(value.key) == parseInt(element)
                                    flag++ 
                                else if $.inArray(parseInt(element),tempnew) >=0 
                                    flag++ 

                        else
                            if value1.get(value.key) == parseInt(value.value)
                                flag++
                        


                )
                if flag >= myArray1.length - 1
                    if  value1.get('unitType') != 14 && value1.get('unitType') != 16
                        floorCollunits1.push(value1)





            )
            if App.defaults['floor'] == "All"
                floorCollunits = unitslen
            units = new Backbone.Collection floorCollunits
            unitsfilter = new Backbone.Collection floorCollunits1
            buildings = units.pluck("building")
            uniqBuildings = _.uniq(buildings)

            tempunitvarinat = []
            uniqUnitvariant = []
            
            
            $.each(unitslen, (index,value)->
                if value.get('unitType') != 14 && value.get('unitType') != 16
                    tempunitvarinat.push(value)

                )
            unitvarinatColl = new Backbone.Collection tempunitvarinat
            unitvariant = unitvarinatColl.pluck("unitVariant")
            uniqUnitvariant = _.uniq(unitvariant)
            floorunitvariant = units.pluck("unitVariant")
            flooruniqUnitvariant = _.uniq(floorunitvariant)
            unitVariantModels = []
            unitVariantID = []
            viewModels = []
            viewID = []
            viewtemp = []
            facingModels = []
            facingID = []
            facingtemp = []
            terraceModels = []
            terraceID = []
            terracetemp = []
            viewtemp1 = []
            facingtemp1 = []
            terracetemp1 = []
            usermodel = new Backbone.Model USER
            capability = usermodel.get('all_caps')
            if usermodel.get('id') != "0" && $.inArray('see_special_filters',capability) >= 0
                unitscur = App.master.unit
                unitscur.each (item)->
                    if  item.get('unitType') != 14 && item.get('unitType') != 16
                        if item.get('apartment_views') != "" && item.get('apartment_views').length != 0
                            $.merge(viewtemp,item.get('apartment_views'))
                        if item.get('facing').length != 0 && item.get('facing') != ""
                            $.merge(facingtemp,item.get('facing'))
                        if item.get('terrace') != "" && item.get('terrace') != 0
                            terracetemp.push item.get('terrace')

                floorCollectionCur = unitsfilter
                floorCollectionCur.each (item)->
                    if item.get('unitType') != 14 && item.get('unitType') != 16
                        if item.get('apartment_views') != "" && item.get('apartment_views').length != 0
                            $.merge(viewtemp1,item.get('apartment_views'))
                        if item.get('facing').length != 0 && item.get('facing') != ""
                            $.merge(facingtemp1,item.get('facing'))
                        if item.get('terrace') != "" && item.get('terrace') != 0
                            terracetemp1.push item.get('terrace')

                viewtemp = viewtemp.map((item)->
                    return parseInt(item)
                    )
                facingtemp = facingtemp.map((item)->
                    return parseInt(item)
                    )
                terracetemp = terracetemp.map((item)->
                    return parseInt(item)
                    )
                    
                uniqviews = _.uniq(viewtemp)
                uniqfacings = _.uniq(facingtemp)
                uniqterrace = _.uniq(terracetemp)
                viewtemp1 = viewtemp1.map((item)->
                    return parseInt(item)
                    )
                viewtemp1 = _.uniq(viewtemp1)
                facingtemp1 = facingtemp1.map((item)->
                    return parseInt(item)
                    )
                facingtemp1 = _.uniq(facingtemp1)
                terracetemp1 = terracetemp1.map((item)->
                    return parseInt(item)
                    )
                terracetemp1 = _.uniq(terracetemp1)
                $.each(uniqviews, (index,value)->
                    viewModel = App.master.view.findWhere({id:parseInt(value)})
                    disabled = "disabled"
                    checked = ""
                    key = ""
                    key  =  $.inArray(parseInt(value),viewtemp1)
                    count = []
                    $.each(floorCollunits1, (ind,val)->
                        if parseInt(val.get('status')) == parseInt(status.get('id')) || parseInt(val.get('status')) == parseInt(status_onhold.get('id'))
                            apartment = val.get('apartment_views')
                            if val.get('apartment_views') !="" && val.get('apartment_views').length !=0
                                apartment = apartment.map((item)->
                                    return parseInt(item)
                                    )
                                if $.inArray(parseInt(value),apartment) >= 0
                                    $.merge(count,val.get('apartment_views'))



                            )
                    if count.length != 0 && key >= 0 
                        disabled = ""
                        checked = "checked"
                        classname = 'filtered'
                        
                        viewID.push(parseInt(viewModel.get('id')))
                    else if count.length == 0 && key >= 0
                        classname = 'sold'
                    else
                        classname = 'other'
                    
                    # if $.inArray(parseInt(value),viewtemp1) >= 0
                    #     viewID.push(parseInt(viewModel.get('id')))
                    #     disabled = ""
                    #     checked = "checked"
                        
                    viewModels.push({id:viewModel.get('id'),name:viewModel.get('name'),disabled:disabled,checked:checked,classname:classname})

                )
                $.each(uniqfacings, (index,value)->
                    facingModel = App.master.facings.findWhere({id:parseInt(value)})
                    disabled = "disabled"
                    checked = ""
                    key = ""
                    key  = $.inArray(parseInt(value),facingtemp1)
                    count = []
                    $.each(floorCollunits1, (ind,val)->
                        if parseInt(val.get('status')) == parseInt(status.get('id')) || parseInt(val.get('status')) == parseInt(status_onhold.get('id'))
                            facing = val.get('facing')
                            facing = facing.map((item)->
                                return parseInt(item)
                                )
                            if $.inArray(parseInt(value),facing) >= 0
                                $.merge(count,val.get('facing'))



                            )
                    if count.length != 0 && key >= 0 
                        disabled = ""
                        checked = "checked"
                        classname = 'filtered'
                        
                        facingID.push(parseInt(facingModel.get('id')))
                    else if count.length ==0 && key >= 0
                        classname = 'sold'
                    else
                        classname = 'other'
                    # if $.inArray(parseInt(value),facingtemp1) >= 0
                    #     facingID.push(parseInt(facingModel.get('id')))
                    #     disabled = ""
                    #     checked = "checked"
                        
                    facingModels.push({id:facingModel.get('id'),name:facingModel.get('name'),disabled:disabled,checked:checked,classname:classname})
                    

                )
                $.each(uniqterrace, (index,value)->
                    terraceModel = App.master.terrace.findWhere({id:parseInt(value)})
                    disabled = "disabled"
                    checked = ""
                    key = ""
                    key  = $.inArray(parseInt(value),terracetemp1) 
                    count = []
                    $.each(floorCollunits1, (ind,val)->
                        if parseInt(val.get('status')) == parseInt(status.get('id')) ||  parseInt(val.get('status')) == parseInt(status_onhold.get('id')) 
                            if parseInt(value) == val.get('terrace') 
                                count.push(val)



                            )
                    if count.length != 0 && key >= 0 
                        disabled = ""
                        checked = "checked"
                        classname = 'filtered'
                        
                        terraceID.push(parseInt(terraceModel.get('id')))
                    else if count.length ==0 && key >= 0
                        classname = 'sold'
                    else
                        classname = 'other'
                    # if $.inArray(parseInt(value),terracetemp1) >= 0
                    #     terraceID.push(parseInt(terraceModel.get('id')))
                    #     disabled = ""
                    #     checked = "checked"
                        
                    terraceModels.push({id:parseInt(terraceModel.get('id')),name:terraceModel.get('name'),disabled:disabled,checked:checked,classname:classname})
                    
                )
            
            $.each(uniqUnitvariant, (index,value)->
                unitVarinatModel = App.master.unit_variant.findWhere({id:value})
                count  = _.filter(units.toArray(),  (num)->
                                return (parseInt(num.get('status')) == parseInt(status.get('id')) || 
                                parseInt(num.get('status')) == parseInt(status_onhold.get('id'))) &&
                                num.get('unitVariant') == value


                            )
                key  = $.inArray(value,flooruniqUnitvariant)
                selected = ""
                if App.defaults['unitType'] != "All"
                    unittypemodel = App.master.unit_type.findWhere({id:parseInt(App.defaults['unitType'])})
                    filter = unittypemodel.get('name')+' apartments'
                else if App.defaults['budget'] != "All"
                    filter = 'Apartments within '+App.defaults['budget']
                if count.length != 0 && key >= 0 
                    classname = 'boxLong filtered'
                    filtername = 'filtered'
                    selected = 'selected'
                    unitVariantID.push(parseInt(unitVarinatModel.get('id')))
                else if count.length ==0 && key >= 0
                    classname = 'boxLong sold'
                    filtername = 'sold'
                else
                    classname = 'boxLong other'
                    filtername = 'other'
                unitVariantModels.push({id:unitVarinatModel.get('id'),name:unitVarinatModel.get('name'),sellablearea:unitVarinatModel.get('sellablearea'),count:count.length,classname:classname,filtername:filtername,selected:selected,filter:filter})
                


            )
            unitVariantModels.sort( (a,b)->
                a.id - b.id

            )
            unitVariantID.sort( (a,b)->
                a - b

            )
            
            floorArray = []
            floorCountArray = []
            unitsArray = []
            buildingvalue = App.defaults['building']
            if App.defaults['building'] == "All"
                buildings = App.currentStore.building
                buildings.each ( item)->
                    unitsColl = App.master.unit.where({building:item.get('id')})
                    unitsArray.push({id:item.get('id'),count:unitsColl.length})
                buildingvalue = _.max(unitsArray,  (model)->
                    model.count
                )
                buildingvalue = buildingvalue.id
            units1 = new Backbone.Collection floorUnitsArray
            unitsCollection = units1.where({building:parseInt(buildingvalue)})
            $.each(unitsCollection, (index,value)->
                    if floorArray.indexOf(value.get 'floor') ==  -1
                        floorArray.push value.get 'floor'
                        floorCountArray.push {id:value.get 'floor'}



            )
            floorArray = floorArray.sort()
            floorArray.sort( (a,b) ->
                    b - a
            )

            floorCountArray.sort( (a,b) ->
                    b.id - a.id
            )
            trackposition = []
            unitArray= []
            unitColl = new Backbone.Collection unitsCollection
            unitAssigned = unitColl.pluck("unitAssigned")
            uniqunitAssignedval = _.uniq(unitAssigned)
            uniqunitAssigned = _.without(uniqunitAssignedval, 0)
            uniqunitAssigned.sort( (a,b)->
                a - b


                )
            $.each(uniqunitAssigned, (index,value)->
                # floorColl1 = _.reject(floorUnitsArray, (model)->
                #         return model.get('unitType') == 14 || model.get('unitType') == 16
                #     )
                floorColl =  new Backbone.Collection floorUnitsArray
                if App.defaults['building'] == "All"
                     
                    unitAssgendModels = floorColl.where({unitAssigned:value,building:buildingvalue})
                else
                    unitAssgendModels = floorColl.where({unitAssigned:value})
                $.each(unitAssgendModels, (index,value)->
                    unitType = App.master.unit_type.findWhere({id:value.get('unitType')})
                        
                    if value.get('unitType') == 16
                        value.set "unittypename" , "Not Released"
                        value.set "sellablearea" ,  ""
                        value.set "sqft" , ""
                    else if value.get('unitType') == 14
                        value.set "unittypename" , unitType.get "name"
                        value.set "sellablearea" ,  ""
                        value.set "sqft" , ""

                    else

                        value.set "unittypename" , unitType.get "name"
                        unitVariant = App.master.unit_variant.findWhere({id:value.get('unitVariant')})
                        value.set "sellablearea" , unitVariant.get "sellablearea"
                        value.set "sqft" , unitVariant.get "Sq.ft."

                )
                unitAssgendModels = _.uniq(unitAssgendModels)
                unitAssgendModels.sort( (a,b)->
                    b.get('floor') - a.get('floor')

                )
                maxcount = []
                maxunits = []  
                track = 0  
                
                $.each(unitAssgendModels, (index,value1)->
                    flag = 0
                    $.each(myArray, (index,value)->
                        paramKey = {}
                        paramKey[value.key] = value.value
                        if value.key == 'budget'
                            buildingModel = App.master.building.findWhere({'id':value1.get 'building'})
                            floorRise = buildingModel.get 'floorrise'
                            floorRiseValue = floorRise[value1.get 'floor']
                            unitVariantmodel = App.master.unit_variant.findWhere({'id':value1.get 'unitVariant'})
                            #unitPrice = (parseInt( unitVariantmodel.get('persqftprice')) + parseInt(floorRiseValue)) * parseInt(unitVariantmodel.get 'sellablearea')
                            unitPrice = value1.get 'unitPrice'
                            budget_arr = value.value.split(' ')
                            budget_price = budget_arr[0].split('-')
                            budget_price[0] = budget_price[0]+'00000'
                            budget_price[1] = budget_price[1]+'00000'
                            if parseInt(unitPrice) >= parseInt(budget_price[0]) && parseInt(unitPrice) <= parseInt(budget_price[1])
                                flag++
                        else if value.key != 'floor'
                            tempnew = []
                            
                            if value.key == 'view' ||  value.key == 'apartment_views'
                                tempnew = []
                                value.key = 'apartment_views'
                                tempnew = value1.get(value.key)
                                if tempnew != ""
                                    tempnew = tempnew.map((item)->
                                        return parseInt(item))
                            else if value.key == 'facing'
                                tempnew = []
                                tempnew = value1.get(value.key)
                                if tempnew.length != 0
                                    tempnew = tempnew.map((item)->
                                        return parseInt(item))
                            temp = []
                            temp.push value.value
                            tempstring = temp.join(',')
                            initvariant = tempstring.split(',').map((item)->
                                return parseInt(item)
                            )
                            
                            if initvariant.length >= 1
                                for element in initvariant
                                    if value1.get(value.key) == parseInt(element)
                                        flag++ 
                                    else if $.inArray(parseInt(element),tempnew) >=0 
                                        flag++ 

                            else
                                if value1.get(value.key) == parseInt(value.value)
                                    flag++
                            


                    )
                    if flag >= myArray.length - 1
                        track = 1
                    if myArray.length == 0
                        track = 1
                    if  parseInt(value1.get('status')) == parseInt(status.get('id')) || parseInt(value1.get('status')) == parseInt(status_onhold.get('id')) && value1.get('unitType') != 14 && value1.get('unitType') != 16
                        maxunits = App.currentStore.unit.where({unitAssigned:value})

                    
                    





                )
                disabled = disabled
                unitAssgendModelsColl = new Backbone.Collection unitAssgendModels
                if maxunits.length == 0
                    trackposition.push(value)
                unitArray.push({id:value,units:unitAssgendModelsColl,count:maxunits.length,disabled:disabled})



            )
            unitArray.sort( (a,b)->
                a.id - b.id

            )
            
            maxvalue = _.max(unitArray,  (model)->
                model.count
            )
            newunitCollection = new Backbone.Collection unitArray
            buildingModel = App.master.building.where(id:parseInt(buildingvalue))
            buildingCollection = new Backbone.Collection buildingModel
            mainnewarr = ""
            [buildingCollection,newunitCollection,templateString,Countunits.length,templateString,mainnewarr,range,unitVariantModels,unitVariantID,maxvalue,viewModels,facingModels,viewID,facingID,terraceModels,terraceID,trackposition]






        mainUnitSelected:(childview,childview1,unit,unittypeid,range,size)=>
            App.navigate "#screen-four/unit/#{unit}/unittype/#{unittypeid}/range/#{range}/size/#{size}" ,  trigger : true





    msgbus.registerController 'screen:three', ScreenThreeController