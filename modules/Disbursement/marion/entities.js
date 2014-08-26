define( function ( require ) {
	
	var App = require ( 'disbursement' );
	var Backbone = require( 'backbone' );

	var Model = Backbone.Model.extend( {
		urlRoot : 'index.php?module=Disbursement&action=MProcess',
		idAttribute: 'id'
		// add validation for arno
	} );
	
	var SearchDisbursement = Backbone.Collection.extend( {
		model: Model,
		url : 'index.php?module=Disbursement&action=MProcess',
	} );
	
	var SelectedModel = Backbone.Model.extend( {
		idAttribute: 'id'
		// add validation for arno
	} );
	
	var Disbursement = Backbone.Collection.extend( {
		model: SelectedModel,
		url : 'index.php?module=Disbursement&action=MProcess',
		save: function ( options ) {
			Backbone.sync("create", this , options );
		}
	} );
	
    var API = {
		'searchAP' : function( data ){

			var disbursement = new SearchDisbursement();
			disbursement.url += '&func=searchAP&searchString='+data.searchString+'&filter='+data.apFilter+'&conversion='+data.conversion;
			
			var defer = $.Deferred();
			
			disbursement.fetch({
				error:   function(results, xhr, options){
				   console.log(xhr.responseText);
				   defer.resolve(undefined) 
				},
				success: function(results, response, options) {
					console.log(results)
					defer.resolve(disbursement)
				}
			});
			
			return defer.promise();
			
		},
		'initSelectedDisbursement' : function( ){
			var disbursement = new Disbursement( );
			return disbursement;
		},
		'updateRelation' : function ( disbursement, data ){
			disbursement.url +=  '&func=updateRelations&'+ data;
			var defer = $.Deferred();
			
			disbursement.save({
				error:   function(disbursement, xhr, options){
				   console.log(xhr.responseText);
				   defer.resolve(undefined) 
				},
				success: function(disbursement, response, options) {
					defer.resolve(disbursement)
				}
			});
			
			return defer.promise();
		}
	}

	
	App.reqres.setHandler('search:ap', function( data ){
		return API.searchAP( data );
	});
	
	App.reqres.setHandler('selected:init-disbursement', function( ){
		return API.initSelectedDisbursement( );
	});
	
	App.reqres.setHandler('selected:create-disbursement', function( disbursement, data){
		return API.updateRelation( disbursement, data );
	});
	
});