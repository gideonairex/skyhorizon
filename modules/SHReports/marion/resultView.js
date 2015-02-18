define( function( require ) {

	var App = require ( 'reports' );
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
		ui : function() {

			if( this.options.report === 'ar' ) {
				return {
					'tRemarks' : '[name="remarks"]',
					'editview' : '.editview',
					'remarks'  : '.remarks',
					'remarksDetails': '.remarks-details',
					'cancel'   : '.cancel',
					'save'   : '.save'
				};
			}

		},
		events : function() {

			if( this.options.report === 'ar' ) {
				return {
					'click @ui.remarks'  : 'showEditView',
					'click @ui.cancel'   : 'cancel',
					'click @ui.save'   : 'save'
				};
			}

		},
		cancel : function( e ) {
			e.preventDefault();
			this.ui.editview.css( "display", "none" );
			this.ui.remarks.css( "display", "block" );
		},
		save : function( e ) {
			e.preventDefault();
			this.tempRemarks = this.model.attributes.remarks;
			this.model.attributes.remarks = this.ui.tRemarks.val();
			App.trigger( 'save:ar', this.model.attributes, function( result ) {

				if( !result ) {
					alert( 'Error in connection' );
					this.model.attributes.remarks = this.tempRemarks;
				} else {
					this.ui.remarksDetails.text( this.ui.tRemarks.val() );
				}
				this.ui.editview.css( "display", "none" );
				this.ui.remarks.css( "display", "block" );

			}.bind( this ) );

		},
		showEditView : function ( e ) {
			e.preventDefault();
			this.ui.editview.css( "display", "block" );
			this.ui.remarks.css( "display", "none" );
		},
		onBeforeRender : function () {
			this.template = this[ "template"+this.options.report ];
		}
	} );
} );