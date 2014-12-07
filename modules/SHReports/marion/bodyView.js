define( function( require ) {

	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	var template = require('text!modules/SHReports/marion/templates/bodyView.html');
	return Backbone.Marionette.Layout.extend( {
		template : _.template( template ),
		className : 'container-fluid',
		regions : {
			filters : '#filters',
			results : '#results'
		}
	} );

} )