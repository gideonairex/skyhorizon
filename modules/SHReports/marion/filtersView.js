define( function( require ) {
	var App = require ( 'reports' );
	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	var template = require('text!modules/SHReports/marion/templates/filtersView.html');
	var $ = require( 'jquery' );
	return Marionette.ItemView.extend( {
		template : _.template( template ),
		ui : {
			'date' : '.date',
			'report_name' : '.report_name',
			'accounts' : '.accounts',
			'suppliers' : '.suppliers',
			'users' : '.users',
			'form' : 'form',
			'print' : '.print'
		},
		events : {
			'submit form' : 'generateReport',
			'change @ui.report_name' : 'toggleAccountsSuppliers',
			'click @ui.print' : 'printReport'
		},
		toggleAccountsSuppliers : function () {
			var report = this.ui.report_name.val();
			if ( report === "sales" || report === "ar" ) {
				this.ui.users.css("display","block");
				this.ui.print.css("display","block");
				this.ui.accounts.css("display","block");
				this.ui.suppliers.css("display","none");
			} else if  ( report === "collection" ){
				this.ui.accounts.css("display","none");
				this.ui.users.css("display","none");
				this.ui.suppliers.css("display","none");
				this.ui.print.css("display","none");
			}else {
				this.ui.users.css("display","block");
				this.ui.suppliers.css("display","block");
				this.ui.accounts.css("display","none");
				this.ui.print.css("display","none");
			}
		},
		printReport : function ( e ) {
			e.preventDefault();
			var data = this.ui.form.serialize();
			window.open( 'index.php?module=SHReports&action=PrintTemplate&'+data,'_blank' );
		},
		generateReport : function( e ) {
			e.preventDefault();
			var data = this.ui.form.serialize();
			var data2 = this.ui.form.serializeArray();
			var newData = {}
			_.each( data2, function ( element ) {
				var value = _.values(element);
				newData[ value[0] ] = value[1];
			} )
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