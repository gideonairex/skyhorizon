define( function ( require ){

	var App = require ( 'disbursement' );
	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	var template = require( 'text!modules/Disbursement/marion/templates/selectView.html' );
	
	var selectView = Marionette.ItemView.extend({
		template : _.template( template ),
		tagName : 'tr',
		'ui' : {
			'payment' : '.payment',
			'ewt' : '.ewt'
		},
		'events' : {
			'click #delete' : 'removeMe',
			'change input.payment' : 'updatePayment',
			'change input.ewt' : 'updateAWT'
		},
		'initialize' : function() {
			this.model.set('current_payment',0);
			this.model.set('current_ewt',0);
		},
		'updatePayment' : function(){
			this.model.set('current_payment',this.ui.payment.val());
			this.trigger('do:updatePayment',this.model);
		},
		'updateAWT' : function(){
			this.model.set('current_ewt',this.ui.ewt.val());
			this.trigger('do:updatePayment',this.model);
		},
		'removeMe' : function(){
			this.trigger("do:removeme",this.model);
		}
	});
	
	return selectView;

}) 