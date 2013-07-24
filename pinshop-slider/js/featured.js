(function($){
	$(window).load(function(){
		/////////////////////////////////////////////
		// Product slider
		/////////////////////////////////////////////
		if ($('.product-slides-2').length > 0) {

			// Parse data from wp_localize_script
			themifyShop2.autoplay = parseInt(themifyShop2.autoplay);
			themifyShop2.speed = parseInt(themifyShop2.speed);
			themifyShop2.scroll = parseInt(themifyShop2.scroll);
			themifyShop2.visible = parseInt(themifyShop2.visible);
			if (null == themifyShop2.wrap) {
				themifyShop2.wrap = false;
			} else {
				themifyShop2.wrap = true;
			}
			if (0 == themifyShop2.autoplay) {
				themifyShop2.play = false;
			} else {
				themifyShop2.play = true;
			}

			$('.product-slides-2').carouFredSel({
				responsive : true,
				prev : '#product-slider-2 .carousel-prev',
				next : '#product-slider-2 .carousel-next',
				pagination : "#product-slider-2 .carousel-pager",
				width : '100%',
				circular : themifyShop2.wrap,
				infinite : themifyShop2.wrap,
				auto : {
					play : themifyShop2.play,
					pauseDuration : themifyShop2.autoplay * 1000,
					duration : themifyShop2.speed
				},
				scroll : {
					items : themifyShop2.scroll,
					duration : themifyShop2.speed,
					wipe : true
				},
				items : {
					visible : {
						min : 1,
						max : themifyShop2.visible
					},
					width : 150
				},
				onCreate : function() {
					$('.product-sliderwrap').css({
						'height' : 'auto',
						'visibility' : 'visible'
					});
				}
			});
			
		}
	});

})(jQuery);