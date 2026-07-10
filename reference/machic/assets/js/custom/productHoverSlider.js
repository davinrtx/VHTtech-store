(function ($) {
  "use strict";

	$(document).on('machicShopPageInit', function () {
		machicThemeModule.productHoverSlider();
	});

	machicThemeModule.productHoverSlider = function() {
      hoverSlider.init({});
      hoverSlider.prepareMarkup();
	}
	
	$(document).ready(function() {
		machicThemeModule.productHoverSlider();
	});

})(jQuery);
