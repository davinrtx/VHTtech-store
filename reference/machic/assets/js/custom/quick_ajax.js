jQuery(document).ready(function($) {
	"use strict";

	$(document).on('click', 'a.detail-bnt', function(event){
		event.preventDefault(); 
        var data = {
			cache: false,
            action: 'quick_view',
			beforeSend: function() {
				$('body').append('<svg class="loader-image preloader quick-view" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg></div>');
			},
			'id': $(this).data('product_id'),
        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		$.post(MyAjax.ajaxurl, data, function(response) {
            $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: response
                }
            })
			
			  const container = document.querySelectorAll( '.swiper-container' );

			  if ( container !== null ) {
				container.forEach( ( event ) => {
				  const self = event;

				  const items = self.querySelectorAll( '.swiper-slide' );
				  imagesLoaded( items, () => {
					self.classList.add( 'slider-loaded' )
				  });

				  let thumbnails = null;

				  const productThumbnails = document.querySelector( '#product-thumbnails' );
					
				  if ( productThumbnails !== null ) {
					// Options
					thumbnails = new Swiper( '.quickview-product #product-thumbnails', {
					  effect: 'slide',
					  speed: 1100,
					  slidesPerView: 5,
					  spaceBetween: 7,
					  direction: 'horizontal',
					  loop: false,
					  cssMode: false,
					  mousewheel: false,
					  freeMode: true,
					  watchSlidesVisibility: true,
					  watchSlidesProgress: true,
					  // Breakpoints
					  breakpoints: {
						480: {
						  slidesPerView: 3
						},
						640: {
						  slidesPerView: 3
						},
						768: {
						  slidesPerView: 5
						},
					  }
					});
				  }
				 

				  const images = new Swiper( '.quickview-product #product-images', {
					effect: 'slide',
					autoHeight: true,
					speed: 1100,
					slidesPerView: 1,
					spaceBetween: 0,
					direction: 'horizontal',
					loop: false,
					cssMode: false,
					mousewheel: false,
					// Navigation
					navigation: {
					  nextEl: '.swiper-button-next',
					  prevEl: '.swiper-button-prev',
					},
					thumbs: {
					  swiper: thumbnails,
					},
				  });
				});
			  }
			  
			  
			  // Quantity Plus Minus
			  function qty() {
				var container = $( '.quantity:not(.ajax-quantity)' );
				container.each( function() {
				  var self = $( this );
				  var buttons = $( this ).find( '.quantity-button' );
				  buttons.each( function() {
					$(this).on( 'click', function(event) {
					  var qty_input = self.find( '.input-text.qty' );
					  if ( $(qty_input).prop('disabled') ) return;
					  var qty_step = parseFloat($(qty_input).attr('step'));
					  var qty_min = parseFloat($(qty_input).attr('min'));
					  var qty_max = parseFloat($(qty_input).attr('max'));


					  if ( $(this).hasClass('minus') ){
						var vl = parseFloat($(qty_input).val());
						vl = ( (vl - qty_step) < qty_min ) ? qty_min : (vl - qty_step);
						$(qty_input).val(vl);
					  } else if ( $(this).hasClass('plus') ) {
						var vl = parseFloat($(qty_input).val());
						vl = ( (vl + qty_step) > qty_max ) ? qty_max : (vl + qty_step);
						$(qty_input).val(vl);
					  }

					  qty_input.trigger( 'change' );
					});
				  });
				});
			  }

			  qty();
			  $('body').on( 'updated_cart_totals', qty );
			  
			$("form.cart.grouped_form .input-text.qty").attr("value", "0");

			$( document.body ).trigger( 'machicSinglePageInit' );

			$(".loader-image").remove();
        });
    });	

});