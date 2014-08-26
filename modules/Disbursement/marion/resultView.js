define( function ( require ){

	var App = require ( 'disbursement' );
	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	var template = require( 'text!modules/Disbursement/marion/templates/resultView.html' );
	
	var resultView = Marionette.ItemView.extend({
		template : _.template( template ),
		tagName : 'tr',
		'events' : {
			'click #test' : 'addToSelected'
		},
		'addToSelected' : function(){
			App.trigger('disbursement:add-selected',this.model);
		}
	});
	
	return resultView;

}) 