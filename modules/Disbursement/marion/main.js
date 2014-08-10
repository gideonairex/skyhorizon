requirejs.config({

    baseUrl: './',
	
    paths: {
        jquery : 'include/components/jquery/dist/jquery',
		underscore : 'include/components/underscore/underscore',
		backbone : 'include/components/backbone/backbone',
		'backbone.babysitter' : 'include/components/backbone.babysitter/lib/backbone.babysitter',
		'backbone.wreqr' : 'include/components/backbone.wreqr/lib/backbone.wreqr',
		'backbone.syphon' : 'include/components/backbone.syphon/lib/amd/backbone.syphon',
		'backbone.validation' : 'include/components/backbone.validation/dist/backbone-validation-amd',
		marionette : 'include/components/marionette/lib/core/amd/backbone.marionette',
		disbursement : 'modules/Disbursement/marion/app',
		text : 'include/components/text/text',
		bootstrap : 'include/components/bootstrap/dist/js/bootstrap',
		'bootstrap-datepicker' : 'include/components/bootstrap-datepicker/js/bootstrap-datepicker'
    },
	
	shim : {
		'jquery' : {
			'exports' : '$'
		},
		'underscore' : {
			'exports' : '_'
		},
		'backbone' : {
			'deps' : ['jquery','underscore']
		},
		'bootstrap' : {
			'deps' : [ 'jquery' ]
		},
		'bootstrap-datepicker' : {
			'deps' : [ 'jquery' ]
		},
		'marionette': {
			'deps' : [ 'backbone', 'backbone.wreqr', 'backbone.babysitter', 'backbone.syphon', 'backbone.validation', 'bootstrap', 'bootstrap-datepicker' ]
		},
		'disbursement' : {
			'deps' : [ 'marionette' ]
		}
	}
	
});

( function () {
	'use strict';

	define( function ( require ) {
	
		require(['marionette', 'backbone'], function( marionette, backbone ){
		
			var App = require( 'disbursement' );
			var Entities = require( 'modules/Disbursement/marion/entities' );			
			var Controller = require( 'modules/Disbursement/marion/controller' );

			App.start();
			
		});
		
	} );

} )();
