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
			} );

		},
		'generateReport' : function ( data, data2 ) {
			var request = App.request( 'generate:report', data );
			$.when(request).done(function( reportCollection ){
				if( data2.report_name === 'apntp' ) {
					data2.report_name = 'ap';
				}

				layout.results.show( new resultsView( { collection: reportCollection, report:data2.report_name } ) );
			} );
		},
		'saveAr' : function ( data, cb ) {
			var str = 'remarks=' + data.remarks + '&id=' + data.id;
			var request = App.request( 'save:ar', str );
			$.when( request ).done( function ( result ) {
				cb( result );
			} );
		}
	};
	var Router = Marionette.AppRouter.extend({
		appRoutes : {
			'reports/home' : 'showHome'
		}
	});
	App.addInitializer(function(){
		new Router( {
			controller : API
		} );
	});
	App.on('generate:report',function( data, data2 ){
		API.generateReport( data, data2 );
	});

	App.on('save:ar',function( data, cb ){
		API.saveAr( data, cb );
	});

	App.on('reports:home',function(){
		App.navigate("reports/home");
		API.showHome();
	});
});