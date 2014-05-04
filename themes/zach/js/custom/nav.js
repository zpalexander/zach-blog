(function($) {

	var handleHamburger = function() {
		// If visible, hide
		if ( $( '.site-navigation ul' ).is(':visible') ) {
			$( '.site-navigation ul' ).hide();
			$( '.social-media-container').hide();
		}
		// Else show
		else {
			$( '.site-navigation ul' ).show();
			$( '.social-media-container' ).show();
		}
	}

	var handleWindowResize = function() {
		var windowWidth = $(window).width();
		if ( (windowWidth > 730) && (!$('.site-navigation ul').is(':visible')) )
			$( '.site-navigation ul' ).show();
			$( '.social-media-container' ).show();
		if ( windowWidth < 730 && ($('.site-navigation ul').is(':visible')) )
			$('.site-navigation ul').hide();
			$('.social-media-container').hide();
	}

	$(window).load(function() {
		$( '.header-hamburger' ).click(handleHamburger);
		$( window ).resize(handleWindowResize);
	});
})(jQuery);