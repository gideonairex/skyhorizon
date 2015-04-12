define( function ( require ){

	var App = require ( 'collection' );
	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	var template = require( 'text!modules/Collection/marion/templates/resultsView.html' );
	var resultView  = require( 'modules/Collection/marion/resultView' );
	var resulsView = Marionette.CompositeView.extend({
		template : _.template( template ),
		itemView : resultView,
		itemViewContainer : 'table.results',
	});
	return resulsView;

})