(function($) {

	machicThemeModule.ajaxLinks = '.widget_klb_product_categories a, .widget_product_status a, .remove-filter a, .widget_layered_nav a, .product-views-buttons a, .woocommerce-pagination a';

	machicThemeModule.ajaxFilters = function() {

		machicThemeModule.$document.pjax(machicThemeModule.ajaxLinks, '.site-content', {
			timeout       : 5000,
			scrollTo      : false,
			renderCallback: function(context, html, afterRender) {
				context.html(html);
				afterRender();
			}
		});

		machicThemeModule.$document.on('submit', '.widget_price_filter form', function(event) {
			$.pjax.submit(event, '.site-content');
			machicThemeModule.$document.trigger('machicShopPageInit');
		});

		machicThemeModule.$document.on('submit', '.widget_search_filter form', function(event) {
			$.pjax.submit(event, '.site-content');
			machicThemeModule.$document.trigger('machicShopPageInit');
		});

		machicThemeModule.$document.on('submit', 'form.woocommerce-widget-layered-nav-dropdown', function(event) {
			$.pjax.submit(event, '.site-content');
			machicThemeModule.$document.trigger('machicShopPageInit');
		});

		machicThemeModule.$document.on('pjax:error', function(xhr, textStatus, error) {
			console.log('pjax error ' + error);
		});

		machicThemeModule.$document.on('pjax:start', function() {

			scrollToTop(false);

			var $siteContent = $('.site-content');

			$siteContent.removeClass('ajax-loaded');
			$siteContent.addClass('ajax-loading');
			$(".site-content .content-primary .products, nav.woocommerce-pagination").hide();
			$('.site-content .content-primary .products').before('<svg class="loader-image preloader" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg></div>');
		});

		machicThemeModule.$document.on('pjax:complete', function() {

			$('.site-content').removeClass('ajax-loading');

			$('.loader-image.preloader').remove();
			
			machicThemeModule.$document.trigger('machicShopPageInit');
			
			$('.site-overlay').removeClass('active');
			$(".site-overlay").css({"opacity": "0", "visibility": "hidden"});

		});


		machicThemeModule.$document.on('pjax:end', function() {

			scrollToTop(false);

			var $siteContent = $('.site-content');

			$siteContent.removeClass('ajax-loading');
			$siteContent.addClass('ajax-loaded');
			
		});

		var scrollToTop = function(type) {
			if (machic_settings.ajax_scroll === 'no' && type === false) {
				return false;
			}

			var $scrollTo = $(machic_settings.ajax_scroll_class),
			    scrollTo  = $scrollTo.offset().top - machic_settings.ajax_scroll_offset;

			$('html, body').stop().animate({
				scrollTop: scrollTo
			}, 400);
		};
	};

	$(document).ready(function() {
		machicThemeModule.ajaxFilters();
	});
})(jQuery);
