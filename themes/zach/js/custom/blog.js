(function($) {

	var activateTeaserImage = function() {
		$( this ).css('opacity', '.5');
	}

	var deactivateTeaserImage = function() {
		$( this ).css('opacity', '1');
	}

	$(window).load( function() {
		$( '#content' ).fadeIn(1000);
		$( '.blog-teaser-image' ).mouseenter( activateTeaserImage ).mouseleave( deactivateTeaserImage );
	});

})(jQuery);
