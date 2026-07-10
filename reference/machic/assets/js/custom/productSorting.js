(function ($) {
  "use strict";

	$(document).on('machicShopPageInit', function () {
		machicThemeModule.productsorting();
	});

	machicThemeModule.productsorting = function() {
      const item = document.querySelectorAll( '.filterSelect' );

      if ( item !== null ) {
        item.forEach( ( event ) => {
		  let filterClass = event.dataset.class;
          var filterSelect = $(event).select2({
            minimumResultsForSearch: Infinity,
            dropdownAutoWidth: true,
			dropdownCssClass: filterClass,
          });
        });
      }

		if ( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			if ($('select').data('select2')) {
				$("select").select2('destroy');
			}
		}

	}
	
	$(document).ready(function() {
		machicThemeModule.productsorting();
	});

})(jQuery);
