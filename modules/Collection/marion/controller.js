define( function ( require ) {
	
	var App = require ( 'collection' );
	var Marionette  = require( 'marionette' );
	var bodyView  = require( 'modules/Collection/marion/bodyView' );
	var searchView  = require( 'modules/Collection/marion/searchView' );
	var resultsView  = require( 'modules/Collection/marion/resultsView' );
	var emptyResult  = require( 'modules/Collection/marion/emptyResult' );
	var selectedView  = require( 'modules/Collection/marion/selectedView' );
	
	var layout = new bodyView();
	App.content.show( layout )
	
	var selected = new selectedView( {
										collection : App.request( 'selected:init-collection' )
									} ) 
	selected.on("itemview:do:removeme", function(ViewInstance,model){
		selected.subtractTotal( model );
	}); 
	
	selected.on("itemview:do:updatePayment", function(ViewInstance,model){
		selected.updatePayment();
	});
	
	var Router = Marionette.AppRouter.extend({
		appRoutes : {
			'collections/home' : 'showHome'
		}
	});
	
	var API = {
		
		'showHome' : function(){
			layout.search.show(   new searchView() );
			layout.result.show( new emptyResult() );
			layout.selected.show( selected );
		},
		
		'addResult' : function( data ){
			var request = App.request( 'search:ar', data );
			
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

		'createCollection' : function( selectedCollection, data ){
			
			var request = App.request( 'selected:create-collection' , selectedCollection, data );
			
			$.when( request ).done( function( collection ){
				if ( collection.error ) {
					alert( collection.error );
					selected.enableCreate();
				} else {
					window.location.assign("index.php?module=Collection&record="+collection.id+"&action=DetailView");
				}
			
			});
		}
		
	}
	
	App.addInitializer(function(){
	
		new Router({
			controller : API
		});
		
	});
	
	App.on('collections:home',function(){
		App.navigate("collections/home");
		API.showHome();
	});
	
	App.on('collections:add-result',function( data ){
		API.addResult( data );
	});
	
	App.on('collections:add-selected',function( resultModel ){
		API.addSelected( resultModel );
	});
	
	App.on('collections:create-collections',function( selectedCollection, data ){
		API.createCollection( selectedCollection, data );
	});
	
	
});