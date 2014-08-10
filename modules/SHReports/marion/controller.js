define( function ( require ) {
	
	var App = require ( 'reports' );
	var Marionette  = require( 'marionette' );
	var bodyView = require( 'modules/SHReports/marion/bodyView' );
	var filterView = require( 'modules/SHReports/marion/filtersView' );
	var resultsView = require( 'modules/SHReports/marion/resultsView' );
	
	var layout = new bodyView();
	App.content.show( layout )

	var API = {
		
		'showHome' : function(){
			var users = App.request( 'filters:get' );
			
			$.when(users).done(function( usersModel ){

				layout.filters.show( new filterView( { model : usersModel } ) );
				//layout.results.show( new resultView() );
			} );

		},
		'generateReport' : function ( data, data2 ) {
			var request = App.request( 'generate:report', data );
			$.when(request).done(function( reportCollection ){
				layout.results.show( new resultsView( { collection: reportCollection, report:data2.report_name } ) );
			} );
		}
		
	}
	
	var Router = Marionette.AppRouter.extend({
		appRoutes : {
			'reports/home' : 'showHome'
		}
	});
	
	App.addInitializer(function(){
	
		new Router( {
			controller : API
		} )
		
	});
	
	App.on('generate:report',function( data, data2 ){
		API.generateReport( data, data2 );
	});
	
	App.on('reports:home',function(){
		App.navigate("reports/home");
		API.showHome();
	});
	
	
});