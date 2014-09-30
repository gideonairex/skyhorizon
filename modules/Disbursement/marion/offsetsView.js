define ( function ( require ) {
	'use strict';

	var Marionette = require( 'marionette' );
	var offsetView = require( 'modules/Disbursement/marion/offsetView' );
	var template   = require( 'text!modules/Disbursement/marion/templates/offsetsView.html' );
	var _          = require( 'underscore' );

	return Marionette.CompositeView.extend( {
		template : _.template( template ),
		itemView : offsetView,
		className : 'row',
		itemViewContainer : 'table.offsets'
	} );

} );
