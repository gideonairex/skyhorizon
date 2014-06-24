define( function ( require ){

	var App = require ( 'collection' );
	var Marionette = require( 'marionette' );
	var _ = require( 'underscore' );
	var template = require( 'text!modules/Collection/marion/templates/selectedView.html' );
	var selectView  = require( 'modules/Collection/marion/selectView' );
	
	var selectedView = Marionette.CompositeView.extend({
		template : _.template( template ),
		itemView : selectView,
		itemViewContainer : 'table.here',
		events : {
			'submit form' : 'createCollection'
		},
		sumTotal : function(){
			
			var total = 0;
			for( var i = 0 ; i < this.collection.length ; i++){
				var sales = this.collection.models[i].get('sales');
				var payment = this.collection.models[i].get('payment');
				total = total + parseInt(sales) - parseInt(payment);

			}
			
			this.$el.find('.total-sales').html(total);
		},
		subtractTotal : function( model ){
			var total = parseInt(this.$el.find('.total-sales').html());
			var diff = parseInt( model.get('sales') );
			var payment = parseInt( model.get('payment') );
			var newTotal = total - diff + payment;
			this.$el.find('.total-sales').html(newTotal);
			model.destroy();
		},
		createCollection : function ( e ) {
			e.preventDefault();
			var data = Backbone.Syphon.serialize(this);
			this.$el.find('.create-collection').attr("disabled", "disabled");
			App.trigger('collections:create-collections',this.collection,data);
		}
		
	});
	
	return selectedView;

})