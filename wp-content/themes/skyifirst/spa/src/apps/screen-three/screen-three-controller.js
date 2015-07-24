// Generated by CoffeeScript 1.7.1
var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; },
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

define(['extm', 'src/apps/screen-three/screen-three-view'], function(Extm, ScreenThreeView) {
  var ScreenThreeController;
  ScreenThreeController = (function(_super) {
    __extends(ScreenThreeController, _super);

    function ScreenThreeController() {
      this.mainUnitSelected = __bind(this.mainUnitSelected, this);
      this._unitItemSelected = __bind(this._unitItemSelected, this);
      this._loadRangeData = __bind(this._loadRangeData, this);
      this.showViews = __bind(this.showViews, this);
      return ScreenThreeController.__super__.constructor.apply(this, arguments);
    }

    ScreenThreeController.prototype.initialize = function() {
      this.Collection = this._getUnits();
      this.layout = new ScreenThreeView.ScreenThreeLayout({
        buildingCollection: this.Collection[0],
        countUnits: this.Collection[3],
        uintVariantId: this.Collection[8],
        uintVariantIdArray: this.Collection[8],
        unitVariants: this.Collection[7],
        maxvalue: this.Collection[9],
        views: this.Collection[12],
        facings: this.Collection[13],
        Oviews: this.Collection[10],
        Ofacings: this.Collection[11],
        terrace: this.Collection[14],
        terraceID: this.Collection[15],
        position: this.Collection[16],
        templateHelpers: {
          selection: this.Collection[2],
          countUnits: this.Collection[3],
          range: this.Collection[4],
          high: this.Collection[5],
          rangetext: this.Collection[6],
          unitVariants: this.Collection[7],
          views: this.Collection[10],
          facings: this.Collection[11],
          terrace: this.Collection[14],
          terraceID: this.Collection[15],
          maxvalue: this.Collection[9]
        }
      });
      this.listenTo(this.layout, "show", this.showViews);
      this.listenTo(this.layout, 'unit:variants:selected', this._showBuildings);
      this.listenTo(this.layout, 'unit:item:selected', this._unitItemSelected);
      this.listenTo(this.layout, 'load:range:data', this._loadRangeData);
      return this.show(this.layout);
    };

    ScreenThreeController.prototype.showViews = function() {
      this.buildingCollection = this.Collection[0];
      this.unitCollection = this.Collection[1];
      this.showBuildingRegion(this.buildingCollection);
      return this.showUnitRegion(this.unitCollection);
    };

    ScreenThreeController.prototype._showBuildings = function() {
      this.Collection = this._getUnits();
      this.layout = new ScreenThreeView.ScreenThreeLayout({
        buildingCollection: this.Collection[0],
        countUnits: this.Collection[3],
        uintVariantId: this.Collection[8],
        uintVariantIdArray: this.Collection[8],
        unitVariants: this.Collection[7],
        maxvalue: this.Collection[9],
        views: this.Collection[12],
        facings: this.Collection[13],
        Oviews: this.Collection[10],
        Ofacings: this.Collection[11],
        terrace: this.Collection[14],
        terraceID: this.Collection[15],
        position: this.Collection[16],
        templateHelpers: {
          selection: this.Collection[2],
          countUnits: this.Collection[3],
          range: this.Collection[4],
          high: this.Collection[5],
          rangetext: this.Collection[6],
          unitVariants: this.Collection[7],
          maxvalue: this.Collection[9],
          views: this.Collection[10],
          facings: this.Collection[11],
          terrace: this.Collection[14],
          terraceID: this.Collection[15]
        }
      });
      this.listenTo(this.layout, "show", this.showViews);
      this.listenTo(this.layout, 'unit:variants:selected', this._showBuildings);
      this.listenTo(this.layout, 'unit:item:selected', this._unitItemSelected);
      this.listenTo(this.layout, 'load:range:data', this._loadRangeData);
      return this.show(this.layout);
    };

    ScreenThreeController.prototype._loadRangeData = function(unitModel) {
      var itemview1, itemview2, sudoSlider;
      this.Collection = this._getUnits();
      itemview1 = new ScreenThreeView.UnitTypeChildView({
        collection: this.Collection[0]
      });
      itemview2 = new ScreenThreeView.UnitTypeView({
        collection: this.Collection[1]
      });
      this.layout.buildingRegion.$el.empty();
      this.layout.unitRegion.$el.empty();
      this.layout.buildingRegion.$el.append(itemview1.render().el);
      this.layout.unitRegion.$el.append(itemview2.render().el);
      sudoSlider = $("#unitsSlider").sudoSlider({
        customLink: "a",
        prevNext: false,
        responsive: true,
        speed: 800
      });
      sudoSlider.goToSlide(unitModel.get('unitAssigned'));
      msgbus.showApp('header').insideRegion(App.headerRegion).withOptions();
      return this.layout.triggerMethod("show:range:data", unitModel, this.Collection[1]);
    };

    ScreenThreeController.prototype.showBuildingRegion = function(buildingCollection) {
      var itemview1;
      itemview1 = this.getView(buildingCollection);
      this.layout.buildingRegion.show(itemview1);
      return this.listenTo(itemview1, 'childview:building:link:selected', this._showBuildings);
    };

    ScreenThreeController.prototype.showUnitRegion = function(unitCollection) {
      var itemview2;
      itemview2 = this.getUnitsView(unitCollection);
      return this.layout.unitRegion.show(itemview2);
    };

    ScreenThreeController.prototype.getView = function(buildingCollection) {
      return new ScreenThreeView.UnitTypeChildView({
        collection: buildingCollection
      });
    };

    ScreenThreeController.prototype.getUnitsView = function(unitCollection) {
      return new ScreenThreeView.UnitTypeView({
        collection: unitCollection
      });
    };

    ScreenThreeController.prototype._unitItemSelected = function(childview, childview1, childview2) {
      return App.navigate("screen-four", {
        trigger: true
      });
    };

    ScreenThreeController.prototype._getUnits = function() {
      var Countunits, buildingArray, buildingArrayModel, buildingCollection, buildingModel, buildings, buildingvalue, capability, facingID, facingModels, facingtemp, facingtemp1, flag, floorArray, floorCollectionCur, floorCollunits, floorCollunits1, floorCountArray, floorUnitsArray, flooruniqUnitvariant, floorunitvariant, mainnewarr, maxvalue, myArray, myArray1, newunitCollection, param, paramkey, range, status, status_onhold, templateArr, templateString, tempunitvarinat, terraceID, terraceModels, terracetemp, terracetemp1, track, trackArray, trackposition, uniqBuildings, uniqUnitvariant, uniqfacings, uniqterrace, uniqunitAssigned, uniqunitAssignedval, uniqviews, unitArray, unitAssigned, unitColl, unitVariantID, unitVariantModels, units, units1, unitsArray, unitsCollection, unitscur, unitsfilter, unitslen, unitslen1, unitvariant, unitvarinatColl, usermodel, viewID, viewModels, viewtemp, viewtemp1;
      buildingArray = [];
      unitArray = [];
      unitsArray = [];
      buildingArrayModel = [];
      templateArr = [];
      param = {};
      paramkey = {};
      flag = 0;
      range = "";
      track = 0;
      trackArray = [];
      floorUnitsArray = [];
      templateString = "";
      myArray = [];
      myArray1 = [];
      units = App.master.unit;
      status = App.currentStore.status.findWhere({
        'name': 'Available'
      });
      status_onhold = App.currentStore.status.findWhere({
        'name': 'On Hold'
      });
      Countunits = _.filter(App.currentStore.unit.toArray(), function(num) {
        return parseInt(num.get('status')) === parseInt(status.get('id')) || parseInt(num.get('status')) === parseInt(status_onhold.get('id'));
      });
      $.map(App.defaults, function(value, index) {
        if (value !== 'All') {
          if (index !== 'unitVariant') {
            myArray.push({
              key: index,
              value: value
            });
          }
          if (index !== 'facing' && index !== 'terrace' && index !== 'view') {
            return myArray1.push({
              key: index,
              value: value
            });
          }
        }
      });
      flag = 0;
      unitslen = App.master.unit.toArray();
      unitslen1 = App.master.unit.where({
        'building': parseInt(App.defaults['building'])
      });
      $.each(unitslen1, function(index, value1) {
        var floorArray, floorstring;
        if (App.defaults['floor'] !== 'All') {
          floorstring = App.defaults['floor'];
          floorArray = floorstring.split(',');
          return $.each(floorArray, function(index, value) {
            if (value1.get('floor') === parseInt(value)) {
              return floorUnitsArray.push(value1);
            }
          });
        }
      });
      if (App.defaults['floor'] === "All") {
        floorUnitsArray = unitslen1;
      }
      floorCollunits = [];
      floorCollunits1 = [];
      $.each(floorUnitsArray, function(index, value1) {
        flag = 0;
        $.each(myArray, function(index, value) {
          var budget_arr, budget_price, buildingModel, element, floorRise, floorRiseValue, initvariant, paramKey, temp, tempnew, tempstring, unitPrice, unitVariantmodel, _i, _len, _results;
          paramKey = {};
          paramKey[value.key] = value.value;
          if (value.key === 'budget') {
            buildingModel = App.master.building.findWhere({
              'id': value1.get('building')
            });
            floorRise = buildingModel.get('floorrise');
            floorRiseValue = floorRise[value1.get('floor')];
            unitVariantmodel = App.master.unit_variant.findWhere({
              'id': value1.get('unitVariant')
            });
            unitPrice = value1.get('unitPrice');
            budget_arr = value.value.split(' ');
            budget_price = budget_arr[0].split('-');
            budget_price[0] = budget_price[0] + '00000';
            budget_price[1] = budget_price[1] + '00000';
            if (parseInt(unitPrice) >= parseInt(budget_price[0]) && parseInt(unitPrice) <= parseInt(budget_price[1])) {
              return flag++;
            }
          } else if (value.key !== 'floor') {
            tempnew = [];
            if (value.key === 'view' || value.key === 'apartment_views') {
              tempnew = [];
              value.key = 'apartment_views';
              tempnew = value1.get(value.key);
              if (tempnew !== "") {
                tempnew = tempnew.map(function(item) {
                  return parseInt(item);
                });
              }
            } else if (value.key === 'facing') {
              tempnew = [];
              tempnew = value1.get(value.key);
              if (tempnew.length !== 0) {
                tempnew = tempnew.map(function(item) {
                  return parseInt(item);
                });
              }
            }
            temp = [];
            temp.push(value.value);
            tempstring = temp.join(',');
            initvariant = tempstring.split(',').map(function(item) {
              return parseInt(item);
            });
            if (initvariant.length >= 1) {
              _results = [];
              for (_i = 0, _len = initvariant.length; _i < _len; _i++) {
                element = initvariant[_i];
                if (value1.get(value.key) === parseInt(element)) {
                  _results.push(flag++);
                } else if ($.inArray(parseInt(element), tempnew) >= 0) {
                  _results.push(flag++);
                } else {
                  _results.push(void 0);
                }
              }
              return _results;
            } else {
              if (value1.get(value.key) === parseInt(value.value)) {
                return flag++;
              }
            }
          }
        });
        if (flag >= myArray.length - 1) {
          if (value1.get('unitType') !== 14 && value1.get('unitType') !== 16) {
            return floorCollunits.push(value1);
          }
        }
      });
      $.each(floorUnitsArray, function(index, value1) {
        flag = 0;
        $.each(myArray1, function(index, value) {
          var budget_arr, budget_price, buildingModel, element, floorRise, floorRiseValue, initvariant, paramKey, temp, tempnew, tempstring, unitPrice, unitVariantmodel, _i, _len, _results;
          paramKey = {};
          paramKey[value.key] = value.value;
          if (value.key === 'budget') {
            buildingModel = App.master.building.findWhere({
              'id': value1.get('building')
            });
            floorRise = buildingModel.get('floorrise');
            floorRiseValue = floorRise[value1.get('floor')];
            unitVariantmodel = App.master.unit_variant.findWhere({
              'id': value1.get('unitVariant')
            });
            unitPrice = value1.get('unitPrice');
            budget_arr = value.value.split(' ');
            budget_price = budget_arr[0].split('-');
            budget_price[0] = budget_price[0] + '00000';
            budget_price[1] = budget_price[1] + '00000';
            if (parseInt(unitPrice) >= parseInt(budget_price[0]) && parseInt(unitPrice) <= parseInt(budget_price[1])) {
              return flag++;
            }
          } else if (value.key !== 'floor') {
            tempnew = [];
            if (value.key === 'view' || value.key === 'apartment_views') {
              tempnew = [];
              value.key = 'apartment_views';
              tempnew = value1.get(value.key);
              if (tempnew !== "") {
                tempnew = tempnew.map(function(item) {
                  return parseInt(item);
                });
              }
            } else if (value.key === 'facing') {
              tempnew = [];
              tempnew = value1.get(value.key);
              if (tempnew.length !== 0) {
                tempnew = tempnew.map(function(item) {
                  return parseInt(item);
                });
              }
            }
            temp = [];
            temp.push(value.value);
            tempstring = temp.join(',');
            initvariant = tempstring.split(',').map(function(item) {
              return parseInt(item);
            });
            if (initvariant.length >= 1) {
              _results = [];
              for (_i = 0, _len = initvariant.length; _i < _len; _i++) {
                element = initvariant[_i];
                if (value1.get(value.key) === parseInt(element)) {
                  _results.push(flag++);
                } else if ($.inArray(parseInt(element), tempnew) >= 0) {
                  _results.push(flag++);
                } else {
                  _results.push(void 0);
                }
              }
              return _results;
            } else {
              if (value1.get(value.key) === parseInt(value.value)) {
                return flag++;
              }
            }
          }
        });
        if (flag >= myArray1.length - 1) {
          if (value1.get('unitType') !== 14 && value1.get('unitType') !== 16) {
            return floorCollunits1.push(value1);
          }
        }
      });
      if (App.defaults['floor'] === "All") {
        floorCollunits = unitslen;
      }
      units = new Backbone.Collection(floorCollunits);
      unitsfilter = new Backbone.Collection(floorCollunits1);
      buildings = units.pluck("building");
      uniqBuildings = _.uniq(buildings);
      tempunitvarinat = [];
      uniqUnitvariant = [];
      $.each(unitslen, function(index, value) {
        if (value.get('unitType') !== 14 && value.get('unitType') !== 16) {
          return tempunitvarinat.push(value);
        }
      });
      unitvarinatColl = new Backbone.Collection(tempunitvarinat);
      unitvariant = unitvarinatColl.pluck("unitVariant");
      uniqUnitvariant = _.uniq(unitvariant);
      floorunitvariant = units.pluck("unitVariant");
      flooruniqUnitvariant = _.uniq(floorunitvariant);
      unitVariantModels = [];
      unitVariantID = [];
      viewModels = [];
      viewID = [];
      viewtemp = [];
      facingModels = [];
      facingID = [];
      facingtemp = [];
      terraceModels = [];
      terraceID = [];
      terracetemp = [];
      viewtemp1 = [];
      facingtemp1 = [];
      terracetemp1 = [];
      usermodel = new Backbone.Model(USER);
      capability = usermodel.get('all_caps');
      if (usermodel.get('id') !== "0" && $.inArray('see_special_filters', capability) >= 0) {
        unitscur = App.master.unit;
        unitscur.each(function(item) {
          if (item.get('unitType') !== 14 && item.get('unitType') !== 16) {
            if (item.get('apartment_views') !== "" && item.get('apartment_views').length !== 0) {
              $.merge(viewtemp, item.get('apartment_views'));
            }
            if (item.get('facing').length !== 0 && item.get('facing') !== "") {
              $.merge(facingtemp, item.get('facing'));
            }
            if (item.get('terrace') !== "" && item.get('terrace') !== 0) {
              return terracetemp.push(item.get('terrace'));
            }
          }
        });
        floorCollectionCur = unitsfilter;
        floorCollectionCur.each(function(item) {
          if (item.get('unitType') !== 14 && item.get('unitType') !== 16) {
            if (item.get('apartment_views') !== "" && item.get('apartment_views').length !== 0) {
              $.merge(viewtemp1, item.get('apartment_views'));
            }
            if (item.get('facing').length !== 0 && item.get('facing') !== "") {
              $.merge(facingtemp1, item.get('facing'));
            }
            if (item.get('terrace') !== "" && item.get('terrace') !== 0) {
              return terracetemp1.push(item.get('terrace'));
            }
          }
        });
        viewtemp = viewtemp.map(function(item) {
          return parseInt(item);
        });
        facingtemp = facingtemp.map(function(item) {
          return parseInt(item);
        });
        terracetemp = terracetemp.map(function(item) {
          return parseInt(item);
        });
        uniqviews = _.uniq(viewtemp);
        uniqfacings = _.uniq(facingtemp);
        uniqterrace = _.uniq(terracetemp);
        viewtemp1 = viewtemp1.map(function(item) {
          return parseInt(item);
        });
        viewtemp1 = _.uniq(viewtemp1);
        facingtemp1 = facingtemp1.map(function(item) {
          return parseInt(item);
        });
        facingtemp1 = _.uniq(facingtemp1);
        terracetemp1 = terracetemp1.map(function(item) {
          return parseInt(item);
        });
        terracetemp1 = _.uniq(terracetemp1);
        $.each(uniqviews, function(index, value) {
          var checked, classname, count, disabled, key, viewModel;
          viewModel = App.master.view.findWhere({
            id: parseInt(value)
          });
          disabled = "disabled";
          checked = "";
          key = "";
          key = $.inArray(parseInt(value), viewtemp1);
          count = [];
          $.each(floorCollunits1, function(ind, val) {
            var apartment;
            if (parseInt(val.get('status')) === parseInt(status.get('id')) || parseInt(val.get('status')) === parseInt(status_onhold.get('id'))) {
              apartment = val.get('apartment_views');
              if (val.get('apartment_views') !== "" && val.get('apartment_views').length !== 0) {
                apartment = apartment.map(function(item) {
                  return parseInt(item);
                });
                if ($.inArray(parseInt(value), apartment) >= 0) {
                  return $.merge(count, val.get('apartment_views'));
                }
              }
            }
          });
          if (count.length !== 0 && key >= 0) {
            disabled = "";
            checked = "checked";
            classname = 'filtered';
            viewID.push(parseInt(viewModel.get('id')));
          } else if (count.length === 0 && key >= 0) {
            classname = 'sold';
          } else {
            classname = 'other';
          }
          return viewModels.push({
            id: viewModel.get('id'),
            name: viewModel.get('name'),
            disabled: disabled,
            checked: checked,
            classname: classname
          });
        });
        $.each(uniqfacings, function(index, value) {
          var checked, classname, count, disabled, facingModel, key;
          facingModel = App.master.facings.findWhere({
            id: parseInt(value)
          });
          disabled = "disabled";
          checked = "";
          key = "";
          key = $.inArray(parseInt(value), facingtemp1);
          count = [];
          $.each(floorCollunits1, function(ind, val) {
            var facing;
            if (parseInt(val.get('status')) === parseInt(status.get('id')) || parseInt(val.get('status')) === parseInt(status_onhold.get('id'))) {
              facing = val.get('facing');
              facing = facing.map(function(item) {
                return parseInt(item);
              });
              if ($.inArray(parseInt(value), facing) >= 0) {
                return $.merge(count, val.get('facing'));
              }
            }
          });
          if (count.length !== 0 && key >= 0) {
            disabled = "";
            checked = "checked";
            classname = 'filtered';
            facingID.push(parseInt(facingModel.get('id')));
          } else if (count.length === 0 && key >= 0) {
            classname = 'sold';
          } else {
            classname = 'other';
          }
          return facingModels.push({
            id: facingModel.get('id'),
            name: facingModel.get('name'),
            disabled: disabled,
            checked: checked,
            classname: classname
          });
        });
        $.each(uniqterrace, function(index, value) {
          var checked, classname, count, disabled, key, terraceModel;
          terraceModel = App.master.terrace.findWhere({
            id: parseInt(value)
          });
          disabled = "disabled";
          checked = "";
          key = "";
          key = $.inArray(parseInt(value), terracetemp1);
          count = [];
          $.each(floorCollunits1, function(ind, val) {
            if (parseInt(val.get('status')) === parseInt(status.get('id')) || parseInt(val.get('status')) === parseInt(status_onhold.get('id'))) {
              if (parseInt(value) === val.get('terrace')) {
                return count.push(val);
              }
            }
          });
          if (count.length !== 0 && key >= 0) {
            disabled = "";
            checked = "checked";
            classname = 'filtered';
            terraceID.push(parseInt(terraceModel.get('id')));
          } else if (count.length === 0 && key >= 0) {
            classname = 'sold';
          } else {
            classname = 'other';
          }
          return terraceModels.push({
            id: parseInt(terraceModel.get('id')),
            name: terraceModel.get('name'),
            disabled: disabled,
            checked: checked,
            classname: classname
          });
        });
      }
      $.each(uniqUnitvariant, function(index, value) {
        var classname, count, filter, filtername, key, selected, unitVarinatModel, unittypemodel;
        unitVarinatModel = App.master.unit_variant.findWhere({
          id: value
        });
        count = _.filter(units.toArray(), function(num) {
          return (parseInt(num.get('status')) === parseInt(status.get('id')) || parseInt(num.get('status')) === parseInt(status_onhold.get('id'))) && num.get('unitVariant') === value;
        });
        key = $.inArray(value, flooruniqUnitvariant);
        selected = "";
        if (App.defaults['unitType'] !== "All") {
          unittypemodel = App.master.unit_type.findWhere({
            id: parseInt(App.defaults['unitType'])
          });
          filter = unittypemodel.get('name') + ' apartments';
        } else if (App.defaults['budget'] !== "All") {
          filter = 'Apartments within ' + App.defaults['budget'];
        }
        if (count.length !== 0 && key >= 0) {
          classname = 'boxLong filtered';
          filtername = 'filtered';
          selected = 'selected';
          unitVariantID.push(parseInt(unitVarinatModel.get('id')));
        } else if (count.length === 0 && key >= 0) {
          classname = 'boxLong sold';
          filtername = 'sold';
        } else {
          classname = 'boxLong other';
          filtername = 'other';
        }
        return unitVariantModels.push({
          id: unitVarinatModel.get('id'),
          name: unitVarinatModel.get('name'),
          sellablearea: unitVarinatModel.get('sellablearea'),
          count: count.length,
          classname: classname,
          filtername: filtername,
          selected: selected,
          filter: filter
        });
      });
      unitVariantModels.sort(function(a, b) {
        return a.id - b.id;
      });
      unitVariantID.sort(function(a, b) {
        return a - b;
      });
      floorArray = [];
      floorCountArray = [];
      unitsArray = [];
      buildingvalue = App.defaults['building'];
      if (App.defaults['building'] === "All") {
        buildings = App.currentStore.building;
        buildings.each(function(item) {
          var unitsColl;
          unitsColl = App.master.unit.where({
            building: item.get('id')
          });
          return unitsArray.push({
            id: item.get('id'),
            count: unitsColl.length
          });
        });
        buildingvalue = _.max(unitsArray, function(model) {
          return model.count;
        });
        buildingvalue = buildingvalue.id;
      }
      units1 = new Backbone.Collection(floorUnitsArray);
      unitsCollection = units1.where({
        building: parseInt(buildingvalue)
      });
      $.each(unitsCollection, function(index, value) {
        if (floorArray.indexOf(value.get('floor')) === -1) {
          floorArray.push(value.get('floor'));
          return floorCountArray.push({
            id: value.get('floor')
          });
        }
      });
      floorArray = floorArray.sort();
      floorArray.sort(function(a, b) {
        return b - a;
      });
      floorCountArray.sort(function(a, b) {
        return b.id - a.id;
      });
      trackposition = [];
      unitArray = [];
      unitColl = new Backbone.Collection(unitsCollection);
      unitAssigned = unitColl.pluck("unitAssigned");
      uniqunitAssignedval = _.uniq(unitAssigned);
      uniqunitAssigned = _.without(uniqunitAssignedval, 0);
      uniqunitAssigned.sort(function(a, b) {
        return a - b;
      });
      $.each(uniqunitAssigned, function(index, value) {
        var disabled, floorColl, maxcount, maxunits, unitAssgendModels, unitAssgendModelsColl;
        floorColl = new Backbone.Collection(floorUnitsArray);
        if (App.defaults['building'] === "All") {
          unitAssgendModels = floorColl.where({
            unitAssigned: value,
            building: buildingvalue
          });
        } else {
          unitAssgendModels = floorColl.where({
            unitAssigned: value
          });
        }
        $.each(unitAssgendModels, function(index, value) {
          var unitType, unitVariant;
          unitType = App.master.unit_type.findWhere({
            id: value.get('unitType')
          });
          if (value.get('unitType') === 16) {
            value.set("unittypename", "Not Released");
            value.set("sellablearea", "");
            return value.set("sqft", "");
          } else if (value.get('unitType') === 14) {
            value.set("unittypename", unitType.get("name"));
            value.set("sellablearea", "");
            return value.set("sqft", "");
          } else {
            value.set("unittypename", unitType.get("name"));
            unitVariant = App.master.unit_variant.findWhere({
              id: value.get('unitVariant')
            });
            value.set("sellablearea", unitVariant.get("sellablearea"));
            return value.set("sqft", unitVariant.get("Sq.ft."));
          }
        });
        unitAssgendModels = _.uniq(unitAssgendModels);
        unitAssgendModels.sort(function(a, b) {
          return b.get('floor') - a.get('floor');
        });
        maxcount = [];
        maxunits = [];
        track = 0;
        $.each(unitAssgendModels, function(index, value1) {
          flag = 0;
          $.each(myArray, function(index, value) {
            var budget_arr, budget_price, buildingModel, element, floorRise, floorRiseValue, initvariant, paramKey, temp, tempnew, tempstring, unitPrice, unitVariantmodel, _i, _len, _results;
            paramKey = {};
            paramKey[value.key] = value.value;
            if (value.key === 'budget') {
              buildingModel = App.master.building.findWhere({
                'id': value1.get('building')
              });
              floorRise = buildingModel.get('floorrise');
              floorRiseValue = floorRise[value1.get('floor')];
              unitVariantmodel = App.master.unit_variant.findWhere({
                'id': value1.get('unitVariant')
              });
              unitPrice = value1.get('unitPrice');
              budget_arr = value.value.split(' ');
              budget_price = budget_arr[0].split('-');
              budget_price[0] = budget_price[0] + '00000';
              budget_price[1] = budget_price[1] + '00000';
              if (parseInt(unitPrice) >= parseInt(budget_price[0]) && parseInt(unitPrice) <= parseInt(budget_price[1])) {
                return flag++;
              }
            } else if (value.key !== 'floor') {
              tempnew = [];
              if (value.key === 'view' || value.key === 'apartment_views') {
                tempnew = [];
                value.key = 'apartment_views';
                tempnew = value1.get(value.key);
                if (tempnew !== "") {
                  tempnew = tempnew.map(function(item) {
                    return parseInt(item);
                  });
                }
              } else if (value.key === 'facing') {
                tempnew = [];
                tempnew = value1.get(value.key);
                if (tempnew.length !== 0) {
                  tempnew = tempnew.map(function(item) {
                    return parseInt(item);
                  });
                }
              }
              temp = [];
              temp.push(value.value);
              tempstring = temp.join(',');
              initvariant = tempstring.split(',').map(function(item) {
                return parseInt(item);
              });
              if (initvariant.length >= 1) {
                _results = [];
                for (_i = 0, _len = initvariant.length; _i < _len; _i++) {
                  element = initvariant[_i];
                  if (value1.get(value.key) === parseInt(element)) {
                    _results.push(flag++);
                  } else if ($.inArray(parseInt(element), tempnew) >= 0) {
                    _results.push(flag++);
                  } else {
                    _results.push(void 0);
                  }
                }
                return _results;
              } else {
                if (value1.get(value.key) === parseInt(value.value)) {
                  return flag++;
                }
              }
            }
          });
          if (flag >= myArray.length - 1) {
            track = 1;
          }
          if (myArray.length === 0) {
            track = 1;
          }
          if (parseInt(value1.get('status')) === parseInt(status.get('id')) || parseInt(value1.get('status')) === parseInt(status_onhold.get('id')) && value1.get('unitType') !== 14 && value1.get('unitType') !== 16) {
            return maxunits = App.currentStore.unit.where({
              unitAssigned: value
            });
          }
        });
        disabled = disabled;
        unitAssgendModelsColl = new Backbone.Collection(unitAssgendModels);
        if (maxunits.length === 0) {
          trackposition.push(value);
        }
        return unitArray.push({
          id: value,
          units: unitAssgendModelsColl,
          count: maxunits.length,
          disabled: disabled
        });
      });
      unitArray.sort(function(a, b) {
        return a.id - b.id;
      });
      maxvalue = _.max(unitArray, function(model) {
        return model.count;
      });
      newunitCollection = new Backbone.Collection(unitArray);
      buildingModel = App.master.building.where({
        id: parseInt(buildingvalue)
      });
      buildingCollection = new Backbone.Collection(buildingModel);
      mainnewarr = "";
      return [buildingCollection, newunitCollection, templateString, Countunits.length, templateString, mainnewarr, range, unitVariantModels, unitVariantID, maxvalue, viewModels, facingModels, viewID, facingID, terraceModels, terraceID, trackposition];
    };

    ScreenThreeController.prototype.mainUnitSelected = function(childview, childview1, unit, unittypeid, range, size) {
      return App.navigate("#screen-four/unit/" + unit + "/unittype/" + unittypeid + "/range/" + range + "/size/" + size, {
        trigger: true
      });
    };

    return ScreenThreeController;

  })(Extm.RegionController);
  return msgbus.registerController('screen:three', ScreenThreeController);
});
