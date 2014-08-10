define( function( require ){

	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	var template = require('text!modules/Disbursement/marion/templates/bodyView.html');

	BodyView = Backbone.Marionette.Layout.extend({
	  template: _.template( template ),
	  className: "container",
	  
	  
	  regions: {
		search: "#search",
		result: "#result",
		selected: "#selected"
	  }
	  
	});

	
	return BodyView;
});