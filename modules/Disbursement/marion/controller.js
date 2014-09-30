define( function ( require ) {
	var App = require ( 'disbursement' );
	var Marionette  = require( 'marionette' );
	var bodyView  = require( 'modules/Disbursement/marion/bodyView' );
	var searchView  = require( 'modules/Disbursement/marion/searchView' );
	var resultsView  = require( 'modules/Disbursement/marion/resultsView' );
	var emptyResult  = require( 'modules/Disbursement/marion/emptyResult' );
	var selectedView  = require( 'modules/Disbursement/marion/selectedView' );
	var offsetsView  = require( 'modules/Disbursement/marion/offsetsView' );

	var layout = new bodyView();
	App.content.show( layout );

	var selected = new selectedView( {
										collection : App.request( 'selected:init-disbursement' )
									} );

	selected.on("itemview:do:removeme", function(ViewInstance,model){
		selected.subtractTotal( model );
	});

	selected.on("itemview:do:updatePayment", function(ViewInstance,model){
		selected.updatePayment();
	});

	var Router = Marionette.AppRouter.extend({
		appRoutes : {
			'disbursement/home' : 'showHome'
		}
	});

	var API = {
		'showHome' : function(){
			layout.search.show( new searchView() );
			layout.result.show( new emptyResult() );
			layout.selected.show( selected );
		},
		'addResult' : function( data ){
			var request = App.request( 'search:ap', data );
			$.when(request).done(function( collection ){

				if( collection ){
					var searchResult = new resultsView( {
						collection : collection
					} );
					layout.result.show( searchResult );
				}else{
					var empty = new emptyResult( { } );
					layout.result.show( empty );
				}
			} );
		},
		'addSelected' : function( model ){
			selected.collection.add( model )
			selected.updateBalance();
		},

		'createDisbursement' : function( selectedDisbursement, data ){
			var request = App.request( 'selected:create-disbursement' , selectedDisbursement, data );
			$.when( request ).done( function( disbursement ){
				if ( disbursement.error ) {
					alert( disbursement.error );
					selected.enableCreate();
				} else {
					window.location.assign("index.php?module=Disbursement&record="+disbursement.id+"&action=DetailView");
				}
			});
		},

		'getOffsets' : function( data ) {
			var request = App.request( 'offsets:add', data );
			$.when( request ).done ( function ( offsets ) {
				if( offsets.error ) {
					alert( offsets.error );
				} else {
					var offset = new offsetsView( {
						collection : offsets
					} );
					layout.offsets.show( offset );
					selected.insertOffsets( offsets );
				}
			} );
		}
	};

	App.addInitializer(function(){
		new Router({
			controller : API
		});
	});
	App.on('disbursement:home',function(){
		App.navigate("disbursement/home");
		API.showHome();
	});
	App.on('disbursement:add-result',function( data ){
		API.addResult( data );
	});
	App.on('disbursement:add-selected',function( resultModel ){
		API.addSelected( resultModel );
	});
	App.on('disbursement:create-disbursement',function( selectedDisbursement, data ){
		API.createDisbursement( selectedDisbursement, data );
	});
	App.on('offsets:add', function( selected ) {
		API.getOffsets( selected );
	} );
});
