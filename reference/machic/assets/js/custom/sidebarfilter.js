(function ($) {
  "use strict";

	$(document).on('machicShopPageInit', function () {
		machicThemeModule.sidebarfilter();
	});

	machicThemeModule.sidebarfilter = function() {
      var sidebar = $( '.filtered-sidebar' );
      var button = $( '.filter-button' );
      var siteOverlay = $( '.site-overlay' );
      var close = $( '.close-sidebar' );

	  if ( sidebar.length > 0 ) {
	      var tl = gsap.timeline( { paused: true, reversed: true } );
	      tl.set( sidebar, {
	        autoAlpha: 1
	      }).to( sidebar, .5, {
	        x:0,
					ease: 'power4.inOut'
	      }).to( siteOverlay, .5, {
	        autoAlpha: 1,
	        ease: 'power4.inOut'
	      }, "-=.5");
	
	      button.on( 'click', function(e) {
		    e.preventDefault();
	        siteOverlay.addClass( 'active' );
		    tl.reversed() ? tl.play() : tl.reverse();
			siteOverlay.show();
		  });
	
	      close.on( 'click', function(e) {
	        e.preventDefault();
		    tl.reverse();
	        setTimeout( function() {
			  siteOverlay.hide();
	          siteOverlay.removeClass( 'active' );
	        }, 100);
		  });

	      siteOverlay.on( 'click', function(e) {
	        e.preventDefault();
		    tl.reverse();
	        setTimeout( function() {
			  siteOverlay.hide();
	          siteOverlay.removeClass( 'active' );
	        }, 100);
		  });


      }
	}
	
	$(document).ready(function() {
		machicThemeModule.sidebarfilter();
	});

})(jQuery);
