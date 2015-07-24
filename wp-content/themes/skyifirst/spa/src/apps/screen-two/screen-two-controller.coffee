define [ 'extm', 'src/apps/screen-two/screen-two-view' ], ( Extm, ScreenTwoView )->

    # Screen two controller
    tagsArray = ""
    class ScreenTwoController extends Extm.RegionController

        initialize : ()->

            @Collection = @_getUnitsCountCollection()


            @layout = new ScreenTwoView.ScreenTwoLayout(
                collection:@Collection[0]
                buildingColl : @Collection[0]
                uintVariantId : @Collection[9]
                uintVariantIdArray : @Collection[10]
                unitVariants:@Collection[8]
                views :@Collection[13] 
                facings : @Collection[14]
                Oviews :@Collection[11] 
                Ofacings : @Collection[12]
                terrace :@Collection[15] 
                terraceID : @Collection[16]
                templateHelpers:
                    selection :@Collection[2]
                    unitsCount:@Collection[3]
                    unittypes:  @Collection[4]
                    high : @Collection[5]
                    medium : @Collection[6]
                    low : @Collection[7]
                    unitVariants:@Collection[8]
                    views :@Collection[11] 
                    facings : @Collection[12]
                    terrace :@Collection[15] 
                    terraceID : @Collection[16]
                    AJAXURL : AJAXURL)


            @listenTo @layout, "show", @showViews

            @listenTo @layout, "show:updated:building", @showUpdateBuilding

            @listenTo @layout, 'unit:variants:selected', @showUpdateBuildings

            @listenTo @layout, 'unit:count:selected', @_unitCountSelected






            @show @layout


        showUpdateBuildings:->
            
            @Collection = @_getUnitsCountCollection()


            @layout = new ScreenTwoView.ScreenTwoLayout(
                collection:@Collection[0]
                buildingColl : @Collection[0]
                uintVariantId : @Collection[9]
                uintVariantIdArray : @Collection[10]
                views :@Collection[13] 
                facings : @Collection[14]
                Oviews :@Collection[11] 
                Ofacings : @Collection[12]
                unitVariants:@Collection[8]
                terrace :@Collection[15] 
                terraceID : @Collection[16]
                templateHelpers:
                    selection :@Collection[2]
                    unitsCount:@Collection[3]
                    unittypes:  @Collection[4]
                    high : @Collection[5]
                    medium : @Collection[6]
                    low : @Collection[7]
                    unitVariants:@Collection[8]
                    views :@Collection[11] 
                    facings : @Collection[12]
                    terrace :@Collection[15] 
                    terraceID : @Collection[16]
                    AJAXURL : AJAXURL)


            @listenTo @layout, "show", @showViews

            @listenTo @layout, "show:updated:building", @showUpdateBuilding

            @listenTo @layout, 'unit:variants:selected', @showUpdateBuildings

            @listenTo @layout, 'unit:count:selected', @_unitCountSelected






            @show @layout


        showUpdateBuilding:(id)=>
            @Collection = @_getUnitsCountCollection(id)

            
            itemview1 = new ScreenTwoView.UnitTypeChildView
                collection : @Collection[0]

            itemview2 = new ScreenTwoView.UnitTypeView
                collection : @Collection[1]

            
            @layout.buildingRegion.$el.empty();
            @layout.unitRegion.$el.empty();
            @layout.buildingRegion.$el.append(itemview1.render().el ); 
            @layout.unitRegion.$el.append(itemview2.render().el ); 
            scr = document.createElement('script')
            scr.src = '../wp-content/themes/Homes/js/src/preload/main2.js'
            document.body.appendChild(scr)
            
            
            building = @Collection[0].toArray()
            buidlingValue = _.first(building)
            masterbuilding = App.master.building
            masterbuilding.each ( index)->
                $("#highlighttower"+index.get('id')).attr('class','overlay')
            $("#highlighttower"+buidlingValue.get('id')).attr('class','overlay highlight')





            


            

       
            

            



        showViews:=>
            @buildingCollection = @Collection[0]
            @unitCollection = @Collection[0]
            @showBuildingRegion @buildingCollection
            @showUnitRegion @unitCollection





        showBuildingRegion:(buildingCollection)->
            itemview1 = @getView buildingCollection
            @layout.buildingRegion.show itemview1



        showUnitRegion:(unitCollection)->
            console.log unitCollection
            itemview2 = @getUnitsView unitCollection
            @layout.unitRegion.show itemview2








        getView:(buildingCollection)->
            new ScreenTwoView.UnitTypeChildView
                collection : buildingCollection

        getUnitsView:(unitCollection)->
            new ScreenTwoView.UnitTypeView
                collection : unitCollection


        _unitCountSelected:=>
            App.navigate "screen-three" , trigger:true









        _getUnitsCountCollection:(paramid={})->
            buildingArray = Array()
            buildingArrayModel = Array()
            unitColl = Array()
            templateArr = []
            mainunitTypeArray = []
            mainnewarr =  []
            lnewarr =  []
            mnewarr =  []
            hnewarr =  []
            mainunique = {}
            myArray1 = []
            MainCollection = new Backbone.Model()
            status = App.currentStore.status.findWhere({'name':'Available'})
            status_onhold = App.currentStore.status.findWhere({'name':'On Hold'})
            key =  _.isEmpty(paramid)
            if key == true
                units  = _.filter(App.currentStore.unit.toArray(),  (num)->
                    return (parseInt(num.get('status')) == parseInt(status.get('id')) || parseInt(num.get('status')) == parseInt(status_onhold.get('id'))) 

                )
            else
               units  = _.filter(App.currentStore.unit.toArray(),  (num)->
                    return (parseInt(num.get('status')) == parseInt(status.get('id')) || parseInt(num.get('status')) == parseInt(status_onhold.get('id'))) 

                ) 
            Countunits  = _.filter(App.currentStore.unit.toArray(),  (num)->
                    return (parseInt(num.get('status')) == parseInt(status.get('id')) || parseInt(num.get('status')) == parseInt(status_onhold.get('id'))) 

            )
            param = {}
            paramkey = {}
            flag = 0
            mainunitsTypeArray = []
            mainArray = []
            param = {}
            templateString = ""
            paramkey = {}
            flag = 0
            floorUnitsArray = []
            myArray = []
            $.map(App.defaults, (value, index)->
                if value!='All' 
                    if  index != 'unitVariant' 
                        myArray.push({key:index,value:value})
                    if  index != 'facing' && index != 'terrace' && index != 'view'
                        myArray1.push({key:index,value:value})

            )
            
            unitslen  = _.filter(App.currentStore.unit.toArray(),  (num)->
                    return (parseInt(num.get('status')) == parseInt(status.get('id')) || parseInt(num.get('status')) == parseInt(status_onhold.get('id'))) 

            ) 
            
            unitslen1 = App.master.unit.toArray()


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
                if flag >= myArray.length
                    floorCollunits.push(value1)





            )
            floorCollunits1 = []
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
                if flag == myArray1.length 
                    if  value1.get('unitType') != 14 && value1.get('unitType') != 16
                        floorCollunits1.push(value1)





            )
            tempunitvarinat = []
            uniqUnitvariant = []
            
            floorCollection = new Backbone.Collection(floorCollunits)
            $.each(App.master.unit.toArray(), (index,value)->
                if value.get('unitType') != 14 && value.get('unitType') != 16
                    tempunitvarinat.push(value)

                )
            unitvarinatColl = new Backbone.Collection tempunitvarinat
            unitvariant = unitvarinatColl.pluck("unitVariant")
            uniqUnitvariant = _.uniq(unitvariant)
            floorunitvariant = floorCollection.pluck("unitVariant")
            flooruniqUnitvariant = _.uniq(floorunitvariant)

            unitVariantModels = []
            unitVariantID = []
            viewModels = []
            viewID = []
            viewtemp = []
            viewtemp1 = []
            facingModels = []
            facingID = []
            facingtemp = []
            facingtemp1 = []
            terraceModels = []
            terraceID = []
            terracetemp = []
            terracetemp1 = []
            usermodel = new Backbone.Model USER
            capability = usermodel.get('all_caps')
            if usermodel.get('id') != "0" && $.inArray('see_special_filters',capability) >= 0
                floorCollectionmaster = App.master.unit
                floorCollectionmaster.each (item)->
                    if item.get('unitType') != 14 && item.get('unitType') != 16
                        if item.get('apartment_views') != "" && item.get('apartment_views').length != 0
                            $.merge(viewtemp,item.get('apartment_views'))
                        if item.get('facing').length != 0 && item.get('facing') != ""
                            $.merge(facingtemp,item.get('facing'))
                        if item.get('terrace') != "" && item.get('terrace') != 0
                            terracetemp.push item.get('terrace')
                
                floorCollectionCur = new Backbone.Collection floorCollunits1
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
                        if parseInt(val.get('status')) == parseInt(status.get('id')) || parseInt(val.get('status')) == parseInt(status_onhold.get('id'))
                            if parseInt(value) == parseInt(val.get('terrace')) 
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
                count  = _.filter(floorCollection.toArray(),  (num)->
                    return (parseInt(num.get('status')) == parseInt(status.get('id')) || 
                    parseInt(num.get('status')) == parseInt(status_onhold.get('id'))) &&
                    num.get('unitVariant') == value

                )
                key  = $.inArray(value,flooruniqUnitvariant)
                if App.defaults['unitType'] != "All"
                    unittypemodel = App.master.unit_type.findWhere({id:parseInt(App.defaults['unitType'])})
                    filter = unittypemodel.get('name')+' apartments'
                else if App.defaults['budget'] != "All"
                    filter = 'Apartments within '+App.defaults['budget']
                selected = ""
                if count.length != 0 && key >= 0 
                    classname = 'filtered'
                    selected = 'selected'
                    unitVariantID.push(parseInt(unitVarinatModel.get('id')))
                else if count.length ==0 && key >= 0
                    classname = 'sold'
                else
                    classname = 'other'
                unitVariantModels.push({id:unitVarinatModel.get('id'),name:unitVarinatModel.get('name'),sellablearea:unitVarinatModel.get('sellablearea'),count:count.length,classname:classname,selected:selected,filter:filter})
                


            )
            
            unitVariantModels.sort( (a,b)->
                a.id - b.id

            )
            unitVariantID.sort( (a,b)->
                a - b

            )
            mainunitTypeArray1 = []
            units1  = _.filter(App.master.unit.toArray(),  (num)->
                    return (parseInt(num.get('status')) == parseInt(status.get('id')) || parseInt(num.get('status')) == parseInt(status_onhold.get('id'))) 

            )
            $.each(units1, (index,value)->

                if buildingArray.indexOf(value.get 'building') ==  -1
                    buildingArray.push value.get 'building'
                unitType = App.master.unit_type.findWhere({id:value.get 'unitType'})
                mainunitTypeArray1.push({id:unitType.get('id'),name: unitType.get('name')})
            )
            $.each(units, (index,value)->
                maxcoll = Array()
                
                
                    


                unitType = App.master.unit_type.findWhere({id:value.get 'unitType'})
                mainunitTypeArray.push({id:unitType.get('id'),name: unitType.get('name')})
            )


            $.each(mainunitTypeArray1, (key,item)->
                if (!mainunique[item.id])
                    if item.id != 14 && item.id != 16
                        
                        count  = _.filter(App.currentStore.unit.toArray(),  (num)->
                                return (parseInt(num.get('status')) == parseInt(status.get('id')) || 
                                parseInt(num.get('status')) == parseInt(status_onhold.get('id'))) &&
                                num.get('unitType') == item.id


                        )

                        count = App.currentStore.unit.where({unitType:item.id,'status':status.get('id')})

                        if parseInt(item.id) == 9
                            classname = 'twoBHK'
                        else if parseInt(item.id) == 19
                            classname = 'oneBHK'
                        else
                            classname = 'threeBHK'

                        mainnewarr.push({id:item.id,name:item.name,classname:classname,count:count})
                        mainunique[item.id] = item;


            )


            buildingUnits = []
            $.each(buildingArray, (index,value)->
                buildingid = value
                unitTypeArray = Array()
                newarr =  []
                unique = {}
                viewmodels = []
                lunitTypeArray = []
                lnewarr =  []
                lunique = {}
                munitTypeArray = []
                mnewarr =  []
                munique = {}
                hunitTypeArray = []
                hnewarr =  []
                hunique = {}
                lcount = []
                mcount = []
                hcount = []
                mainArray = Array()
                lclassname = ""
                mclassname = ""
                hclassname = ""
                totalunits = App.currentStore.unit.where({'building':value})
                buildingModel = App.master.building.findWhere({id:buildingid})
                floorriserange = buildingModel.get 'floorriserange'
                #floorriserange = [{"name":"low","start":"1","end":"2"},{"name":"medium","start":"3","end":"4"},{"name":"high","start":"5","end":"6"}]

                #$.each(totalunits, (index,value)->
                    #viewsData = value.get('views')
                    #viewmodels = $.merge(viewmodels, viewsData)
                #)
                #uniqueViewArry = _.uniq(viewmodels);
                variantsDataValues = []
                data = []
                #$.each(uniqueViewArry, (index,value)->
                    #viewModel = App.master.view.findWhere({id:parseInt(value)})

                    #data.push({id:viewModel.get('id'),name:viewModel.get('name')})
                    #if data.length == 2
                        #variantsDataValues.push({data:data})
                        #data = []



                #)
                flag = 0
                flag1 = 0
                flag11 = 0
                $.each(mainunitTypeArray, (key,item)->
                    if (!lunique[item.id])
                        lunitTypeArray = []
                        count  = _.filter(App.currentStore.unit.toArray(),  (num)->
                                return (parseInt(num.get('status')) == parseInt(status.get('id')) || 
                                parseInt(num.get('status')) == parseInt(status_onhold.get('id'))) &&
                                parseInt(num.get('building')) == parseInt(buildingid) &&
                                num.get('unitType') == item.id


                        )
                        $.each(count, (index,value)->
                            #lowUnits = App.currentStore.range.findWhere({name:'low'})
                            if (value.get('floor') >= parseInt(floorriserange[0].start) &&  value.get('floor') <= parseInt(floorriserange[0].end)) && item.id == value.get('unitType')
                                lunitTypeArray.push value
                        )
                        $.each(lunitTypeArray, (index,value)->
                            if value.get('unitType') == 9
                                flag = 1
                            if value.get('unitType') == 10
                                flag1 = 1
                            if value.get('unitType') == 19
                                flag11 = 1

                        )
                        if parseInt(flag11) == 1
                            lclassname = 'oneBHK'
                        if parseInt(flag) == 1
                            lclassname = 'twoBHK'
                        if parseInt(flag1) == 1
                            lclassname = 'threeBHK'
                        if parseInt(flag) == 1 && parseInt(flag1) == 1 && parseInt(flag11)
                            lclassname = 'multiBHK'





                        lnewarr.push({id:item.id,name:item.name,count:lunitTypeArray.length,classname:lclassname})
                        lunique[item.id] = item;

                )
                flag2 = 0
                flag3 = 0
                flag33 = 0

                $.each(mainunitTypeArray, (key,item)->
                    if (!munique[item.id])
                        munitTypeArray = []
                        count  = _.filter(App.currentStore.unit.toArray(),  (num)->
                                return (parseInt(num.get('status')) == parseInt(status.get('id')) || 
                                parseInt(num.get('status')) == parseInt(status_onhold.get('id'))) &&
                                parseInt(num.get('building')) == parseInt(buildingid) &&
                                num.get('unitType') == item.id


                        )
                        $.each(count, (index,value)->
                            if (value.get('floor') >= parseInt(floorriserange[1].start) &&  value.get('floor') <= parseInt(floorriserange[1].end)) && item.id == value.get('unitType')
                                munitTypeArray.push value
                        )
                        $.each(munitTypeArray, (index,value)->
                            if value.get('unitType') == 9
                                flag2 = 1
                            if value.get('unitType') == 10
                                flag3 = 1
                            if value.get('unitType') == 19
                                flag33 = 1

                        )
                        if parseInt(flag2) == 1
                            mclassname = 'twoBHK'
                        if parseInt(flag33) == 1
                            mclassname = 'oneBHK'
                        if parseInt(flag3) == 1
                            mclassname = 'threeBHK'
                        if parseInt(flag2) == 1 && parseInt(flag3) == 1 && parseInt(flag33) == 1
                            mclassname = 'multiBHK'


                        mnewarr.push({id:item.id,name:item.name,count:munitTypeArray.length,classname:mclassname})
                        munique[item.id] = item;


                )
                flag4 = 0
                flag5 = 0
                flag55 = 0
                $.each(mainunitTypeArray, (key,item)->

                    if (!hunique[item.id])
                        hunitTypeArray = []
                        count  = _.filter(App.currentStore.unit.toArray(),  (num)->
                                return (parseInt(num.get('status')) == parseInt(status.get('id')) || 
                                parseInt(num.get('status')) == parseInt(status_onhold.get('id'))) &&
                                parseInt(num.get('building')) == parseInt(buildingid) &&
                                num.get('unitType') == item.id


                            )
                        $.each(count, (index,value)->
                            if (value.get('floor') >= parseInt(floorriserange[2].start) &&  value.get('floor') <= parseInt(floorriserange[2].end)) && item.id == value.get('unitType')
                                hunitTypeArray.push value
                        )
                        $.each(hunitTypeArray, (index,value)->
                            if value.get('unitType') == 9
                                flag4 = 1
                            if value.get('unitType') == 10
                                flag5 = 1
                            if value.get('unitType') == 19
                                flag55 = 1

                        )

                        if parseInt(flag4) == 1
                            hclassname = 'twoBHK'
                        if parseInt(flag5) == 1
                            hclassname = 'threeBHK'
                        if parseInt(flag55) == 1
                            hclassname = 'oneBHK'
                        if parseInt(flag4) == 1 && parseInt(flag5) == 1 && parseInt(flag55)
                            hclassname = 'multiBHK'

                        hnewarr.push({id:item.id,name:item.name,count:hunitTypeArray.length,classname:hclassname})
                        hunique[item.id] = item;


                )





                availableunits  = _.filter(App.currentStore.unit.toArray(),  (num)->
                    return (parseInt(num.get('status')) == parseInt(status.get('id')) || 
                        parseInt(num.get('status')) == parseInt(status_onhold.get('id'))) &&
                        num.get('building') == value

                )
                totalfloorcollection = new Backbone.Collection(totalunits)
                floors = totalfloorcollection.pluck("floor")
                uniqFloors = _.uniq(floors)
                newunits  = _.filter(App.currentStore.unit.toArray(),  (num)->
                    return (parseInt(num.get('status')) == parseInt(status.get('id')) || 
                        parseInt(num.get('status')) == parseInt(status_onhold.get('id'))) &&
                        num.get('building') == value

                )
                buildingUnits.push({id:buildingid,count:newunits.length,name:'tower'+buildingid})
                lowArray = Array()
                mediumArray = Array()
                highArray = Array()
                mainArray = Array()
                unitTypeArray = []
                $.each(newunits, (index,value)->
                    if  value.get('unitType') != 14 && value.get('unitType') != 16
                        if (value.get('floor') >= parseInt(floorriserange[0].start) &&  value.get('floor') <= parseInt(floorriserange[0].end))
                            lowArray.push value.get 'id'



                        if (value.get('floor') >= parseInt(floorriserange[1].start) &&  value.get('floor') <= parseInt(floorriserange[1].end))
                            mediumArray.push value.get 'id'


                        if (value.get('floor') >= parseInt(floorriserange[2].start) &&  value.get('floor') <= parseInt(floorriserange[2].end))
                            highArray.push value.get 'id'

                    unitType = App.master.unit_type.findWhere({id:value.get 'unitType'})
                    unitTypeArray.push({id:unitType.get('id'),name: unitType.get('name')})

                )
                $.each(unitTypeArray, (key,item)->
                    if (!unique[item.id])
                        count  = _.filter(App.currentStore.unit.toArray(),  (num)->
                                return (parseInt(num.get('status')) == parseInt(status.get('id')) || 
                                parseInt(num.get('status')) == parseInt(status_onhold.get('id'))) &&
                                parseInt(num.get('building')) == parseInt(buildingid) &&
                                num.get('unitType') == item.id


                            )
                        if parseInt(item.id) == 9
                            classname = 'twoBHK m-l-20'
                        else
                            classname = 'oneBHK'
                        newarr.push({id:item.id,name:item.name,count:count.length,classname:classname})
                        unique[item.id] = item;


                )
                low_max_val = 0
                low_min_val = 0
                medium_max_val = 0
                medium_min_val = 0
                high_min_val = 0
                high_max_val = 0
                lfloorvalue = ""
                mfloorvalue = ""
                hfloorvalue = ""
                disablehigh = "other"
                disablemedium = "other"
                disablelow = "other"
                lfloorvalue = 'Floors '+floorriserange[0].start+'-'+floorriserange[0].end
                mfloorvalue = 'Floors '+floorriserange[1].start+'-'+floorriserange[1].end
                hfloorvalue = 'Floors '+floorriserange[2].start+'-'+floorriserange[2].end




                $.each(lowArray , (index,value)->
                    disablelow = ""
                    unitmodel = App.master.unit.findWhere({id:value})
                    unittypemodel = App.master.unit_type.findWhere({id :  unitmodel.get( 'unitType' ) })
                    unitCollection = App.master.unit.where({unitType: unittypemodel.get( 'id' ) } )
                    max_coll = Array()
                    $.each(unitCollection, (index,value)->

                        variantmodel = App.master.unit_variant.findWhere({id: value.get( 'unitVariant' )} )
                        max_coll.push variantmodel.get 'sellablearea'


                    )
                    low_max_val = Math.max.apply( Math, max_coll )
                    low_min_val = Math.min.apply( Math, max_coll )
                )

                $.each(mediumArray , (index,value)->
                    disablemedium = ""
                    unitmodel = App.master.unit.findWhere({id:value})
                    unittypemodel = App.master.unit_type.findWhere({id :  unitmodel.get( 'unitType' ) })
                    munitTypeArray.push({id:unittypemodel.get('id'),name: unittypemodel.get('name')})

                    unitCollection = App.master.unit.where({unitType: unittypemodel.get( 'id' ) } )
                    max_coll = Array()
                    $.each(unitCollection, (index,value)->

                        variantmodel = App.master.unit_variant.findWhere({id: value.get( 'unitVariant' )} )
                        max_coll.push variantmodel.get 'sellablearea'


                    )
                    medium_max_val = Math.max.apply( Math, max_coll )
                    medium_min_val = Math.min.apply( Math, max_coll )
                )

                $.each(highArray , (index,value)->
                    disablehigh = ""
                    unitmodel = App.master.unit.findWhere({id:value})
                    unittypemodel = App.master.unit_type.findWhere({id :  unitmodel.get( 'unitType' ) })
                    hunitTypeArray.push({id:unittypemodel.get('id'),name: unittypemodel.get('name')})

                    unitCollection = App.master.unit.where({unitType: unittypemodel.get( 'id' ) } )
                    max_coll = Array()
                    $.each(unitCollection, (index,value)->

                        variantmodel = App.master.unit_variant.findWhere({id: value.get( 'unitVariant' )} )
                        max_coll.push variantmodel.get 'sellablearea'


                    )
                    high_max_val = Math.max.apply( Math, max_coll )
                    high_min_val = Math.min.apply( Math, max_coll )
                )
                if App.defaults['unitType'] != 'All'
                    mainnewarr = []
                    hclassname = ""
                    mclassname = ""
                    lclassname = ""
                mainArray.push({count:highArray.length,low_max_val: high_max_val,low_min_val:high_min_val,range:'high',buildingid:buildingid,unittypes:hnewarr,classname:hclassname,rangetext:'HIGHRISE',rangeNo:hfloorvalue,disable:disablehigh})
                mainArray.push({count: mediumArray.length,low_max_val: medium_max_val,low_min_val:medium_min_val,range:'medium',buildingid:buildingid,unittypes:mnewarr,classname:mclassname,rangetext:'MIDRISE',rangeNo:mfloorvalue,disable:disablemedium})
                mainArray.push({count: lowArray.length,low_max_val: low_max_val,low_min_val:low_min_val,range:'low',buildingid:buildingid,unittypes:lnewarr,classname:lclassname,rangetext:'LOWRISE',rangeNo:lfloorvalue,disable:disablelow})

                itemCollection = new Backbone.Collection(mainArray)
                buildingModel = App.master.building.findWhere({id:value})
                unitColl.push {id:buildingModel.get('id'),buildingname: buildingModel.get('name') , units: itemCollection ,buildingid:buildingModel.get('id'),
                unittypes:newarr,availableunits:availableunits.length,totalunits:totalunits.length,totalfloors:uniqFloors.length,views:variantsDataValues}
                buildingArrayModel.push(buildingModel)

            )
            mainArray = []
            if buildingUnits.length == 2
                buildingUnits.push({id:100,count:0,name:'tower'+100})
                mainArray.push({count:'---',low_max_val: 0,low_min_val:0,range:'high',buildingid:100,unittypes:0,classname:"",rangetext:'HIGHRISE',rangeNo:'Floors --'})
                mainArray.push({count: '---',low_max_val: 0,low_min_val:0,range:'medium',buildingid:100,unittypes:0,classname:"",rangetext:'MIDRISE',rangeNo:'Floors --'})
                mainArray.push({count: '---',low_max_val: 0,low_min_val:0,range:'low',buildingid:100,unittypes:0,classname:"",rangetext:'LOWRISE',rangeNo:'Floors --'})
                itemCollection = new Backbone.Collection(mainArray)
                unitColl.push {id:101,buildingname: 'Random' , units: itemCollection ,buildingid:100,
                unittypes:0,availableunits:0,totalunits:0,totalfloors:0,views:0}
            


            buildingvalue = _.max(buildingUnits,  (model)->
                model.count
            )
            buildingUnits.sort( (a,b)->
                a.id - b.id

            )
            modelIdArr = []
            modelArr = []
            ModelActualArr = []
            $.each(buildingUnits, (index,value)->
                modelIdArr.push(value.id)

            )
            key =  _.isEmpty(paramid)
            if key == true
                index = _.indexOf(modelIdArr, buildingvalue.id)
                modelArr.push buildingvalue.id

            else
                keycheck = _.findWhere(buildingUnits, {name:paramid})
                index = _.indexOf(modelIdArr, keycheck.id)
                modelArr.push keycheck.id

            
            highLength = modelIdArr.length - index
            i = index + 1
            while(i<modelIdArr.length)
                modelArr.push(modelIdArr[i])
                i++
            j= 0
            while(j<index)
                modelArr.push(modelIdArr[j])
                j++
            
            if modelArr.length == 2
                arrayvalue = _.last(modelArr)
                modelArr.push(arrayvalue)
            
            buildingsactual = []
            unitsactual = []
            buildingCollection = new Backbone.Collection(buildingArrayModel)
            units = new Backbone.Collection(unitColl)
            $.each(modelArr , (index,value)->
                value = value
                buildingsactual.push(buildingCollection.get(value))
                unitsactual.push(units.get(value))
            )
            
            buildingCollection = new Backbone.Collection(buildingsactual)
            units = new Backbone.Collection(unitsactual)
            temp = []
            $.each(buildingArray, (index,value)->
                buildingmodel = App.master.building.findWhere({'id':parseInt(value)})
                units = App.currentStore.unit.where({'building':parseInt(value)})
                temp.push
                    'id' : value
                    'count' : units.length
                    'name'  : buildingmodel.get('name')
            )

            console.log buildingCollection =  new Backbone.Collection temp

            [buildingCollection ,units,templateString,Countunits.length,mainnewarr,hnewarr,mnewarr,lnewarr,unitVariantModels,unitVariantID,unitVariantID,viewModels,facingModels,viewID,facingID,terraceModels,terraceID]





    msgbus.registerController 'screen:two', ScreenTwoController