define( function ( require ){

	var App = require ( 'collection' );
	var Marionette = require( 'marionette' );
	var Backbone = require( 'backbone' );
	var _ = require( 'underscore' );
	var template = require( 'text!modules/Collection/marion/templates/searchView.html' );
	
	var searchView = Marionette.ItemView.extend({
		template : _.template( template ),
		'events' : {
			'submit form' : 'search'
		},
		'search' : function( e ){
			e.preventDefault();
			var data = Backbone.Syphon.serialize(this);
			App.trigger('collections:add-result',data);
		}
	});
	
	return searchView;

})