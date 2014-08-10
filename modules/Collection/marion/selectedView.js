define( function ( require ){

	var App = require ( 'collection' );
	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	var template = require( 'text!modules/Collection/marion/templates/selectedView.html' );
	var selectView  = require( 'modules/Collection/marion/selectView' );
	var $ = require( 'jquery' );
	
	var selectedView = Marionette.CompositeView.extend({
		template : _.template( template ),
		itemView : selectView,
		itemViewContainer : 'table.here',
		ui : {
			'dateOfCheck' : '.date-of-check',
			'paymentType' : '.payment_type',
			'form' : 'form',
			'checkDetails' : '.check-details'
		},
		events : {
			'submit form' : 'createCollection',
			'change @ui.paymentType' : 'toggleCheckDetails'
		},
			
		onRender : function () {
			this.toggleCheckDetails();
			this.ui.dateOfCheck.datepicker({
				'format' : 'yyyy-mm-dd'
			});
		},
		
		toggleCheckDetails : function() {
			if( this.ui.paymentType.val() == 'Check') {
				this.ui.checkDetails.css('display','')
			}else {
				this.ui.checkDetails.css('display','none')
			}
		},
		
		
		updateBalance : function(){
			
			var totalBalance = 0;
			for( var i = 0 ; i < this.collection.length ; i++){
				var sales = this.collection.models[i].get('sales');
				var payment = this.collection.models[i].get('payment');
				var awt = this.collection.models[i].get('awt');
				
				if ( !awt )
					awt = 0;
				if ( !payment )
					awt = 0;
					
				totalBalance = totalBalance + parseFloat(sales) - parseFloat(payment) - parseFloat(awt);
			}
			
			this.$el.find('.total-balance').html(totalBalance);
		},
		
		updatePayment : function( model ){
			var totalPayment = 0;
			for( var i = 0 ; i < this.collection.length ; i++){
				var payment = this.collection.models[i].get('payment');
				var ewt = this.collection.models[i].get('ewt');
				totalPayment = totalPayment + parseFloat(ewt) + parseFloat(payment);
			}
			this.$el.find('.total-payment').html(totalPayment);
		},
		
		subtractTotal : function( model ){
			var total = parseFloat(this.$el.find('.total-sales').html());
			var diff = parseFloat( model.get('sales') );
			var payment = parseFloat( model.get('payment') );
			var newTotal = total - diff + payment;
			this.$el.find('.total-sales').html(newTotal);
			model.destroy();
		},
		
		
		createCollection : function ( e ) {
			e.preventDefault();
			var data = this.ui.form.serialize();
			this.$el.find('.create-collection').attr("disabled", "disabled");
			App.trigger('collections:create-collections',this.collection,data);
		},
		
		enableCreate : function ( ) {
			this.$el.find('.create-collection').removeAttr("disabled");
		}
		
	});
	
	return selectedView;

})