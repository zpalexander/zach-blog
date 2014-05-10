(function($) {

	var setContainers = function() {
		var windowHeight = $( window ).height();
		$( '.business-card' ).height(windowHeight);
	};

	var parallax = function() {
	    var scrolled = $(window).scrollTop();
	    $('.about-background').css('top', -(scrolled * 0.2) + 'px');
	};

	$(window).load( function() {
		setContainers();
		$( window ).scroll(parallax);	
	});

})(jQuery);