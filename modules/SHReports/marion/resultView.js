define( function( require ) {
	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	var sales = require('text!modules/SHReports/marion/templates/resultView.html');
	var ar = require('text!modules/SHReports/marion/templates/arResultView.html');
	var expenses = require('text!modules/SHReports/marion/templates/expensesResultView.html');
	var purchases = require('text!modules/SHReports/marion/templates/purchasesResultView.html');
	var ap = require('text!modules/SHReports/marion/templates/apResultView.html');
	var outstanding = require('text!modules/SHReports/marion/templates/outstandingResultView.html');
	var collection = require('text!modules/SHReports/marion/templates/collectionResultView.html');
	var disbursement = require('text!modules/SHReports/marion/templates/disbursementResultView.html');
	var arntr = require('text!modules/SHReports/marion/templates/arntrResultView.html');

	return Marionette.ItemView.extend( {
		templatear          : _.template( ar ),
		templateoutstanding : _.template( outstanding ),
		templateexpenses    : _.template( expenses ),
		templatepurchases    : _.template( purchases ),
		templatesales       : _.template( sales ),
		templateap          : _.template( ap ),
		templatecollection  : _.template( collection ),
		templatedisbursement  : _.template( disbursement ),
		templatearntr  : _.template( arntr ),
		tagName             : 'tr',
		onBeforeRender : function () {
			this.template = this[ "template"+this.options.report ];
		}
	} );
} );