(function($) {

	var setContainers = function() {
		var windowHeight = $( window ).height();
		$( '.business-card' ).height( (windowHeight-55) );
		$( '.primary-skills' ).height( (windowHeight-65) ).css('margin-top', windowHeight);
	};

	var fadeInContent = function() {
		$( '.page-id-54 .site-content' ).fadeIn( 1000 );
	};

	var fadeInBusinessCard = function() {
		$( '.business-card img' ).animate({opacity: 1}, 2000);
		$( '.business-card h2' ).delay( 2000 ).fadeIn( 1500 );
		$( '.business-card .self-summary').delay( 3500 ).fadeIn( 1500 );
		$( '.down-arrow' ).delay( 6000 ).fadeIn( 500 );
		$( '.arrow-instructions').delay( 6000 ).fadeIn( 500 )
	}

	var parallax = function() {
		// Set parallax motion for background image
	    var scrolled = $(window).scrollTop();
	    var windowHeight = $(window).height();
	    $('.about-background').css('top', -(scrolled * 0.1) + 'px');

	    // After interests, hide first image and show second
	    if ( scrolled > windowHeight * 1.9) {
	    	$( '.overlooking-water').css('z-index', '1');
	    	$( '.edc' ).css('z-index', '2');	
	    }
	    else if ( (scrolled < (windowHeight * 1.9) ) && ( $( '.edc' ).css('z-index') == 2 ) ) {
	    		$( '.overlooking-water').css('z-index', '2');
	    		$( '.edc' ).css('z-index', '1');
	    }
	};

	$(window).load( function() {
		fadeInContent();
		setContainers();
		fadeInBusinessCard();
		$( window ).scroll(parallax);	
	});

})(jQuery);