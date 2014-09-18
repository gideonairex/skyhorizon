define( function ( require ) {
	var Marionette  = require( 'marionette' );
	var App = new Marionette.Application();
	// set the regions of the app
	App.addRegions( {
		'menu'         : '#navbar',
		'footerRegion' : '#footer',
		'content'      : '#main-content',
	} );
	App.navigate = function ( route, options ) {
		options = options || { };
		Backbone.history.navigate( route, options );
	};

	App.getCurrentRoute = function () {
		return Backbone.history.fragment;
	};
	App.on("initialize:after", function(){
			if(Backbone.history)
				Backbone.history.start();
			if(this.getCurrentRoute() === ""){
				App.trigger("reports:home");
			}

		});
	return App;
});
