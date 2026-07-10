(function ($) {
  "use strict";

	$(document).on('machicShopPageInit', function () {
		machicThemeModule.sitescroll();
	});

	machicThemeModule.sitescroll = function() {
      const container = document.querySelectorAll( '.site-scroll' );

      for( var i = 0; i < container.length; i++ ) {
        const ps = new PerfectScrollbar( container[i], {
          suppressScrollX: true
        });
      }
	}
	
	$(document).ready(function() {
		machicThemeModule.sitescroll();
	});

})(jQuery);
