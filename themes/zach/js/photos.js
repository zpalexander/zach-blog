(function($) {

	var initIsotope = function() {
		$('.photo-content').isotope({
  			// options
  			itemSelector : '.photo',
  			layoutMode : 'fitRows'
  			transitionDuration: '1.0s',
		});
	};

	$(window).load( function() {
		initIsotope();
	});

})(jQuery);