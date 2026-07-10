(function ($) {
  "use strict";

	$(document).on('machicShopPageInit', function () {
		machicThemeModule.siteslider();
	});

	machicThemeModule.siteslider = function() {
       const container = document.querySelectorAll( '.swiper-container' );

      if ( container !== null ) {
        container.forEach( ( event ) => {
          const loader = '<svg xmlns="http://www.w3.org/2000/svg" class="spinner" width="50" height="50" viewBox="0 0 44 44"><circle class="spinner-path" cx="22" cy="22" r="20" fill="none" stroke-width="3"></circle></svg>';
          const sliderLoader = document.createElement( 'div' );
          sliderLoader.classList.add( 'slider-loader' );

          sliderLoader.innerHTML = loader;
          event.prepend( sliderLoader );

          const items = event.querySelectorAll( '.swiper-slide' );
          imagesLoaded( items, () => {
            event.classList.add( 'slider-loaded' );
          });

          // Slider options
          let direction = event.dataset.direction;
          let effect = event.dataset.effect;
          let loop = event.dataset.loop === 'true' ? true : false;

          let desktopItems = parseInt( event.dataset.items );
          let mobileItems = parseInt( event.dataset.mobileitems );
          let tabletItems = parseInt( event.dataset.tabletitems );
          let speed = parseInt( event.dataset.speed );
          let spaceBetween = parseInt( event.dataset.spacebetween );

          // Autoplay Option
          let autoplay = event.dataset.autoplay === 'true' ? true : false;
          let autospeed = parseInt( event.dataset.autospeed );
          let autoPlaySettings = false;

          if ( autoplay ) {
            autoPlaySettings = {
              delay: autospeed,
              pauseOnMouseEnter: true
            }
          }

          // Init slider
          const swiper = new Swiper( event, {
            // Optional parameters
            direction: direction,
            loop: loop,
            speed: speed,
            effect: effect,
            autoplay: autoPlaySettings,
            spaceBetween: spaceBetween,
          
            // If we need pagination
            pagination: {
              el: '.swiper-pagination',
              clickable: true
            },
          
            // Navigation arrows
            navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev',
            },

            // Breakpoints
            breakpoints: {
              320: {
                slidesPerView: mobileItems
              },
              480: {
                slidesPerView: mobileItems
              },
              640: {
                slidesPerView: mobileItems
              },
              768: {
                slidesPerView: tabletItems
              },
              1024: {
                slidesPerView: tabletItems
              },
              1200: {
                slidesPerView: desktopItems
              },
              1280: {
                slidesPerView: desktopItems
              }
            }
          });
        });
      }
	}
	
	$(document).ready(function() {
		machicThemeModule.siteslider();
	});

})(jQuery);
