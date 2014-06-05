(function($) {


	var handleSocialMedia = function() {
		var windowWidth = $( window ).width();
		var windowHeight = $( window ).height();
		var socialMediaContainerHeight = 487.1875;
		if ( ( windowWidth > 730 ) ) {
			// Vertically center social media icons
			var socialMediaContainerTop = (windowHeight/2) - (socialMediaContainerHeight/2);
			$( '.social-media-container' ).css('top', socialMediaContainerTop);
			if ( ! $( '.social-media-container' ).is( ':visible' ) ) {
				$('.social-media-container').show();
			}
		}
		else {
			$( '.social-media-container' ).css('top', '170px');
		}
	};

	var setContentHeight = function() {
		var windowHeight = $( window ).height();
		var headerHeight = $( '.site-header' ).height();
		$( 'body' ).css('min-height', windowHeight);
		$( '.home #content' ).height( windowHeight - headerHeight );
	};

	$(window).load(function() {
		setContentHeight();
		$( '.home' ).fadeIn(1200);
		$( '.social-media-link' ).fadeIn(1500);
		handleSocialMedia();
		$( window ).resize(handleSocialMedia).resize(setContentHeight);
	});
})(jQuery);
