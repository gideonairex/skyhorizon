define( function ( require ){

	var App = require ( 'collection' );
	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	var template = require( 'text!modules/Collection/marion/templates/selectView.html' );
	
	var selectView = Marionette.ItemView.extend({
		template : _.template( template ),
		tagName : 'tr',
		'ui' : {
			'payment' : '.payment',
			'ewt' : '.ewt',
			'bc'  : '.bc'
		},
		'events' : {
			'click #delete' : 'removeMe',
			'change input.payment' : 'updatePayment',
			'change input.ewt' : 'updateAWT',
			'change input.bc'  : 'updateBC'
		},
		'updatePayment' : function(){
			this.model.set('payment',this.ui.payment.val());
			this.trigger('do:updatePayment',this.model);
		},
		'updateAWT' : function(){
			this.model.set('ewt',this.ui.ewt.val());
			this.trigger('do:updatePayment',this.model);
		},
		'updateBC' : function(){
			this.model.set('bc',this.ui.bc.val());
			this.trigger('do:updatePayment',this.model);
		},
		'removeMe' : function(){
			this.trigger("do:removeme",this.model);
		}
	});
	
	return selectView;

}) 