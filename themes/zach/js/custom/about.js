(function($) {

	var parallax = function() {
	    var scrolled = $(window).scrollTop();
	    $('.about-background-container').css('top', -(scrolled * 0.2) + 'px');
	}

	$(window).load( function() {
		parallax();	
	});

})(jQuery);