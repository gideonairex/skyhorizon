define ( function ( require ) {
	'use strict';

	var Marionette = require( 'marionette' );
	var template   = require( 'text!modules/Disbursement/marion/templates/offsetView.html' );
	var _          = require( 'underscore' );

	return Marionette.ItemView.extend( {
		template : _.template( template ),
		tagName : 'tr'
	} );

} );
