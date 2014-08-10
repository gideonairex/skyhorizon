define( function ( require ){

	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	var template = require( 'text!modules/Disbursement/marion/templates/emptyResultView.html' );
	
	var emptyResultView = Marionette.ItemView.extend({
		template : _.template( template )
	});
	
	return emptyResultView;

})