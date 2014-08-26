define( function ( require ){

	var App = require ( 'disbursement' );
	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	var template = require( 'text!modules/Disbursement/marion/templates/resultsView.html' );
	var resultView  = require( 'modules/Disbursement/marion/resultView' );
	
	var resulsView = Marionette.CompositeView.extend({
		template : _.template( template ),
		itemView : resultView,
		itemViewContainer : 'table.results',
	});
	
	return resulsView;

})