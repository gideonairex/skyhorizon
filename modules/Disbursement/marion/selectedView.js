define( function ( require ){

	var App = require ( 'disbursement' );
	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	var template = require( 'text!modules/Disbursement/marion/templates/selectedView.html' );
	var selectView  = require( 'modules/Disbursement/marion/selectView' );
	var $ = require( 'jquery' );
	
	var selectedView = Marionette.CompositeView.extend({
		template : _.template( template ),
		itemView : selectView,
		itemViewContainer : 'table.here',
		ui : {
			'dateOfCheck' : '.date-of-check',
			'form' : 'form',
			'checkDetails' : '.check-details'
		},
		events : {
			'submit form' : 'createDisbursement',
		},
			
		onRender : function () {
			this.ui.dateOfCheck.datepicker({
				'format' : 'yyyy-mm-dd'
			});
		},

		updateBalance : function(){
			
			var totalBalance = 0;
			for( var i = 0 ; i < this.collection.length ; i++){
				var payable = this.collection.models[i].get('payable');
				var payment = this.collection.models[i].get('payment');
				var ewt =  this.collection.models[i].get('ewt');
				totalBalance = totalBalance + parseFloat(payable) - parseFloat(payment) - parseFloat(ewt);
			}
			  
			this.$el.find('.total-balance').html(totalBalance);
		},
		
		updatePayment : function( model ){
			var totalPayment = 0;
			for( var i = 0 ; i < this.collection.length ; i++){
				var payment = this.collection.models[i].get('current_payment');
				var ewt = this.collection.models[i].get('current_ewt');
				totalPayment = totalPayment + parseFloat(ewt) + parseFloat(payment);
			}
			this.$el.find('.total-payment').html(totalPayment);
		},
		
		subtractTotal : function( model ){
			var totalBalance = parseFloat(this.$el.find('.total-balance').html());
			var total = parseFloat(this.$el.find('.total-payment').html());
			
			var payment = parseFloat( model.get('current_payment') );
			var ewt = parseFloat( model.get('current_ewt') );
			var balance = parseFloat( model.get('balance') );
			
			payment += ewt;
			var newTotal = total - payment;
			
			totalBalance -= balance;
			
			this.$el.find('.total-balance').html(totalBalance);
			this.$el.find('.total-payment').html(newTotal);
			model.destroy();
		},
		
		
		createDisbursement : function ( e ) {
			e.preventDefault();
			var data = this.ui.form.serialize();
			this.$el.find('.create-disbursement').attr("disabled", "disabled");
			App.trigger('disbursement:create-disbursement',this.collection,data);
		},
		enableCreate : function ( ) {
			this.$el.find('.create-disbursement').removeAttr("disabled");
		}
		
	});
	
	return selectedView;

})