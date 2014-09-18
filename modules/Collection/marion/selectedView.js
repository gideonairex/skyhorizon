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
				var bc = this.collection.models[i].get('bc');
				if ( !awt )
					awt = 0;
				if ( !payment )
					awt = 0;
				if ( !bc )
					bc = 0;
				totalBalance = totalBalance + parseFloat(sales) - parseFloat(payment) - parseFloat(awt) - parseFloat(bc);
			}
			this.$el.find('.total-balance').html(totalBalance);
		},
		updatePayment : function( model ){
			var totalPayment = 0;
			for( var i = 0 ; i < this.collection.length ; i++){
				var payment = this.collection.models[i].get('paymentp') ? this.collection.models[i].get('paymentp') : 0;
				var ewt = this.collection.models[i].get('ewt') ? this.collection.models[i].get('ewt') : 0;
				var bc = this.collection.models[i].get('bcp') ? this.collection.models[i].get('bcp') : 0;

				totalPayment = totalPayment + parseFloat(ewt) + parseFloat(payment) + parseFloat(bc);
			}

			this.$el.find('.create-collection').removeAttr("disabled");
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
			var c = true;
			for( var i = 0 ; i < this.collection.length ; i++){

				var payment = this.collection.models[i].get('paymentp') ? this.collection.models[i].get('paymentp') : 0;
				var ewt = this.collection.models[i].get('ewt') ? this.collection.models[i].get('ewt') : 0;
				var bc = this.collection.models[i].get('bcp') ? this.collection.models[i].get('bcp') : 0;

				if( !isNaN( payment) && !isNaN( ewt ) && !isNaN(bc) ) {
				} else {
					c = false;
					break;
				}
			}

			if( c ) {
				this.$el.find('.create-collection').attr("disabled", "disabled");
				//App.trigger('collections:create-collections',this.collection,data);
			} else {
				alert( "Must all be numeric" );
			}

		},
		enableCreate : function ( ) {
			this.$el.find('.create-collection').removeAttr("disabled");
		}
	});

	return selectedView;

})