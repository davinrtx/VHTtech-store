(function ($) {
  "use strict";

	$(document).on('machicShopPageInit', function () {
		machicThemeModule.productHover();
	});

	machicThemeModule.productHover = function() {
      var product = $( '.products .product' );

      product.each( function(e) {
        var fadeBlock = $(this).find( '.product-footer' );
        var contentBlock = $(this).find( '.product-content-fade' );
        var outerHeight = 0;

        const parent = contentBlock.closest( '.product' );

        parent.addClass( 'custom-hover' );

        if ( fadeBlock.length ) {
          fadeBlock.each( function(e) {
            var self = $(this);
            outerHeight += self.outerHeight();

            contentBlock.css( 'marginBottom', -outerHeight );
          });
        }
      });
	}
	
	$(document).ready(function() {
		machicThemeModule.productHover();
	});

})(jQuery);
