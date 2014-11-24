define( function( require ) {

	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	require( 'amcharts.pie' );
	var resultView = require( 'modules/SHReports/marion/resultView' );
	var sales = require('text!modules/SHReports/marion/templates/resultsView.html');
	var ar = require('text!modules/SHReports/marion/templates/arView.html');
	var expenses = require('text!modules/SHReports/marion/templates/expensesView.html');
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
			$('.chart').css('height','0px');
			$('.arCharts').css('height','0px');
			$('.apChart').css('height','0px');
			$('.expensesChart').css('height','0px');
			$('.chartHeader').css('display','none');
			$('.arHeader').css('display','none');
			$('.apHeader').css('display','none');
			$('.expensesHeader').css('display','none');
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
			$('.expensesChart').css('height','400px');

			var data3 = [];
			var data4 = [];
			var i = 0;
			for (key in this.resultsByPOExpenses['po']) {
				var temp = {};
				temp.category = this.resultsByPOExpenses['po'][key]['supplier_name'];
				temp.value = this.resultsByPOExpenses['po'][key]['balance'];
				data3[i] = temp;
				i++;
			}
			var chart9 = AmCharts.makeChart('chartdiv9',{
				"type"		: "pie",
				"titleField"	: "category",
				"valueField"	: "value",
				"angle"			: 30,
				"outlineThickness" : 2,
				"depth3D"		: 15,
				"dataProvider"	: data3
			});
			var i = 0;
			for (key in this.resultsByPOExpenses['expense']) {
				var temp = {};
				temp.category = this.resultsByPOExpenses['expense'][key]['supplier_name'];
				temp.value = this.resultsByPOExpenses['expense'][key]['balance'];
				data4[i] = temp;
				i++;
			}
			var chart10 = AmCharts.makeChart('chartdiv10',{
				"type"		: "pie",
				"titleField"	: "category",
				"valueField"	: "value",
				"angle"			: 30,
				"outlineThickness" : 2,
				"depth3D"		: 15,
				"dataProvider"	: data4
			});
			$(".expensesHeader").css('display','block');
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