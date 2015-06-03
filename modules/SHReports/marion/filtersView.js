define( function( require ) {
	'use strict';

	var App = require ( 'reports' );
	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	var template = require('text!modules/SHReports/marion/templates/filtersView.html');

	return Marionette.ItemView.extend( {
		template : _.template( template ),
		ui : {
			'date' : '.date',
			'report_name' : '.report_name',
			'report_type' : '.report_type',
			'accounts' : '.accounts',
			'suppliers' : '.suppliers',
			'users' : '.users',
			'form' : 'form',
			'print' : '.print',
			'excel' : '.excel',
			'ntptypes' : '.ntp-types',
			'servicetypes' : '.service-types',
			'purchasereporttype' : '[name="purchase_report_type"]',
			'expensesreporttype' : '[name="expenses_report_type"]',
			'salestemplate' : '[name="salestemplate"]',
			'artemplate' : '[name="artemplate"]',
			'purchasetemplate' : '[name="purchasetemplate"]',
			'reporttemplate' : '.reporttemplate'
		},
		events : {
			'submit form' : 'generateReport',
			'change @ui.report_name' : 'toggleAccountsSuppliers',
			'change @ui.purchasereporttype' : 'togglePurchaseType',
			'change @ui.expensesreporttype' : 'toggleExpenseType',
			'click @ui.print' : 'printReport',
			'click @ui.excel' : 'exportExcel'
		},
		toggleAccountsSuppliers : function () {
			var report = this.ui.report_name.val();
			this.ui.excel.css('display','none');

			if ( report === 'sales' || report === 'ar' ) {
				this.ui.users.css('display','block');
				this.ui.print.css('display','block');
				this.ui.accounts.css('display','block');
				this.ui.suppliers.css('display','none');
				this.ui.reporttemplate.css('display','block');
				// Export to excel
				this.ui.excel.css('display','block');
				if( report === 'sales' ) {
					this.ui.salestemplate.css('display','block');
					this.ui.artemplate.css('display','none');
				} else {
					this.ui.salestemplate.css('display','none');
					this.ui.artemplate.css('display','block');
				}

			} else if  ( report === 'collection' ){
				this.ui.accounts.css('display','none');
				this.ui.users.css('display','none');
				this.ui.suppliers.css('display','none');
				this.ui.print.css('display','block');
				this.ui.reporttemplate.css('display','none');
			} else {
				this.ui.users.css('display','block');
				this.ui.suppliers.css('display','block');
				this.ui.accounts.css('display','none');
				this.ui.print.css('display','none');
				this.ui.reporttemplate.css('display','none');
			}

			if( report === 'ap' || report === 'apntp' || report === 'purchases' ) {
				this.ui.print.css('display','block');
			}

			// Default
			this.ui.ntptypes.css('display','none');
			this.ui.servicetypes.css('display','none');

			if( report === 'purchases' || report === 'expenses' ) {
				this.ui.report_type.css('display','block');
				this.ui.excel.css('display','block');
				if( report === 'purchases' ) {
					this.ui.ntptypes.css('display','none');
					this.ui.servicetypes.css('display','block');
					this.ui.purchasereporttype.css( 'display', 'block' );
					this.ui.expensesreporttype.css( 'display', 'none' );
					this.togglePurchaseType();
				} else if( report ==='expenses' ) {
					this.ui.ntptypes.css('display','block');
					this.ui.servicetypes.css('display','none');
					this.ui.purchasereporttype.css( 'display', 'none' );
					this.ui.expensesreporttype.css( 'display', 'block' );
					this.toggleExpenseType();
				}
			} else {
				this.ui.report_type.css('display','none');
			}

		},
		togglePurchaseType : function ( e ) {
			var type = this.ui.purchasereporttype.val();

			if( type === 'supplier' ) {
				this.ui.suppliers.css('display','block');
				this.ui.servicetypes.css('display','none');
			} else if( type ==='service_type' ) {
				this.ui.suppliers.css('display','none');
				this.ui.servicetypes.css('display','block');
			}

		},
		toggleExpenseType : function ( e ) {
			var type = this.ui.expensesreporttype.val();

			if( type === 'supplier' ) {
				this.ui.suppliers.css('display','block');
				this.ui.ntptypes.css('display','none');
			} else if( type ==='ntp_type' ) {
				this.ui.suppliers.css('display','none');
				this.ui.ntptypes.css('display','block');
			}

		},
		printReport : function ( e ) {
			e.preventDefault();
			var data = this.ui.form.serialize();
			window.open( 'index.php?module=SHReports&action=PrintTemplate&'+data,'_blank' );
		},
		exportExcel : function ( e ) {
			e.preventDefault();
			var data = this.ui.form.serialize();
			window.open( 'index.php?module=SHReports&action=exportExcel&'+data,'_blank' );
		},
		generateReport : function( e ) {
			e.preventDefault();
			var data = this.ui.form.serialize();
			var data2 = this.ui.form.serializeArray();
			var newData = {};
			_.each( data2, function ( element ) {
				var value = _.values(element);
				newData[ value[0] ] = value[1];
			} );
			App.trigger('generate:report',data,newData);
		},
		onRender : function () {
			this.ui.date.datepicker({
				'format' : 'yyyy-mm-dd',
				'multidate' : true
			});
			this.toggleAccountsSuppliers();
		}
	} );
} );