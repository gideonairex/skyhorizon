define( function ( require ) {
	
	var App = require ( 'collection' );
	var Backbone = require( 'backbone' );

	var Model = Backbone.Model.extend( {
		urlRoot : 'index.php?module=Collection&action=MProcess',
		idAttribute: 'id'
		// add validation for arno
	} );
	
	var SearchCollection = Backbone.Collection.extend( {
		model: Model,
		url : 'index.php?module=Collection&action=MProcess',
	} );
	
	
	var SelectedModel = Backbone.Model.extend( {
		idAttribute: 'id'
		// add validation for arno
	} );
	
	var Collection = Backbone.Collection.extend( {
		model: SelectedModel,
		url : 'index.php?module=Collection&action=MProcess',
		save: function ( options ) {
			console.log(this)
			Backbone.sync("create", this , options );
		}
	} );
	
	
    var API = {
		'searchAR' : function( data ){

			var collection = new SearchCollection();
			collection.url += '&func=searchAR&searchString='+data.searchString+'&filter='+data.arFilter;
			
			var defer = $.Deferred();
			
			collection.fetch({
				error:   function(results, xhr, options){
				   console.log(xhr.responseText);
				   defer.resolve(undefined) 
				},
				success: function(results, response, options) {
					console.log(results)
					defer.resolve(collection)
				}
			});
			
			return defer.promise();
			
		},
		'initSelectedCollection' : function( ){
			var collection = new Collection( );
			return collection;
		},
		'updateRelation' : function ( collection, data ){
			collection.url +=  '&func=updateRelations&payment='+data.payment;
			var defer = $.Deferred();

			collection.save({
				error:   function(collection, xhr, options){
				   console.log(xhr.responseText);
				   defer.resolve(undefined) 
				},
				success: function(collection, response, options) {
					defer.resolve(collection)
				}
			});
			
			return defer.promise();
		}
	}

	
	App.reqres.setHandler('search:ar', function( data ){
		return API.searchAR( data );
	});
	
	App.reqres.setHandler('selected:init-collection', function( ){
		return API.initSelectedCollection( );
	});
	
	App.reqres.setHandler('selected:create-collection', function( collection, data){
		return API.updateRelation( collection, data );
	});
	
});