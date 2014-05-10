(function($) {

	var setContainers = function() {
		var windowHeight = $( window ).height();
		$( '.business-card' ).height( (windowHeight-55) );
		$( '.primary-skills' ).height( (windowHeight-55) );
	};

	var fadeInBusinessCard = function() {
		$( '.business-card img' ).animate({opacity: 1}, 2000);
		$( '.business-card h2' ).delay( 2500 ).fadeIn( 1500 );
		$( '.business-card p').delay( 3500 ).fadeIn( 1500 );
	}

	var parallax = function() {
	    var scrolled = $(window).scrollTop();
	    $('.about-background').css('top', -(scrolled * 0.2) + 'px');
	};

	$(window).load( function() {
		setContainers();
		fadeInBusinessCard();
		$( window ).scroll(parallax);	
	});

})(jQuery);