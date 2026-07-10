(function ($) {
  "use strict";

	$(document).on('machicShopPageInit', function () {
		machicThemeModule.filterdropdown();
	});

	machicThemeModule.filterdropdown = function() {
		if (!$('body').hasClass('machic-ajax-shop-on') && !$(".woocommerce-widget-layered-nav-dropdown").length) {
			return;
		}
		
		// Update value on change.
		$( 'form.woocommerce-widget-layered-nav-dropdown select' ).on( 'change', function() {
			var slug = $( this ).val();
			var attribute_name = $( this ).closest( 'form' ).find('input[name^="filter_"]').attr('name');
			
			$( ':input[name="'+ attribute_name +'"]' ).val( slug );
	
			// Submit form on change if standard dropdown.
			if ( ! $( this ).attr( 'multiple' ) ) {
				$( this ).closest( 'form' ).trigger( 'submit' );
			}
		});

		// Use Select2 enhancement if possible
		if ( $().selectWoo ) {
			var wc_layered_nav_select = function() {
				$( 'form.woocommerce-widget-layered-nav-dropdown select' ).selectWoo( {
					minimumResultsForSearch: 5,
					width: '100%',
					allowClear: true,
					language: {
						noResults: function() {
							return 'No matches found';
						}
					}
				} );
			};
			wc_layered_nav_select();
		}
	};

	$(document).ready(function() {
		machicThemeModule.filterdropdown();
	});
})(jQuery);
