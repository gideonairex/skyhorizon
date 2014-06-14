define( function ( require ){

	var App = require ( 'collection' );
	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	var template = require( 'text!modules/Collection/marion/templates/selectView.html' );
	
	var selectView = Marionette.ItemView.extend({
		template : _.template( template ),
		tagName : 'tr',
		'events' : {
			'click #delete' : 'removeMe'
		},
		'removeMe' : function(){
			this.trigger("do:removeme",this.model);
		}
	});
	
	return selectView;

}) 