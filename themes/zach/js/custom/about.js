(function($) {

	var parallax = function() {
	    var scrolled = $(window).scrollTop();
	    $('.about-background').css('top', -(scrolled * 0.2) + 'px');
	}

	$(window).load( function() {
		$( window ).scroll(parallax);	
	});

})(jQuery);