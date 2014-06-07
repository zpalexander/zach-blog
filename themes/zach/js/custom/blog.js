(function($) {

	var activateTeaserImage = function() {
		$( this ).css('opacity', '.5');
	}

	var deactivateTeaserImage = function() {
		$( this ).css('opacity', '1');
	}

	$(window).load( function() {
		$( '.blog-post-teaser-container' ).fadeIn(1000);
		$( 'hr' ).fadeIn(1000);
		$( '.blog-teaser-image' ).mouseenter( activateTeaserImage ).mouseleave( deactivateTeaserImage );
	});

})(jQuery);
