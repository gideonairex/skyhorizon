requirejs.config({

    baseUrl: './',
	
    paths: {
		'amcharts' : 'include/components/amcharts_components/amcharts/amcharts',
		'amcharts.pie'      : 'include/components/amcharts_components/amcharts/pie',
        jquery : 'include/components/jquery/dist/jquery',
		underscore : 'include/components/underscore/underscore',
		backbone : 'include/components/backbone/backbone',
		'backbone.babysitter' : 'include/components/backbone.babysitter/lib/backbone.babysitter',
		'backbone.wreqr' : 'include/components/backbone.wreqr/lib/backbone.wreqr',
		'backbone.syphon' : 'include/components/backbone.syphon/lib/amd/backbone.syphon',
		'backbone.validation' : 'include/components/backbone.validation/dist/backbone-validation-amd',
		marionette : 'include/components/marionette/lib/core/amd/backbone.marionette',
		reports : 'modules/SHReports/marion/app',
		text : 'include/components/text/text',
		bootstrap : 'include/components/bootstrap/dist/js/bootstrap',
		'bootstrap-datepicker' : 'include/components/bootstrap-datepicker/js/bootstrap-datepicker',
		'chart' : 'include/components/chartjs/site/assets/Chart'
    },
	
	shim : {
		'amcharts.pie'      : {
            deps: ['amcharts'],
            exports: 'AmCharts',
            init: function() {
                AmCharts.isReady = true;
            }
        },
		'jquery' : {
			'exports' : '$'
		},
		'underscore' : {
			'exports' : '_'
		},
		'backbone' : {
			'deps' : ['jquery','underscore']
		},
		'chart' : {
			'deps' : ['jquery']
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
		'reports' : {
			'deps' : [ 'marionette' ]
		}
	}
	
});

( function () {
	'use strict';

	define( function ( require ) {
	
		require(['marionette', 'backbone'], function( marionette, backbone ){
		
			var App = require( 'reports' );
			var Entities = require( 'modules/SHReports/marion/entities' );			
			var Controller = require( 'modules/SHReports/marion/controller' );

			App.start();
			
		});
		
	} );

} )();
