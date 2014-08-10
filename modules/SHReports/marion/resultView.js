define( function( require ) {
	
	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	
	var sales = require('text!modules/SHReports/marion/templates/resultView.html');
	var ar = require('text!modules/SHReports/marion/templates/arResultView.html');
	var expenses = require('text!modules/SHReports/marion/templates/expensesResultView.html');
	var ap = require('text!modules/SHReports/marion/templates/apResultView.html');
	
	return Marionette.ItemView.extend( {
		
		templatear : _.template( ar ) ,
		templateexpenses: _.template( expenses ),
		templatesales: _.template( sales ),
		templateap: _.template( ap ),
		tagName : 'tr',
		onBeforeRender : function () {
			this.template = this[ "template"+this.options.report ];	
		}
		
	} );
	
	
} );