define( function ( require ){

	var App = require ( 'collection' );
	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	var template = require( 'text!modules/Collection/marion/templates/resultView.html' );
	
	var resultView = Marionette.ItemView.extend({
		template : _.template( template ),
		tagName : 'tr',
		'events' : {
			'click #test' : 'addToSelected'
		},
		'addToSelected' : function(){
			App.trigger('collections:add-selected',this.model);
		}
	});
	
	return resultView;

}) 