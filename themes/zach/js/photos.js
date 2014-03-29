(function($) {

	var initIsotope = function() {
		$('.photo-content').isotope({
  			// options
  			itemSelector : '.photo',
  			layoutMode : 'fitRows'
		});
	};

	$(window).load( function() {
		initIsotope();
	};

})(jQuery);