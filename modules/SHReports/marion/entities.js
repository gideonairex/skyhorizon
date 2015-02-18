define( function ( require ) {
	var App = require ( 'reports' );
	var Backbone = require( 'backbone' );

	var UserModel = Backbone.Model.extend( {
		urlRoot : 'index.php?module=SHReports&action=MProcess',
		idAttribute: 'id'
	} );

	var Model = Backbone.Model.extend( {
		urlRoot : 'index.php?module=SHReports&action=MProcess',
		idAttribute: 'id'
	} );
	var ResultsCollection = Backbone.Collection.extend( {
		model: Model,
		url : 'index.php?module=SHReports&action=MProcess',
	} );

    var API = {
		'getFilters' : function () {
			var User = new UserModel();
			User.urlRoot += '&func=getFilters';
			var defer = $.Deferred();
			User.fetch( {
				error:   function(results, xhr, options){
				   console.log(xhr.responseText);
				   defer.resolve(undefined)
				},
				success: function(results, response, options) {
					//console.log(results)
					defer.resolve(User)
				}
			} );
			return defer.promise();
		},
		'generateReport' : function ( data ) {
			var resultsCollection = new ResultsCollection();
			resultsCollection.url += '&func=generateReport&'+ data;
			var defer = $.Deferred();
			resultsCollection.fetch( {
				error:   function(results, xhr, options){
				   console.log(xhr.responseText);
				   defer.resolve(undefined)
				},
				success: function(results, response, options) {
					//console.log(results)
					defer.resolve(resultsCollection)
				}
			} );
			return defer.promise();
		},
		'saveAr' : function ( data ) {

			var resultsCollection = new ResultsCollection();
			resultsCollection.url += '&func=saveAr&'+ data;
			var defer = $.Deferred();
			resultsCollection.fetch( {
				error:   function(results, xhr, options){
				   console.log(xhr.responseText);
				   defer.resolve(undefined)
				},
				success: function(results, response, options) {
					//console.log(results)
					defer.resolve(resultsCollection)
				}
			} );

			return defer.promise();
		}
	};

	App.reqres.setHandler('generate:report', function( data ){
		return API.generateReport( data );
	});
	App.reqres.setHandler('filters:get', function( ){
		return API.getFilters( );
	});
	App.reqres.setHandler('save:ar', function( data ){
		return API.saveAr( data );
	});
});