(function($) {

	var handleSocialMedia = function() {
		var windowWidth = $( window ).width();
		if ( ( windowWidth > 730 ) && ( ! $( '.social-media-container' ).is( ':visible' ) ) ) {
			$('.social-media-container').show();
		}
	};

	$(window).load(function() {
		var windowHeight = $( window ).height();
		$( 'body' ).css('min-height', windowHeight);
		$( '.home' ).fadeIn(500);
		$( '.social-media-link' ).fadeIn(1200);
		$( window ).resize(handleSocialMedia);
	});
})(jQuery);