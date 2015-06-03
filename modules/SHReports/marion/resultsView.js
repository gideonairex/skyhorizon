define( function( require ) {

	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	require( 'amcharts.pie' );
	// require( 'amcharts.funnel' );
	var resultView = require( 'modules/SHReports/marion/resultView' );
	var sales = require('text!modules/SHReports/marion/templates/resultsView.html');
	var ar = require('text!modules/SHReports/marion/templates/arView.html');
	var expenses = require('text!modules/SHReports/marion/templates/expensesView.html');
	var purchases = require('text!modules/SHReports/marion/templates/purchasesView.html');
	var ap = require('text!modules/SHReports/marion/templates/apView.html');
	var outstanding = require('text!modules/SHReports/marion/templates/outstandingView.html');
	var collection = require('text!modules/SHReports/marion/templates/collectionView.html');
	var disbursement = require('text!modules/SHReports/marion/templates/disbursementView.html');
	var arntr = require('text!modules/SHReports/marion/templates/arntrView.html');
	var model = Backbone.Model.extend({});

	return Marionette.CompositeView.extend( {
		itemView            : resultView,
		itemViewContainer   : 'table.results',
		templatear          : _.template( ar ) ,
		templateoutstanding : _.template( outstanding ),
		templateexpenses    : _.template( expenses ),
		templatepurchases    : _.template( purchases ),
		templatesales       : _.template( sales ),
		templateap          : _.template( ap ),
		templatecollection  : _.template( collection ),
		templatedisbursement  : _.template( disbursement ),
		templatearntr       : _.template( arntr ),
		model              : new model(),
		params : {
				'sales' : [
					'quantity',
					'fee',
					'mark_up',
					'service_fee',
					'vat',
					'vatable_sale',
					'grand_total',
					'profit',
					'balance'
				],
				'expenses' : [
					'payable',
					'payment',
					'ewt',
					'balance'
				],
				'purchases' : [
					'no_of_pax',
					'cost',
					'service_fee',
					'grand_total'
				]
		},
		itemViewOptions : function(){
			return {
				'report' : this.options.report
			}
		},
		onRender : function(){
			this.clearCharts();
			this['generate' + this.options.report]();
		},
		clearCharts : function () {
			$('.chart').html('');
			$('.arCharts').html('');
			$('.apCharts').html('');
			$('.expensesChart').html('');
			$('.expensesCharta').html('');
			$('.purchasesChart').html('');
			$('.purchasesCharta').html('');
			$('.chart').css('height','0px');
			$('.arCharts').css('height','0px');
			$('.apChart').css('height','0px');
			$('.purchasesChart').css('height','0px');
			$('.purchasesCharta').css('height','0px');
			$('.expensesChart').css('height','0px');
			$('.expensesCharta').css('height','0px');
			$('.chartHeader').css('display','none');
			$('.arHeader').css('display','none');
			$('.apHeader').css('display','none');
			$('.expensesHeader').css('display','none');
			$('.purchasesHeader').css('display','none');
		},
		generatesales : function(){
			$('.chart').css('height','400px');
			$('.arCharts').css('height','0px');
			var data = [];
			var data2 = [];
			var i = 0;
			for (key in this.resultsGroupByAccounts) {
				var temp = {};
				temp.category = this.resultsGroupByAccounts[key]['account_name'];
				temp.value = this.resultsGroupByAccounts[key]['grand_total'];
				temp.value2 = this.resultsGroupByAccounts[key]['profit'];
				data[i] = temp;
				i++;
			}

			var chart = AmCharts.makeChart('chartdiv',{
				"type"		: "pie",
				"titleField"	: "category",
				"valueField"	: "value",
				"angle"			: 30,
				"outlineThickness" : 2,
				"depth3D"		: 15,
				"dataProvider"	: data
			});
			var chart2 = AmCharts.makeChart('chartdiv2',{
				"type"		: "pie",
				"titleField"	: "category",
				"valueField"	: "value2",
				"angle"			: 30,
				"outlineThickness" : 2,
				"depth3D"		: 15,
				"dataProvider"	: data
			});
			i = 0;
			for (key in this.resultsGroupByUser) {
				var temp = {};
				temp.category = this.resultsGroupByUser[key]['user'];
				temp.value = this.resultsGroupByUser[key]['grand_total'];
				temp.value2 = this.resultsGroupByUser[key]['profit'];
				data2[i] = temp;
				i++;
			}
			var chart3 = AmCharts.makeChart('chartdiv3',{
				"type"		: "pie",
				"titleField"	: "category",
				"valueField"	: "value",
				"angle"			: 30,
				"outlineThickness" : 2,
				"depth3D"		: 15,
				"dataProvider"	: data2
			});
			var chart4 = AmCharts.makeChart('chartdiv4',{
				"type"		: "pie",
				"titleField"	: "category",
				"valueField"	: "value2",
				"angle"			: 30,
				"outlineThickness" : 2,
				"depth3D"		: 15,
				"dataProvider"	: data2
			});
			$(".chartHeader").css('display','block');
		},
		generatear : function () {
			$('.arCharts').css('height','400px');
			var data = [];
			var data2 = [];
			i = 0;
			for (key in this.resultsGroupByAccounts) {
				var temp = {};
				temp.category = this.resultsGroupByAccounts[key]['account_name'];
				temp.value = this.resultsGroupByAccounts[key]['balance'];
				data[i] = temp;
				i++;
			}
			i = 0;
			for (key in this.resultsGroupByStatus) {
				var temp = {};
				temp.category = this.resultsGroupByStatus[key]['ar_status'];
				temp.value = this.resultsGroupByStatus[key]['balance'];
				data2[i] = temp;
				i++;
			}
			var chart5 = AmCharts.makeChart('chartdiv5',{
				"type"		: "pie",
				"titleField"	: "category",
				"valueField"	: "value",
				"angle"			: 30,
				"outlineThickness" : 2,
				"depth3D"		: 15,
				"dataProvider"	: data
			});
			var chart6 = AmCharts.makeChart('chartdiv6',{
				"type"		: "pie",
				"titleField"	: "category",
				"valueField"	: "value",
				"angle"			: 30,
				"outlineThickness" : 2,
				"depth3D"		: 15,
				"dataProvider"	: data2
			});
			$('.arHeader').css('display','block');
		},
		generateoutstanding : function () {
			$('.arCharts').css('height','400px');
			var data = [];
			var data2 = [];
			i = 0;
			for (key in this.resultsGroupByAccounts) {
				var temp = {};
				temp.category = this.resultsGroupByAccounts[key]['account_name'];
				temp.value = this.resultsGroupByAccounts[key]['balance'];
				data[i] = temp;
				i++;
			}
			i = 0;
			for (key in this.resultsGroupByStatus) {
				var temp = {};
				temp.category = this.resultsGroupByStatus[key]['ar_status'];
				temp.value = this.resultsGroupByStatus[key]['balance'];
				data2[i] = temp;
				i++;
			}
			var chart5 = AmCharts.makeChart('chartdiv5',{
				"type"		: "pie",
				"titleField"	: "category",
				"valueField"	: "value",
				"angle"			: 30,
				"outlineThickness" : 2,
				"depth3D"		: 15,
				"dataProvider"	: data
			});
			var chart6 = AmCharts.makeChart('chartdiv6',{
				"type"		: "pie",
				"titleField"	: "category",
				"valueField"	: "value",
				"angle"			: 30,
				"outlineThickness" : 2,
				"depth3D"		: 15,
				"dataProvider"	: data2
			});
			$('.arHeader').css('display','block');
		},
		generateexpenses : function () {
			$('.expensesChart').css('height','1500px');
			$('.expensesCharta').css('height','600px');

			var data4 = [];
			var data5 = [];

			var i = 0;
			for (key in this.resultsByPOExpenses['expense']) {
				var temp = {};
				temp.category = this.resultsByPOExpenses['expense'][key]['supplier_name'];
				temp.value = this.resultsByPOExpenses['expense'][key]['payable'];
				data4[i] = temp;
				i++;
			}

			i = 0;
			_.each( this.resultsGroupByNTP, function( value, key ) {
				var temp = {};
				temp.category = key;
				temp.value = value.payable;
				data5[i]=temp;
				i++;
			} );

			var sortedData4 = _.sortBy( data4, "value" );
			var sortedData5 = _.sortBy( data5, "value" );

			// Chart 1
			var legend = new AmCharts.AmLegend();
			legend.align = "center";
			legend.markType = "circle";
			legend.valueText = "[[percents]]%";

			var chart10 = new AmCharts.AmPieChart();
			chart10.dataProvider = sortedData4;
			chart10.titleField = "category";
			chart10.valueField = "value";
			chart10.angle = 30;
			chart10.outlineThickness = 2;
			chart10.depth3D = 15;
			chart10.balloonText = "[[title]]<br><span style='font-size : 14px'><b>[[value]]</b> ([[percents]]%)</span>";

			chart10.addLegend( legend );
			chart10.write( 'chartdiv10' );

			// Chart 2
			var sortedData5 = _.sortBy( data5, "value" );

			var legenda = new AmCharts.AmLegend();
			legenda.align = "center";
			legenda.markType = "circle";
			legenda.valueText = "[[percents]]%";

			var chart10a = new AmCharts.AmPieChart();
			chart10a.dataProvider = sortedData5;
			chart10a.titleField = "category";
			chart10a.valueField = "value";
			chart10a.angle = 30;
			chart10a.outlineThickness = 2;
			chart10a.depth3D = 15;
			chart10a.balloonText = "[[title]]<br><span style='font-size : 14px'><b>[[value]]</b> ([[percents]]%)</span>";

			chart10a.addLegend( legenda );
			chart10a.write( 'chartdiv10a' );

			$(".expensesHeader").css('display','block');
		},
		generatepurchases : function () {
			$('.purchasesChart').css('height','1000px');
			$('.purchasesCharta').css('height','650px');

			var data3 = [];
			var data4 = [];
			var i = 0;

			for (key in this.resultsByPOExpenses['po']) {
				var temp = {};
				temp.category = this.resultsByPOExpenses['po'][key]['supplier_name'];
				temp.value = this.resultsByPOExpenses['po'][key]['grand_total'];
				data3[i] = temp;
				i++;
			}

			// Chart 1
			var sortedData3 = _.sortBy( data3, "value" );
			var legend = new AmCharts.AmLegend();
			legend.align = "center";
			legend.markType = "circle";
			legend.valueText = "[[percents]]%";

			var chart9 = new AmCharts.AmPieChart();
			chart9.dataProvider = sortedData3;
			chart9.titleField = "category";
			chart9.valueField = "value";
			chart9.angle = 30;
			chart9.outlineThickness = 2;
			chart9.depth3D = 15;
			chart9.balloonText = "[[title]]<br><span style='font-size : 14px'><b>[[value]]</b> ([[percents]]%)</span>";

			chart9.addLegend( legend );
			chart9.write( 'chartdiv9' );

			i = 0;
			_.each( this.resultsGroupByServiceTypes, function( value, key ) {
				var temp = {};
				temp.category = key;
				temp.value = value.grand_total;
				data4[i]=temp;
				i++;
			} );

			if ( Object.keys( this.resultsGroupByServiceTypes ) ) {
				var sortedData4 = _.sortBy( data4, "value" );
				// Chart 1
				var legend = new AmCharts.AmLegend();
				legend.align = "center";
				legend.markType = "circle";
				legend.valueText = "[[percents]]%";

				var chart9a = new AmCharts.AmPieChart();
				chart9a.dataProvider = sortedData4;
				chart9a.titleField = "category";
				chart9a.valueField = "value";
				chart9a.angle = 30;
				chart9a.outlineThickness = 2;
				chart9a.depth3D = 15;
				chart9a.balloonText = "[[title]]<br><span style='font-size : 14px'><b>[[value]]</b> ([[percents]]%)</span>";

				chart9a.addLegend( legend );
				chart9a.write( 'chartdiv9a' );
			}

			$(".purchasesHeader").css('display','block');
		},
		generateap : function() {
			$('.apChart').css('height','400px');
			var data = [];
			var data2 = [];
			var i = 0;
			for (key in this.resultsGroupBySupplier) {
				var temp = {};
				temp.category = this.resultsGroupBySupplier[key]['supplier_name'];
				temp.value = this.resultsGroupBySupplier[key]['balance'];
				data[i] = temp;
				i++;
			}

			var chart7 = AmCharts.makeChart('chartdiv7',{
				"type"		: "pie",
				"titleField"	: "category",
				"valueField"	: "value",
				"angle"			: 30,
				"outlineThickness" : 2,
				"depth3D"		: 15,
				"dataProvider"	: data
			});
			var i = 0;
			for (key in this.resultsGroupByStatus) {
				var temp = {};
				temp.category = this.resultsGroupByStatus[key]['ap_status'];
				temp.value = this.resultsGroupByStatus[key]['balance'];
				data2[i] = temp;
				i++;
			}
			var chart8 = AmCharts.makeChart('chartdiv8',{
				"type"		: "pie",
				"titleField"	: "category",
				"valueField"	: "value",
				"angle"			: 30,
				"outlineThickness" : 2,
				"depth3D"		: 15,
				"dataProvider"	: data2
			});
			$(".apHeader").css('display','block');
		},
		generatecollection : function () {
		},
		generatedisbursement : function () {
		},
		generatearntr : function () {
		},
		onBeforeRender : function () {
			this.template = this[ "template"+this.options.report ];
			this.paramVar = 'sales';
			if( this.options.report === "expenses" || this.options.report === "ap")
				this.paramVar = 'expenses';
			this['beforeRender'+this.options.report]();
		},
		beforeRenderar : function ( ) {
			var paramVar = this.paramVar;
			if ( this.collection ) {
				var results = {};
				var resultsGroupByAccounts = [];
				var resultsGroupByStatus = [];
				var i = 0;
				var j = 0;
				var temp =0;
				var account_name ='';
				var ar_status = '';
				var balance = 0;
				for ( i = 0 ; i < this.collection.models.length; i++) {
					balance = 0;
					profit = 0;
					account_name = this.collection.models[i].get('account_name');
					ar_status = this.collection.models[i].get('ar_status');
					for ( j =0 ; j < this.params[paramVar].length; j ++ ) {
						if( !results[this.params[paramVar][j]] )
							results[this.params[paramVar][j]] = 0;

						temp = this.collection.models[i].get(this.params[paramVar][j]);
						if( temp ) {
							temp = temp.toString().split(',').join('');
						} else {
							temp = 0;
						}
						temp = parseFloat( temp );
						results[this.params[paramVar][j]] += temp;
						if ( this.params[paramVar][j] === "balance")
							balance = temp;
					}
					if(	!resultsGroupByAccounts[account_name] ) {
						resultsGroupByAccounts[account_name] = {};
						resultsGroupByAccounts[account_name]['account_name'] = account_name;
						resultsGroupByAccounts[account_name]['balance'] = 0;
					}
					if(	!resultsGroupByStatus[ar_status] ) {
						resultsGroupByStatus[ar_status] = {};
						resultsGroupByStatus[ar_status]['ar_status'] = ar_status;
						resultsGroupByStatus[ar_status]['balance'] = 0;
					}
					resultsGroupByAccounts[account_name]['balance'] += balance;
					resultsGroupByStatus[ar_status]['balance'] += balance;
				}
				this.resultsGroupByAccounts = resultsGroupByAccounts;
				this.resultsGroupByStatus = resultsGroupByStatus;
				for ( j =0 ; j < this.params[paramVar].length; j ++ ) {
					temp = parseFloat( results[this.params[paramVar][j]] ).toFixed(2);
					this.model.set( this.params[paramVar][j] , temp );
				}
			}
		},
		beforeRenderoutstanding : function ( ) {
			var paramVar = this.paramVar;
			if ( this.collection ) {
				var results = {};
				var resultsGroupByAccounts = [];
				var resultsGroupByStatus = [];
				var i = 0;
				var j = 0;
				var temp =0;
				var account_name ='';
				var ar_status = '';
				var balance = 0;
				for ( i = 0 ; i < this.collection.models.length; i++) {
					balance = 0;
					profit = 0;
					account_name = this.collection.models[i].get('account_name');
					ar_status = this.collection.models[i].get('ar_status');
					for ( j =0 ; j < this.params[paramVar].length; j ++ ) {
						if( !results[this.params[paramVar][j]] )
							results[this.params[paramVar][j]] = 0;

						temp = parseFloat( this.collection.models[i].get(this.params[paramVar][j]) );
						results[this.params[paramVar][j]] += temp;
						if ( this.params[paramVar][j] === "balance")
							balance = temp;
					}
					if(	!resultsGroupByAccounts[account_name] ) {
						resultsGroupByAccounts[account_name] = {};
						resultsGroupByAccounts[account_name]['account_name'] = account_name;
						resultsGroupByAccounts[account_name]['balance'] = 0;
					}
					if(	!resultsGroupByStatus[ar_status] ) {
						resultsGroupByStatus[ar_status] = {};
						resultsGroupByStatus[ar_status]['ar_status'] = ar_status;
						resultsGroupByStatus[ar_status]['balance'] = 0;
					}
					resultsGroupByAccounts[account_name]['balance'] += balance;
					resultsGroupByStatus[ar_status]['balance'] += balance;
				}
				this.resultsGroupByAccounts = resultsGroupByAccounts;
				this.resultsGroupByStatus = resultsGroupByStatus;
				for ( j =0 ; j < this.params[paramVar].length; j ++ ) {
					this.model.set( this.params[paramVar][j] , results[this.params[paramVar][j]] );
				}
			}
		},
		beforeRendersales : function(){
			var paramVar = this.paramVar;
			if ( this.collection ) {
				var results = {};
				var resultsGroupByAccounts = [];
				var resultsGroupByUser = [];
				var i = 0;
				var j = 0;
				var temp =0;
				var account_name ='';
				var user = '';
				var grand_total = 0;
				var profit = 0;
				for ( i = 0 ; i < this.collection.models.length; i++) {
					grand_total = 0;
					profit = 0;
					account_name = this.collection.models[i].get('account_name');
					user = this.collection.models[i].get('user');
					for ( j =0 ; j < this.params[paramVar].length; j ++ ) {
						if( !results[this.params[paramVar][j]] )
							results[this.params[paramVar][j]] = 0;

						temp = this.collection.models[i].get(this.params[paramVar][j]);
						if( temp ) {
							temp = temp.toString().split(',').join('');
						} else {
							temp = 0;
						}
						temp = parseFloat( temp );
						results[this.params[paramVar][j]] += temp;
						if ( this.params[paramVar][j] === "grand_total")
							grand_total = temp;
						if ( this.params[paramVar][j] === "profit")
							profit = temp;
					}
					if(	!resultsGroupByAccounts[account_name] ) {
						resultsGroupByAccounts[account_name] = {};
						resultsGroupByAccounts[account_name]['account_name'] = account_name;
						resultsGroupByAccounts[account_name]['grand_total'] = 0;
						resultsGroupByAccounts[account_name]['profit'] = 0;
					}
					if(	!resultsGroupByUser[user] ) {
						resultsGroupByUser[user] = {};
						resultsGroupByUser[user]['user'] = user;
						resultsGroupByUser[user]['grand_total'] = 0;
						resultsGroupByUser[user]['profit'] = 0;
					}
					resultsGroupByAccounts[account_name]['grand_total'] += grand_total;
					resultsGroupByAccounts[account_name]['profit'] += profit;
					resultsGroupByUser[user]['grand_total'] += grand_total;
					resultsGroupByUser[user]['profit'] += profit;
			}

				this.resultsGroupByAccounts = resultsGroupByAccounts;
				this.resultsGroupByUser = resultsGroupByUser;

				for ( j =0 ; j < this.params[paramVar].length; j ++ ) {
					temp = parseFloat( results[this.params[paramVar][j]] ).toFixed(2);
					this.model.set( this.params[paramVar][j] , temp );
				}

			}
		},
		beforeRenderexpenses : function(){
			var paramVar = this.paramVar;
			if ( this.collection ) {
				var results = {};
				var i = 0;
				var j = 0;
				var temp =0;
				var ap_status = '';
				var payable = 0;
				var resultsGroupByStatus = [];
				var resultsGroupBySupplier = [];
				var resultsGroupByNTP = {};

				var resultsByPOExpenses = [];
				for ( i = 0 ; i < this.collection.models.length; i++) {

					ap_status = this.collection.models[i].get('ap_status');
					supplier_name = this.collection.models[i].get('supplier_name');
					purchase_type = this.collection.models[i].get('purchase_type');
					expense_type = this.collection.models[i].get('expense_type');

					for ( j =0 ; j < this.params[paramVar].length; j ++ ) {
						if( !results[this.params[paramVar][j]] )
							results[this.params[paramVar][j]] = 0;

						temp = parseFloat( this.collection.models[i].get(this.params[paramVar][j]) );
						results[this.params[paramVar][j]] += temp
						if ( this.params[paramVar][j] === "payable")
							payable = temp;
					}

					// Checks the key
					if(	!resultsGroupBySupplier[supplier_name] ) {
						resultsGroupBySupplier[supplier_name] = {};
						resultsGroupBySupplier[supplier_name]['supplier_name'] = supplier_name;
						resultsGroupBySupplier[supplier_name]['payable'] = 0;
					}
					if(	!resultsGroupByStatus[ap_status] ) {
						resultsGroupByStatus[ap_status] = {};
						resultsGroupByStatus[ap_status]['ap_status'] = ap_status;
						resultsGroupByStatus[ap_status]['payable'] = 0;
					}
					if ( !resultsByPOExpenses[purchase_type] ) {
						resultsByPOExpenses[purchase_type] = {};
					}
					if(	!resultsByPOExpenses[purchase_type][supplier_name] ) {
						resultsByPOExpenses[purchase_type][supplier_name] = {};
						resultsByPOExpenses[purchase_type][supplier_name]['supplier_name'] = supplier_name;
						resultsByPOExpenses[purchase_type][supplier_name]['payable'] = 0;
					}

					if( !resultsGroupByNTP[ expense_type ] ) {
						resultsGroupByNTP[ expense_type ] = {};
						resultsGroupByNTP[ expense_type ].payable = 0;
					}
					// Checks the key

					resultsGroupBySupplier[supplier_name]['payable'] += payable;
					resultsGroupByStatus[ap_status]['payable'] += payable;
					resultsByPOExpenses[purchase_type][supplier_name]['payable'] += payable;
					resultsGroupByNTP[ expense_type ].payable += payable;
				}

				this.resultsGroupBySupplier = resultsGroupBySupplier;
				this.resultsGroupByStatus = resultsGroupByStatus;
				this.resultsByPOExpenses = resultsByPOExpenses;
				this.resultsGroupByNTP = resultsGroupByNTP;

				for ( j =0 ; j < this.params[paramVar].length; j ++ ) {
					this.model.set( this.params[paramVar][j] , results[this.params[paramVar][j]] );
				}
			}
		},

		beforeRenderpurchases : function(){
			var paramVar = 'purchases';
			if ( this.collection ) {
				var results = {};
				var i = 0;
				var j = 0;
				var temp =0;
				var po_status = '';
				var resultsGroupByStatus = [];
				var resultsGroupBySupplier = [];
				var resultsGroupByServiceTypes = {};

				var resultsByPOExpenses = [];
				for ( i = 0 ; i < this.collection.models.length; i++) {
					po_status = this.collection.models[i].get('po_status');
					supplier_name = this.collection.models[i].get('supplier_name');
					purchase_type = this.collection.models[i].get('purchase_type');
					servicetype = this.collection.models[i].get('servicetype');
					grand_total_single = parseFloat( this.collection.models[i].get('grand_total') );

					for ( j =0 ; j < this.params[paramVar].length; j ++ ) {
						if( !results[this.params[paramVar][j]] ) {
							results[this.params[paramVar][j]] = 0;
						}

						temp = parseFloat( this.collection.models[i].get(this.params[paramVar][j]) );
						results[this.params[paramVar][j]] += temp;
						if( this.params[ paramVar ][ j ] === 'grand_total' ) {
							grand_total = temp;
						}
					}

					// This is just for creating the objects
					if(	!resultsGroupBySupplier[supplier_name] ) {
						resultsGroupBySupplier[supplier_name] = {};
						resultsGroupBySupplier[supplier_name]['supplier_name'] = supplier_name;
					}

					if(	!resultsGroupByStatus[po_status] ) {
						resultsGroupByStatus[po_status] = {};
						resultsGroupByStatus[po_status]['po_status'] = po_status;
					}

					if ( !resultsByPOExpenses[purchase_type] ) {
						resultsByPOExpenses[purchase_type] = {};
					}

					if(	!resultsByPOExpenses[purchase_type][supplier_name] ) {
						resultsByPOExpenses[purchase_type][supplier_name] = {};
						resultsByPOExpenses[purchase_type][supplier_name]['supplier_name'] = supplier_name;
						resultsByPOExpenses[purchase_type][supplier_name]['grand_total'] = 0;
					}

					if( !resultsGroupByServiceTypes[servicetype] ) {
						resultsGroupByServiceTypes[servicetype] = {};
						resultsGroupByServiceTypes[servicetype].grand_total = 0;
					}
					// This if for just creating the objects

					resultsByPOExpenses[purchase_type][supplier_name]['grand_total'] += grand_total;
					resultsGroupByServiceTypes[servicetype].grand_total += grand_total_single;
				}

				this.resultsGroupBySupplier = resultsGroupBySupplier;
				this.resultsGroupByStatus = resultsGroupByStatus;
				this.resultsByPOExpenses = resultsByPOExpenses;
				this.resultsGroupByServiceTypes = resultsGroupByServiceTypes;

				for ( j =0 ; j < this.params[paramVar].length; j ++ ) {
					this.model.set( this.params[paramVar][j] , results[this.params[paramVar][j]] );
				}
			}
		},
		beforeRenderap : function () {
			var paramVar = this.paramVar;
			if ( this.collection ) {
				var results = {};
				var i = 0;
				var j = 0;
				var temp =0;
				var ap_status = '';
				var balance = 0;
				var resultsGroupByStatus = [];
				var resultsGroupBySupplier = [];
				var resultsByPOExpenses = [];
				for ( i = 0 ; i < this.collection.models.length; i++) {
					ap_status = this.collection.models[i].get('ap_status');
					supplier_name = this.collection.models[i].get('supplier_name');
					purchase_type = this.collection.models[i].get('purchase_type');
					for ( j =0 ; j < this.params[paramVar].length; j ++ ) {
						if( !results[this.params[paramVar][j]] )
							results[this.params[paramVar][j]] = 0;

						temp = parseFloat( this.collection.models[i].get(this.params[paramVar][j]) );
						results[this.params[paramVar][j]] += temp
						if ( this.params[paramVar][j] === "balance")
							balance = temp;
					}
					if(	!resultsGroupBySupplier[supplier_name] ) {
						resultsGroupBySupplier[supplier_name] = {};
						resultsGroupBySupplier[supplier_name]['supplier_name'] = supplier_name;
						resultsGroupBySupplier[supplier_name]['balance'] = 0;
					}
					if(	!resultsGroupByStatus[ap_status] ) {
						resultsGroupByStatus[ap_status] = {};
						resultsGroupByStatus[ap_status]['ap_status'] = ap_status;
						resultsGroupByStatus[ap_status]['balance'] = 0;
					}

					if ( !resultsByPOExpenses[purchase_type] ) {
						resultsByPOExpenses[purchase_type] = {};
					}
					if(	!resultsByPOExpenses[purchase_type][supplier_name] ) {
						resultsByPOExpenses[purchase_type][supplier_name] = {};
						resultsByPOExpenses[purchase_type][supplier_name]['supplier_name'] = supplier_name;
						resultsByPOExpenses[purchase_type][supplier_name]['balance'] = 0;
					}

					resultsGroupBySupplier[supplier_name]['balance'] += balance;
					resultsGroupByStatus[ap_status]['balance'] += balance;
					resultsByPOExpenses[purchase_type][supplier_name]['balance'] += balance;
				}
				this.resultsGroupBySupplier = resultsGroupBySupplier;
				this.resultsGroupByStatus = resultsGroupByStatus;
				this.resultsByPOExpenses = resultsByPOExpenses;
				for ( j =0 ; j < this.params[paramVar].length; j ++ ) {
					this.model.set( this.params[paramVar][j] , results[this.params[paramVar][j]] );
				}
			}
		},
		beforeRendercollection : function () {
			this.model.set( 'Check', null );
			this.model.set( 'Cash', null );
			this.model.set( 'Cash_on_hand', null );
			this.model.set( 'Cash_online', null );
			var self = this;
			var summary = this.collection.models[0].get( 'summary' );
			var gt = this.collection.models[0].get( 'summary' ).Summary;
			_.each( summary, function( obj ) {
				self.model.set( obj.c_payment_method, obj );
			} );
			self.model.set( 'GT', gt );
		},
		beforeRenderdisbursement : function () {
			this.model.set( 'Check', null );
			this.model.set( 'Cash', null );
			var self = this;
			var summary = this.collection.models[0].get( 'summary' );
			var gt = this.collection.models[0].get( 'summary' ).Summary;
			_.each( summary, function( obj ) {
				self.model.set( obj.d_payment_method, obj );
			} );
			self.model.set( 'GT', gt );
		},
		beforeRenderarntr : function () {

		}
	} );
} );